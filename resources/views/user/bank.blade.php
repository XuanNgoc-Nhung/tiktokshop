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
        .account-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        }
        .form-label { font-weight: 600; color: #111827; }
        .form-control { border-radius: 10px; }
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
        .avatar-img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block; }
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


