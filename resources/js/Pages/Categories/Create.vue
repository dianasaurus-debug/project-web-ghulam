<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-green-400 hover:text-green-600" :href="route('categories.index')">Produk
            </inertia-link>
            <span class="text-green-400 font-medium">/</span> Tambah
        </h1>
        <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="store">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input v-model="form.nama_kategori" :error="form.errors.nama_kategori"
                                class="pr-6 pb-8 w-full lg:w-1/2" label="Nama Kategori"/>
                </div>
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input v-model="form.min_harga" :error="form.errors.min_harga"
                                class="pr-6 pb-8 w-full lg:w-1/2" label="Min Harga"/>
                    <text-input v-model="form.max_harga" :error="form.errors.max_harga"
                                class="pr-6 pb-8 w-full lg:w-1/2" label="Max Harga"/>
                </div>
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
                    <loading-button :loading="form.processing" class="btn-green" type="submit">Buat Kategori
                    </loading-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from "../../Shared/SelectInput";

export default {
    metaInfo: {title: 'Tambah Kategori'},
    components: {
        TextInput,
        LoadingButton,
        SelectInput
    },
    layout: Layout,
    remember: 'form',
    data() {
        return {
            form: this.$inertia.form({
                nama_kategori : null,
                min_harga : null,
                max_harga : null,
            }),
        }
    },
    methods: {
        store() {
            this.form.post('/categories')
        },
    },
}
</script>
