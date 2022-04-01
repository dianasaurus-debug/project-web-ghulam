<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Manajemen Letak Barang</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
      </search-filter>
      <inertia-link class="btn-green" :href="route('letak-barang.create')">
        <span>Tambah</span>
        <span class="hidden md:inline">Letak</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Nama</th>
            <th class="px-6 pt-6 pb-4">Deskripsi</th>
        </tr>
        <tr v-for="le in letak.data" :key="le.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('letak-barang.edit', le.id)" tabindex="-1">
                {{ le.name }}
            </inertia-link>
          </td>
            <td class="border-t">
                <inertia-link class="px-6 py-4 flex items-center" :href="route('letak-barang.edit', le.id)" tabindex="-1">
                    {{ le.description }}
                </inertia-link>
            </td>

        </tr>
        <tr v-if="letak.data.length === 0">
          <td class="border-t px-6 py-4" colspan="4">Tidak ada data letak barang.</td>
        </tr>
      </table>
    </div>
    <pagination class="mt-6" :links="letak.links" />
  </div>
</template>

<script>
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import SearchFilter from '@/Shared/SearchFilter'

export default {
  metaInfo: { title: 'Letak Barang' },
  components: {
    Pagination,
    SearchFilter,
  },
  layout: Layout,
  props: {
      filters: Object,
      letak: Object,
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
        this.$inertia.get('/letak-barang', pickBy(this.form), { preserveState: true })
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
