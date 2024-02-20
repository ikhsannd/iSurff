<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function create()
    {
        $data = Role::get();
        return view('auth.register', compact('data'));
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
            'password' => ['required', 'min:5', 'max:20'],
            'role_id' => ['required'],
            'alamat' => ['required'],
            'no_telp' => ['required'],
        ]);
        $attributes['password'] = bcrypt($attributes['password']);
       
        session()->flash('success', 'Your account has been created.');
        $user = User::create($attributes);
        Auth::login($user);
        return redirect('login');
    }
}
