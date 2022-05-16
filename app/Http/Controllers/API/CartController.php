<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        try {
            $all_carts = Cart::with('product.category.main_category', 'product.criterias')
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
    public function add_to_cart(Request $request) {
        $validator = Validator::make($request->all(),[
            'jumlah' => 'required',
            'product_id' => 'required',
        ]);

        if($validator->fails()){
            $data = [
                'success' => false,
                'message' => 'Akun sudah ada atau pastikan data yang Anda masukkan benar',
            ];
            return response()->json($data);
        }
        try{
            $product = Product::where('id', $request->product_id)->first();
            $existing = Cart::where('product_id', $product->id)
                ->where('user_id', Auth::id())
                ->first();
            if($product){
                if($existing){
                    $total_price = $request->jumlah * $product->harga_jual;
                    $cart = Cart::update([
                        'jumlah' => $request->jumlah,
                        'total' => $total_price,
                        'product_id' => $product->id,
                        'user_id' => Auth::id()
                    ]);
                }
                else {
                    $total_price = $request->jumlah * $product->harga_jual;
                    $cart = Cart::create([
                        'jumlah' => $request->jumlah,
                        'total' => $total_price,
                        'product_id' => $product->id,
                        'user_id' => Auth::id()
                    ]);
                }
                $data = [
                    'success' => true,
                    'message' => 'Product berhasil ditambahkan ke cart',
                ];
            } else {
                $data = [
                    'success' => false,
                    'message' => 'Product tidak ditemukan',
                ];
            }
        } catch (\Exception $exception){
            $data = [
                'success' => false,
                'message' => 'Terdapat eror! '.$exception->getMessage(),
            ];
        }

        return response()->json($data);
    }
    public function remove($id)
    {
        try {
            $cart = Cart::where('user_id', Auth::id())->where('id', $id)->first();
            if($cart){
                $cart->delete();
                $data = array(
                    'success' => true,
                    'message' => 'Berhasil menghapus data cart',
                    'data' => $cart,
                );
            } else {
                $data = array(
                    'success' => false,
                    'message' => 'Gagal! data cart tidak ditemukan',
                    'data' => $cart,
                );
            }

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
    public function scan_product($id) {
        try{
            $cart = Cart::where('product_id', $id)->first();
            if($cart){
                $cart->update(['is_scanned' => 1]);
                $data = [
                    'success' => true,
                    'message' => 'Product berhasil ditambahkan ke cart',
                ];
            } else {
                $data = [
                    'success' => false,
                    'message' => 'Product tidak ditemukan',
                ];
            }
        } catch (\Exception $exception){
            $data = [
                'success' => false,
                'message' => 'Terdapat eror! '.$exception->getMessage(),
            ];
        }

        return response()->json($data);
    }
    public function remove_product($id) {
        try{
            $cart = Cart::where('product_id', $id)->first();
            if($cart){
                $cart->update(['is_scanned' => 0]);
                $data = [
                    'success' => true,
                    'message' => 'Product berhasil ditambahkan ke cart',
                ];
            } else {
                $data = [
                    'success' => false,
                    'message' => 'Product tidak ditemukan',
                ];
            }
        } catch (\Exception $exception){
            $data = [
                'success' => false,
                'message' => 'Terdapat eror! '.$exception->getMessage(),
            ];
        }

        return response()->json($data);
    }

}
