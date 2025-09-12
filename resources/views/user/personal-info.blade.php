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
        .form-control, .form-select { border-radius: 10px; }
        .save-btn {
            background: #111827;
            color: #ffffff;
            border-radius: 12px;
            padding: 10px 16px;
            border: none;
        }
    </style>
</div>

<div class="container">
    <!-- User Info -->
    <x-user-info-card />

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


