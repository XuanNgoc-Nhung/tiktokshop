<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Helpers\LanguageHelper;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6',
            ], [
                'email.required' => LanguageHelper::getAdminTranslation('fill_all_fields'),
                'email.email' => LanguageHelper::getAdminTranslation('invalid_credentials'),
                'password.required' => LanguageHelper::getAdminTranslation('fill_all_fields'),
                'password.min' => LanguageHelper::getAdminTranslation('invalid_credentials'),
            ]);

            $credentials = $request->only('email', 'password');
            $remember = $request->boolean('remember');

            // Tìm user với email và kiểm tra role admin
            $user = User::where('email', $credentials['email'])->first();

            if ($user && Hash::check($credentials['password'], $user->password)) {
                // Kiểm tra nếu user có role admin
                if ($user->role === 'admin') {
                    Auth::login($user, $remember);
                    $request->session()->regenerate();
                    
                    return response()->json([
                        'success' => true,
                        'message' => LanguageHelper::getAdminTranslation('login_success'),
                        'redirect' => route('admin.dashboard')
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => LanguageHelper::getAdminTranslation('access_denied'),
                        'errors' => [
                            'email' => [LanguageHelper::getAdminTranslation('access_denied')]
                        ]
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getAdminTranslation('invalid_credentials'),
                'errors' => [
                    'email' => [LanguageHelper::getAdminTranslation('invalid_credentials')]
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getAdminTranslation('error'),
                'errors' => $e->errors()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getAdminTranslation('error'),
                'error' => $e->getMessage()
            ]);
        }
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login')
            ->with('success', LanguageHelper::getAdminTranslation('logout_success'));
    }

    public function register()
    {
        return view('admin.register');
    }
}
