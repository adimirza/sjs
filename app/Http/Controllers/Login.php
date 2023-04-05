<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Captcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Login extends Controller
{
    public function index()
    {
        $data['title'] = 'Login';
        return view('login.index', $data);
    }

    public function register()
    {
        $data['title'] = 'Register';
        return view('login.register', $data);
    }

    public function proses_login(Request $request)
    {
        Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            // 'captcha' => 'required|captcha'
            // 'CaptchaCode' => 'required|captcha_validate'
            // 'g-recaptcha-response' => 'recaptcha',
        ])->validate();

        $cek = UserModel::where('username', $request->username)->first();
        if($cek['password'] == md5($request->password)){
            $username = $cek['username'];
            return view('login.reset', compact('username'));
        }
        
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->with('loginError', 'Login Failed!');
    }

    public function reset(Request $request)
    {
        // if ($request->isMethod('POST')) {
            $validatedData = $request->validate([
                'password' => 'required|confirmed|min:6',
                'password_confirmation' => 'required|min:6',
            ]);

            if ($validatedData) {
                $user = UserModel::where('username', $request->username)->first();
                $user->update([
                    'password' => Hash::make($request->password),
                    'updated_by' => $request->username,
                ]);
                return redirect('login')->with('success', 'Reset password berhasil');
            }
            return redirect('login')->with('loginError', 'Reset password gagal.');
        // }
    }

    // public function reloadCaptcha()
    // {
    //     return response()->json(['captcha'=> captcha_img()]);
    // }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        UserModel::create($validatedData);
        return redirect('/login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
