<template>
  <div class="mt-2 mb-6 text-sm text-red-600" v-if="errors !== ''">
    {{ errors }}
  </div>

  <form class="space-y-6" @submit.prevent="saveReservation">
    testy
  </form>
</template>

<script>
import useBookings from '../../composables/bookings'
import useRooms from '../../composables/rooms'
import { reactive, onMounted } from 'vue'
import axios from 'axios';

export default {
  setup() {
    const form = reactive({
      room_id: '',
      from: '',
      to: '',
    })

    const { errors, storeBooking } = useBookings()
    const { rooms, getRooms } = useRooms();

    onMounted(() => getRooms());

    const saveReservation = async () => {
      await storeBooking({ ...form })
    }

    return {
      rooms,
      form,
      errors,
      saveReservation
    }
  }
}
</script>