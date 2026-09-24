<style>.logo, table.footer p { display: none; }</style>

@component('mail::message')
# Yeni Mesajınız Var

{{ $sender->user_type == 'user' ? $sender?->informations?->name : $sender?->company?->name }} size yeni bir mesaj gönderdi.

@if($message->message)
**Mesaj:**
{{ $message->message }}
@endif

@if($message->file_name)
**Dosya:**
{{ $message->file_name }}
@endif

@component('mail::button', ['url' => route('chat.show', ['receiver' => $sender->id])])
Mesajı Görüntüle
@endcomponent

Saygılarımızla,<br>
Ev Hayaliniz
{{--{{ config('app.name') }}--}}
@endcomponent
