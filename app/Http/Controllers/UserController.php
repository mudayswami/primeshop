<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\AdminUser;

class UserController extends Controller
{
    
    function login(){
        if(Auth::check()){
            return redirect('/');
        }
        return view('login');
    }

    function register(){
        return view('register');
    }

    function postRegister(request $request){
        
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'], 
            'last_name' => ['required', 'string', 'max:255'], 
            'email' => ['required', 'email', 'unique:admin_user,email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $admin = AdminUser::create([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
        ]);

        // Auth::login($admin);

        return redirect('login');

    }


    function postLogin(Request $request){

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $user_data['id']            = $user->id;
            $user_data['first_name']    = $user->first_name;
            $user_data['last_name']     = $user->last_name;
            $user_data['email']         = $user->email;
            session()->put('user_data', $user_data);
            return redirect('/');
        } else {
            return back()->withErrors(provider: "Email or Password doesn't match");
        }

    }


    function logout(Request $request){
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('login');
    }



}
