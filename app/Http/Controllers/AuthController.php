<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class Authcontroller extends Controller
{

    public function signin(Request $request)
    {

        $request->validate([
            'email' => ['required', 'string', 'email' ],
            'password' => ['required', 'string' ],
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password,'Status' => 'مفعل'])){
            $user = Auth::user();

            return redirect(url('/' . $page='home'));
            }else{
                return back()->withErrors(
                    [
                        'loginerr' => 'الحساب معطل برجاء التواصل مع المسؤل'
                    ]
                );
            }

        }else{
            return back()->withErrors(
                [
                    'loginerr' => 'The email or password not correct'
                ]
            );
        }
    }


    public function signup(Request $request)
    {
        $this->validate($request , [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],

           ]);

            User::create([
            'name' => $request->name ,
            'email' => $request->email ,
            'password' => Hash::make($request->password ),
        ]);
        return redirect(url('/' . $page='home'));
    }
}
