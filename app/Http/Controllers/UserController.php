<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function login()
    {
        return view('user.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|min:10|max:11',
            'password' => 'required|string|min:6',
        ], [
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.min' => 'Số điện thoại phải có ít nhất 10 số',
            'phone.max' => 'Số điện thoại không được quá 11 số',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        // For demo purposes, we'll simulate a successful login
        // In a real application, you would validate against your database
        $credentials = $request->only('phone', 'password');
        
        // Demo validation (replace with actual authentication logic)
        if ($credentials['phone'] === '0123456789' && $credentials['password'] === '123456') {
            // Simulate successful login
            session(['user_logged_in' => true, 'user_phone' => $credentials['phone']]);
            return redirect()->intended('/dashboard')->with('success', 'Đăng nhập thành công!');
        }

        return redirect()->back()
            ->withErrors(['login' => 'Số điện thoại hoặc mật khẩu không đúng'])
            ->withInput($request->except('password'));
    }

    public function dashboard()
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để truy cập dashboard');
        }
        
        return view('user.dashboard');
    }

    public function logout()
    {
        session()->forget(['user_logged_in', 'user_phone']);
        return redirect()->route('login')->with('success', 'Đăng xuất thành công!');
    }
}
