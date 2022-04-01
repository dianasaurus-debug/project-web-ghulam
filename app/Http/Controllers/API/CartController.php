<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        try {
            $all_carts = Cart::with('product')
                ->where('user_id', Auth::id())
                ->get();

            $data = array(
                'success' => true,
                'message' => 'Berhasil menampilkan data cart',
                'data' => $all_carts,
            );
            return response()->json($data, 200);
        } catch (\Exception $exception) {
            $data = array(
                [
                    'success' => false,
                    'message' => 'Terjadi kesalahan : '.$exception->getMessage()
                ]
            );
            return response()->json($data, 400);
        }
    }
}
