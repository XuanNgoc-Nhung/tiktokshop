@php
    use App\Helpers\LanguageHelper;
    use Illuminate\Support\Facades\Auth;
    $__ = [LanguageHelper::class, 'getUserTranslation'];
    $__account = fn($key) => LanguageHelper::getTranslationFromFile('account', $key, 'user');
    $user = Auth::user();
    $profile = optional($user)->profile;
@endphp

@extends('user.layouts.app')

@section('title', ($__account('personal_info') ?? 'Thông tin cá nhân') . ' - ' . ($__('tiktok_shop') ?? 'TikTok Shop'))

@section('content')
<div class="nav-header">
    <button class="nav-button" onclick="goBack()">
        <i class="fas fa-chevron-left"></i>
    </button>
    <div class="nav-title">{{ $__account('personal_info') ?? 'Thông tin cá nhân' }}</div>
    <x-user.language-switcher />
    <script>
        function goBack() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = '{{ route('account') }}';
            }
        }
    </script>
    <style>
        .account-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        }
        .form-label { font-weight: 600; color: #111827; }
        .form-control, .form-select { border-radius: 10px; }
        .save-btn {
            background: #111827;
            color: #ffffff;
            border-radius: 12px;
            padding: 10px 16px;
            border: none;
        }
        .avatar {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f4d03f, #f7dc6f);
            color: #8b4513;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 6px 18px rgba(17, 24, 39, 0.18), 0 2px 8px rgba(244, 208, 63, 0.25), inset 0 0 0 2px rgba(255, 255, 255, 0.5);
            overflow: hidden;
            position: relative;
        }
        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            display: block;
        }
        .vip-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #fde68a, #f59e0b);
            color: #78350f;
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 12px;
            font-weight: 700;
        }
        .vip-badge i { color: #ca8a04; }
        .helper { font-size: 12px; color: #6b7280; }
    </style>
</div>

<div class="container">
    <!-- Header card with avatar -->
    <div class="account-card p-3 mb-3">
        <div class="d-flex align-items-center">
            <div class="avatar me-3">
                @if($profile->anh_chan_dung)
                <img class="avatar-img" src="{{ $profile->anh_chan_dung ?? '' }}" alt="Avatar" class="avatar-img">
                @else
                {{ strtoupper(mb_substr($user->name ?? $user->phone ?? 'U', 0, 1)) }}
                @endif
            </div>
            <div class="flex-grow-1">
                <div class="fw-bold" style="font-size:16px; color:#111827;">{{ $user->name ?? 'User' }}</div>
                <div class="text-muted" style="font-size:13px;"><i class="fas fa-phone me-1"></i>{{ $user->phone ?? '—' }}</div>
                {{-- //tiền --}}
                <div class="text-muted" style="font-size:13px;"><i class="fas fa-money-bill me-1"></i>{{ $profile->so_du ?? '0' }}</div>
            </div>
            <div class="ms-auto">
                <span class="vip-badge"><i class="fas fa-crown"></i>VIP {{ (int)($profile->cap_do ?? 0) }}</span>
            </div>
        </div>
    </div>

    <!-- Personal information form -->
    <div class="account-card p-3">

            <div class="mb-3">
                <label class="form-label">{{ $__account('phone') ?? 'Số điện thoại' }}</label>
                <input type="text" class="form-control" value="{{ $user->phone }}" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ $__account('full_name') ?? 'Họ và tên' }}</label>
                <input autocomplete="off" id="full_name" name="full_name" type="text" class="form-control" value="{{ old('name', $user->name) }}" placeholder="{{ $__account('full_name') ?? 'Họ và tên' }}">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ $__account('email') ?? 'Email' }}</label>
                <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" placeholder="{{ $__account('email') ?? 'Email' }}">
            </div>

            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">{{ $__account('gender') ?? 'Giới tính' }}</label>
                    <input id="gioi_tinh" name="gioi_tinh" type="text" class="form-control" value="{{ old('gioi_tinh', $profile->gioi_tinh ?? '') }}" placeholder="{{ $__account('gender') ?? 'Giới tính' }}">
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">{{ $__account('birthday') ?? 'Ngày sinh' }}</label>
                    <input id="ngay_sinh" name="ngay_sinh" type="text" class="form-control" value="{{ old('ngay_sinh', $profile->ngay_sinh ?? '') }}" placeholder="{{ $__account('birthday') ?? 'Ngày sinh' }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ $__account('address') ?? 'Địa chỉ' }}</label>
                <input id="dia_chi" name="dia_chi" type="text" class="form-control" value="{{ old('dia_chi', $profile->dia_chi ?? '') }}" placeholder="{{ $__account('address_placeholder') ?? 'Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành' }}">
            </div>

            <div class="d-grid">
                <button type="button" id="btnSavePersonalInfo" class="save-btn">
                    <i class="fas fa-save me-2"></i>{{ $__account('update') ?? 'Cập nhật' }}
                </button>
            </div>
    </div>
