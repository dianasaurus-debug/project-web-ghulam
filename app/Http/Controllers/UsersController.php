<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $user_admin = User::filter(\Illuminate\Support\Facades\Request::only(['search', 'role']))
            ->where('role', 3)
            ->get()
            ->transform(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'photo' => $user->photo_path ? URL::route('image', ['path' => $user->photo_path, 'w' => 40, 'h' => 40, 'fit' => 'crop']) : null,
                    'deleted_at' => $user->deleted_at,
                ];
            });
        $user_pemilik = User::filter(\Illuminate\Support\Facades\Request::only(['search', 'role']))
            ->get()
            ->transform(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'photo' => $user->photo_path ? URL::route('image', ['path' => $user->photo_path, 'w' => 40, 'h' => 40, 'fit' => 'crop']) : null,
                    'deleted_at' => $user->deleted_at,
                ];
            });
        return Inertia::render('Users/Index', [
            'filters' => \Illuminate\Support\Facades\Request::all('search', 'role'),
            'users' => Auth::user()->role == 1 ? $user_pemilik : $user_admin
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/Create');
    }

    public function store()
    {
        Request::validate([
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', Rule::unique('users')],
            'password' => ['nullable'],
            'role' => ['required'],
            'phone' => ['required', Rule::unique('users')],
            'photo' => ['nullable', 'image'],
        ]);

        User::create([
            'first_name' => Request::get('first_name'),
            'last_name' => Request::get('last_name'),
            'email' => Request::get('email'),
            'password' => Request::get('password'),
            'role' => Request::get('role'),
            'phone' => Request::get('phone'),
            'photo_path' => Request::file('photo') ? Request::file('photo')->store('users') : null,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat!');
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', [
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'role' => $user->role,
                'phone' => $user->phone,
                'photo' => $user->photo_path ? URL::route('image', ['path' => $user->photo_path, 'w' => 60, 'h' => 60, 'fit' => 'crop']) : null,
            ],
        ]);
    }

    public function update(User $user)
    {
        if (App::environment('demo') && $user->isDemoUser()) {
            return Redirect::back()->with('error', 'Updating the demo user is not allowed.');
        }

        Request::validate([
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable'],
            'role' => ['required'],
            'photo' => ['nullable', 'image'],
            'phone' => ['required', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update(Request::only('first_name', 'last_name', 'email', 'role', 'phone'));

        if (Request::file('photo')) {
            $user->update(['photo_path' => Request::file('photo')->store('users')]);
        }

        if (Request::get('password')) {
            $user->update(['password' => Request::get('password')]);
        }
        return redirect()->route('users')->with('success', 'User berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        if (App::environment('demo') && $user->isDemoUser()) {
            return Redirect::back()->with('error', 'Deleting the demo user is not allowed.');
        }
        $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        if (file_exists($storagePath.$user->photo_path)) unlink($storagePath.$user->photo_path);
        $user->delete();

        return redirect()->route('users')->with('success', 'User berhasil dihapus!');
    }

}
