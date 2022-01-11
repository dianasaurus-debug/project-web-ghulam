<template>
    <div class="min-h-screen flex justify-center items-center">
        <div class="w-full max-w-md">
            <logo class="block mx-auto w-full max-w-xs fill-white" height="50" />
            <form class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden" @submit.prevent="hitung">
                <div class="px-10 py-12">
                    <h1 class="text-center font-bold text-3xl">Masukkan parameter</h1>
                    <div class="mx-auto mt-6 w-24 border-b-2" />
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
import TextInput from '@/Shared/TextInput'
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
        suppliers: Array,
        rating: Array,
        harga: Array,
        matriks: Array,
        input_bobot: Array,

    },
    layout : Layout,
    data() {
        return {
            form: this.$inertia.form({
                criteria_supplier: null,
                criteria_rating: null,
                criteria_harga: null,
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
