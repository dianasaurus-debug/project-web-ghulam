<template>
    <div class="min-h-screen flex justify-center items-center">
        <div class="w-full max-w-md">
            <form class="bg-white rounded-lg shadow-xl overflow-hidden" @submit.prevent="hitung">
                <div class="px-10 py-12">
                    <h1 class="text-center font-bold text-3xl">Masukkan parameter</h1>
                    <div class="mx-auto mt-6 w-24 border-b-2" />
                    <select-input v-model="form.category_primary_id" :error="form.errors.category_primary_id"
                                  class="mt-6" label="Kategori Barang">
                        <option :value="null">Pilih Kategori</option>
                        <option v-for="category in categories" :key="category.id" :value="category">
                            {{ category.nama_kategori }}
                        </option>
                    </select-input>
                    <div v-if="form.category_primary_id==null" class="mt-6">
                        <label class="form-label" >Sub Kategori Barang:</label>
                        <select disabled class="form-select">
                            <option :value="null">Pilih Sub Kategori</option>
                        </select>
                    </div>
                    <select-input v-else v-model="form.category_id" :error="form.errors.category_id" class="mt-6" label="Sub Kategori Barang">
                        <option :value="null" disabled>Pilih Sub Kategori</option>
                        <option v-for="category in form.category_primary_id.sub_categories" :key="category.id" :value="category.id">
                            {{ category.nama_kategori }}
                        </option>
                    </select-input>

                    <select-input v-model="form.criteria_supplier" :error="form.errors.criteria_supplier"
                                  class="mt-6" label="Parameter supplier (C1)">
                        <option :value="null">Pilih kriteria</option>
                        <option v-for="(category, index) in input_bobot" :key="index" :value="index">
                            {{ category }}
                        </option>
                    </select-input>
                    <select-input v-model="form.criteria_rating" :error="form.errors.criteria_rating"
                                  class="mt-6" label="Parameter rating (C2)">
                        <option :value="null">Pilih kriteria</option>
                        <option v-for="(category, index) in input_bobot" :key="index" :value="index">
                            {{ category }}
                        </option>
                    </select-input>
                    <select-input v-model="form.criteria_harga" :error="form.errors.criteria_harga"
                                  class="mt-6" label="Parameter harga (C3)">
                        <option :value="null">Pilih kriteria</option>
                        <option v-for="(category, index) in input_bobot" :key="index" :value="index">
                            {{ category }}
                        </option>
                    </select-input>

                </div>
                <div class="px-10 py-4 bg-gray-100 border-t border-gray-100 flex">
                    <loading-button :loading="form.processing" class="ml-auto btn-green" type="submit">Hitung</loading-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Logo from '@/Shared/Logo'
import LoadingButton from '@/Shared/LoadingButton'
import Layout from "../../Shared/Layout";
import SelectInput from "../../Shared/SelectInput";

export default {
    metaInfo: { title: 'Input Parameter' },
    components: {
        LoadingButton,
        Logo,
        SelectInput,
    },
    props: {
        matriks: Array,
        input_bobot: Object,
        categories : Array
    },
    layout : Layout,
    data() {
        return {
            form: this.$inertia.form({
                criteria_supplier: null,
                criteria_rating: null,
                criteria_harga: null,
                category_id : null,
                category_primary_id : null,
            }),
        }
    },
    methods: {
        hitung() {
            this.form.get(this.route('rekomendasi.hasil'))
        },
    },
}
</script>
