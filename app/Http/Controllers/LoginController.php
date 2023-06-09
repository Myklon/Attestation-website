<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
       // $this->middleware('guest');

//        $this->middleware('redirect_if_authenticated')->only(['login']);
    }
    public function index()
    {
        return view('auth.login');
    }
    public function login(LoginRequest $request)
    {
        $remember = isset($request->remember);
        if (Auth::attempt($request->validated(), $remember))
            return redirect()->route('profile.show', Auth::id())->with('success',  __('login.success.success'));
        return redirect()->route('login')->withInput($request->only('login'))->withErrors(['fail' => __('login.fail.fail')]);
    }
}
