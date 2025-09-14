<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPhamTrangChu;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SanPhamTrangChuController extends Controller
{
    public function index(Request $request)
    {
        $query = SanPhamTrangChu::query();
        
        // Tìm kiếm theo tên sản phẩm
        if ($request->has('q') && !empty($request->q)) {
            $keyword = $request->q;
            $query->where('ten_san_pham', 'like', '%' . $keyword . '%');
        }
        
        $sanPhamTrangChu = $query->orderBy('id', 'desc')->paginate(10);
        $keyword = $request->q ?? '';
        
        return view('admin.san-pham-trang-chu', compact('sanPhamTrangChu', 'keyword'));
    }

    public function sanPhamTrangChu()
    {
        return $this->index(request());
    }

    public function create()
    {
        return view('admin.san-pham-trang-chu-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten_san_pham' => 'required|string|max:255',
            'hinh_anh' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gia_san_pham' => 'required|numeric|min:0',
            'hoa_hong' => 'required|numeric|min:0',
            'sao_vote' => 'required|numeric|min:0|max:5',
            'da_ban' => 'required|integer|min:0',
            'trang_thai' => 'required|in:0,1'
        ]);

        $data = $request->all();
        
        // Xử lý upload hình ảnh
        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('products'), $filename);
            $data['hinh_anh'] = 'products/' . $filename;
        }

        SanPhamTrangChu::create($data);

        // Trả về JSON response nếu request từ AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thêm sản phẩm thành công!'
            ]);
        }

        return redirect()->route('admin.san-pham-trang-chu.index')
            ->with('success', 'Thêm sản phẩm thành công!');
    }

    public function show($id)
    {
        $sanPhamTrangChu = SanPhamTrangChu::findOrFail($id);
        return view('admin.san-pham-trang-chu-show', compact('sanPhamTrangChu'));
    }

    public function edit($id)
    {
        $sanPhamTrangChu = SanPhamTrangChu::findOrFail($id);
        return view('admin.san-pham-trang-chu-edit', compact('sanPhamTrangChu'));
    }

    public function update(Request $request, $id)
    {
        $sanPhamTrangChu = SanPhamTrangChu::findOrFail($id);
        
        $request->validate([
            'ten_san_pham' => 'required|string|max:255',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gia_san_pham' => 'required|numeric|min:0',
            'hoa_hong' => 'required|numeric|min:0',
            'sao_vote' => 'required|numeric|min:0|max:5',
            'da_ban' => 'required|integer|min:0',
            'trang_thai' => 'required|in:0,1'
        ]);

        $data = $request->all();
        
        // Xử lý upload hình ảnh mới
        if ($request->hasFile('hinh_anh')) {
            // Xóa hình ảnh cũ
            if ($sanPhamTrangChu->hinh_anh && file_exists(public_path($sanPhamTrangChu->hinh_anh))) {
                unlink(public_path($sanPhamTrangChu->hinh_anh));
            }
            
            $file = $request->file('hinh_anh');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('products'), $filename);
            $data['hinh_anh'] = 'products/' . $filename;
        } else {
            unset($data['hinh_anh']);
        }

        $sanPhamTrangChu->update($data);

        // Trả về JSON response nếu request từ AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật sản phẩm thành công!'
            ]);
        }

        return redirect()->route('admin.san-pham-trang-chu.index')
            ->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy(Request $request, $id)
    {
        try {
            // Tìm sản phẩm
            $sanPhamTrangChu = SanPhamTrangChu::findOrFail($id);
            $productName = $sanPhamTrangChu->ten_san_pham;
            
            // Xóa hình ảnh nếu có
            if ($sanPhamTrangChu->hinh_anh && file_exists(public_path($sanPhamTrangChu->hinh_anh))) {
                unlink(public_path($sanPhamTrangChu->hinh_anh));
            }
            
            // Xóa sản phẩm
            $sanPhamTrangChu->delete();

            // Trả về response - kiểm tra cả ajax và expectsJson
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => __('admin::cms.product_deleted_successfully')
                ]);
            }

            return redirect()->route('admin.san-pham-trang-chu.index')
                ->with('success', __('admin::cms.product_deleted_successfully'));
                
        } catch (\Exception $e) {
            // Xử lý lỗi
            $errorMessage = __('admin::cms.error_deleting_product') . ': ' . $e->getMessage();
            
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 500);
            }

            return redirect()->route('admin.san-pham-trang-chu.index')
                ->with('error', $errorMessage);
        }
    }

    public function toggleStatus($id)
    {
        $sanPhamTrangChu = SanPhamTrangChu::findOrFail($id);
        $sanPhamTrangChu->trang_thai = $sanPhamTrangChu->trang_thai == 1 ? 0 : 1;
        $sanPhamTrangChu->save();

        return response()->json([
            'success' => true,
            'trang_thai' => $sanPhamTrangChu->trang_thai
        ]);
    }
}
