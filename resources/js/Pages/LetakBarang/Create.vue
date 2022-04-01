<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-green-400 hover:text-green-600" :href="route('categories.index')">Letak Barang
            </inertia-link>
            <span class="text-green-400 font-medium">/</span> Tambah
        </h1>
        <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="store">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input v-model="form.name" :error="form.errors.name"
                                class="pr-6 pb-8 w-full lg:w-1/2" label="Nama Letak"/>
                    <TextareaInput v-model="form.description" :error="form.errors.description"
                                   class="pr-6 pb-8 w-full lg:w-1/2" label="Deskripsi Letak"/>
                    <file-input v-model="form.image" :error="form.errors.image" class="pr-6 pb-8 w-full lg:w-1/2"
                                type="file" accept="image/*" label="Gambar Letak"/>
                </div>
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
                    <loading-button :loading="form.processing" class="btn-green" type="submit">Buat Letak Barang
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
import FileInput from "../../Shared/FileInput";
import TextareaInput from "../../Shared/TextareaInput";

export default {
    metaInfo: {title: 'Tambah Letak Barang'},
    components: {
        TextInput,
        LoadingButton,
        FileInput,
        TextareaInput
    },
    layout: Layout,
    remember: 'form',
    props: {
        letak : Array,
    },
    data() {
        return {
            form: this.$inertia.form({
                name : null,
                description : null,
                image : null,
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
