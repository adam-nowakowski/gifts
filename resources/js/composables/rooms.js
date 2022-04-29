import { ref } from 'vue'
import axios from 'axios'

export default function useRooms() {
    const rooms = ref([])
    const room = ref([])

    const getRooms = async () => {
        let response = await axios.get('/api/rooms')
        rooms.value = response.data.data
    }

    const getRoom = async (id) => {
        let response = await axios.get(`/api/rooms/${id}`)
        room.value = response.data.data
    }

    return {
        room,
        rooms,
        getRooms,
        getRoom,
    }
}
