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
        return view('user.support');
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
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => LanguageHelper::getUserTranslation('fill_all_fields')
            ], 401);
        }

        try {
            // Lấy ngẫu nhiên 1 sản phẩm từ database
            $randomProduct = SanPham::inRandomOrder()->first();
            
            if (!$randomProduct) {
                return response()->json([
                    'success' => false,
                    'message' => LanguageHelper::getHomeTranslation('no_products_available')
                ], 404);
            }

            // Trả về thông tin sản phẩm
            return response()->json([
                'success' => true,
                'message' => LanguageHelper::getHomeTranslation('receive_order_success'),
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

            return response()->json([
                'success' => true,
                'message' => 'Xác nhận đơn hàng thành công!',
                'data' => [
                    'id' => $nhanDon->id,
                    'ten_san_pham' => $nhanDon->ten_san_pham,
                    'gia_tri' => $nhanDon->gia_tri,
                    'hoa_hong' => $nhanDon->hoa_hong,
                    'created_at' => $nhanDon->created_at
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
}
