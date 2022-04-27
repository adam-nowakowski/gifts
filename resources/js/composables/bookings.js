import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

export default function useBookings() {
    const booking = ref([])
    const bookings = ref([])

    const errors = ref('')
    const router = useRouter()

    const getBookings = async () => {
        let response = await axios.get('/api/bookings')
        bookings.value = response.data.data
    }

    const getBooking = async (id) => {
        let response = await axios.get(`/api/bookings/${id}`)
        booking.value = response.data.data
    }

    const storeBooking = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/bookings', data)
            await router.push({ name: 'bookings.index' })
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value += e.response.data.errors[key][0] + ' ';
                }
            }
        }

    }

    const updateBooking = async (id) => {
        errors.value = ''
        try {
            await axios.patch(`/api/bookings/${id}`, booking.value)
            await router.push({ name: 'bookings.index' })
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
        booking,
        bookings,
        getBooking,
        getBookings,
        storeBooking,
        updateBooking
    }
}
