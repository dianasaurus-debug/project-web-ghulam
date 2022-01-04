<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Manajemen Suplier</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
      </search-filter>
      <inertia-link class="btn-green" :href="route('suppliers.create')">
        <span>Tambah</span>
        <span class="hidden md:inline">Suplier</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Nama Suplier</th>
            <th class="px-6 pt-6 pb-4">Nomor HP</th>
            <th class="px-6 pt-6 pb-4">E-Mail</th>
        </tr>
        <tr v-for="supplier in suppliers.data" :key="supplier.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-green-500" :href="route('suppliers.edit', supplier.id)">
              {{ supplier.nama_supplier }}
            </inertia-link>
          </td>
            <td class="border-t">
                <inertia-link class="px-6 py-4 flex items-center focus:text-green-500" :href="route('suppliers.edit', supplier.id)">
                    {{ supplier.phone }}
                </inertia-link>
            </td>
            <td class="border-t">
                <inertia-link class="px-6 py-4 flex items-center focus:text-green-500" :href="route('suppliers.edit', supplier.id)">
                    {{ supplier.email }}
                </inertia-link>
            </td>
            <inertia-link class="px-4 flex items-center" :href="route('suppliers.edit', supplier.id)" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="suppliers.data.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No suppliers found.</td>
        </tr>
      </table>
    </div>
    <pagination class="mt-6" :links="suppliers.links" />
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
  metaInfo: { title: 'Suplier' },
  components: {
    Icon,
    Pagination,
    SearchFilter,
  },
  layout: Layout,
  props: {
    filters: Object,
    suppliers: Object,
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
        this.$inertia.get('/suppliers', pickBy(this.form), { preserveState: true })
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
