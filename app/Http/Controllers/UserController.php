<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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

    public function register()
    {
        return view('user.register');
    }

    public function registerStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|min:10|max:11|unique:users,phone',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|same:password',
            'referral_code' => 'nullable|string|max:50',
            'agree_terms' => 'required|accepted',
        ], [
            'full_name.required' => __('auth.full_name') . ' is required',
            'full_name.max' => __('auth.full_name') . ' must not exceed 255 characters',
            'phone.required' => __('auth.phone_number') . ' is required',
            'phone.min' => __('auth.phone_number') . ' must be at least 10 digits',
            'phone.max' => __('auth.phone_number') . ' must not exceed 11 digits',
            'phone.unique' => __('auth.phone_number') . ' already exists',
            'password.required' => __('auth.password') . ' is required',
            'password.min' => __('auth.password') . ' must be at least 6 characters',
            'password_confirmation.required' => __('auth.confirm_password') . ' is required',
            'password_confirmation.same' => __('auth.password_mismatch'),
            'referral_code.max' => __('auth.referral_code') . ' must not exceed 50 characters',
            'agree_terms.required' => __('auth.terms_required'),
            'agree_terms.accepted' => __('auth.terms_required'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except(['password', 'password_confirmation']));
        }

        // For demo purposes, we'll simulate a successful registration
        // In a real application, you would create a new user in your database
        try {
            $user = User::create([
                'name' => $request->full_name,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'referral_code' => $request->referral_code,
                'email' => $request->phone . '@tiktokshop.local', // Demo email
            ]);

            return redirect()->route('login')
                ->with('success', __('auth.registration_success'))
                ->with('registered_phone', $request->phone);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['register' => 'Registration failed. Please try again.'])
                ->withInput($request->except(['password', 'password_confirmation']));
        }
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
