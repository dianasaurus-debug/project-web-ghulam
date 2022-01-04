<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-green-400 hover:text-green-600" :href="route('suppliers.index')">Suplier
            </inertia-link>
            <span class="text-green-400 font-medium">/</span> Tambah
        </h1>
        <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="store">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input v-model="form.nama_supplier" :error="form.errors.nama_supplier"
                                class="pr-6 pb-8 w-full lg:w-1/2" label="Nama Suplier"/>
                    <text-input v-model="form.email" :error="form.errors.email" class="pr-6 pb-8 w-full lg:w-1/2" label="Email" />
                    <text-input v-model="form.phone" :error="form.errors.phone" class="pr-6 pb-8 w-full lg:w-1/2" label="Nomor HP" />
                    <TextareaInput v-model="form.deskripsi" :error="form.errors.deskripsi"
                                   class="pr-6 pb-8 w-full lg:w-1/2" label="Deskripsi"/>
                    <TextareaInput v-model="form.alamat" :error="form.errors.alamat"
                                   class="pr-6 pb-8 w-full lg:w-1/2" label="Alamat"/>
                </div>
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
                    <loading-button :loading="form.processing" class="btn-green" type="submit">Simpan
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
    remember: 'form',
    data() {
        return {
            form: this.$inertia.form({
                nama_supplier: null,
                phone: null,
                email: null,
                deskripsi: null,
                alamat: null,
            }),
        }
    },
    methods: {
        store() {
            this.form.post('/suppliers')
        },
    },
}
</script>
