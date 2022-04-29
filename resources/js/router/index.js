import { createRouter, createWebHistory } from 'vue-router'

import BookingsIndex from '../components/bookings/Index.vue'
import BookingsCreate from '../components/bookings/Create.vue'

const routes = [
    {
        path: '/dashboard',
        name: 'bookings.index',
        component: BookingsIndex
    },
    {
        path: '/bookings/create',
        name: 'bookings.create',
        component: BookingsCreate
    }
];

export default createRouter({
    history: createWebHistory(),
    routes
})
