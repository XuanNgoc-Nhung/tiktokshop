<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function productManagement(Request $request)
    {
        $keyword = $request->get('q');
        $productsQuery = SanPham::query();

        if (!empty($keyword)) {
            $productsQuery->where(function($q) use ($keyword) {
                $q->where('ten', 'like', "%{$keyword}%")
                  ->orWhere('mo_ta', 'like', "%{$keyword}%");
            });
        }

        $products = $productsQuery->orderByDesc('id')->paginate(10)->withQueryString();

        return view('admin.product-management', compact('products', 'keyword'));
    }

    public function createProduct()
    {
        return view('admin.product-management-create');
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'ten' => ['required','string','max:255'],
            'gia' => ['required','numeric','min:0'],
            'hoa_hong' => ['nullable','numeric','min:0'],
            'mo_ta' => ['nullable','string'],
            'hinh_anh' => ['required','image','mimes:jpeg,jpg,png,gif,webp','max:5120'],
            'cap_do' => ['required','in:0,1']
        ]);

        // Handle image upload if present
        if ($request->hasFile('hinh_anh')) {
            // Save directly to public/products
            $uploadDir = public_path('products');
            if (!is_dir($uploadDir)) {
                @mkdir($uploadDir, 0755, true);
            }
            $file = $request->file('hinh_anh');
            $filename = uniqid('prod_').'.'.$file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            // Store relative path from public
            $validated['hinh_anh'] = 'products/'.$filename;
        } else {
            // Ensure we don't try to store a non-file value for hinh_anh
            unset($validated['hinh_anh']);
        }

        $sanPham = SanPham::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('admin::cms.product_created_success'),
                'data' => $sanPham,
            ]);
        }

        return redirect()->route('admin.product-management');
    }
    
    public function updateProduct(Request $request, $id)
    {
        $sanPham = SanPham::findOrFail($id);

        $validated = $request->validate([
            'ten' => ['required','string','max:255'],
            'gia' => ['required','numeric','min:0'],
            'hoa_hong' => ['nullable','numeric','min:0'],
            'mo_ta' => ['nullable','string'],
            'hinh_anh' => ['nullable','image','mimes:jpeg,jpg,png,gif,webp','max:5120'],
            'cap_do' => ['required','in:0,1']
        ]);

        // Handle image upload if present
        if ($request->hasFile('hinh_anh')) {
            $uploadDir = public_path('products');
            if (!is_dir($uploadDir)) {
                @mkdir($uploadDir, 0755, true);
            }
            $file = $request->file('hinh_anh');
            $filename = uniqid('prod_').'.'.$file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $newPath = 'products/'.$filename;

            // Optionally delete old file if it's under public/products
            $oldPath = $sanPham->hinh_anh;
            if ($oldPath && !filter_var($oldPath, FILTER_VALIDATE_URL)) {
                $oldAbsolute = public_path($oldPath);
                if (str_starts_with($oldPath, 'products/') && file_exists($oldAbsolute)) {
                    @unlink($oldAbsolute);
                }
            }

            $validated['hinh_anh'] = $newPath;
        } else {
            // keep existing image
            unset($validated['hinh_anh']);
        }

        $sanPham->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('admin::cms.product_updated_success'),
                'data' => $sanPham->fresh(),
            ]);
        }

        return redirect()->route('admin.product-management');
    }

    public function deleteProduct(Request $request, $id)
    {
        $sanPham = SanPham::findOrFail($id);

        // If image is a local file under public/products, delete it
        $oldPath = $sanPham->hinh_anh;
        if ($oldPath && !filter_var($oldPath, FILTER_VALIDATE_URL)) {
            $oldAbsolute = public_path($oldPath);
            if (str_starts_with($oldPath, 'products/') && file_exists($oldAbsolute)) {
                @unlink($oldAbsolute);
            }
        }

        $sanPham->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('admin::cms.deleted_success'),
            ]);
        }

        return redirect()->route('admin.product-management');
    }

    public function toggleVipStatus(Request $request, $id)
    {
        try {
            $sanPham = SanPham::findOrFail($id);
            
            $validated = $request->validate([
                'vip_status' => ['required', 'in:0,1']
            ]);

            $sanPham->update(['cap_do' => $validated['vip_status']]);

            $message = $validated['vip_status'] == 1 
                ? __('admin::cms.product_set_as_vip_success')
                : __('admin::cms.product_set_as_no_vip_success');

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $sanPham->fresh(),
            ]);

        } catch (\Exception $e) {
            \Log::error('Toggle VIP status error', [
                'product_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => __('admin::cms.error_generic'),
            ], 500);
        }
    }
}
