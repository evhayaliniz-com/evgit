<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\User;
use App\Traits\NotificationTrait;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewMessageMail;
use Carbon\Carbon;

class Chat extends Component
{
    use WithFileUploads, NotificationTrait;

    public $message;
    public $file;
    public $receiver_id;
    public $messages = [];
    public $filter = 'all'; // tümü, read, unread
    public $contacts = [];
    public $allowedFileTypes = ['jpg', 'png', 'pdf', 'doc'];

    protected $listeners = [
        'messageReceived' => 'notifyNewMessage',
        'deleteConversation' => 'deleteConversation'
    ];
    protected $queryString = ['filter'];

    // Polling ile her 3 saniyede bir mesajları ve kontakları kontrol et
    public function getPollingConfiguration()
    {
        return [
            'method' => 'pollData',
            'interval' => 3000, // 3 saniye
        ];
    }

    // Polling için yeni metod
    public function pollData()
    {
        $this->loadMessages();
        $this->loadContacts();
    }

    public function mount($receiver_id = null)
    {
        $this->receiver_id = $receiver_id;
        $this->loadContacts();
        if ($receiver_id) {
            $this->loadMessages();
        }

        // Dinamik dinleyici ekle
        $this->listeners['echo-private:chat.' . Auth::id() . ',MessageSent'] = 'handleNewMessage';
    }

    public function deleteConversation($receiverId)
    {
        logger()->info('Silme işlemi başladı', ['receiverId' => $receiverId, 'auth' => Auth::id()]);

        if (Auth::id() == $receiverId) {
            return;
        }

        Message::where(function($query) use ($receiverId) {
            $query->where('sender_id', Auth::id())
                ->where('receiver_id', $receiverId);
        })->orWhere(function($query) use ($receiverId) {
            $query->where('sender_id', $receiverId)
                ->where('receiver_id', Auth::id());
        })->delete();

        // Kontak listesini yenile
        $this->loadContacts();

        // Mesajları temizle
        $this->messages = [];

        // Yönlendirme yap
        return redirect()->route('messages.index');
    }

    public function notifyNewMessage($event)
    {
        $this->loadMessages();
        $this->loadContacts();
    }

    public function handleNewMessage($event)
    {
        if ($event['message']['receiver_id'] == auth()->id()) {
            $message = Message::with(['sender.informations', 'sender.company'])->find($event['message']['id']);

            $this->dispatch('newMessageNotification', [
                'message' => [
                    'id' => $message->id,
                    'message' => $message->message,
                    'created_at' => $message->created_at,
                    'is_read' => false
                ],
                'sender' => [
                    'id' => $message->sender->id,
                    'user_type' => $message->sender->user_type,
                    'informations' => $message->sender->informations,
                    'company' => $message->sender->company
                ]
            ]);

            // Mesajları ve kontakları yenile
            $this->loadMessages();
            $this->loadContacts();
        }
    }

