<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Helpers\LanguageHelper;

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
        $recent_orders = [
            [
                'id' => '001',
                'customer' => 'Nguyễn Văn A',
                'amount' => 150.00,
                'status' => 'completed'
            ],
            [
                'id' => '002',
                'customer' => 'Trần Thị B',
                'amount' => 89.50,
                'status' => 'pending'
            ],
            [
                'id' => '003',
                'customer' => 'Lê Văn C',
                'amount' => 200.00,
                'status' => 'completed'
            ],
        ];

        // Lấy danh sách người dùng gần đây
        $recent_users = User::latest()->take(5)->get()->map(function($user) {
            return [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role ?? 'user',
                'created_at' => $user->created_at->format('d/m/Y')
            ];
        })->toArray();

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

        // Demo users data
        $demoUsers = [
            ['name' => 'Nguyễn Văn A', 'email' => 'nguyenvana@example.com', 'phone' => '0901000001', 'role' => 'user', 'created_at' => now()->subDays(1)],
            ['name' => 'Trần Thị B', 'email' => 'tranthib@example.com', 'phone' => '0901000002', 'role' => 'user', 'created_at' => now()->subDays(2)],
            ['name' => 'Lê Văn C', 'email' => 'levanc@example.com', 'phone' => '0901000003', 'role' => 'seller', 'created_at' => now()->subDays(3)],
            ['name' => 'Phạm Thị D', 'email' => 'phamthid@example.com', 'phone' => '0901000004', 'role' => 'user', 'created_at' => now()->subDays(4)],
            ['name' => 'Hoàng Văn E', 'email' => 'hoangvane@example.com', 'phone' => '0901000005', 'role' => 'admin', 'created_at' => now()->subDays(5)],
            ['name' => 'Võ Thị F', 'email' => 'vothif@example.com', 'phone' => '0901000006', 'role' => 'user', 'created_at' => now()->subDays(6)],
            ['name' => 'Bùi Văn G', 'email' => 'buivang@example.com', 'phone' => '0901000007', 'role' => 'user', 'created_at' => now()->subDays(7)],
            ['name' => 'Đặng Thị H', 'email' => 'dangthih@example.com', 'phone' => '0901000008', 'role' => 'seller', 'created_at' => now()->subDays(8)],
            ['name' => 'Ngô Văn I', 'email' => 'ngovani@example.com', 'phone' => '0901000009', 'role' => 'user', 'created_at' => now()->subDays(9)],
            ['name' => 'Đỗ Thị K', 'email' => 'dothik@example.com', 'phone' => '0901000010', 'role' => 'user', 'created_at' => now()->subDays(10)],
        ];

        // Filter by keyword over name, email, phone
        $filtered = collect($demoUsers)->filter(function ($user) use ($keyword) {
            if ($keyword === '') {
                return true;
            }
            $haystack = strtolower(($user['name'] ?? '') . ' ' . ($user['email'] ?? '') . ' ' . ($user['phone'] ?? ''));
            return strpos($haystack, strtolower($keyword)) !== false;
        })->map(function ($user) {
            $user['created_at_formatted'] = optional($user['created_at'])->format('d/m/Y');
            return $user;
        })->values();

        return view('admin.user-management', [
            'users' => $filtered,
            'keyword' => $keyword,
            'total' => count($filtered),
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
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:30|unique:users,phone',
                'password' => 'required|string|min:6|confirmed',
                'referral_code' => 'required|string|max:255',
            ], [
                'name.required' => 'Vui lòng nhập tên người dùng',
                'phone.required' => 'Vui lòng nhập số điện thoại',
                'phone.unique' => 'Số điện thoại đã tồn tại',
                'password.required' => 'Vui lòng nhập mật khẩu',
                'password.min' => 'Mật khẩu tối thiểu 6 ký tự',
                'password.confirmed' => 'Mật khẩu xác nhận không khớp',
                'referral_code.required' => 'Vui lòng nhập mã giới thiệu',
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
                'message' => 'Tạo người dùng thành công',
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
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Store user error', [ 'error' => $e->getMessage() ]);
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
