import './bootstrap';

// Livewire'ı import et
import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';

// Alpine'ı CDN üzerinden yükle
import Alpine from 'alpinejs';
window.Alpine = Alpine;

// Alpine ve Livewire'ı başlat
document.addEventListener('livewire:init', () => {
    Alpine.start();
});

Livewire.start();

// Echo konfigürasyonu
// window.Echo.private(`chat.${window.userId}`)
//     .listen('MessageSent', (e) => {
//         Livewire.dispatch('messageReceived', e);
//     });
