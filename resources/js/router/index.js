import { createRouter, createWebHistory } from 'vue-router'

import ReservationsIndex from '../components/reservations/Index.vue'

const routes = [
    {
        path: '/reservations',
        name: 'reservations.index',
        component: ReservationsIndex
    }
];

export default createRouter({
    history: createWebHistory(),
    routes
})
