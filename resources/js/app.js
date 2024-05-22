import './bootstrap';

import Alpine from 'alpinejs';
import { createApp } from 'vue';
import IncrementCounter from './components/IncrementCounter.vue';
import Chat from './components/chat.vue';

window.Alpine = Alpine;

Alpine.start();

createApp({})
    .component('IncrementCounter', IncrementCounter)
    .component('Chat', Chat)
    .mount('#app')
