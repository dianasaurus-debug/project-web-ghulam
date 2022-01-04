<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">
            <inertia-link class="text-green-400 hover:text-green-600" :href="route('products.index')">Produk</inertia-link>
            <span class="text-green-400 font-medium">/</span>
            {{ form.nama_barang }}
        </h1>

        <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
            <form @submit.prevent="update">
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
                    <select-input v-model="form.supplier_id" :error="form.errors.supplier_id"
                                  class="pr-6 pb-8 w-full lg:w-1/2" label="Suplier">
                        <option :value="null">Pilih Suplier</option>
                        <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">
                            {{ supplier.nama_supplier }}
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
                    <text-input v-model="presentase_keuntungan" aria-readonly="true"
                                class="pr-6 pb-8 w-full lg:w-1/2" label="Presentase Keuntungan"/>
                    <file-input v-model="form.gambar" :error="form.errors.gambar" class="pr-6 pb-8 w-full lg:w-1/2"
                                type="file" accept="image/*" label="Gambar Produk"/>
                    <div class="flex flex-col">
                        <div class="mb-2">
                            <h6 class="font-bold">QR Code Barang</h6>
                        </div>
                        <div>
                            <img width="200" v-bind:src="'/qr_codes/'+product.qr_code">
                        </div>
                    </div>

                </div>
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
                    <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Hapus
                        Barang
                    </button>
                    <loading-button :loading="form.processing" class="btn-green ml-auto" type="submit">Update Barang
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
            title: `${this.form.nama_barang}`,
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
        product: Object,
        categories: Array,
        suppliers: Array,
    },
    remember: 'form',
    data() {
        return {
            form: this.$inertia.form({
                _method: 'PUT',
                kode_barang: this.product.kode_barang,
                nama_barang: this.product.nama_barang,
                harga_beli: this.product.harga_beli,
                harga_jual: this.product.harga_jual,
                deskripsi: this.product.deskripsi,
                stok: this.product.stok,
                category_id: this.product.category_id,
                supplier_id: this.product.supplier_id,
                gambar: null,

            }),
        }
    },
    methods: {
        update() {
            this.form.post('/products/'+this.product.id, {
                onSuccess: () => this.form.reset('gambar'),
            })
        },
        destroy() {
            if (confirm('Yakin ingin menghapus produk?')) {
                this.$inertia.delete('/products/' + this.product.id)
            }
        },
    },
    computed : {
        presentase_keuntungan() {
            if(this.form.harga_jual==0&&this.form.harga_beli==0){
                return 0;
            } else {
                return (((this.form.harga_jual-this.form.harga_beli)/this.form.harga_beli)*100).toFixed(2);
            }
        }
    },
}
</script>
