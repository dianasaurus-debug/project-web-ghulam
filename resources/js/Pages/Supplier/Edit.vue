<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-green-400 hover:text-green-600" :href="route('suppliers.index')">Suplier</inertia-link>
            <span class="text-green-400 font-medium">/</span>
            {{ form.nama_supplier }}
        </h1>

        <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="update">
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
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
                    <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Hapus
                        Suplier
                    </button>
                    <loading-button :loading="form.processing" class="btn-green ml-auto" type="submit">Update Suplier
                    </loading-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TextareaInput from '@/Shared/TextareaInput'
import FileInput from '@/Shared/FileInput'

export default {
    metaInfo() {
        return {
            title: `${this.form.nama_supplier}`,
        }
    },
    components: {
        LoadingButton,
        SelectInput,
        TextInput,
        TextareaInput,
        FileInput
    },
    layout: Layout,
    props: {
        supplier: Object,
    },
    remember: 'form',
    data() {
        return {
            form: this.$inertia.form({
                _method: 'PUT',
                nama_supplier: this.supplier.nama_supplier,
                phone: this.supplier.phone,
                alamat: this.supplier.alamat,
                deskripsi: this.supplier.deskripsi,
                email: this.supplier.email,
            }),
        }
    },
    methods: {
        update() {
            this.form.post('/suppliers/'+this.supplier.id, {
                onSuccess: () => this.form.reset(),
            })
        },
        destroy() {
            if (confirm('Yakin ingin menghapus suplier?')) {
                this.$inertia.delete('/suppliers/' + this.supplier.id)
            }
        },

    },
}
</script>
