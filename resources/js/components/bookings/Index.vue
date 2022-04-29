<template>
  <div class="overflow-hidden overflow-x-auto min-w-full align-middle sm:rounded-md">
    <table class="min-w-full w-100 border divide-y divide-gray-200">
      <thead>
      <tr>
        <th class="px-6 py-3 bg-gray-50">
          <span class="text-xs font-medium tracking-wider leading-4 text-left text-gray-500 uppercase">
            #
          </span>
        </th>
        <th class="px-6 py-3 bg-gray-50">
          <span class="text-xs font-medium tracking-wider leading-4 text-left text-gray-500 uppercase">
            Nights
          </span>
        </th>
        <th class="px-6 py-3 bg-gray-50">
          <span class="text-xs font-medium tracking-wider leading-4 text-left text-gray-500 uppercase">
            Room
          </span>
        </th>
        <th class="px-6 py-3 bg-gray-50">
          <span class="text-xs font-medium tracking-wider leading-4 text-left text-gray-500 uppercase">
            From
          </span>
        </th>
        <th class="px-6 py-3 bg-gray-50">
          <span class="text-xs font-medium tracking-wider leading-4 text-left text-gray-500 uppercase">
            To
          </span>
        </th>
        <th class="px-6 py-3 bg-gray-50">
          <span class="text-xs font-medium tracking-wider leading-4 text-left text-gray-500 uppercase">
            User
          </span>
        </th>
      </tr>
      </thead>

      <tbody class="bg-white divide-y divide-gray-200 divide-solid">
      <template v-for="item in bookings" :key="item.id">
        <tr class="bg-white">
          <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
            {{ item.id }}
          </td>
          <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
            {{ item.nights }}
          </td>
          <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
            {{ item.room.name }}
          </td>
          <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
            {{ item.from }}
          </td>
          <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
            {{ item.to }}
          </td>
          <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
            {{ item.user.name }}
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
    const { bookings, getBookings } = useBookings()

    onMounted(getBookings)

    return {
      bookings,
    }
  }
}
</script>
