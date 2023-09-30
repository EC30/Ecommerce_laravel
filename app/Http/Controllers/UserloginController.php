<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserloginController extends Controller
{
    public function register(){
        return view('User.register');
    }
    public function login(){
        return view('User.login');
    }


    public function authenticate(Request $request){
            $validator=Validator::make($request->all(),[
                'email'=>'required|email',
                'password'=>'required'
            ]);
            if($validator->fails()){
                return redirect()->route('user.login')
                ->withErrors($validator)
                ->withInput();
            }
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                return redirect()->route('user.profile')->with('success', 'Login successful');
            } else{
                return redirect()->route('user.login')->with('message', 'Invalid login credentials');
            }
        
    }
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:6',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required|min:6',
            'cpassword' => 'required|same:password',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('user.register')
                ->withErrors($validator)
                ->withInput();
        }
    
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->password = $request->input('password');
    
       
        $user->save();
        
        return redirect()->route('user.login')->with('message', 'User register Successfully');
    }

    public function profile(){
        return view('User.profile');

    }
    public function logout(){
        Auth::logout();
        return redirect()->route('user.login')->with('message', 'logout Successfully');
    }
}
