@php
    use App\Helpers\LanguageHelper;
    use Illuminate\Support\Facades\Auth;
    $__ = [LanguageHelper::class, 'getUserTranslation'];
    $__account = fn($key) => LanguageHelper::getTranslationFromFile('account', $key, 'user');
    $user = Auth::user();
    $profile = optional($user)->profile;
@endphp

@extends('user.layouts.app')

@section('title', ($__account('bank') ?? 'Ngân hàng') . ' - ' . ($__('tiktok_shop') ?? 'TikTok Shop'))

@section('content')
<div class="nav-header">
    <button class="nav-button" onclick="goBack()">
        <i class="fas fa-chevron-left"></i>
    </button>
    <div class="nav-title">{{ $__account('bank') ?? 'Ngân hàng' }}</div>
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
        .form-control { border-radius: 10px; }
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
    <!-- Bank information form -->
    <div class="account-card p-3">
        <div class="mb-3">
            <label class="form-label">{{ $__account('bank_name') ?? 'Ngân hàng' }}</label>
            <input autocomplete="off" id="ngan_hang" name="ngan_hang" type="text" class="form-control" value="{{ old('ngan_hang', $profile->ngan_hang ?? '') }}" placeholder="{{ $__account('placeholder_bank') ?? 'Nhập tên ngân hàng' }}">
        </div>
        <div class="mb-3">
            <label class="form-label">{{ $__account('account_number') ?? 'Số tài khoản' }}</label>
            <input autocomplete="off" id="so_tai_khoan" name="so_tai_khoan" type="text" class="form-control" value="{{ old('so_tai_khoan', $profile->so_tai_khoan ?? '') }}" placeholder="{{ $__account('placeholder_account_number') ?? 'Nhập số tài khoản' }}">
        </div>
        <div class="mb-3">
            <label class="form-label">{{ $__account('account_holder') ?? 'Chủ tài khoản' }}</label>
            <input autocomplete="off" id="chu_tai_khoan" name="chu_tai_khoan" type="text" class="form-control" value="{{ old('chu_tai_khoan', $profile->chu_tai_khoan ?? '') }}" placeholder="{{ $__account('placeholder_account_holder') ?? 'Nhập tên chủ tài khoản' }}">
        </div>

        <div class="d-grid">
            <button type="button" id="btnSaveBank" class="save-btn">
                <i class="fas fa-save me-2"></i>{{ $__account('update') ?? 'Cập nhật' }}
            </button>
        </div>
    </div>
</div>

<script>
    (function() {
        const btn = document.getElementById('btnSaveBank');
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
                { id: 'ngan_hang' },
                { id: 'so_tai_khoan' },
                { id: 'chu_tai_khoan' },
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
                ngan_hang: document.getElementById('ngan_hang').value.trim(),
                so_tai_khoan: document.getElementById('so_tai_khoan').value.trim(),
                chu_tai_khoan: document.getElementById('chu_tai_khoan').value.trim(),
                _token: '{{ csrf_token() }}'
            };

            try {
                const url = '{{ route('account.bank.update') }}';
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


