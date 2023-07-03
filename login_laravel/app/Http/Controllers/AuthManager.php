<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthManager extends Controller
{
   function login(){
    return view('login');
   }

   function registration (){
    return view('registration');
}
    function loginPost(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only(keys: 'email', 'password');
        if(Auth::attempt($credentials)){
            return redirect()->intended(route(name: 'home'));
        }
        return redirect(route(name: 'login'))->with("error", "Login details are not valid");
    }

    function registrationPost(Request $request){
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required'
            ]);

            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['password'] = Hash::make($request->password);
            $user = user::create($data)
            if (!$user){
                return redirect(route(name: 'regisstration'))->with("error", "Registration failed, plss try again.");
            }
            return redirect(route(name: 'login'))->with("Success", "Your Resgistration Successfully");
    }
}
