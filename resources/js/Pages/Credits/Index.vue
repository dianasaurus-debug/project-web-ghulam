<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Manajemen Saldo</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
      </search-filter>
      <inertia-link class="btn-green" :href="route('credits.create')">
        <span>Tambah</span>
        <span class="hidden md:inline">Saldo</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Customer</th>
          <th class="px-6 pt-6 pb-4">Jumlah Top up</th>
          <th class="px-6 pt-6 pb-4">Admin</th>
          <th class="px-6 pt-6 pb-4">Tanggal top up</th>
        </tr>
        <tr v-for="credit in credits.data" :key="credit.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-green-500" :href="route('credits.edit', credit.id)">
              {{ credit.user.first_name }} {{credit.user.last_name}}
            </inertia-link>
          </td>
            <td class="border-t">
                <inertia-link class="px-6 py-4 flex items-center focus:text-green-500" :href="route('credits.edit', credit.id)">
                    {{ credit.jumlah_topup }}
                </inertia-link>
            </td>
            <td class="border-t">
                <inertia-link class="px-6 py-4 flex items-center focus:text-green-500" :href="route('credits.edit', credit.id)">
                    {{ credit.admin.first_name }} {{credit.admin.last_name}}
                </inertia-link>
            </td>
            <td class="border-t">
                <inertia-link class="px-6 py-4 flex items-center focus:text-green-500" :href="route('credits.edit', credit.id)">
                    {{credit.created_at | formatDate}}
                </inertia-link>
            </td>
          <td class="border-t w-px">
            <inertia-link class="px-4 flex items-center" :href="route('credits.edit', credit.id)" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="credits.data.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No credits found.</td>
        </tr>
      </table>
    </div>
    <pagination class="mt-6" :links="credits.links" />
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import SearchFilter from '@/Shared/SearchFilter'

export default {
  metaInfo: { title: 'Saldo' },
  components: {
    Icon,
    Pagination,
    SearchFilter,
  },
  layout: Layout,
  props: {
    filters: Object,
    credits: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function() {
        this.$inertia.get('/credits', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
