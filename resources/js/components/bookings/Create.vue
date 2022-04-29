<template>
  <div class="mt-2 mb-6 text-sm text-red-600" v-if="errors !== ''">
    {{ errors }}
  </div>

  <form class="space-y-6" @submit.prevent="saveReservation">
    <div class="form-group">
      <label for="room_id">Room</label>
      <select
          v-model="form.room_id"
          name="room_id"
          class="form-select form-control"
          required
      >
        <option v-for="room in rooms" :value="room.id" v-text="room.name"/>
      </select>
    </div>
    <div class="form-group">
      <label for="from">Date from</label>
      <datepicker
          v-model="form.from"
          name="from"
          format="dd.MM.yyyy"
          :minDate="new Date()"
          :enable-time-picker="false"
      />
    </div>
    <div class="form-group">
      <label for="to">Date to</label>
      <datepicker
          v-model="form.to"
          name="to"
          format="dd.MM.yyyy"
          :minDate="new Date()"
          :enable-time-picker="false"
          required
      />
    </div>
    <hr/>
    <div class="text-right">
      <button type="submit" class="btn btn-primary flo">Submit</button>
    </div>
  </form>
</template>

<script>
import useBookings from '../../composables/bookings'
import useRooms from '../../composables/rooms'
import { reactive, onMounted } from 'vue'
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'


export default {
  components: {
    Datepicker
  },
  setup() {
    const form = reactive({
      room_id: 1,
      from: new Date(),
      to: new Date(),
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