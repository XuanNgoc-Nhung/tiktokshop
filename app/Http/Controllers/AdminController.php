<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profile;
use App\Helpers\LanguageHelper;
use App\Models\LichSu;

class AdminController extends Controller
{
    public function index()
    {
        // Ensure admin locale is set
        $adminLocale = session('admin_locale', 'vi');
        if (LanguageHelper::isSupported($adminLocale)) {
            app()->setLocale($adminLocale);
        }
        
        // Debug log
        \Log::info('AdminController index', [
            'current_locale' => app()->getLocale(),
            'session_admin_locale' => session('admin_locale'),
            'request_url' => request()->url()
        ]);
        
        // Lấy thống kê tổng quan
        $stats = [
            'total_users' => User::count(),
            'total_orders' => 0, // Sẽ cập nhật khi có model Order
            'total_products' => 0, // Sẽ cập nhật khi có model Product
            'total_revenue' => 0, // Sẽ cập nhật khi có model Order
        ];

        // Lấy danh sách đơn hàng gần đây (mock data)
        $recent_orders = [];
        $recent_users = User::orderBy('created_at', 'desc')->limit(5)->get()->toArray();

        return view('admin.index', compact('stats', 'recent_orders', 'recent_users'));
    }

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
    public function userManagement(Request $request)
    {
        $keyword = trim((string) $request->get('q', ''));

        // Lấy ra danh sách người dùng từ database
        $query = User::with('profile');
        
        // Nếu có từ khóa tìm kiếm, thêm điều kiện where
        if ($keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                  ->orWhere('phone', 'like', '%' . $keyword . '%');
            });
        }
        
        // Sử dụng paginate với 10 items per page
        $users = $query->paginate(10)->withQueryString();
        
        // Format dữ liệu cho mỗi user
        $users->getCollection()->transform(function ($user) {
            $user->created_at_formatted = optional($user->created_at)->format('d/m/Y');
            // Load profile relationship if not already loaded
            if (!$user->relationLoaded('profile')) {
                $user->load('profile');
            }
            return $user;
        });

        return view('admin.user-management', [
            'users' => $users,
            'keyword' => $keyword,
        ]);
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

    public function registerStore(Request $request)
    {
        return view('admin.register');
    }

    public function changeLanguage(Request $request)
    {
        try {
            $request->validate([
                'language' => 'required|string|in:vi,en,zh,ja,bn'
            ]);

            $language = $request->input('language');
            
            // Debug: Log the request
            \Log::info('Admin Language Change Request', [
                'language' => $language,
                'current_locale' => app()->getLocale(),
                'session_admin_locale' => session('admin_locale')
            ]);
            
            // Lưu ngôn ngữ vào session
            session(['admin_locale' => $language]);
            
            // Set locale immediately for this request
            app()->setLocale($language);
            
            // Debug: Log after setting
            \Log::info('After setting language', [
                'new_locale' => app()->getLocale(),
                'session_admin_locale' => session('admin_locale')
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Language changed successfully',
                'language' => $language,
                'current_locale' => app()->getLocale()
            ]);

        } catch (\Exception $e) {
            \Log::error('Language change error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error changing language: ' . $e->getMessage()
            ]);
        }
    }

    public function storeUser(Request $request)
    {
        try {
            // Ensure admin locale is set for validation messages
            $adminLocale = session('admin_locale', 'vi');
            if (LanguageHelper::isSupported($adminLocale)) {
                app()->setLocale($adminLocale);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:30|unique:users,phone',
                'password' => 'required|string|min:6|confirmed',
                'referral_code' => 'required|string|max:255',
            ], [
                'name.required' => LanguageHelper::getAdminTranslation('name_required'),
                'phone.required' => LanguageHelper::getAdminTranslation('phone_required'),
                'phone.unique' => LanguageHelper::getAdminTranslation('phone_already_exists'),
                'password.required' => LanguageHelper::getAdminTranslation('password_required'),
                'password.min' => LanguageHelper::getAdminTranslation('password_min_length'),
                'password.confirmed' => LanguageHelper::getAdminTranslation('password_confirmation_mismatch'),
                'referral_code.required' => LanguageHelper::getAdminTranslation('referral_code_required'),
            ]);

            // Generate placeholder email from phone to satisfy NOT NULL + UNIQUE email column
            $baseEmail = preg_replace('/[^0-9A-Za-z]/', '', $validated['phone']) . '@tiktokshop.local';
            $email = $baseEmail;
            $suffix = 1;
            while (User::where('email', $email)->exists()) {
                $suffix++;
                $email = preg_replace('/@.*/', '', $baseEmail) . "+{$suffix}@tiktokshop.local";
            }

            $user = User::create([
                'name' => $validated['name'],
                'email' => $email,
                'phone' => $validated['phone'],
                'password' => $validated['password'],
                'referral_code' => $validated['referral_code'],
                'role' => 'user',
            ]);

            return response()->json([
                'success' => true,
                'message' => LanguageHelper::getAdminTranslation('user_created_success'),
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'role' => $user->role,
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getAdminTranslation('invalid_data'),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Store user error', [ 'error' => $e->getMessage() ]);
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getAdminTranslation('error_occurred'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function updateUser(Request $request, $id)
    {
        try {
            // Ensure admin locale is set for validation messages
            $adminLocale = session('admin_locale', 'vi');
            if (LanguageHelper::isSupported($adminLocale)) {
                app()->setLocale($adminLocale);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'gioi_tinh' => 'nullable|string|max:10',
                'ngay_sinh' => 'nullable|date',
                'dia_chi' => 'nullable|string|max:255',
                'so_du' => 'nullable|numeric|min:0',
                'anh_mat_truoc' => 'nullable|string|max:255',
                'anh_mat_sau' => 'nullable|string|max:255',
                'anh_chan_dung' => 'nullable|string|max:255',
                'ngan_hang' => 'nullable|string|max:100',
                'so_tai_khoan' => 'nullable|string|max:50',
                'chu_tai_khoan' => 'nullable|string|max:100',
                'cap_do' => 'nullable|string|max:50',
                'giai_thuong_id' => 'nullable|string|max:50',
                'luot_trung' => 'nullable|integer|min:0',
            ], [
                'name.required' => LanguageHelper::getAdminTranslation('validation_name_required'),
                'name.max' => LanguageHelper::getAdminTranslation('validation_name_required'),
                'gioi_tinh.max' => LanguageHelper::getAdminTranslation('validation_gioi_tinh_required'),
                'ngay_sinh.date' => LanguageHelper::getAdminTranslation('validation_ngay_sinh_format'),
                'dia_chi.max' => LanguageHelper::getAdminTranslation('validation_dia_chi_required'),
                'so_du.numeric' => LanguageHelper::getAdminTranslation('validation_so_du_invalid'),
                'so_du.min' => LanguageHelper::getAdminTranslation('validation_so_du_invalid'),
                'anh_mat_truoc.max' => LanguageHelper::getAdminTranslation('validation_so_du_required'),
                'anh_mat_sau.max' => LanguageHelper::getAdminTranslation('validation_so_du_required'),
                'anh_chan_dung.max' => LanguageHelper::getAdminTranslation('validation_so_du_required'),
                'ngan_hang.max' => LanguageHelper::getAdminTranslation('validation_ngan_hang_required'),
                'so_tai_khoan.max' => LanguageHelper::getAdminTranslation('validation_so_tai_khoan_required'),
                'chu_tai_khoan.max' => LanguageHelper::getAdminTranslation('validation_chu_tai_khoan_required'),
                'cap_do.max' => LanguageHelper::getAdminTranslation('validation_cap_do_required'),
                'giai_thuong_id.max' => LanguageHelper::getAdminTranslation('validation_giai_thuong_id_required'),
                'luot_trung.integer' => LanguageHelper::getAdminTranslation('validation_luot_trung_invalid'),
                'luot_trung.min' => LanguageHelper::getAdminTranslation('validation_luot_trung_invalid'),
            ]);

            $user = User::findOrFail($id);
            
            // Chỉ cập nhật tên người dùng, không cập nhật email và phone
            $user->update([
                'name' => $validated['name'],
            ]);
            
            // Tìm hoặc tạo profile cho user
            $profile = Profile::where('user_id', $id)->first();
            if (!$profile) {
                $profile = new Profile();
                $profile->user_id = $id;
            }

            // Cập nhật thông tin profile (loại bỏ trường name)
            $profileData = collect($validated)->except(['name'])->toArray();
            $profile->fill($profileData);
            $profile->save();

            return response()->json([
                'success' => true,
                'message' => LanguageHelper::getAdminTranslation('updated_success'),
                'data' => $profile
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getAdminTranslation('invalid_data'),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Update user error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getAdminTranslation('error_occurred'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteUser(Request $request, $id)
    {
        try {
            // Ensure admin locale is set for validation messages
            $adminLocale = session('admin_locale', 'vi');
            if (LanguageHelper::isSupported($adminLocale)) {
                app()->setLocale($adminLocale);
            }

            // Tìm user cần xóa
            $user = User::findOrFail($id);
            
            // Kiểm tra không cho phép xóa admin
            if ($user->role === 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => LanguageHelper::getAdminTranslation('cannot_delete_admin'),
                ], 403);
            }

            // Xóa profile trước (nếu có)
            $profile = Profile::where('user_id', $id)->first();
            if ($profile) {
                $profile->delete();
            }

            // Xóa user
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => LanguageHelper::getAdminTranslation('user_deleted_success'),
            ]);

        } catch (\Exception $e) {
            \Log::error('Delete user error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getAdminTranslation('error_occurred'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function adjustBalance(Request $request, $id)
    {
        try {
            // Ensure admin locale is set for validation messages
            $adminLocale = session('admin_locale', 'vi');
            if (LanguageHelper::isSupported($adminLocale)) {
                app()->setLocale($adminLocale);
            }

            // Validate input
            $request->validate([
                'balance_adjustment' => 'required|numeric'
            ], [
                'balance_adjustment.required' => LanguageHelper::getAdminTranslation('validation_balance_adjustment_required'),
                'balance_adjustment.numeric' => LanguageHelper::getAdminTranslation('validation_balance_adjustment_invalid'),
            ]);

            // Tìm user
            $user = User::findOrFail($id);
            $profile = Profile::where('user_id', $id)->first();
            
            if (!$profile) {
                return response()->json([
                    'success' => false,
                    'message' => LanguageHelper::getAdminTranslation('user_profile_not_found'),
                ], 404);
            }

            // Lấy dữ liệu từ request
            $balanceAdjustment = floatval($request->balance_adjustment);
            $currentBalance = floatval($profile->so_du ?? 0);
            $newBalance = $currentBalance + $balanceAdjustment;

            // Kiểm tra số dư mới không âm
            if ($newBalance < 0) {
                return response()->json([
                    'success' => false,
                    'message' => LanguageHelper::getAdminTranslation('balance_cannot_be_negative'),
                ], 400);
            }
            //add lich su
            LichSu::create([
                'user_id' => $user->id,
                'hanh_dong' => 3,
                'so_tien' => $balanceAdjustment,
                'ghi_chu' => 'Số dư sau: ' . number_format($newBalance, 0, '.', '.'),
                'trang_thai' => 1,
            ]);

            // Cập nhật số dư
            $profile->so_du = $newBalance;
            $profile->save();

            // Log hoạt động điều chỉnh số dư
            \Log::info('Balance adjusted', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'admin_id' => Auth::id(),
                'old_balance' => $currentBalance,
                'adjustment_amount' => $balanceAdjustment,
                'new_balance' => $newBalance,
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => LanguageHelper::getAdminTranslation('balance_adjusted_success'),
                'data' => [
                    'old_balance' => $currentBalance,
                    'adjustment_amount' => $balanceAdjustment,
                    'new_balance' => $newBalance
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getAdminTranslation('invalid_data'),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Adjust balance error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getAdminTranslation('error_occurred'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
