<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-green-400 hover:text-green-600" :href="route('products.index')">Kriteria
            </inertia-link>
            <span class="text-green-400 font-medium">/</span> Edit
        </h1>
        <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="store">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input v-model="form.nama_barang" :error="form.errors.nama_barang"
                                class="pr-6 pb-8 w-full lg:w-1/2" label="Nama Barang"/>

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
        suppliers: Array,
    },
    remember: 'form',
    data() {
        return {
            form: this.$inertia.form({
                kriteria1: null,
                kriteria2: null,
                kriteria3: null,
                kriteria4: null,
                kriteria5: null,
            }),
        }
    },
    computed : {
        presentase_keuntungan() {
            if(this.form.harga_jual==null&&this.form.harga_beli==null){
                return 0;
            } else {
                return (((this.form.harga_jual-this.form.harga_beli)/this.form.harga_beli)*100).toFixed(2);
            }
        }
    },
    methods: {
        store() {
            this.form.post('/products')
        },
    }
}
</script>