</div>

<script>
    (function() {
        const btn = document.getElementById('btnSavePersonalInfo');
        if (!btn) return;
        const t = {
            missing: '{{ $__account('please_fill_all') ?? 'Vui lòng điền đầy đủ thông tin.' }}',
            success: '{{ $__account('update_success') ?? 'Cập nhật thành công.' }}',
            missing_title: '{{ $__account('missing_data') ?? 'Thiếu dữ liệu' }}',
            success_title: '{{ $__account('success_title') ?? 'Thành công' }}',
            error_title: '{{ $__account('error_title') ?? 'Lỗi' }}',
        };
        function firstEmptyField(fields) {
            for (const field of fields) {
                const el = document.getElementById(field.id);
                if (!el) continue;
                if ((el.value || '').toString().trim() === '') {
                    return el;
                }
            }
            return null;
        }
        btn.addEventListener('click', async function() {
            const fields = [
                { id: 'full_name' },
                { id: 'email' },
                { id: 'gioi_tinh' },
                { id: 'ngay_sinh' },
                { id: 'dia_chi' },
            ];
            const missingEl = firstEmptyField(fields);
            if (missingEl) {
                try { missingEl.focus(); } catch (e) {}
                if (typeof window.showToast === 'function') {
                    window.showToast('error', t.missing_title, t.missing);
                } else {
                    alert(t.missing);
                }
                return;
            }

            const payload = {
                full_name: document.getElementById('full_name').value.trim(),
                email: document.getElementById('email').value.trim(),
                gioi_tinh: document.getElementById('gioi_tinh').value.trim(),
                ngay_sinh: document.getElementById('ngay_sinh').value,
                dia_chi: document.getElementById('dia_chi').value.trim(),
                _token: '{{ csrf_token() }}'
            };

            try {
                const url = '{{ route('account.personal-info.update') }}';
                const res = await window.axios.post(url, payload, { headers: { 'Accept': 'application/json' }});
                if (res && res.data && res.data.success) {
                    if (typeof window.showToast === 'function') {
                        window.showToast('success', t.success_title, res.data.message || t.success);
                    }
                } else {
                    const msg = (res && res.data && (res.data.message || (res.data.errors && Object.values(res.data.errors)[0][0]))) || t.missing;
                    if (typeof window.showToast === 'function') {
                        window.showToast('error', t.error_title, msg);
                    }
                }
            } catch (err) {
                let msg = t.missing;
                try {
                    if (err.response && err.response.data) {
                        const d = err.response.data;
                        msg = d.message || (d.errors && Object.values(d.errors)[0][0]) || msg;
                    }
                } catch (e) {}
                if (typeof window.showToast === 'function') {
                    window.showToast('error', t.error_title, msg);
                }
            }
        });
    })();
</script>

@endsection


