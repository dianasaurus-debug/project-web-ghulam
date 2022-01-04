<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-green-400 hover:text-green-600" :href="route('credits.index')">Saldo
            </inertia-link>
            <span class="text-green-400 font-medium">/</span> Isi Saldo
        </h1>
        <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="store">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <div class="pr-6 pb-8 w-full lg:w-2/3">
                        <label  class="form-label">Customer</label>
                        <multiselect v-model="form.user_id" deselect-label="Tidak bisa dihapus" :options="users.map(user => user.id)" :custom-label="opt => users.find(x => x.id == opt).nama_lengkap" placeholder="Pilih customer" :searchable="true" :allow-empty="false">
                        </multiselect>
                    </div>
                    <text-input v-model="form.jumlah_topup" :type="'number'" :error="form.errors.jumlah_topup"
                                class="pr-6 pb-8 w-full lg:w-1/4" label="Jumlah top up"/>
                    <TextareaInput v-model="form.catatan" :error="form.errors.catatan"
                                   class="pr-6 pb-8 w-full lg:w-1/2" label="Catatan"/>
                </div>
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
                    <loading-button :loading="form.processing" class="btn-green" type="submit">Tambah Saldo
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
    metaInfo: {title: 'Tambah Saldo'},
    components: {
        LoadingButton,
        TextInput,
        TextareaInput
    },
    layout: Layout,
    props: {
        users: Array,
    },
    remember: 'form',
    data() {
        return {
            form: this.$inertia.form({
                user_id: null,
                jumlah_topup: null,
                catatan: null,
            }),
        }
    },
    methods: {
        store() {
            this.form.post('/credits')
        },
    }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
