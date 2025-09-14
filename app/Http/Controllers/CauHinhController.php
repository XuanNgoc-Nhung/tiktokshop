<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CauHinh;

class CauHinhController extends Controller
{
    public function index()
    {
        $cauHinh = CauHinh::first();
        return view('admin.cai-dat-he-thong', compact('cauHinh'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hinh_nen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link_zalo' => 'nullable|url',
            'link_facebook' => 'nullable|url',
            'link_telegram' => 'nullable|url',
            'link_whatapp' => 'nullable|url',
            'email' => 'nullable|email',
            'hotline' => 'nullable|string|max:20',
            'vi_btc' => 'nullable|string|max:100',
            'vi_eth' => 'nullable|string|max:100',
            'vi_usdt' => 'nullable|string|max:100',
        ], [
            'hinh_nen.image' => __('admin::cms.config_validation_background_image'),
            'hinh_nen.mimes' => __('admin::cms.config_validation_background_format'),
            'hinh_nen.max' => __('admin::cms.config_validation_background_size'),
            'link_zalo.url' => __('admin::cms.config_validation_zalo_url'),
            'link_facebook.url' => __('admin::cms.config_validation_facebook_url'),
            'link_telegram.url' => __('admin::cms.config_validation_telegram_url'),
            'link_whatapp.url' => __('admin::cms.config_validation_whatsapp_url'),
            'email.email' => __('admin::cms.config_validation_email_format'),
            'hotline.max' => __('admin::cms.config_validation_hotline_format'),
            'vi_btc.max' => __('admin::cms.config_validation_btc_format'),
            'vi_eth.max' => __('admin::cms.config_validation_eth_format'),
            'vi_usdt.max' => __('admin::cms.config_validation_usdt_format'),
        ]);

        $data = $request->except('_token');

        // Xử lý upload hình nền
        if ($request->hasFile('hinh_nen')) {
            $file = $request->file('hinh_nen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $data['hinh_nen'] = 'uploads/' . $filename;
        }

        // Kiểm tra xem đã có cấu hình chưa
        $cauHinh = CauHinh::first();
        
        if ($cauHinh) {
            // Cập nhật cấu hình hiện có
            if ($request->hasFile('hinh_nen')) {
                // Xóa hình cũ nếu có
                if ($cauHinh->hinh_nen && file_exists(public_path($cauHinh->hinh_nen))) {
                    unlink(public_path($cauHinh->hinh_nen));
                }
            } else {
                // Giữ nguyên hình cũ nếu không upload hình mới
                unset($data['hinh_nen']);
            }
            $cauHinh->update($data);
        } else {
            // Tạo cấu hình mới
            CauHinh::create($data);
        }

        return redirect()->route('admin.cai-dat-he-thong.index')->with('success', __('admin::cms.config_saved_success'));
    }

    public function saveConfig(Request $request)
    {
        try {
            $request->validate([
                'hinh_nen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'link_zalo' => 'nullable|url',
                'link_facebook' => 'nullable|url',
                'link_telegram' => 'nullable|url',
                'link_whatapp' => 'nullable|url',
                'email' => 'nullable|email',
                'hotline' => 'nullable|string|max:20',
                'vi_btc' => 'nullable|string|max:100',
                'vi_eth' => 'nullable|string|max:100',
                'vi_usdt' => 'nullable|string|max:100',
            ], [
                'hinh_nen.image' => __('admin::cms.config_validation_background_image'),
                'hinh_nen.mimes' => __('admin::cms.config_validation_background_format'),
                'hinh_nen.max' => __('admin::cms.config_validation_background_size'),
                'link_zalo.url' => __('admin::cms.config_validation_zalo_url'),
                'link_facebook.url' => __('admin::cms.config_validation_facebook_url'),
                'link_telegram.url' => __('admin::cms.config_validation_telegram_url'),
                'link_whatapp.url' => __('admin::cms.config_validation_whatsapp_url'),
                'email.email' => __('admin::cms.config_validation_email_format'),
                'hotline.max' => __('admin::cms.config_validation_hotline_format'),
                'vi_btc.max' => __('admin::cms.config_validation_btc_format'),
                'vi_eth.max' => __('admin::cms.config_validation_eth_format'),
                'vi_usdt.max' => __('admin::cms.config_validation_usdt_format'),
            ]);

            $data = $request->except('_token');

            // Xử lý upload hình nền
            if ($request->hasFile('hinh_nen')) {
                $file = $request->file('hinh_nen');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $filename);
                $data['hinh_nen'] = 'uploads/' . $filename;
            }

            // Xóa tất cả bản ghi khác id = 1
            CauHinh::where('id', '!=', 1)->delete();

            // Kiểm tra xem có bản ghi id = 1 chưa
            $cauHinh = CauHinh::find(1);
            
            if ($cauHinh) {
                // Cập nhật bản ghi id = 1
                if ($request->hasFile('hinh_nen')) {
                    // Xóa hình cũ nếu có
                    if ($cauHinh->hinh_nen && file_exists(public_path($cauHinh->hinh_nen))) {
                        unlink(public_path($cauHinh->hinh_nen));
                    }
                } else {
                    // Giữ nguyên hình cũ nếu không upload hình mới
                    unset($data['hinh_nen']);
                }
                $cauHinh->update($data);
            } else {
                // Tạo bản ghi mới với id = 1
                $data['id'] = 1;
                CauHinh::create($data);
            }

            return response()->json([
                'success' => true,
                'message' => __('admin::cms.config_saved_success')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin::cms.config_error_occurred') . ': ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        return $this->store($request);
    }
}
