<template>
  <div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('dashboard')">
        <icon name="dashboard" class="w-4 h-4 mr-2" :class="isUrl('') ? 'fill-white' : 'fill-green-400 group-hover:fill-white'" />
        <div :class="isUrl('') ? 'text-white' : 'text-green-300 group-hover:text-white'">Dashboard</div>
      </inertia-link>
    </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('products.index')">
        <icon name="apple" class="w-4 h-4 mr-2" :class="isUrl('products') ? 'fill-white' : 'fill-green-400 group-hover:fill-white'" />
        <div :class="isUrl('products') ? 'text-white' : 'text-green-300 group-hover:text-white'">Produk</div>
      </inertia-link>
    </div>
      <div class="mb-4" v-if="$page.props.auth.user.role==1">
          <inertia-link  class="flex items-center group py-3" :href="route('users')">
              <icon name="users" class="w-4 h-4 mr-2" :class="isUrl('users') ? 'fill-white' : 'fill-green-400 group-hover:fill-white'" />
              <div :class="isUrl('users') ? 'text-white' : 'text-green-300 group-hover:text-white'">Users</div>
          </inertia-link>
      </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('suppliers.index')">
        <icon name="store-front" class="w-4 h-4 mr-2" :class="isUrl('suppliers') ? 'fill-white' : 'fill-green-400 group-hover:fill-white'" />
        <div :class="isUrl('suppliers') ? 'text-white' : 'text-green-300 group-hover:text-white'">Suplier</div>
      </inertia-link>
    </div>
      <div class="mb-4">
          <inertia-link class="flex items-center group py-3" :href="route('credits.index')">
              <icon name="store-front" class="w-4 h-4 mr-2" :class="isUrl('credits') ? 'fill-white' : 'fill-green-400 group-hover:fill-white'" />
              <div :class="isUrl('credits') ? 'text-white' : 'text-green-300 group-hover:text-white'">Saldo</div>
          </inertia-link>
      </div>
      <div class="mb-4">
          <inertia-link class="flex items-center group py-3" :href="route('categories.index')">
              <icon name="store-front" class="w-4 h-4 mr-2" :class="isUrl('categories') ? 'fill-white' : 'fill-green-400 group-hover:fill-white'" />
              <div :class="isUrl('categories') ? 'text-white' : 'text-green-300 group-hover:text-white'">Kategori</div>
          </inertia-link>
      </div>
      <div class="mb-4">
          <inertia-link class="flex items-center group py-3" :href="route('letak-barang.index')">
              <icon name="store-front" class="w-4 h-4 mr-2" :class="isUrl('letak-barang') ? 'fill-white' : 'fill-green-400 group-hover:fill-white'" />
              <div :class="isUrl('letak-barang') ? 'text-white' : 'text-green-300 group-hover:text-white'">Letak Barang</div>
          </inertia-link>
      </div>
      <div class="mb-4">
          <inertia-link class="flex items-center group py-3" :href="route('rekomendasi.index')">
              <icon name="store-front" class="w-4 h-4 mr-2" :class="isUrl('rekomendasi') ? 'fill-white' : 'fill-green-400 group-hover:fill-white'" />
              <div :class="isUrl('rekomendasi') ? 'text-white' : 'text-green-300 group-hover:text-white'">Rekomendasi</div>
          </inertia-link>
      </div>
<!--    <div class="mb-4">-->
<!--      <inertia-link class="flex items-center group py-3" :href="route('reports')">-->
<!--        <icon name="printer" class="w-4 h-4 mr-2" :class="isUrl('reports') ? 'fill-white' : 'fill-green-400 group-hover:fill-white'" />-->
<!--        <div :class="isUrl('reports') ? 'text-white' : 'text-green-300 group-hover:text-white'">Reports</div>-->
<!--      </inertia-link>-->
<!--    </div>-->
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'

export default {
  components: {
    Icon,
  },
  methods: {
    isUrl(...urls) {
      let currentUrl = this.$page.url.substr(1)
      if (urls[0] === '') {
        return currentUrl === ''
      }
      return urls.filter(url => currentUrl.startsWith(url)).length
    },
  },
}
</script>
