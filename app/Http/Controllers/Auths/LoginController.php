<?php

namespace App\Http\Controllers\Auths;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        //
        // $user=User::where('email',$request->email)->first();

        // if(!$user || !Hash::check($request->password,$user->password)){

        //     throw ValidationException::withMessages([
        //         'email'=>['The credentials you entered are incorrect.']
        //     ]);
        // }

        if(!auth()->attempt($request->only(['email','password']))){
            throw ValidationException::withMessages([
                'email'=>['the credentails you entered are incorrect,']
            ]);
        }else{
            return Auth::user();
        }
    }
}
