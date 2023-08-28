<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Session\Session;




class adminLoginController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $validator =Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->passes())
        {
            //Now Authenticate Admin
            if(Auth::guard('admin')->attempt(['email' => $request->email, 'password'=> $request->password ], $request->get('remember')))
            {
                $user = Auth::guard('admin')->user();

                if($user->role == 'admin')
                {
                    //redirect to dashboard
                    return redirect()->route('admin.dashboard');
                }
                else
                {
                    Auth::guard('admin')->logout();
                    // $request->session()->flash('error', 'Either email/password is incorrect');
                    session()->flash('error', 'Either email/password is incorrect');



                    $request->session()->put('error', 'Either email/password is incorrect');

                    return redirect()->route('admin.login');
                }
            }
            else
            {



                // $request->session()->flash('error', 'Either email/password is incorrect');
                session()->flash('error', 'Either email/password is incorrect');

                return redirect()->route('admin.login');

            }

        }
        else
        {
            //Redirect with Errors
            return back()->withInput($request->only('email'))->withErrors($validator);
        }
    }

    // logout Function
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

}
