<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    public function index_wishlist()
    {
        try {
            $all_wishlist = Wishlist::where('user_id', Auth::id())
                ->with('product.category.main_category', 'product.criterias')->get();
            $data = array(
                'success' => true,
                'message' => 'Berhasil menampilkan data wishlist',
                'data' => $all_wishlist,
            );
            return response()->json($data,200, [], JSON_NUMERIC_CHECK);
        } catch (\Exception $exception) {
            $data = array(
                [
                    'success' => false,
                    'message' => 'Terjadi kesalahan : '.$exception->getMessage()
                ]
            );
            return response()->json($data,200, [], JSON_NUMERIC_CHECK);
        }
    }
    public function add_to_wishlist($id) {

        try{
            $product = Product::where('id', $id)->first();
            if($product){
                $existing = Wishlist::where('product_id', $product->id)
                    ->where('user_id', Auth::id())
                    ->first();
                if($existing){
                    $data = [
                        'success' => true,
                        'is_exist' => true,
                        'message' => 'Product sudah dimasukkan ke wishlist',
                    ];
                } else {
                    $wishlist = Wishlist::create([
                        'product_id' => $product->id,
                        'user_id' => Auth::id()
                    ]);
                    $data = [
                        'success' => true,
                        'is_exist' => false,
                        'message' => 'Product berhasil ditambahkan ke wishlist',
                    ];
                }


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

        return response()->json($data,200, [], JSON_NUMERIC_CHECK);
    }
    public function remove($id)
    {
        try {
            $wishlist = Wishlist::where('user_id', Auth::id())->where('id', $id)->first();
            if($wishlist){
                $wishlist->delete();
                $data = array(
                    'success' => true,
                    'message' => 'Berhasil menghapus data wishlist',
                    'data' => $wishlist,
                );
            } else {
                $data = array(
                    'success' => false,
                    'message' => 'Gagal! data wishlist tidak ditemukan',
                    'data' => $wishlist,
                );
            }
            return response()->json($data,200, [], JSON_NUMERIC_CHECK);
        } catch (\Exception $exception) {
            $data = array(
                [
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan : '.$exception->getMessage()
                ]
            );
            return response()->json($data,200, [], JSON_NUMERIC_CHECK);
        }
    }
}
