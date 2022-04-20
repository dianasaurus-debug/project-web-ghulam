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
                                class="pr-6 w-full lg:w-1/2" label="Nama Kategori"/>
                </div>
                <div class="p-8 -mr-6 mb-8">
                    <div class="flex gap-4 items-center mb-3">
                        <h4 class="font-bold">Daftar Sub Kategori</h4>
                        <button type="button" class="btn-green btn-sm" @click="addMoreSubCategory()"
                        >+ Tambah Sub Kategori
                        </button>
                    </div>
                    <div class="flex items-center gap-4" v-for="(subcategory, index) in form.sub_category_list" :key="index">
                        <text-input v-model="subcategory.nama_kategori" label="Nama Kategori"/>
                        <text-input v-model="subcategory.min_harga" label="Min Harga"/>
                        <text-input v-model="subcategory.max_harga" label="Max Harga"/>
                            <a href="" v-if="index != 0" type="button" class="font-bold" style="color: red"  @click.prevent="removeSubCategory(index)"
                            >Hapus
                            </a>
                    </div>

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
                sub_category_list : [
                    {
                        nama_kategori : '',
                        min_harga : '',
                        max_harga : ''
                    }
                ],
                nama_kategori : null,
            }),
        }
    },
    methods: {
        addMoreSubCategory(){
          this.form.sub_category_list.push({
                nama_kategori : '',
                min_harga : '',
                max_harga : ''
          });
        },
        removeSubCategory(index){
            this.form.sub_category_list.splice(index, 1);
        },
        store() {
            this.form.post('/categories')
        },
    },
}
</script>