    public function loadMessages()
    {
        $messages = Message::where(function($query) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $this->receiver_id);
        })->orWhere(function($query) {
            $query->where('sender_id', $this->receiver_id)
                  ->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')
          ->get();

        // Alınan mesajları okundu olarak işaretle
        Message::where('sender_id', $this->receiver_id)
              ->where('receiver_id', Auth::id())
              ->where('is_read', false)
              ->update(['is_read' => true]);

        // Mesajları array'e çevir
        $this->messages = $messages->toArray();

        // Sadece yeni mesajlar varsa scroll'u en alta kaydır
//        $this->dispatch('scrollToBottom');
    }

    public function loadContacts()
    {
        // Son mesajlara göre kişileri getir
        $query = Message::where(function($query) {
            $query->where('sender_id', Auth::id())
                ->orWhere('receiver_id', Auth::id());
        })
        ->orderBy('created_at', 'desc')
        ->get()
        ->unique(function ($item) {
            // Her kişi için tek bir kayıt al
            return $item->sender_id === Auth::id()
                ? $item->receiver_id
                : $item->sender_id;
        })
        ->map(function ($message) {
            $contactId = $message->sender_id === Auth::id()
                ? $message->receiver_id
                : $message->sender_id;

            $contact = User::with(['informations', 'company'])->find($contactId);

            // Son mesajı al
            $lastMessage = Message::where(function($query) use ($contactId) {
                $query->where('sender_id', Auth::id())
                      ->where('receiver_id', $contactId);
            })->orWhere(function($query) use ($contactId) {
                $query->where('sender_id', $contactId)
                      ->where('receiver_id', Auth::id());
            })
            ->latest()
            ->first();

            return [
                'id' => $contact->id,
                'avatar' => $contact->user_type == 'user' ? $contact?->informations?->avatar : $contact?->company?->avatar,
                'name' => $contact->getDisplayName(),
                'last_message' => $lastMessage->message ?? 'Dosya gönderildi',
                'last_message_time' => Carbon::parse($lastMessage->created_at)->tz('Europe/Istanbul')->format('H:i'),
                'unread_count' => Message::where('sender_id', $contactId)->where('receiver_id', Auth::id())
                    ->where('is_read', false)->count(),
            ];
        });

        // Filtreleme uygula
        if ($this->filter === 'read') {
            $query = $query->filter(fn($contact) => $contact['unread_count'] === 0);
        } elseif ($this->filter === 'unread') {
            $query = $query->filter(fn($contact) => $contact['unread_count'] > 0);
        }

        $this->contacts = $query->values()->all();
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->loadContacts();
    }

    public function selectContact($contactId)
    {
        $this->receiver_id = $contactId;

        // Seçilen kişiden gelen okunmamış mesajları okundu olarak işaretle
        Message::where('sender_id', $contactId)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->loadMessages();
        $this->loadContacts(); // Sidebar'ı güncelle
        $this->dispatch('changeUrl', ['url' => route('chat.show', ['receiver' => $contactId])]);
    }

    public function sendMessage()
    {
        if (Auth::id() == $this->receiver_id) {
            return;
        }

        $this->validate([
            'message' => 'required_without:file',
            'file' => 'nullable|file|mimes:jpg,png,pdf,doc|max:10240'
        ]);

        $filePath = null;
        $fileName = null;
        $fileType = null;

        if ($this->file) {
//            $fileName = $this->file->getClientOriginalName();
//            $fileType = $this->file->getClientOriginalExtension();
//            $filePath = $this->file->store('chat-files', 'public');

//            dd(realpath(base_path('../site/chat_files')));

            $fileName = time() . '_' . $this->file->getClientOriginalName();
            $fileType = $this->file->getClientOriginalExtension();
//            $this->file->move(realpath(base_path('../site/chat_files')), $fileName);

            $this->file->storeAs(
                '', // hedef
                time() . '_' . $this->file->getClientOriginalName(), // dosya ismi
                ['disk' => 'chat_files'] // Laravel disk
            );

//            $filePath = realpath(base_path('../site/chat_files')).'/' . $fileName;
            $filePath = asset('site/chat_files').'/' . $fileName;
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->receiver_id,
            'message' => $this->message,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_type' => $fileType
        ]);

        // Pusher üzerinden event yayınla
        broadcast(new MessageSent($message))->toOthers();

        // Alıcının son görülme zamanını kontrol et
        $receiver = User::find($this->receiver_id);
        $lastSeen = $receiver->last_seen ?? null;

        // Eğer kullanıcı 5 dakikadan fazla süredir offline ise mail gönder
//        if (!$lastSeen || Carbon::parse($lastSeen)->diffInMinutes(now()) > 5) {
            Mail::to($receiver)->send(new NewMessageMail($message));
//        }

        // Alıcıya bildirim gönder
        $this->notification('new-message', $this->receiver_id, [
            'message' => $this->message ?? 'Dosya gönderildi'
        ]);

        $this->reset(['message', 'file']);
        $this->loadMessages();
        $this->loadContacts();

        $this->dispatch('clearInput');
//        $this->dispatch('scrollToBottom');
    }

    public function downloadFile($filePath)
    {
        // Dosya yolundan dosya adını al
        $fileName = basename(parse_url($filePath, PHP_URL_PATH));
        // Url ile direkt erişimlerde erişim hatası çıktığından dolayı indirme işlemi için aşağıdaki kodu kullanıyoruz.
        $downloadFilePath = realpath(base_path('../site/chat_files')).'/' . $fileName;

        // Dosyanın var olup olmadığını kontrol et
        if (!File::exists($downloadFilePath)) {
            abort(404, 'Dosya bulunamadı.');
        }

        // Dosyanın bu sohbete ait olup olmadığını kontrol et
        $messageExists = Message::where('file_path', $filePath)
            ->where(function($query) {
                $query->where('sender_id', Auth::id())
                      ->orWhere('receiver_id', Auth::id());
            })->exists();

        if (!$messageExists) {
            abort(403, 'Bu dosyaya erişim izniniz yok.');
        }

        // Dosyayı indir
        return response()->download($downloadFilePath);

    }


    public function render()
    {
        return view('livewire.chat');
    }
}
