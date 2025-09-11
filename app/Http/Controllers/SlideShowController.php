<?php

namespace App\Http\Controllers;

use App\Models\SlideShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SlideShowController extends Controller
{
    public function sliderManagement(Request $request)
    {
        $sliders = SlideShow::query();
        //tìm kiếm slider theo từ khoá
        if ($request->filled('search')) {
            $sliders = $sliders->where('tieu_de', 'like', '%' . $request->search . '%');
        }
        //lọc slider theo trạng thái
        if ($request->filled('trang_thai')) {
            $sliders = $sliders->where('trang_thai', $request->trang_thai);
        }
        //sắp xếp slider theo vị trí
        $sliders = $sliders->orderBy('vi_tri', 'asc')->orderBy('created_at', 'desc');
        $sliders = $sliders->paginate(10);
        return view('admin.slider-management', compact('sliders'));
    }

    public function index(Request $request)
    {
        $query = SlideShow::query();

        // Search by title
        if ($request->filled('search')) {
            $query->where('tieu_de', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        // Order by position and created_at
        $query->orderBy('vi_tri', 'asc')->orderBy('created_at', 'desc');

        $perPage = $request->get('per_page', 10);
        $sliders = $query->paginate($perPage);

        return response()->json($sliders);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tieu_de' => 'required|string|max:255',
            'vi_tri' => 'nullable|integer|min:0',
            'trang_thai' => 'required|integer|in:1,2',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only(['tieu_de', 'vi_tri', 'trang_thai']);
        $data['vi_tri'] = $data['vi_tri'] ?? 0;

        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $filename = 'slider_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('sliders'), $filename);
            $data['hinh_anh'] = 'sliders/' . $filename;
        }

        $slider = SlideShow::create($data);
        $res = [
            'success' => true,
            'message' => __('admin::cms.slider_created_success'),
            'data' => $slider
        ];
        return response()->json($res);
    }

    public function update(Request $request, $id)
    {
        $slider = SlideShow::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'tieu_de' => 'required|string|max:255',
            'vi_tri' => 'nullable|integer|min:0',
            'trang_thai' => 'required|integer|in:1,2',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only(['tieu_de', 'vi_tri', 'trang_thai']);
        $data['vi_tri'] = $data['vi_tri'] ?? 0;

        if ($request->hasFile('hinh_anh')) {
            // Delete old image
            if ($slider->hinh_anh && file_exists(public_path($slider->hinh_anh))) {
                unlink(public_path($slider->hinh_anh));
            }

            $file = $request->file('hinh_anh');
            $filename = 'slider_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('sliders'), $filename);
            $data['hinh_anh'] = 'sliders/' . $filename;
        }

        $slider->update($data);
        $res = [
            'success' => true,
            'message' => __('admin::cms.slider_updated_success'),
            'data' => $slider
        ];
        return response()->json($res);

        return response()->json($slider);
    }

    public function destroy($id)
    {
        $slider = SlideShow::findOrFail($id);

        // Delete image file
        if ($slider->hinh_anh && file_exists(public_path($slider->hinh_anh))) {
            unlink(public_path($slider->hinh_anh));
        }

        $slider->delete();

        $res = [
            'success' => true,
            'message' => __('admin::cms.slider_deleted_success'),
            'data' => $slider
        ];
        return response()->json($res);
    }

    public function toggleStatus($id)
    {
        $slider = SlideShow::findOrFail($id);
        $newStatus = $slider->trang_thai == 1 ? 2 : 1;
        $slider->update(['trang_thai' => $newStatus]);

        return response()->json($slider);
    }
}
