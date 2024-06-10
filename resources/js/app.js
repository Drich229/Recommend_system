import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Vue.component('label', require('./components/Label.vue').default);

Alpine.start();
