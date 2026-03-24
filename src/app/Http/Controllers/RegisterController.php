<?php

namespace App\Http\Controllers;


use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{

    public function index()
    {
        return view('auth.register');
    }


    public function store(RegisterRequest $request)
    {
        $user = $request->all();

        $user['password'] = Hash::make($request->password);

        \App\Models\User::create($user);

        return redirect('/login');
    }
}
