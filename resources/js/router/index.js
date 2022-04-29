import { createRouter, createWebHistory } from 'vue-router'

import BookingsIndex from '../components/bookings/Index.vue'

const routes = [
    {
        path: '/dashboard',
        name: 'bookings.index',
        component: BookingsIndex
    }
];

export default createRouter({
    history: createWebHistory(),
    routes
})
