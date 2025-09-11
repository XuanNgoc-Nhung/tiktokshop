<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Profile;
use App\Models\User;
use App\Models\ThongBao;
use App\Helpers\LanguageHelper;
use Illuminate\Support\Facades\File;

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
            'phone.unique' => LanguageHelper::getUserTranslation('phone_exists'),
            'password.required' => LanguageHelper::getUserTranslation('fill_all_fields'),
            'password.min' => LanguageHelper::getUserTranslation('fill_all_fields'),
            'password_confirmation.required' => LanguageHelper::getUserTranslation('fill_all_fields'),
            'password_confirmation.same' => LanguageHelper::getUserTranslation('password_mismatch'),
            'referral_code.max' => LanguageHelper::getUserTranslation('fill_all_fields'),
            'agree_terms.required' => LanguageHelper::getUserTranslation('terms_required'),
            'agree_terms.accepted' => LanguageHelper::getUserTranslation('terms_required'),
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                $firstMessage = $validator->errors()->first();
                return response()->json([
                    'success' => false,
                    'message' => $firstMessage,
                    'errors' => $validator->errors()
                ]);
            }
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

            if ($request->expectsJson()) {
                //tạo profile cho user
                Profile::create([
                    'user_id' => $user->id,
                ]);
                return response()->json([
                    'success' => true,
                    'message' => LanguageHelper::getUserTranslation('registration_success'),
                    'redirect' => route('login')
                ]);
            }
            return redirect()->route('login')
                ->with('success', LanguageHelper::getUserTranslation('registration_success'))
                ->with('registered_phone', $request->phone);
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => LanguageHelper::getUserTranslation('error'),
                    'error' => $e->getMessage()
                ], 500);
            }
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
                    $firstMessage = $validator->errors()->first();
                    return response()->json([
                        'success' => false,
                        'message' => $firstMessage,
                        'errors' => $validator->errors()
                    ], 422);
                }
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($request->except('password'));
            }

            $credentials = $request->only('phone', 'password');
            
            // Find user by phone and verify password
            $user = User::findByPhone($credentials['phone']);
            
            if ($user && Hash::check($credentials['password'], $user->password)) {
                // Use Auth::login() to properly authenticate the user
                Auth::login($user);
                
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => LanguageHelper::getUserTranslation('login_success'),
                        'redirect' => route('dashboard'),
                        'user' => [
                            'id' => $user->id,
                            'name' => $user->name,
                            'phone' => $user->phone,
                            'email' => $user->email,
                            'role' => $user->role ?? 'user'
                        ]
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
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', LanguageHelper::getUserTranslation('fill_all_fields'));
        }
        
        // Get authenticated user data
        $user = Auth::user();
        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'phone' => $user->phone,
            'email' => $user->email,
            'role' => $user->role ?? 'user'
        ];
        
        return view('user.dashboard', compact('userData'));
    }
    public function notification()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', LanguageHelper::getUserTranslation('fill_all_fields'));
        }
        // Get authenticated user data
        $user = Auth::user();
        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'phone' => $user->phone,
            'email' => $user->email,
            'role' => $user->role ?? 'user'
        ];
        $notifications = ThongBao::where('trang_thai', 1)->get();
        return view('user.notification', compact('userData', 'notifications'));
    }
    public function search()
    {
        return view('user.search');
    }
    public function orders()
    {
        return view('user.orders');
    }
    public function account()
    {
        return view('user.account');
    }

    public function personalInfo()
    {
        return view('user.personal-info');
    }
    public function personalInfoUpdate(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getTranslationFromFile('account', 'missing_data')
            ], 401);
        }

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'gioi_tinh' => 'required|string|max:20',
            'ngay_sinh' => 'required|string',
            'dia_chi' => 'required|string|max:255',
        ], [
            'full_name.required' => LanguageHelper::getTranslationFromFile('account', 'please_fill_all'),
            'email.required' => LanguageHelper::getTranslationFromFile('account', 'please_fill_all'),
            'email.email' => LanguageHelper::getTranslationFromFile('account', 'please_fill_all'),
            'gioi_tinh.required' => LanguageHelper::getTranslationFromFile('account', 'please_fill_all'),
            'ngay_sinh.required' => LanguageHelper::getTranslationFromFile('account', 'please_fill_all'),
            'dia_chi.required' => LanguageHelper::getTranslationFromFile('account', 'please_fill_all'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $user->name = $request->input('full_name');
        $user->email = $request->input('email');
        $user->save();

        $profile = Profile::firstOrCreate(['user_id' => $user->id]);
        $profile->gioi_tinh = $request->input('gioi_tinh');
        $profile->ngay_sinh = $request->input('ngay_sinh');
        $profile->dia_chi = $request->input('dia_chi');
        $profile->save();

        return response()->json([
            'success' => true,
            'message' => LanguageHelper::getTranslationFromFile('account', 'update_success'),
        ]);
    }
    public function bank()
    {
        return view('user.bank');
    }

    public function kyc()
    {
        return view('user.kyc');
    }

    public function kycUpdate(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getTranslationFromFile('account', 'missing_data')
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'anh_chan_dung' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'anh_mat_truoc' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'anh_mat_sau' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'anh_chan_dung.image' => LanguageHelper::getTranslationFromFile('account', 'please_fill_all'),
            'anh_mat_truoc.image' => LanguageHelper::getTranslationFromFile('account', 'please_fill_all'),
            'anh_mat_sau.image' => LanguageHelper::getTranslationFromFile('account', 'please_fill_all'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = Auth::user();
        $profile = Profile::firstOrCreate(['user_id' => $user->id]);

        $paths = [];
        $destinationPath = public_path('kyc');
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }
        foreach (['anh_chan_dung', 'anh_mat_truoc', 'anh_mat_sau'] as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $extension = $file->getClientOriginalExtension();
                $filename = $field . '_' . time() . '_' . uniqid() . '.' . $extension;
                $file->move($destinationPath, $filename);
                $publicPath = '/kyc/' . $filename;
                $profile->$field = $publicPath;
                $paths[$field] = $publicPath;
            }
        }

        $profile->save();

        return response()->json([
            'success' => true,
            'message' => LanguageHelper::getTranslationFromFile('account', 'update_success'),
            'paths' => $paths,
        ]);
    }

    public function bankUpdate(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getTranslationFromFile('account', 'missing_data')
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'ngan_hang' => 'required|string|max:255',
            'so_tai_khoan' => 'required|string|max:100',
            'chu_tai_khoan' => 'required|string|max:255',
        ], [
            'ngan_hang.required' => LanguageHelper::getTranslationFromFile('account', 'please_fill_all'),
            'so_tai_khoan.required' => LanguageHelper::getTranslationFromFile('account', 'please_fill_all'),
            'chu_tai_khoan.required' => LanguageHelper::getTranslationFromFile('account', 'please_fill_all'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = Auth::user();
        $profile = Profile::firstOrCreate(['user_id' => $user->id]);
        $profile->ngan_hang = $request->input('ngan_hang');
        $profile->so_tai_khoan = $request->input('so_tai_khoan');
        $profile->chu_tai_khoan = $request->input('chu_tai_khoan');
        $profile->save();

        return response()->json([
            'success' => true,
            'message' => LanguageHelper::getTranslationFromFile('account', 'update_success'),
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', LanguageHelper::getUserTranslation('logout_success'));
    }
}
