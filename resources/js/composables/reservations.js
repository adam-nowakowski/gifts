import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

export default function useReservations() {
    const reservation = ref([])
    const reservations = ref([])

    const errors = ref('')
    const router = useRouter()

    const getReservations = async () => {
        let response = await axios.get('/api/reservations')
        reservations.value = response.data.data
    }

    const getReservation = async (id) => {
        let response = await axios.get(`/api/reservations/${id}`)
        reservation.value = response.data.data
    }

    const storeReservation = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/reservations', data)
            await router.push({ name: 'reservations.index' })
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
            }
        }

    }

    const updateReservation = async (id) => {
        errors.value = ''
        try {
            await axios.patch(`/api/reservations/${id}`, reservation.value)
            await router.push({ name: 'reservations.index' })
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
            }
        }
    }

    return {
        errors,
        reservation,
        reservations,
        getReservation,
        getReservations,
        storeReservation,
        updateReservation
    }
}
