require('./bootstrap');

require('alpinejs');

import { createApp } from 'vue';
import router from './router'

import BookingsIndex from './components/bookings/Index.vue';

createApp({
    components: {
        CompaniesIndex: BookingsIndex
    }
}).use(router).mount('#app')
