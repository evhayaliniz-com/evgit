@php use Carbon\Carbon; @endphp
<div class="container-fluid mx-auto px-0" wire:poll.3000ms="loadMessages">

    <div class="row flex">
        <div class="col-12 col-md-4 col-lg-3 order-first order-md-first border-end pe-md-0" wire:poll.3000ms="loadMessages">
            <div class="mesajlar-title">
                <h1>Mesajlar</h1>
            </div>

            <div class="position-relative mb-2 me-3">
                <input type="text" id="searchInput" class="form-control" placeholder="İsim ara...">
                <ul id="resultsDropdown" class="dropdown-results list-group mt-1"></ul>
            </div>

            <div class="mesajlar-tabs">
                <div class="flex gap-2 mb-3">
                    <button wire:click="setFilter('all')"
                            class="px-4 py-2 rounded-lg {{ $filter === 'all' ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                        Tümü
                    </button>
                    <button wire:click="setFilter('unread')"
                            class="px-4 py-2 rounded-lg {{ $filter === 'unread' ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                        Okunmamış
                    </button>
                </div>


                <div class="mesajlar-tab-person">
                    <div>
                        @foreach($contacts as $contact)
                            <button @class(['nav-link w-100', 'bg-white' => $receiver_id == $contact['id']])
                                    type="button"
                                    onclick="window.location.href = '{{ route('chat.show', $contact['id']) }}'">
                                <div class="mesajlar-tab-person-box d-flex">
                                    <div class="mtpb-img">
                                        <img src="{{asset($contact['avatar'])}}" class="profile-avatar-min"
                                             alt="Avatar">
                                    </div>
                                    <div class="mtpb-texts">
                                        <div class="mtbp-left">
                                            <h2 @class(['chat-user-name', 'font-bold text-blue-600' => $contact['unread_count'] > 0])>
                                                {{ $contact['name'] }}
                                            </h2>
                                            <p @class(['font-semibold' => $contact['unread_count'] > 0])>
                                                {{ $contact['last_message'] }}
                                            </p>
                                        </div>
                                        <div @class(['mtbp-right', 'font-semibold' => $contact['unread_count'] > 0])>
                                            <span>{{ $contact['last_message_time'] }}</span>
                                        </div>

                                        @if($contact['unread_count'] > 0)
                                            <div class="mt-1 bg-blue-500 text-white rounded-full px-2 py-1 text-xs">
                                                {{ $contact['unread_count'] }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>


        <!-- Mesajlaşma Alanı -->
        <div class="col-12 col-md-8 col-lg-9 order-last order-md-last flex flex-col msg-area-container ps-md-0"
             style="height: 90vh">
            @if($receiver_id)
                <div class="d-flex align-items-center gap-2 p-2 bg-white receiver-informations">
                    <a href="/" class="text-dark fs-3 mx-2 d-md-none">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>

                    <img src="{{asset(auth_info($receiver_id)?->avatar)}}" class="profile-avatar-min" alt="Avatar">
                    <b class="chat-user-name">{{auth_info($receiver_id)?->name}}</b>


                </div>

                <!-- Mevcut mesajlaşma içeriği -->
                <div class="flex-1 overflow-y-auto p-4 mt-5 mt-md-0" id="chat-messages">
                    @foreach($messages as $message)
                        <div class="mb-4 {{ $message['sender_id'] === Auth::id() ? 'text-right' : 'text-left' }}">
                            <div
                                class="inline-block p-2 rounded-lg {{ $message['sender_id'] === Auth::id() ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                                @if($message['message'])
                                    <p class="mb-2">{{ $message['message'] }}</p>
                                @endif

                                @if($message['file_path'])
                                    <div class="mt-2">
                                        @if(in_array(strtolower(pathinfo($message['file_path'], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png']))
                                            <img src="{{$message['file_path']}}" alt="Image">

                                        @else
                                            <a href="#"
                                               class="text-sm underline {{$message['sender_id'] === Auth::id() ? 'text-white' : 'text-dark'}}"
                                               wire:click.prevent="downloadFile('{{ $message['file_path'] }}')"
                                               title="Dosyayı indir">
                                                {{ $message['file_name'] }} <i class="fa-solid fa-download"></i>
                                            </a>
                                        @endif
                                    </div>
                                @endif

                                <span
                                    class="text-xs {{ $message['sender_id'] === Auth::id() ? 'text-white' : 'text-gray-500' }}">
                                    {{ Carbon::parse($message['created_at'])->tz('Europe/Istanbul')->format('H:i') }}
                                    @if($message['sender_id'] !== Auth::id())
                                        @if($message['is_read'])
                                            <span>✓✓</span>
                                        @else
                                            <span>✓</span>
                                        @endif
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Mesaj gönderme formu -->
                <div class="p-2 p-md-4 border-top bg-white msg-send-area">
                    <form wire:submit.prevent="sendMessage" class="flex items-center gap-2">
                        <input type="text" wire:model="message" id="message-input" class="flex-1 rounded-lg border p-2">

                        <div class="relative">
                            <input type="file" wire:model="file" class="hidden" id="file-input"
                                   accept=".jpg,.png,.pdf,.doc">

                            <label for="file-input" class="cursor-pointer file-select-btn">
                                <i class="fa-solid fa-plus"></i>
                            </label>
                        </div>

                        <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg">
                            <i class="fa-regular fa-paper-plane d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Gönder</span>
                        </button>
                    </form>

                    @if($file)
                        <div class="mt-2">
                            <div class="text-sm">{{ $file->getClientOriginalName() }}</div>
                            <div wire:loading wire:target="file">
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: 45%"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="flex-1 flex items-center justify-center text-gray-500">
                    Mesajlaşmak için bir kişi seçin
                </div>
            @endif
        </div>
    </div>
</div>



<script>
    // Mesaj kutusunu en alta kaydır
    function scrollToBottom() {
        const chatMessages = document.getElementById('chat-messages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Input'u temizle
    function clearInput() {
        document.getElementById('message-input').value = '';
    }

    // Event dinleyicileri
    document.addEventListener('livewire:initialized', () => {
        // Sayfa yüklendiğinde en alta kaydır
        scrollToBottom();

        // Livewire eventlerini dinle
        Livewire.on('scrollToBottom', () => {
            scrollToBottom();
        });

        Livewire.on('clearInput', () => {
            clearInput();
        });

        // URL değiştirme için event dinleyici
        Livewire.on('changeUrl', (params) => {
            window.history.pushState({}, '', params.url);
        });
    });
</script>
