<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Manajemen Produk</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
          <label class="block text-gray-700">Kategori:</label>
          <select v-model="form.category" class="mt-1 w-full form-select">
              <option :value="null">Semua Kategori</option>
              <option v-for="category in categories" :key="category.id" :value="category.id">
                  {{ category.nama_kategori }}
              </option>
          </select>
          <label class="block mt-4 text-gray-700">Harga:</label>
          <select v-model="form.harga" class="mt-1 w-full form-select">
              <option :value="null">Semua Harga</option>
              <option v-for="price in price_ranges" :value="price">
                  {{ price[0]}} - {{ price[1]}}
              </option>
          </select>
          <label class="block mt-4 text-gray-700">Stok:</label>
          <select v-model="form.stock" class="mt-1 w-full form-select">
              <option :value="null">Semua Stok</option>
              <option v-for="stock in stock_ranges" :value="stock">
                  {{ stock[0]}} - {{ stock[1]}}
              </option>
          </select>
      </search-filter>
      <inertia-link class="btn-green" :href="route('products.create')">
        <span>Tambah</span>
        <span class="hidden md:inline">Produk</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Nama</th>
          <th class="px-6 pt-6 pb-4">Harga Beli</th>
          <th class="px-6 pt-6 pb-4">Harga Jual</th>
          <th class="px-6 pt-6 pb-4">Kode Barang</th>
            <th class="px-6 pt-6 pb-4">Kategori</th>
            <th class="px-6 pt-6 pb-4">Stok</th>
        </tr>
        <tr v-for="product in products.data" :key="product.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-green-500" :href="route('products.edit', product.id)">
              {{ product.nama_barang }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('products.edit', product.id)" tabindex="-1">
                {{ product.harga_beli }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('products.edit', product.id)" tabindex="-1">
              {{ product.harga_jual }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('products.edit', product.id)" tabindex="-1">
                {{ product.kode_barang }}
            </inertia-link>
          </td>
            <td class="border-t">
                <inertia-link class="px-6 py-4 flex items-center" :href="route('products.edit', product.id)" tabindex="-1">
                    {{ product.category.nama_kategori }}
                </inertia-link>
            </td>
            <td class="border-t">
                <inertia-link class="px-6 py-4 flex items-center" :href="route('products.edit', product.id)" tabindex="-1">
                    {{ product.stok }}
                </inertia-link>
            </td>
          <td class="border-t w-px">
            <inertia-link class="px-4 flex items-center" :href="route('products.edit', product.id)" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="products.data.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No products found.</td>
        </tr>
      </table>
    </div>
    <pagination class="mt-6" :links="products.links" />
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
  metaInfo: { title: 'Produk' },
  components: {
    Icon,
    Pagination,
    SearchFilter,
  },
  layout: Layout,
  props: {
    filters: Object,
    products: Object,
    categories: Array
  },
  data() {
    return {
        price_ranges : [
            [500, 2000],
            [2100, 5000],
            [5100, 10000],
            [10100, 20000],
            [20100, 50000],
        ],
        stock_ranges : [
            [0, 50],
            [51, 100],
            [101, 150],
            [151, 200],
            [201, 300],
        ],
      form: {
        search: this.filters.search,
        category: this.filters.category,
          harga: this.filters.harga,
          stock: this.filters.stock,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function() {
        this.$inertia.get('/products', pickBy(this.form), { preserveState: true })
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
