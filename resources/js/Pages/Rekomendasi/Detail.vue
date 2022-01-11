<template>
    <div>
        <h1 class="mb-8 font-bold text-3xl">Hasil Rekomendasi</h1>

        <h4 class="my-2 font-bold">Data Input User</h4>
        <div class="bg-white mb-2 rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="w-1/6">#</th>
                    <th class="px-6 pt-6 pb-4">C1</th>
                    <th class="px-6 pt-6 pb-4">C2</th>
                    <th class="px-6 pt-6 pb-4">C3</th>
                </tr>
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t bg-green-400">
                        <p class="px-6 py-4 flex items-center focus:text-green-500">
                            Linguistik
                        </p>
                    </td>
                    <td class="border-t" v-for="value_bobot in linguistik">
                        <p class="px-6 py-4 flex items-center focus:text-green-500">
                            {{value_bobot}}
                        </p>
                    </td>
                </tr>
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t bg-green-400">
                        <p class="px-6 py-4 flex items-center focus:text-green-500">
                            Bobot
                        </p>
                    </td>
                    <td class="border-t" v-for="value_bobot in bobot">
                        <p class="px-6 py-4 flex items-center focus:text-green-500">
                            ({{value_bobot[0].toFixed(2)}}, {{value_bobot[1].toFixed(2)}}, {{value_bobot[2].toFixed(2)}})
                        </p>
                    </td>
                </tr>
            </table>
        </div>

        <h4 class="my-2 font-bold">Data Spesifikasi barang</h4>
        <div class="bg-white rounded-md shadow overflow-x-auto mt-4">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Kode</th>
                    <th class="px-6 pt-6 pb-4">Jumlah supplier</th>
                    <th class="px-6 pt-6 pb-4">Rating</th>
                    <th class="px-6 pt-6 pb-4">Harga</th>
                </tr>
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100" v-for="product in daftar_barang" :key="product.id">
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-green-500">
                            {{product.id}}
                        </p>
                    </td>
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-green-500">
                            {{product.criterias[0].nilai}}
                        </p>
                    </td>
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-green-500">
                            {{product.criterias[1].nilai}}
                        </p>
                    </td>
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-green-500">
                            {{product.criterias[2].nilai}}
                        </p>
                    </td>
                </tr>

            </table>
        </div>

        <h4 class="my-2 font-bold">Data Linguistik Barang</h4>
        <div class="bg-white rounded-md shadow overflow-x-auto mt-4">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Kode</th>
                    <th class="px-6 pt-6 pb-4">Jumlah supplier</th>
                    <th class="px-6 pt-6 pb-4">Rating</th>
                    <th class="px-6 pt-6 pb-4">Harga</th>
                </tr>
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100" v-for="product in daftar_barang" :key="product.id">
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-green-500">
                            {{product.id}}
                        </p>
                    </td>
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-green-500">
                            {{product.criterias[0].kriteria.himpunan}}
                        </p>
                    </td>
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-green-500">
                            {{product.criterias[1].kriteria.himpunan}}
                        </p>
                    </td>
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-green-500">
                            {{product.criterias[2].kriteria.himpunan}}
                        </p>
                    </td>
                </tr>

            </table>
        </div>

        <h4 class="my-2 font-bold">Data Matriks Hasil Keputusan</h4>
        <div class="bg-white rounded-md shadow overflow-x-auto mt-4">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Kode</th>
                    <th class="px-6 pt-6 pb-4">C1</th>
                    <th class="px-6 pt-6 pb-4">C2</th>
                    <th class="px-6 pt-6 pb-4">C3</th>
                </tr>
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100" v-for="(product, index) in matriks" >
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-green-500">
                            {{index}}
                        </p>
                    </td>
                    <td class="border-t" v-for="arr in product">
                        <p class="px-6 py-4 flex items-center focus:text-green-500">
                            ({{arr[0].toFixed(2)}}, {{arr[1].toFixed(2)}}, {{arr[2].toFixed(2)}})

                        </p>
                    </td>
                </tr>

            </table>
        </div>

        <h4 class="my-2 font-bold">Data Matriks Ternormalisasi</h4>
        <div class="bg-white rounded-md shadow overflow-x-auto mt-4">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Kode</th>
                    <th class="px-6 pt-6 pb-4">C1</th>
                    <th class="px-6 pt-6 pb-4">C2</th>
                    <th class="px-6 pt-6 pb-4">C3</th>
                </tr>
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100" v-for="(product, index) in matriks_ternormalisasi" >
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-green-500">
                            {{index}}
                        </p>
                    </td>
                    <td class="border-t" v-for="arr in product">
                        <p class="px-6 py-4 flex items-center focus:text-green-500">
                            ({{arr[0].toFixed(2)}}, {{arr[1].toFixed(2)}}, {{arr[2].toFixed(2)}})

                        </p>
                    </td>
                </tr>

            </table>
        </div>

        <h4 class="my-2 font-bold">Data Matriks Terbobot</h4>
        <div class="bg-white rounded-md shadow overflow-x-auto mt-4">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Kode</th>
                    <th class="px-6 pt-6 pb-4">C1</th>
                    <th class="px-6 pt-6 pb-4">C2</th>
                    <th class="px-6 pt-6 pb-4">C3</th>
                </tr>
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100" v-for="(product, index) in matriks_terbobot" >
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-green-500">
                            {{index}}
                        </p>
                    </td>
                    <td class="border-t" v-for="arr in product">
                        <p class="px-6 py-4 flex items-center focus:text-green-500">
                            ({{arr[0].toFixed(2)}}, {{arr[1].toFixed(2)}}, {{arr[2].toFixed(2)}})

                        </p>
                    </td>
                </tr>

            </table>
        </div>

        <h4 class="my-2 font-bold">Data FSIP</h4>
        <div class="bg-white rounded-md shadow overflow-x-auto mt-4">
            <table class="w-full whitespace-nowrap">
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100"  >
                    <td class="border-t" v-for="ideal in ideal_positif">
                        <p class="px-6 py-4 flex items-center focus:text-green-500">
                            ({{ideal[0].toFixed(2)}}, {{ideal[1].toFixed(2)}}, {{ideal[2].toFixed(2)}})
                        </p>
                    </td>

                </tr>

            </table>
        </div>

        <h4 class="my-2 font-bold">Data FSIN</h4>
        <div class="bg-white rounded-md shadow overflow-x-auto mt-4">
            <table class="w-full whitespace-nowrap">
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100"  >
                    <td class="border-t" v-for="ideal in ideal_negatif">
                        <p class="px-6 py-4 flex items-center focus:text-green-500">
                            ({{ideal[0].toFixed(2)}}, {{ideal[1].toFixed(2)}}, {{ideal[2].toFixed(2)}})
                        </p>
                    </td>

                </tr>

            </table>
        </div>

        <h4 class="my-2 font-bold">Jarak Alternatif</h4>
        <div class="bg-white rounded-md shadow overflow-x-auto mt-4">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Kode</th>
                    <th class="px-6 pt-6 pb-4">D+</th>
                    <th class="px-6 pt-6 pb-4">D-</th>
                </tr>
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100" v-for="(product, index) in dplus" >
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-green-500">
                            {{index}}
                        </p>
                    </td>
                    <td class="border-t">
                        {{product.toFixed(3)}}
                    </td>
                    <td class="border-t">
                        {{dmin[index].toFixed(3)}}
                    </td>
                </tr>


            </table>
        </div>

        <h4 class="my-2 font-bold">Ranking</h4>
        <div class="bg-white rounded-md shadow overflow-x-auto mt-4">
            <table class="w-full whitespace-nowrap">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Kode</th>
                    <th class="px-6 pt-6 pb-4">CCi</th>
                    <th class="px-6 pt-6 pb-4">Ranking-</th>
                </tr>
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100" v-for="(product, key, index) in preferensi" >
                    <td class="border-t">
                        <p class="px-6 py-4 flex items-center focus:text-green-500">
                            {{key}}
                        </p>
                    </td>
                    <td class="border-t">
                        {{product.toFixed(3)}}
                    </td>
                    <td class="border-t">
                        {{get_rank(key)}}
                    </td>
                </tr>


            </table>
        </div>
    </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import SearchFilter from '@/Shared/SearchFilter'

export default {
    metaInfo: { title: 'Hasil Rekomendasi' },
    components: {
        Icon,
        Pagination,
        SearchFilter,
    },
    layout: Layout,
    props: {
        bobot: Array,
        linguistik: Array,
        daftar_barang: Array,
        matriks: Array,
        matriks_ternormalisasi: Array,
        matriks_terbobot: Array,
        ideal_negatif: Array,
        ideal_positif: Array,
        dplus: Array,
        dmin: Array,
        preferensi: Array,
        ranking: Array
    },
    methods: {
        get_rank(id){
            for(var i=1;i<=this.ranking.length;i++){
                console.log(id)
                if(this.ranking[i-1]==id){
                    return i;
                }
            }
        }
    },

}
</script>
