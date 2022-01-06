<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\KriteriaFuzzy;
use App\Models\Product;
use App\Models\ProductKriteria;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function index(Request $request) //Nampilin semua data tanpa terkecuali di tabel product
        {
            try {
                $all_products = Product::with('category')
                    ->get();
                $data = array(
                    'status' => 'success',
                    'message' => 'Berhasil menampilkan data products',
                    'data' => $all_products,
                );
                return response()->json($data);
            } catch (\Exception $exception) {
                $data = array(
                    [
                        'status' => 'error',
                        'message' => 'Terjadi kesalahan : '.$exception->getMessage()
                    ]
                );
                return response()->json($data);
            }
        }

        public function product_detail(Request $request) //Nampilin semua data tanpa terkecuali di tabel product
        {
            try {
                $product = Product::where('kode_barang', $request->kode_barang)
                    ->orWhere('id', $request->id)
                    ->with('category')
                    ->first();
                $data = array(
                    'status' => 'success',
                    'message' => 'Berhasil menampilkan data product',
                    'data' => $product,
                );
                return response()->json($data);
            } catch (\Exception $exception) {
                $data = array(
                    [
                        'status' => 'error',
                        'message' => 'Terjadi kesalahan : '.$exception->getMessage()
                    ]
                );
                return response()->json($data);
            }
        }

        public function getRecommendation(Request $request){
            $rentalKriteria = ProductKriteria::with('kriteria.kriteria_fuzzy')->with('product')->get();
            $matriks = array();
            $matriks_ternormalisasi = array();
            $kriteriaFuzzy = KriteriaFuzzy::all();
            $keterangan = getKeterangan($rentalKriteria);
            foreach ($rentalKriteria as $kriteria){
                array_push($matriks,
                    [
                        "product" => $kriteria->product_id,
                        "kode" => $kriteria->kriteria->kode,
                        "tfn" => array($kriteria->kriteria->kriteria_fuzzy->fuzzy_num_a,$kriteria->kriteria->kriteria_fuzzy->fuzzy_num_b,$kriteria->kriteria->kriteria_fuzzy->fuzzy_num_c)
                    ]
                );
            }
//            foreach ($rentalKriteria as $kriteria){
//                $tfn = array($kriteria->kriteria->kriteria_fuzzy->fuzzy_num_a,$kriteria->kriteria->kriteria_fuzzy->fuzzy_num_b,$kriteria->kriteria->kriteria_fuzzy->fuzzy_num_c);
//                array_push($matriks_ternormalisasi,
//                    [
//                        "product" => $kriteria->product_id,
//                        "kode" => $kriteria->kriteria->kode,
//                        "ternormalisasi" => matrikTernormalisasi($tfn, $keterangan)
//                    ]
//                );
//            }
            $group = array();
            foreach ( $matriks as $value ) {
                $group[$value['product']][] = $value;
            }
//            $group2 = array();
//            foreach ( $matriks_ternormalisasi as $value ) {
//                $group2[$value['product']][] = $value;
//            }
            return [
                'matriks' => $group,
//                'matriks_ternormalisasi' => $group2
            ];
        }
}
