<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LichSu;
use App\Models\NhanDon;
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
}
