<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\KriteriaFuzzy;
use App\Models\Product;
use App\Models\ProductKriteria;
use App\Models\ProductCategory;
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
                $all_products = Product::with('category.main_category')
                    ->with('criterias')
                    ->with('cart')
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
        public function index_categories(Request $request) //Nampilin semua data tanpa terkecuali di tabel product
        {
            try {
                $all_categories = ProductCategory::with('sub_categories')
                    ->get();
                $data = array(
                    'status' => 'success',
                    'message' => 'Berhasil menampilkan data kategori',
                    'data' => $all_categories,
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
            try {
                $input_supplier = $request->criteria_supplier; //diisi id dari kriteria
                $input_rating = $request->criteria_rating; //diisi id dari kriteria
                $input_harga = $request->criteria_harga; //diisi id dari kriteria
                $input_kategori = $request->category_id;
                $array_of_inputs = array($input_supplier,$input_rating,$input_harga);
                $input_kriteria_data = config('constants.bobot_user');
                $lingustik_data = config('constants.code_bobot');
                $linguistik_array = array();
                $used_inputs = array();
                $products = Product::with('criterias.kriteria.kriteria_fuzzy')
                    ->where('category_id', $input_kategori)
                    ->with('cart')
                    ->get();
                $array_of_ids = [];
                $i=0;
                foreach ($products as $product){
                    $array_of_ids[$i] = $product->id;
                    $i++;
                }
                $rentalKriteria = ProductKriteria::with('kriteria.kriteria_fuzzy')
                    ->whereIn('product_id', $array_of_ids)
                    ->with('product')
                    ->orderBy('product_id')
                    ->get();
                $matriks = array();
                $keterangan = getKeterangan($rentalKriteria);
                foreach ($products as $product){
                    $array_of_criterias = array();
                    foreach($product->criterias as $kriteria){
                        $fuzzy_nums[0] = $kriteria->kriteria->kriteria_fuzzy->fuzzy_num_a;
                        $fuzzy_nums[1] = $kriteria->kriteria->kriteria_fuzzy->fuzzy_num_b;
                        $fuzzy_nums[2] = $kriteria->kriteria->kriteria_fuzzy->fuzzy_num_c;
                        array_push($array_of_criterias, $fuzzy_nums);
                    }

                    $matriks[$product->id] = $array_of_criterias;
                }
                foreach ($array_of_inputs as $input){
                    $used_inputs[] = $input_kriteria_data[$input];
                    $linguistik_array[] = $lingustik_data[$input];
                }
                $matriks_ternormalisasi =matrikTernormalisasi($matriks, $keterangan);
                $matriks_terbobot = matrikTerbobot($matriks_ternormalisasi, $used_inputs);
                $ideal_negatif = idealNegatif($matriks_terbobot);
                $ideal_positif = idealPositif($matriks_terbobot);
                $dplus = dPlus($matriks_terbobot, $ideal_positif);
                $dmin = dMin($matriks_terbobot, $ideal_negatif);
                $ranking = rangking(nilaiPreferensi($dplus, $dmin));
                $sorted_products = $products->sortBy(function($product) use($ranking){
                    return array_search($product['id'], $ranking);
                })->values()->all();
                $data = array(
                    'status' => 'success',
                    'message' => 'Berhasil menampilkan data rekomendasi',
                    'data' => $sorted_products,
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
        public function rate_product(Request $request, $id){

        }
        public function add_to_wishlist(Request $request, $id){

        }

}
