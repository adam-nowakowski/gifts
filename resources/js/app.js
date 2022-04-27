require('./bootstrap');

require('alpinejs');

import { createApp } from 'vue';
import router from './router'

import ReservationsIndex from './components/reservations/Index.vue';

createApp({
    components: {
        CompaniesIndex: ReservationsIndex
    }
}).use(router).mount('#app')
