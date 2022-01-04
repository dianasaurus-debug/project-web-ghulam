<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\User;
use App\Models\UserCredit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UserCreditsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $all_credits = UserCredit::with('user')
            ->with('admin')
            ->filter(\Illuminate\Support\Facades\Request::only(['search', 'user', 'admin', 'jumlah']))
            ->paginate(10)
            ->withQueryString();
        return Inertia::render('Credits/Index', [
            'users' => User::orderBy('first_name')
                ->get()
                ->map
                ->only('id', 'first_name', 'last_name'),
            'filters' => \Illuminate\Support\Facades\Request::all('search', 'user', 'admin', 'jumlah'),
            'credits' => $all_credits
        ]);
    }
    public function edit(User $user)
    {
        //
    }
    public function create(User $user)
    {
        return Inertia::render('Credits/Create', [
            'users' => User::where('role', 3)->get()
                ->transform(function ($user) {
                    return [
                        'id' => $user->id,
                        'nama_lengkap' => $user->first_name.' '.$user->last_name,
                    ];
                }),
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'jumlah_topup' => 'required',
        ]);

        UserCredit::create([
            'user_id' => $request->get("user_id"),
            'jumlah_topup' => $request->get("jumlah_topup"),
            'catatan' => $request->get("catatan"),
            'admin_id' => Auth::user()->id,
        ]);
        $existing_credit = Credit::where('user_id', $request->get("user_id"))->first();
        if($existing_credit){
            $existing_credit->update(['jumlah' => $existing_credit->jumlah+$request->get("jumlah_topup")]);
        } else {
            Credit::create([
                'user_id' => $request->get("user_id"),
                'jumlah' => $request->get("jumlah_topup"),
            ]);
        }
        return redirect()->route('credits.index')->with('success', 'Saldo berhasil ditambahkan!');
    }
}
