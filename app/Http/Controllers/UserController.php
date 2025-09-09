<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Helpers\LanguageHelper;

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
            'full_name.required' => LanguageHelper::getUserTranslation('fill_all_fields'),
            'full_name.max' => LanguageHelper::getUserTranslation('fill_all_fields'),
            'phone.required' => LanguageHelper::getUserTranslation('fill_all_fields'),
            'phone.min' => LanguageHelper::getUserTranslation('invalid_phone'),
            'phone.max' => LanguageHelper::getUserTranslation('invalid_phone'),
            'phone.unique' => LanguageHelper::getUserTranslation('invalid_phone'),
            'password.required' => LanguageHelper::getUserTranslation('fill_all_fields'),
            'password.min' => LanguageHelper::getUserTranslation('fill_all_fields'),
            'password_confirmation.required' => LanguageHelper::getUserTranslation('fill_all_fields'),
            'password_confirmation.same' => LanguageHelper::getUserTranslation('password_mismatch'),
            'referral_code.max' => LanguageHelper::getUserTranslation('fill_all_fields'),
            'agree_terms.required' => LanguageHelper::getUserTranslation('terms_required'),
            'agree_terms.accepted' => LanguageHelper::getUserTranslation('terms_required'),
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
                ->with('success', LanguageHelper::getUserTranslation('registration_success'))
                ->with('registered_phone', $request->phone);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['register' => LanguageHelper::getUserTranslation('error')])
                ->withInput($request->except(['password', 'password_confirmation']));
        }
    }

    public function authenticate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required|string|min:10|max:11',
                'password' => 'required|string|min:6',
            ], [
                'phone.required' => LanguageHelper::getUserTranslation('fill_all_fields'),
                'phone.min' => LanguageHelper::getUserTranslation('invalid_phone'),
                'phone.max' => LanguageHelper::getUserTranslation('invalid_phone'),
                'password.required' => LanguageHelper::getUserTranslation('fill_all_fields'),
                'password.min' => LanguageHelper::getUserTranslation('fill_all_fields'),
            ]);

            if ($validator->fails()) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => LanguageHelper::getUserTranslation('error'),
                        'errors' => $validator->errors()
                    ], 422);
                }
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($request->except('password'));
            }

            $credentials = $request->only('phone', 'password');
            
            // Demo validation (replace with actual authentication logic)
            if ($credentials['phone'] === '0123456789' && $credentials['password'] === '123456') {
                // Simulate successful login
                session(['user_logged_in' => true, 'user_phone' => $credentials['phone']]);
                
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => LanguageHelper::getUserTranslation('login_success'),
                        'redirect' => route('dashboard')
                    ]);
                }
                
                return redirect()->intended('/dashboard')->with('success', LanguageHelper::getUserTranslation('login_success'));
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => LanguageHelper::getUserTranslation('invalid_credentials'),
                    'errors' => [
                        'login' => [LanguageHelper::getUserTranslation('invalid_credentials')]
                    ]
                ], 422);
            }

            return redirect()->back()
                ->withErrors(['login' => LanguageHelper::getUserTranslation('invalid_credentials')])
                ->withInput($request->except('password'));
                
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => LanguageHelper::getUserTranslation('error'),
                    'error' => $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->withErrors(['login' => LanguageHelper::getUserTranslation('error')])
                ->withInput($request->except('password'));
        }
    }

    public function dashboard()
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login')->with('error', LanguageHelper::getUserTranslation('fill_all_fields'));
        }
        
        return view('user.dashboard');
    }

    public function logout()
    {
        session()->forget(['user_logged_in', 'user_phone']);
        return redirect()->route('login')->with('success', LanguageHelper::getUserTranslation('logout_success'));
    }
}
