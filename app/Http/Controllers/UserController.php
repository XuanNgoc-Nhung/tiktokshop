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
use App\Models\SanPham;
use App\Models\NhanDon;
use App\Helpers\LanguageHelper;
use Illuminate\Support\Facades\File;
use App\Models\LichSu;
use App\Models\NapRut;
use App\Models\SanPhamTrangChu;
use App\Models\SlideShow;

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
        $sanPhamTrangChu = SanPhamTrangChu::where('trang_thai', 1)->get();
        $slide = SlideShow::where('trang_thai', 1)->where('vi_tri', 1)->get();
        return view('user.dashboard', compact('userData', 'sanPhamTrangChu', 'slide'));
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
        $user = Auth::user();
        $profile = $user->profile;
        $tong_hoa_hong = $profile->hoa_hong;
        $so_du = $profile->so_du;
        $cap_do = $profile->cap_do;
        $giai_thuong_id = $profile->giai_thuong_id;
        $luot_trung = $profile->luot_trung;
        //đếm xem có bao nhiêu bản ghi của mình ở bảng NhanDon
        $luot_quay_hom_nay = NhanDon::where('user_id', $user->id)->where('created_at', '>=', now()->startOfDay())->count();
        return view('user.search', compact('tong_hoa_hong', 'so_du', 'cap_do', 'giai_thuong_id', 'luot_trung', 'luot_quay_hom_nay'));
    }
    public function orders()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', LanguageHelper::getUserTranslation('fill_all_fields'));
        }

        $user = Auth::user();
        $orders = NhanDon::with('sanPham')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('user.orders', compact('orders'));
    }
    public function account()
    {
        return view('user.account');
    }

    public function achievement()
    {
        $user = Auth::user();
        $profile = $user->profile;
        
        // Tính tổng tiền đã nạp (hanh_dong = 1 là nạp tiền, trang_thai = 1 là thành công)
        $totalDeposited = \App\Models\LichSu::where('user_id', $user->id)
            ->where('hanh_dong', 1)
            ->where('trang_thai', 1)
            ->sum('so_tien');
        
        // Sử dụng TierHelper để lấy thông tin tiers
        $tierInfo = \App\Helpers\TierHelper::getCurrentAndNextTier($totalDeposited);
        $currentTier = $tierInfo['currentTier'];
        $nextTier = $tierInfo['nextTier'];
        
        // Tính số tiền cần để nâng hạng: số tiền của cấp độ kế tiếp trừ đi số dư hiện tại
        $amountNeededForNextTier = 0;
        if ($nextTier) {
            $currentBalance = $profile->so_du ?? 0;
            $amountNeededForNextTier = max(0, $nextTier['amount'] - $currentBalance);
        }
        
        return view('user.achievement', compact('totalDeposited', 'amountNeededForNextTier', 'currentTier', 'nextTier'));
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
    public function password()
    {
        return view('user.password');
    }
    public function support()
    {
        $cauHinh = \App\Models\CauHinh::first();
        return view('user.support', compact('cauHinh'));
    }
    public function aboutUs()
    {
        return view('user.about-us');
    }
    public function supportUpdate(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getTranslationFromFile('account', 'missing_data')
            ], 401);
        }

        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000'
        ]);

        try {
            // Here you would typically save the support request to database
            // For now, we'll just return a success response
            
            return response()->json([
                'success' => true,
                'message' => LanguageHelper::getTranslationFromFile('account', 'send_request') . ' ' . LanguageHelper::getTranslationFromFile('account', 'success_title')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getTranslationFromFile('account', 'error_title')
            ], 500);
        }
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

    public function changeLoginPassword(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getTranslationFromFile('account', 'missing_data')
            ], 401);
        }

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6',
            'confirm_password' => 'required|string|same:new_password',
        ], [
            'current_password.required' => LanguageHelper::getTranslationFromFile('account', 'please_fill_all'),
            'new_password.required' => LanguageHelper::getTranslationFromFile('account', 'please_fill_all'),
            'new_password.min' => LanguageHelper::getTranslationFromFile('account', 'password_requirements'),
            'confirm_password.required' => LanguageHelper::getTranslationFromFile('account', 'please_fill_all'),
            'confirm_password.same' => LanguageHelper::getTranslationFromFile('account', 'password_mismatch'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getTranslationFromFile('account', 'current_password_incorrect'),
            ], 422);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => LanguageHelper::getTranslationFromFile('account', 'password_changed_success'),
        ]);
    }

    public function changeTransferPassword(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getTranslationFromFile('account', 'missing_data')
            ], 401);
        }

        $user = Auth::user();
        $hasCurrentPassword = !empty($user->mat_khau_chuyen_tien);

        $validator = Validator::make($request->all(), [
            'current_login_password' => 'required|string',
            'new_password' => 'required|string|min:4',
            'confirm_password' => 'required|string|same:new_password',
        ], [
            'current_login_password.required' => LanguageHelper::getTranslationFromFile('account', 'please_fill_all'),
            'new_password.required' => LanguageHelper::getTranslationFromFile('account', 'please_fill_all'),
            'new_password.min' => LanguageHelper::getTranslationFromFile('account', 'transfer_password_requirements'),
            'confirm_password.required' => LanguageHelper::getTranslationFromFile('account', 'please_fill_all'),
            'confirm_password.same' => LanguageHelper::getTranslationFromFile('account', 'password_mismatch'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        // Verify current login password (hashed)
        if (!Hash::check($request->current_login_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getTranslationFromFile('account', 'current_password_incorrect'),
            ], 422);
        }

        // Update transfer password (not hashed)
        $user->mat_khau_chuyen_tien = $request->new_password;
        $user->save();

        $successMessage = $hasCurrentPassword ? 
            LanguageHelper::getTranslationFromFile('account', 'transfer_password_changed_success') :
            LanguageHelper::getTranslationFromFile('account', 'transfer_password_set_success');

        return response()->json([
            'success' => true,
            'message' => $successMessage,
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', LanguageHelper::getUserTranslation('logout_success'));
    }

    public function receiveOrder(Request $request)
    {
        \Log::info('=== BẮT ĐẦU XỬ LÝ NHẬN ĐƠN HÀNG ===');
        
        if (!Auth::check()) {
            \Log::warning('User chưa đăng nhập');
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getUserTranslation('fill_all_fields')
            ], 401);
        }

        try {
            // Lấy thông tin người dùng và số dư
            $user = Auth::user();
            $profile = $user->profile;
            
            \Log::info('Thông tin user', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_phone' => $user->phone,
                'profile_exists' => $profile ? true : false,
                'so_du' => $profile ? $profile->so_du : null,
                'hoa_hong' => $profile ? $profile->hoa_hong : null
            ]);
            
            if (!$profile || !$profile->so_du) {
                \Log::warning('User không có profile hoặc số dư', [
                    'user_id' => $user->id,
                    'profile_exists' => $profile ? true : false,
                    'so_du' => $profile ? $profile->so_du : null
                ]);
                return response()->json([
                    'success' => false,
                    'message' => LanguageHelper::getHomeTranslation('insufficient_balance')
                ], 400);
            }
            
            $userBalance = (float) $profile->so_du;
            
            // Kiểm tra số lượt quay trong ngày hôm nay
            $today = now()->startOfDay();
            $tomorrow = now()->addDay()->startOfDay();
            
            $luotQuayHomNay = NhanDon::where('user_id', $user->id)
                ->whereBetween('created_at', [$today, $tomorrow])
                ->count();
            
            \Log::info('Thống kê lượt quay hôm nay', [
                'user_id' => $user->id,
                'today_start' => $today->format('Y-m-d H:i:s'),
                'tomorrow_start' => $tomorrow->format('Y-m-d H:i:s'),
                'luot_quay_hom_nay' => $luotQuayHomNay,
                'current_time' => now()->format('Y-m-d H:i:s')
            ]);
            
            // Lấy chi tiết các lượt quay hôm nay
            $chiTietLuotQuay = NhanDon::where('user_id', $user->id)
                ->whereBetween('created_at', [$today, $tomorrow])
                ->orderBy('created_at', 'desc')
                ->get(['id', 'ten_san_pham', 'gia_tri', 'hoa_hong', 'created_at']);
            
            \Log::info('Chi tiết các lượt quay hôm nay', [
                'user_id' => $user->id,
                'total_records' => $chiTietLuotQuay->count(),
                'records' => $chiTietLuotQuay->map(function($record) {
                    return [
                        'id' => $record->id,
                        'ten_san_pham' => $record->ten_san_pham,
                        'gia_tri' => $record->gia_tri,
                        'hoa_hong' => $record->hoa_hong,
                        'created_at' => $record->created_at->format('Y-m-d H:i:s')
                    ];
                })->toArray()
            ]);
            
            // Kiểm tra điều kiện đặc biệt: nếu luotQuayHomNay = luot_trung thì lấy sản phẩm theo giai_thuong_id
            $luotTrung = $profile->luot_trung ?? 0;
            $giaiThuongId = $profile->giai_thuong_id ?? null;
            
            \Log::info('Kiểm tra điều kiện đặc biệt', [
                'luot_quay_hom_nay' => $luotQuayHomNay,
                'luot_trung' => $luotTrung,
                'giai_thuong_id' => $giaiThuongId,
                'condition_met' => ($luotQuayHomNay == $luotTrung)
            ]);
            
            $randomProduct = null;
            
            // Nếu luotQuayHomNay = luot_trung và có giai_thuong_id, lấy sản phẩm theo ID
            if ($luotQuayHomNay == $luotTrung && $giaiThuongId) {
                $randomProduct = SanPham::where('id', $giaiThuongId)
                    ->first();
                
                \Log::info('Lấy sản phẩm theo giai_thuong_id', [
                    'giai_thuong_id' => $giaiThuongId,
                    'product_found' => $randomProduct ? true : false,
                    'product_name' => $randomProduct ? $randomProduct->ten : null,
                    'product_price' => $randomProduct ? $randomProduct->gia : null
                ]);
            }
            
            // Nếu không thỏa mãn điều kiện đặc biệt hoặc không tìm thấy sản phẩm theo giai_thuong_id
            if (!$randomProduct) {
                // Lấy ngẫu nhiên 1 sản phẩm có giá <= số dư của người dùng
                $randomProduct = SanPham::where('gia', '<=', $userBalance)
                    ->inRandomOrder()
                    ->first();
                
                \Log::info('Lấy sản phẩm ngẫu nhiên', [
                    'user_balance' => $userBalance,
                    'product_found' => $randomProduct ? true : false,
                    'product_id' => $randomProduct ? $randomProduct->id : null,
                    'product_name' => $randomProduct ? $randomProduct->ten : null,
                    'product_price' => $randomProduct ? $randomProduct->gia : null
                ]);
            }
            
            if (!$randomProduct) {
                \Log::warning('Không tìm thấy sản phẩm phù hợp', [
                    'user_id' => $user->id,
                    'user_balance' => $userBalance
                ]);
                return response()->json([
                    'success' => false,
                    'type' => 'balance',
                    'message' => LanguageHelper::getHomeTranslation('no_affordable_products')
                ]);
            }

            \Log::info('=== HOÀN THÀNH NHẬN ĐƠN HÀNG THÀNH CÔNG ===', [
                'user_id' => $user->id,
                'luot_quay_hom_nay' => $luotQuayHomNay,
                'product_id' => $randomProduct->id,
                'product_name' => $randomProduct->ten,
                'product_price' => $randomProduct->gia
            ]);

            // Trả về thông tin sản phẩm
            return response()->json([
                'success' => true,
                'type' => 'product',
                'message' => LanguageHelper::getHomeTranslation('receive_order_success'),
                'luot_quay_hom_nay' => $luotQuayHomNay,
                'chi_tiet_luot_quay' => $chiTietLuotQuay->map(function($record) {
                    return [
                        'id' => $record->id,
                        'ten_san_pham' => $record->ten_san_pham,
                        'gia_tri' => $record->gia_tri,
                        'hoa_hong' => $record->hoa_hong,
                        'created_at' => $record->created_at->format('Y-m-d H:i:s')
                    ];
                }),
                'product' => [
                    'id' => $randomProduct->id,
                    'ten' => $randomProduct->ten,
                    'gia' => $randomProduct->gia,
                    'hoa_hong' => $randomProduct->hoa_hong,
                    'mo_ta' => $randomProduct->mo_ta,
                    'hinh_anh' => $randomProduct->hinh_anh,
                    'cap_do' => $randomProduct->cap_do
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('=== LỖI KHI NHẬN ĐƠN HÀNG ===', [
                'user_id' => Auth::id(),
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'error_trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getHomeTranslation('error_receiving_order'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function confirmOrder(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getUserTranslation('fill_all_fields')
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'san_pham_id' => 'required|integer|exists:phan_thuong,id',
            'ten_san_pham' => 'required|string|max:255',
            'gia_tri' => 'required|numeric|min:0',
            'hoa_hong' => 'required|numeric|min:0'
        ], [
            'san_pham_id.required' => 'ID sản phẩm là bắt buộc',
            'san_pham_id.exists' => 'Sản phẩm không tồn tại',
            'ten_san_pham.required' => 'Tên sản phẩm là bắt buộc',
            'gia_tri.required' => 'Giá trị sản phẩm là bắt buộc',
            'gia_tri.numeric' => 'Giá trị sản phẩm phải là số',
            'gia_tri.min' => 'Giá trị sản phẩm phải lớn hơn 0',
            'hoa_hong.required' => 'Hoa hồng là bắt buộc',
            'hoa_hong.numeric' => 'Hoa hồng phải là số',
            'hoa_hong.min' => 'Hoa hồng phải lớn hơn hoặc bằng 0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Tạo bản ghi mới trong bảng nhan_don
            $nhanDon = NhanDon::create([
                'user_id' => Auth::id(),
                'san_pham_id' => $request->san_pham_id,
                'ten_san_pham' => $request->ten_san_pham,
                'gia_tri' => $request->gia_tri,
                'hoa_hong' => $request->hoa_hong
            ]);

            // Cộng thêm hoa hồng vào hồ sơ người dùng
            $profile = Profile::firstOrCreate(['user_id' => Auth::id()]);
            $currentCommission = (int) ($profile->hoa_hong ?? 0);
            $profile->hoa_hong = $currentCommission + (int) $request->hoa_hong;
            $profile->save();

            return response()->json([
                'success' => true,
                'message' => 'Xác nhận đơn hàng thành công!',
                'data' => [
                    'id' => $nhanDon->id,
                    'ten_san_pham' => $nhanDon->ten_san_pham,
                    'gia_tri' => $nhanDon->gia_tri,
                    'hoa_hong' => $nhanDon->hoa_hong,
                    'created_at' => $nhanDon->created_at,
                    'tong_hoa_hong' => $profile->hoa_hong,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xác nhận đơn hàng',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function accountHistory()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', LanguageHelper::getUserTranslation('fill_all_fields'));
        }

        $user = Auth::user();
        $accountHistory = LichSu::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('user.account-history', compact('accountHistory'));
    }
    public function recharge()
    {
        return view('user.recharge');
    }
    public function napTien()
    {
        return view('user.nap-tien');
    }
    public function rutTien()
    {
        return view('user.rut-tien');
    }

    public function submitWithdraw(Request $request)
    {
        \Log::info('=== BẮT ĐẦU XỬ LÝ RÚT TIỀN ===');
        \Log::info('User ID: ' . Auth::id());
        \Log::info('Request data: ' . json_encode($request->all()));
        
        $user = Auth::user();
        $profile = $user->profile;
        
        \Log::info('Profile data - Số dư: ' . ($profile->so_du ?? 0) . ', Hoa hồng: ' . ($profile->hoa_hong ?? 0));
        
        // Check if user has bank info
        if (!$profile->ngan_hang || !$profile->so_tai_khoan || !$profile->chu_tai_khoan) {
            \Log::warning('User thiếu thông tin ngân hàng', [
                'user_id' => $user->id,
                'ngan_hang' => $profile->ngan_hang,
                'so_tai_khoan' => $profile->so_tai_khoan,
                'chu_tai_khoan' => $profile->chu_tai_khoan
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Bạn cần cập nhật thông tin ngân hàng trước khi có thể rút tiền.',
                'errors' => ['error' => 'Bạn cần cập nhật thông tin ngân hàng trước khi có thể rút tiền.']
            ], 400);
        }
        
        // Check if user has withdrawal password
        if (!$user->mat_khau_chuyen_tien) {
            \Log::warning('User chưa thiết lập mật khẩu rút tiền', ['user_id' => $user->id]);
            
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getTranslationFromFile('withdraw', 'password_setup_required', 'user'),
                'errors' => ['error' => LanguageHelper::getTranslationFromFile('withdraw', 'password_setup_required', 'user')]
            ], 400);
        }

        // Calculate maximum withdrawable amount (so_du + hoa_hong)
        $maxWithdrawAmount = ($profile->so_du ?? 0) + ($profile->hoa_hong ?? 0);
        \Log::info('Tính toán số tiền rút tối đa', [
            'so_du' => $profile->so_du ?? 0,
            'hoa_hong' => $profile->hoa_hong ?? 0,
            'max_withdraw_amount' => $maxWithdrawAmount
        ]);
        
        // Validation rules
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:10|max:' . $maxWithdrawAmount,
            'withdrawal_password' => 'required|string',
        ], [
            'amount.required' => LanguageHelper::getTranslationFromFile('withdraw', 'amount_required', 'user'),
            'amount.numeric' => LanguageHelper::getTranslationFromFile('withdraw', 'amount_numeric', 'user'),
            'amount.min' => LanguageHelper::getTranslationFromFile('withdraw', 'amount_min', 'user'),
            'amount.max' => LanguageHelper::getTranslationFromFile('withdraw', 'amount_max', 'user'),
            'withdrawal_password.required' => LanguageHelper::getTranslationFromFile('withdraw', 'password_required', 'user'),
        ]);

        if ($validator->fails()) {
            \Log::warning('Validation failed', [
                'user_id' => $user->id,
                'errors' => $validator->errors()->toArray(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getTranslationFromFile('withdraw', 'invalid_data', 'user'),
                'errors' => $validator->errors()
            ]);
        }

        // Check withdrawal password
        if ($request->withdrawal_password !== $user->mat_khau_chuyen_tien) {
            \Log::warning('Mật khẩu rút tiền không đúng', [
                'user_id' => $user->id,
                'provided_password' => $request->withdrawal_password,
                'stored_password' => $user->mat_khau_chuyen_tien
            ]);
            
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getTranslationFromFile('withdraw', 'password_incorrect', 'user'),
                'errors' => ['withdrawal_password' => LanguageHelper::getTranslationFromFile('withdraw', 'password_incorrect', 'user')]
            ]);
        }

        // Check sufficient balance (hoa hong + so du)
        $amount = $request->amount;
        $totalRequired = $amount;
        $totalAvailable = $maxWithdrawAmount; // Use the calculated max amount
        
        \Log::info('Kiểm tra số dư', [
            'amount_requested' => $amount,
            'total_available' => $totalAvailable,
            'sufficient_balance' => $totalAvailable >= $totalRequired
        ]);
        
        if ($totalAvailable < $totalRequired) {
            \Log::warning('Số dư không đủ', [
                'user_id' => $user->id,
                'amount_requested' => $amount,
                'total_available' => $totalAvailable
            ]);
            
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getTranslationFromFile('withdraw', 'amount_insufficient', 'user'),
                'errors' => ['amount' => LanguageHelper::getTranslationFromFile('withdraw', 'amount_insufficient', 'user')]
            ]);
        }

        try {
            \Log::info('Bắt đầu tạo bản ghi rút tiền');
            
            // Create withdrawal record in nap_rut table
            $napRut = new NapRut();
            $napRut->user_id = $user->id;
            $napRut->so_tien = $amount;
            $napRut->ghi_chu = 'Yêu cầu rút tiền từ người dùng';
            $napRut->trang_thai ='pending'; // 0 = pending
            $napRut->loai_giao_dich = 'rut'; // withdrawal
            $napRut->save();
            
            \Log::info('Đã tạo bản ghi rút tiền', [
                'nap_rut_id' => $napRut->id,
                'user_id' => $user->id,
                'amount' => $amount
            ]);

            // Update user balance - ưu tiên trừ từ hoa hồng trước
            $remainingAmount = $totalRequired;
            $deductFromHoaHong = 0;
            $deductFromSoDu = 0;
            
            \Log::info('Bắt đầu cập nhật số dư', [
                'remaining_amount' => $remainingAmount,
                'current_hoa_hong' => $profile->hoa_hong,
                'current_so_du' => $profile->so_du
            ]);
            
            // Trừ từ hoa hồng trước
            if ($profile->hoa_hong > 0 && $remainingAmount > 0) {
                $deductFromHoaHong = min($profile->hoa_hong, $remainingAmount);
                $profile->hoa_hong -= $deductFromHoaHong;
                $remainingAmount -= $deductFromHoaHong;
                
                \Log::info('Đã trừ từ hoa hồng', [
                    'deducted_from_hoa_hong' => $deductFromHoaHong,
                    'remaining_amount' => $remainingAmount,
                    'new_hoa_hong' => $profile->hoa_hong
                ]);
            }
            
            // Nếu còn thiếu thì trừ từ số dư
            if ($remainingAmount > 0) {
                $deductFromSoDu = $remainingAmount;
                $profile->so_du -= $remainingAmount;
                
                \Log::info('Đã trừ từ số dư', [
                    'deducted_from_so_du' => $deductFromSoDu,
                    'new_so_du' => $profile->so_du
                ]);
            }
            
            $profile->save();
            
            \Log::info('Đã cập nhật profile thành công', [
                'final_hoa_hong' => $profile->hoa_hong,
                'final_so_du' => $profile->so_du,
                'total_deducted' => $deductFromHoaHong + $deductFromSoDu
            ]);

            // Create transaction history
            \Log::info('Tạo lịch sử giao dịch');
            $lichSu = new LichSu();
            $lichSu->user_id = $user->id;
            $lichSu->hanh_dong = 2; // 2 = rút tiền
            $lichSu->so_tien = $amount;
            $lichSu->trang_thai = 1; // 1 = thành công
            $lichSu->ghi_chu = "Rút: " . number_format($amount) . " $ (Từ lợi nhuận: " . number_format($deductFromHoaHong) . " $, Từ số dư: " . number_format($deductFromSoDu) . " $)";
            $lichSu->save();
            
            \Log::info('Đã tạo lịch sử giao dịch', [
                'lich_su_id' => $lichSu->id,
                'ghi_chu' => $lichSu->ghi_chu
            ]);

            \Log::info('=== HOÀN THÀNH RÚT TIỀN THÀNH CÔNG ===', [
                'user_id' => $user->id,
                'amount' => $amount,
                'deduct_from_hoa_hong' => $deductFromHoaHong,
                'deduct_from_so_du' => $deductFromSoDu,
                'new_balance' => $profile->so_du,
                'new_hoa_hong' => $profile->hoa_hong
            ]);
            
            return response()->json([
                'success' => true,
                'message' => LanguageHelper::getTranslationFromFile('withdraw', 'withdrawal_success', 'user'),
                'data' => [
                    'amount' => $amount,
                    'deductFromHoaHong' => $deductFromHoaHong,
                    'deductFromSoDu' => $deductFromSoDu,
                    'newBalance' => $profile->so_du,
                    'newHoaHong' => $profile->hoa_hong
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('=== LỖI KHI RÚT TIỀN ===', [
                'user_id' => $user->id,
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'error_trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getTranslationFromFile('withdraw', 'withdrawal_failed', 'user'),
                'errors' => ['error' => LanguageHelper::getTranslationFromFile('withdraw', 'withdrawal_failed', 'user')]
            ], 500);
        }
    }
    public function uuDai()
    {
        // Lấy danh sách sản phẩm khuyến mãi
        $user = Auth::user();
        $profile = $user->profile;
        $idVip = $profile->giai_thuong_id;
        if(!$idVip){
            $sanPhamVip = SanPham::where('cap_do', 1)->first();
        }else{
            $sanPhamVip = SanPham::where('id', $idVip)->first();
        }
        $soDu = $profile->so_du;
        $hoaHong = $profile->hoa_hong;
        $nhanDons = NhanDon::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return view('user.endow', compact('sanPhamVip', 'soDu', 'hoaHong', 'nhanDons'));
    }
}
