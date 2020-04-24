<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {

    $this->validate($request, [
        'email' => 'required|email|exists:users,email',
        'password' => 'required|string'
    ]);

    
    $auth = $request->only('email', 'password');
    $auth['status'] = 1; //TAMBAHKAN JUGA STATUS YANG BISA LOGIN HARUS 1
  
    
    if (auth()->attempt($auth)) {
        
        return redirect()->intended(route('home'));
    }
    
    return redirect()->back()->with(['error' => 'Pengguna Belum Diaktifkan']);
   }

   
}
