<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-green-400 hover:text-green-600" :href="route('products.index')">Produk
            </inertia-link>
            <span class="text-green-400 font-medium">/</span> Tambah
        </h1>
        <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="store">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input v-model="form.nama_barang" :error="form.errors.nama_barang"
                                class="pr-6 pb-8 w-full lg:w-1/2" label="Nama Barang"/>
                    <text-input v-model="form.stok" :error="form.errors.stok" class="pr-6 pb-8 w-full lg:w-1/2"
                                label="Jumlah Stok"/>
                    <select-input v-model="form.category_id" :error="form.errors.category_id"
                                  class="pr-6 pb-8 w-full lg:w-1/2" label="Kategori Barang">
                        <option :value="null">Pilih Kategori</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.nama_kategori }}
                        </option>
                    </select-input>
                    <text-input v-model="form.kode_barang" :error="form.errors.kode_barang"
                                class="pr-6 pb-8 w-full lg:w-1/2" label="Kode Barang"/>
                    <text-input v-model="form.harga_beli" :error="form.errors.harga_beli"
                                class="pr-6 pb-8 w-full lg:w-1/2" label="Harga Beli"/>
                    <text-input v-model="form.harga_jual" :error="form.errors.harga_jual"
                                class="pr-6 pb-8 w-full lg:w-1/2" label="Harga Jual"/>
                    <TextareaInput v-model="form.deskripsi" :error="form.errors.deskripsi"
                                   class="pr-6 pb-8 w-full lg:w-1/2" label="Deskripsi Barang"/>
                    <file-input v-model="form.gambar" :error="form.errors.gambar" class="pr-6 pb-8 w-full lg:w-1/2"
                                type="file" accept="image/*" label="Gambar Produk"/>

                </div>
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
                    <loading-button :loading="form.processing" class="btn-green" type="submit">Buat Produk
                    </loading-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import TextareaInput from '@/Shared/TextareaInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import FileInput from '@/Shared/FileInput'

export default {
    metaInfo: {title: 'Tambah Produk'},
    components: {
        LoadingButton,
        SelectInput,
        TextInput,
        FileInput,
        TextareaInput
    },
    layout: Layout,
    props: {
        categories: Array,
    },
    remember: 'form',
    data() {
        return {
            form: this.$inertia.form({
                kode_barang: null,
                nama_barang: null,
                harga_beli: null,
                harga_jual: null,
                deskripsi: null,
                stok: null,
                category_id: null,
                gambar: null
            }),
        }
    },
    methods: {
        store() {
            this.form.post('/products')
        },
    },
}
</script>
