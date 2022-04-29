<template>
  <div class="overflow-hidden overflow-x-auto min-w-full align-middle sm:rounded-md">
    <table class="min-w-full w-100 border divide-y divide-gray-200">
      <thead>
      <tr>
        <th class="px-6 py-3">
          <span>
            #
          </span>
        </th>
        <th class="px-6 py-3">
          <span>
            Nights
          </span>
        </th>
        <th class="px-6 py-3">
          <span>
            Room
          </span>
        </th>
        <th class="px-6 py-3">
          <span>
            From
          </span>
        </th>
        <th class="px-6 py-3">
          <span>
            To
          </span>
        </th>
        <th class="px-6 py-3">
          <span>
            User
          </span>
        </th>
        <th></th>
      </tr>
      </thead>

      <tbody class="bg-white divide-y divide-gray-200 divide-solid">
      <template v-for="item in bookings" :key="item.id">
        <tr class="bg-white">
          <td class="px-6 py-4">
            {{ item.id }}
          </td>
          <td class="px-6 py-4">
            {{ item.nights }}
          </td>
          <td class="px-6 py-4">
            {{ item.room_name }}
          </td>
          <td class="px-6 py-4">
            {{ item.from }}
          </td>
          <td class="px-6 py-4">
            {{ item.to }}
          </td>
          <td class="px-6 py-4">
            {{ item.user_name }}
          </td>
          <td class="px-6 py-4">
            <button @click="deleteCompany(item.id)" class="p-2 bg-danger rounded-md text-xs text-white uppercase">
              Delete
            </button>
          </td>
        </tr>
      </template>
      </tbody>
    </table>
  </div>
</template>

<script>
import useBookings from '../../composables/bookings'
import { onMounted } from 'vue';

export default {
  setup() {
    const { bookings, getBookings, destroyBooking } = useBookings()

    const deleteCompany = async (id) => {
      if (!window.confirm('Are you sure?')) {
        return
      }

      await destroyBooking(id)
      await getBookings()
    }

    onMounted(getBookings)

    return {
      bookings,
      deleteCompany
    }
  }
}
</script>
