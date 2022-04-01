<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-green-400 hover:text-green-600" :href="route('categories.index')">Produk</inertia-link>
            <span class="text-green-400 font-medium">/</span>
            {{ form.nama_kategori }}
        </h1>

        <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="update">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input v-model="form.nama_kategori" :error="form.errors.nama_kategori"
                                class="pr-6 pb-8 w-full lg:w-1/2" label="Nama Kategori"/>
                    <select-input v-model="form.letak_id" :error="form.errors.letak_id"
                                  class="pr-6 pb-8 w-full lg:w-1/2" label="Letak Kategori">
                        <option :value="null">Pilih Letak</option>
                        <option v-for="le in letak" :key="le.id" :value="le.id">
                            {{ le.name }}
                        </option>
                    </select-input>
                </div>

                <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
                    <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Hapus
                        Kategori
                    </button>
                    <loading-button :loading="form.processing" class="btn-green ml-auto" type="submit">Update Kategori
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
import SelectInput from '@/Shared/SelectInput'


export default {
    metaInfo() {
        return {
            title: `${this.form.nama_kategori}`,
        }
    },
    components: {
        LoadingButton,
        TextInput,
        SelectInput,
    },
    layout: Layout,
    props: {
        categories: Object,
        letak : Array,
    },
    remember: 'form',
    data() {
        return {
            form: this.$inertia.form({
                _method: 'PUT',
                letak_id : this.categories.letak_id,
                nama_kategori: this.categories.nama_kategori,
            }),
        }
    },
    methods: {
        update() {
            this.form.post('/categories/'+this.categories.id)
        },
        destroy() {
            if (confirm('Yakin ingin menghapus kategori?')) {
                this.$inertia.delete('/categories/' + this.categories.id)
            }
        },

    },
}
</script>
