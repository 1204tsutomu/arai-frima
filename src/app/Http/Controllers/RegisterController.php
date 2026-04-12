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


    // App/Http/Controllers/RegisterController.php

    public function store(RegisterRequest $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        auth()->login($user);


        return redirect()->route('profile.edit');
    }
}
