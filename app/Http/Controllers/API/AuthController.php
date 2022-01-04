<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', Rule::unique('users')],
            'password' => ['nullable'],
            'phone' => ['required', Rule::unique('users')],
        ]);

        if($validator->fails()){
            $data = [
                'success' => false,
                'message' => 'Gagal daftar pastikan data yang dimasukkan lengkap!',
            ];
            return response()->json($data);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 3,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        $data = [
            'success' => true,
            'data' => $user,
            'access_token' => $token,
            'message' => 'User berhasil daftar',
            'token_type' => 'Bearer',
        ];
        return response()->json($data);
    }
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()
                ->json(['success' => false,'message' => 'Unauthorized'], 401);
        }
        try {
            $user = User::where('email', $request['email'])
                ->where('role', 3)
                ->firstOrFail();

            $token = $user->createToken('auth_token')->plainTextToken;
            return response()
                ->json([
                    'success' => true,
                    'message' => 'Berhasil login!',
                    'data' => $user,
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ]);
        } catch (\Exception $e){
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Gagal login! Error : '.$e->getMessage(),
                ]);
        }
    }
    // method for user logout and delete token
    public function logout()
    {
        try {
            auth()->user()->tokens()->delete();
            return response()
                ->json([
                    'success' => true,
                    'message' => 'Berhasil logout!',
                ]);
        } catch (\Exception $e){
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Gagal logout! Error : '.$e->getMessage(),
                ]);
        }
    }

    public function profile(Request $request){
        if(!auth()){
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ]);
        }
        try {
            $user = auth()->user();
            return response()
                ->json([
                    'success' => true,
                    'message' => 'Berhasil menampilkan profil!',
                    'data' => $user
                ]);
        } catch (\Exception $e){
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Gagal menampilkan profil! Error : '.$e->getMessage(),
                ]);
        }
    }

}
