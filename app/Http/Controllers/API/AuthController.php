<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendOTPCode;
use Carbon\Carbon;
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
            'email' => ['required', 'max:50', 'email', Rule::unique('users')],
            'password' => ['nullable'],
            'phone' => ['required', Rule::unique('users')],
        ]);

        if($validator->fails()){
            $user = User::where('email', $request['email'])
                ->where('role', 3)
                ->whereNull('is_verified')
                ->first();
            if($user){
                $data = [
                    'success' => false,
                    'message' => 'Mohon verifikasi E-Mail Anda terlebih dahulu',
                ];
                return response()->json($data);
            }
            $data = [
                'success' => false,
                'message' => 'Akun sudah ada',
            ];
            return response()->json($data);

        }
        try{
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'role' => 3,
            ]);
            $user->generateOTP();
            $user->notify(new SendOTPCode());

            $data = [
                'success' => true,
                'message' => 'Mohon cek email Anda untuk kode OTP',
            ];
        } catch (\Exception $exception){
            $data = [
                'success' => false,
                'message' => 'Terdapat eror! '.$exception->getMessage(),
            ];
        }

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
                ->with('saldo')
                ->where('role', 3)
                ->firstOrFail();
            if($user->is_verified == null){
                return response()
                    ->json([
                        'success' => false,
                        'is_verified' => false,
                        'message' => 'Mohon verifikasi E-Mail Anda terlebih dahulu!',
                    ]);
            } else {
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()
                    ->json([
                        'success' => true,
                        'message' => 'Berhasil login!',
                        'data' => $user,
                        'access_token' => $token,
                        'token_type' => 'Bearer',
                    ]);
            }

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

    public function verify_otp(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'kode_otp' => ['required'],
        ]);

        if($validator->fails()){
            $data = [
                'success' => false,
                'message' => 'Kode OTP tidak boleh kosong!',
            ];
            return response()->json($data);
        }
        try {
            $user = User::where('otp_code', $request->kode_otp)
                ->whereNull('is_verified')
                ->where('role', 3)
                ->firstOrFail();
            if($user)
            {
                if(Carbon::parse($user->otp_expires_at)->format('Y-m-d H:i:s')<Carbon::now()->format('Y-m-d H:i:s')){
                    return response()
                        ->json([
                            'success' => false,
                            'is_verified' => false,
                            'times_up' => true,
                            'now' => Carbon::parse($user->otp_expires_at)->format('Y-m-d H:i:s'),
                            'message' => 'Kode OTP sudah kadaluarsa',
                        ]);
                } else {
                    $user->resetOTP();
                    $user->update(['is_verified' => 1]);
                    $token = $user->createToken('auth_token')->plainTextToken;
                    return response()
                        ->json([
                            'success' => true,
                            'is_verified' => true,
                            'times_up' => false,
                            'message' => 'Akun berhasil diverifikasi!',
                            'access_token' => $token,
                            'token_type' => 'Bearer',
                        ]);
                }
            }
        } catch (\Exception $e){
            return response()
                ->json([
                    'success' => false,
                    'is_verified' => false,
                    'times_up' => false,
                    'message' => 'Kode OTP salah! '.$e->getMessage(),
                ]);
        }
    }

    public function resend(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => ['required'],
        ]);

        if($validator->fails()){
            $data = [
                'success' => false,
                'message' => 'E-Mail tidak boleh kosong!',
            ];
            return response()->json($data);
        }
        try {
            $user = User::where('email', $request->email)
                ->where('role', 3)
                ->firstOrFail();
            if($user)
            {
                $user->generateOTP();
                $user->notify(new SendOTPCode());
                return response()
                    ->json([
                        'success' => true,
                        'message' => 'Kode OTP sudah dikirim ulang!',
                    ]);
            }
        } catch (\Exception $e){
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Terdapat eror! '.$e->getMessage(),
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
            $user = User::where('id', auth()->user()->id)->with('saldo')->first();
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
