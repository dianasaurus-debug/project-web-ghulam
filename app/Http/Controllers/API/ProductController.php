<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
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
                    'message' => 'Berhasil menampilkan data vendor',
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
}
