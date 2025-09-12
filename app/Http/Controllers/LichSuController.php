<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LichSu;
use App\Models\NhanDon;
use App\Models\NapRut;
class LichSuController extends Controller
{
    public function lichSuManagement(Request $request)
    {
        $lichSu = LichSu::query();
        //tìm kiếm lich su theo từ khoá
        if ($request->filled('search')) {
            $lichSu = $lichSu->where('ghi_chu', 'like', '%' . $request->search . '%');
            }
        //lọc lich su theo hanh dong
        if ($request->filled('hanh_dong')) {
            $lichSu = $lichSu->where('hanh_dong', $request->hanh_dong);
        }
        //lọc lich su theo trang thai
        if ($request->filled('trang_thai')) {
            $lichSu = $lichSu->where('trang_thai', $request->trang_thai);
        }
        //sắp xếp lich su theo ngày tạo
        $lichSu = $lichSu->orderBy('created_at', 'desc')->with('user');
        $lichSu = $lichSu->paginate(10);
        $actionMap = [
            1 => __('admin::cms.history_action_topup'),
            2 => __('admin::cms.history_action_withdraw'),
            3 => __('admin::cms.history_action_system'),
            4 => __('admin::cms.history_action_commission'),
        ];
        return view('admin.lich-su-management', compact('lichSu', 'actionMap'));
    }
    public function orderManagement(Request $request)
    {
        $orders = NhanDon::query();
        
        // Tìm kiếm theo số điện thoại
        if ($request->filled('search')) {
            $search = $request->search;
            $orders = $orders->whereHas('user', function($q) use ($search) {
                $q->where('phone', 'like', '%' . $search . '%');
            });
        }
        
        $orders = $orders->orderBy('created_at', 'desc')->with('user');
        $orders = $orders->paginate(10);
        
        return view('admin.order-management', compact('orders'));
    }

    public function userLichSu(Request $request)
    {
        $lichSu = LichSu::query();
        
        // Chỉ lấy lịch sử của user đang đăng nhập
        $lichSu = $lichSu->where('user_id', auth()->id());
        
        // Tìm kiếm lịch sử theo từ khóa
        if ($request->filled('search')) {
            $lichSu = $lichSu->where('ghi_chu', 'like', '%' . $request->search . '%');
        }
        
        // Lọc lịch sử theo hành động
        if ($request->filled('hanh_dong')) {
            $lichSu = $lichSu->where('hanh_dong', $request->hanh_dong);
        }
        
        // Lọc lịch sử theo trạng thái
        if ($request->filled('trang_thai')) {
            $lichSu = $lichSu->where('trang_thai', $request->trang_thai);
        }
        
        // Sắp xếp lịch sử theo ngày tạo
        $lichSu = $lichSu->orderBy('created_at', 'desc');
        $lichSu = $lichSu->paginate(10);
        
        return view('user.lich-su', compact('lichSu'));
    }
    public function napRutTien(Request $request)
    {
        $napRut = NapRut::query();
        
        // Tìm kiếm theo số điện thoại hoặc tên người dùng
        if ($request->filled('search')) {
            $search = $request->search;
            $napRut = $napRut->whereHas('user', function($q) use ($search) {
                $q->where('phone', 'like', '%' . $search . '%')
                  ->orWhere('name', 'like', '%' . $search . '%');
            });
        }
        
        // Lọc theo loại giao dịch
        if ($request->filled('loai_giao_dich')) {
            $napRut = $napRut->where('loai_giao_dich', $request->loai_giao_dich);
        }
        
        // Lọc theo trạng thái
        if ($request->filled('trang_thai')) {
            $napRut = $napRut->where('trang_thai', $request->trang_thai);
        }
        
        // Sắp xếp theo ngày tạo
        $napRut = $napRut->orderBy('created_at', 'desc')->with('user');
        $napRut = $napRut->paginate(10);
        
        // Lấy danh sách user để hiển thị trong modal
        $users = \App\Models\User::select('id', 'name', 'phone')->get();
        
        return view('admin.nap-rut-tien', compact('napRut', 'users'));
    }

    public function storeNapRut(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'loai_giao_dich' => 'required|in:nap,rut',
            'so_tien' => 'required|numeric|min:0',
            'ghi_chu' => 'nullable|string|max:255',
            'trang_thai' => 'required|in:0,1,2'
        ]);

        NapRut::create($request->all());

        return redirect()->route('admin.nap-rut-tien')
            ->with('success', __('admin::cms.created_success'));
    }

    public function showNapRut($id)
    {
        $napRut = NapRut::with('user')->findOrFail($id);
        
        $html = view('admin.partials.nap-rut-details', compact('napRut'))->render();
        
        return response()->json(['html' => $html]);
    }

    public function updateNapRut(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'loai_giao_dich' => 'required|in:nap,rut',
            'so_tien' => 'required|numeric|min:0',
            'ghi_chu' => 'nullable|string|max:255',
            'trang_thai' => 'required|in:0,1,2'
        ]);

        $napRut = NapRut::findOrFail($id);
        $napRut->update($request->all());

        return redirect()->route('admin.nap-rut-tien')
            ->with('success', __('admin::cms.updated_success'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:0,1,2'
        ]);

        $napRut = NapRut::findOrFail($id);
        $napRut->update(['trang_thai' => $request->status]);

        return response()->json(['success' => true]);
    }
}
