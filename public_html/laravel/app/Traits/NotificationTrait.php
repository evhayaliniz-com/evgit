<?php

namespace App\Traits;

use App\Models\IdeaReply;
use App\Models\Notification;

trait NotificationTrait
{
    // type: bildirim türünü temsil eder.
    // userId: bildirimi tetikleyen kullanıcının id değeri.
    // id: etkilenecek olan kullanıcının id değerini temsil eder. null ise giriş yapmış kullanıcının id değeri alınır.
    // values: bildirimlerde dinamik değerler gösterilecekse kullanılır.
    // link: bildirim herhangi bir sayfaya yönlendirecekse kullanılır.
    // Not: id değeri her zaman users tablosundan gelmelidir.

    public function notification($type, $id = null, $values = [])
    {
        // Auth kontrolü
        if (!auth()->check()) {
            return;
        }

        $userId = auth()->user()->id;
        $id = $id ?? auth()->user()->id;
        $values = !empty($values) ? $values : [];

        switch ($type) {
            case 'follow':
                $data = ['user_id' => $userId, 'to_id' => $id, 'message' => auth_info()->name . ' hesabınızı takip etmeye başladı.'];
                break;

            case 'idea-like':
                $idea = IdeaReply::find($values['idea_id']);

                $data = ['user_id' => $userId, 'to_id' => $idea->user_id, 'message' => 'yorumunuzu beğendi.',
                    'link' => route('idea.show', $idea->idea->slug)];
                break;

            case 'idea-reply-quoted':
                $reply = IdeaReply::find($values['reply_id']);

                $data = ['user_id' => $userId, 'to_id' => $values['quoted_user_id'], 'message' => 'yorumunuzu yanıtladı.',
                    'link' => route('idea.show', $reply->idea->slug)];
                break;

            case 'idea-reply':
                $data = ['user_id' => $userId, 'to_id' => $id, 'message' => 'tarafından fikrinize yorum yapıldı.',
                    'link' => route('idea.show', $values['slug'])];
                break;

            case 'service-save':
                $data = ['user_id' => $userId, 'to_id' => $id, 'message' => str()->limit($values['title'], 50)
                    . ' başlıklı servisinizi profiline kaydetti.', 'link' => route('services.show', $values['slug'])];
                break;

            case 'new-message':
                $senderName = auth_info()->name ?? 'Bir kullanıcı';
                $messagePreview = str()->limit($values['message'] ?? 'Dosya gönderildi', 50);
                $data = [
                    'user_id' => $userId,
                    'to_id' => $id,
                    'message' => 'size yeni bir mesaj gönderdi: "' . $messagePreview . '"',
                    'link' => route('chat.show', ['receiver' => $userId])
                ];
                break;

            case 'service-approved':
                $data = [
                    'user_id' => $userId,
                    'to_id' => $id,
                    'message' => '"' . str()->limit($values['service_title'], 50) . '" başlıklı hizmetiniz onaylandı ve yayına alındı.',
                    'link' => $values['service_link'] ?? null
                ];
                break;

            case 'idea-approved':
                $data = [
                    'user_id' => $userId,
                    'to_id' => $id,
                    'message' => 'Fikriniz onaylandı ve yayına alındı.',
                    'link' => $values['idea_link'] ?? null
                ];
                break;

            default:
                return;
        }

        Notification::create($data);
    }
}