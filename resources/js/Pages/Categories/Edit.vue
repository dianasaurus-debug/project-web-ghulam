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
        sub_categories : Array
    },
    remember: 'form',
    data() {
        return {
            form: this.$inertia.form({
                _method: 'PUT',
                sub_category_list : this.sub_categories,
                nama_kategori : this.categories.nama_kategori,
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
        addMoreSubCategory(){
            this.form.sub_category_list.push({
                id: null,
                nama_kategori : '',
                min_harga : '',
                max_harga : ''
            });
        },
        removeSubCategory(index){
            this.form.sub_category_list.splice(index, 1);
        },
    },

}
</script>
