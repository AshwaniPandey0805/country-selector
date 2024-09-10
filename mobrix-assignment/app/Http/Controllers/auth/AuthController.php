<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function registerPage(){
        if(Auth::check()){
            return redirect()->route('admin.dashboard');
        }
        return view('auth.register');
    }

    public function registerProcess(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|min:6'
        ]);

        if($validator->passes()){

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'User created'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function loginPage(){
        if(Auth::check()){
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');

    }

    public function loginProcess(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required'
        ]);

        if($validator->passes()){

            if ( Auth::attempt([ 'email' => $request->email , 'password' => $request->password]) ) {
                return response()->json([
                    'status' => true,
                    'isValid' => 'valid',
                    'message' => 'Admin User'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'isValid' => 'not-valid',
                    'message' => 'wrong credentials'
                ]);
            }

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login.page');
    }
}
