<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ThongBao;

class ThongBaoController extends Controller
{
    public function thongBaoManagement()
    {
        return view('admin.thong-bao-management');
    }

    public function index(Request $request)
    {
        $query = ThongBao::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('tieu_de', 'like', "%{$search}%")
                  ->orWhere('noi_dung', 'like', "%{$search}%");
            });
        }

        if ($request->filled('trang_thai')) {
            $status = (int) $request->input('trang_thai');
            if (in_array($status, [0, 1], true)) {
                $query->where('trang_thai', $status);
            }
        }

        $perPage = (int) $request->input('per_page', 10);
        $perPage = $perPage > 0 && $perPage <= 100 ? $perPage : 10;

        $notifications = $query->orderByDesc('created_at')->paginate($perPage);

        return response()->json([
            'data' => $notifications->items(),
            'meta' => [
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'per_page' => $notifications->perPage(),
                'total' => $notifications->total(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tieu_de' => ['required', 'string', 'max:255'],
            'noi_dung' => ['required', 'string'],
            'trang_thai' => ['nullable', Rule::in([0, 1])],
        ]);

        $notification = ThongBao::create([
            'tieu_de' => $validated['tieu_de'],
            'noi_dung' => $validated['noi_dung'],
            'trang_thai' => (int) ($validated['trang_thai'] ?? 1),
        ]);

        return response()->json(['success' => true, 'data' => $notification]);
    }

    public function update(Request $request, int $id)
    {
        $notification = ThongBao::findOrFail($id);

        $validated = $request->validate([
            'tieu_de' => ['required', 'string', 'max:255'],
            'noi_dung' => ['required', 'string'],
            'trang_thai' => ['nullable', Rule::in([0, 1])],
        ]);

        $notification->update([
            'tieu_de' => $validated['tieu_de'],
            'noi_dung' => $validated['noi_dung'],
            'trang_thai' => (int) ($validated['trang_thai'] ?? $notification->trang_thai),
        ]);

        return response()->json(['success' => true, 'data' => $notification->fresh()]);
    }

    public function destroy(int $id)
    {
        $notification = ThongBao::findOrFail($id);
        $notification->delete();
        return response()->json(['success' => true]);
    }

    public function toggleStatus(int $id)
    {
        $notification = ThongBao::findOrFail($id);
        $notification->trang_thai = $notification->trang_thai ? 0 : 1;
        $notification->save();
        return response()->json(['success' => true, 'data' => $notification]);
    }
}
