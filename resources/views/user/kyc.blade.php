@php
    use App\Helpers\LanguageHelper;
    use Illuminate\Support\Facades\Auth;
    $__ = [LanguageHelper::class, 'getUserTranslation'];
    $__account = fn($key) => LanguageHelper::getTranslationFromFile('account', $key, 'user');
    $__kyc = fn($key) => LanguageHelper::getTranslationFromFile('kyc', $key, 'user');
    $user = Auth::user();
    $profile = optional($user)->profile;
@endphp

@extends('user.layouts.app')

@section('title', ($__kyc('title') ?? 'KYC') . ' - ' . ($__('tiktok_shop') ?? 'TikTok Shop'))

@section('content')
<div class="nav-header">
    <button class="nav-button" onclick="goBack()">
        <i class="fas fa-chevron-left"></i>
    </button>
    <div class="nav-title">{{ $__kyc('title') ?? 'KYC' }}</div>
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
        .account-card { background:#ffffff; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 4px 16px rgba(0,0,0,0.06); }
        .form-label { font-weight:600; color:#111827; }
        .helper { font-size:12px; color:#6b7280; }
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
        .upload-tile { border:2px dashed #e5e7eb; border-radius:12px; padding:16px; text-align:center; cursor:pointer; transition:all .2s ease; position:relative; background:#fafafa; }
        .upload-tile:hover { border-color:#d1d5db; background:#f9fafb; }
        .preview-wrapper { position:relative; border-radius:10px; overflow:hidden; background:#f3f4f6; height:180px; }
        .preview-img { width:100%; height:100%; border-radius:10px; object-fit:cover; display:block; }
        .image-skeleton { position:absolute; inset:0; background:linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 37%, #f3f4f6 63%); background-size:400% 100%; animation:skeleton-loading 1.4s ease infinite; }
        .preview-wrapper.loaded .image-skeleton { display:none; }
        @keyframes skeleton-loading { 0% { background-position:100% 0 } 100% { background-position:0 0 } }
        .remove-btn { position:absolute; top:8px; right:8px; border:none; background:rgba(0,0,0,0.6); color:#fff; border-radius:999px; width:28px; height:28px; display:flex; align-items:center; justify-content:center; cursor:pointer; }
        .save-btn { background:#111827; color:#ffffff; border-radius:12px; padding:12px 16px; border:none; width:100%; font-weight:600; }
        .thumb { width:100%; height:180px; display:flex; align-items:center; justify-content:center; color:#9ca3af; }
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

    <div class="account-card p-3">
        <div class="mb-3">
            <label class="form-label">{{ $__kyc('portrait_photo') ?? 'Ảnh chân dung' }}</label>
            <div class="row g-2">
                <div class="col-12">
                    <div class="upload-tile" onclick="document.getElementById('anh_chan_dung').click()">
                        <div id="preview_anh_chan_dung" class="preview-wrapper" style="display: {{ $profile && $profile->anh_chan_dung ? 'block' : 'none' }};">
                            <div class="image-skeleton"></div>
                            <img class="preview-img" loading="lazy" src="{{ $profile->anh_chan_dung ?? '' }}" alt="{{ $__kyc('portrait_photo') ?? 'Ảnh chân dung' }}">
                            <button type="button" class="remove-btn" onclick="event.stopPropagation(); removeImage('anh_chan_dung')"><i class="fas fa-times"></i></button>
                        </div>
                        <div id="placeholder_anh_chan_dung" class="thumb" style="display: {{ $profile && $profile->anh_chan_dung ? 'none' : 'flex' }};">
                            <div>
                                <i class="fas fa-camera" style="font-size:28px;"></i>
                                <div class="helper mt-2">{{ $__kyc('tap_to_select') ?? 'Nhấn để chọn ảnh' }}</div>
                            </div>
                        </div>
                        <input type="file" id="anh_chan_dung" accept="image/*" style="display:none">
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ $__kyc('front_id') ?? 'Ảnh giấy tờ mặt trước' }}</label>
            <div class="upload-tile" onclick="document.getElementById('anh_mat_truoc').click()">
                <div id="preview_anh_mat_truoc" class="preview-wrapper" style="display: {{ $profile && $profile->anh_mat_truoc ? 'block' : 'none' }};">
                    <div class="image-skeleton"></div>
                    <img class="preview-img" loading="lazy" src="{{ $profile->anh_mat_truoc ?? '' }}" alt="{{ $__kyc('front_alt') ?? 'Mặt trước giấy tờ' }}">
                    <button type="button" class="remove-btn" onclick="event.stopPropagation(); removeImage('anh_mat_truoc')"><i class="fas fa-times"></i></button>
                </div>
                <div id="placeholder_anh_mat_truoc" class="thumb" style="display: {{ $profile && $profile->anh_mat_truoc ? 'none' : 'flex' }};">
                    <div>
                        <i class="fas fa-id-card" style="font-size:28px;"></i>
                        <div class="helper mt-2">{{ $__kyc('tap_to_select') ?? 'Nhấn để chọn ảnh' }}</div>
                    </div>
                </div>
                <input type="file" id="anh_mat_truoc" accept="image/*" style="display:none">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ $__kyc('back_id') ?? 'Ảnh giấy tờ mặt sau' }}</label>
            <div class="upload-tile" onclick="document.getElementById('anh_mat_sau').click()">
                <div id="preview_anh_mat_sau" class="preview-wrapper" style="display: {{ $profile && $profile->anh_mat_sau ? 'block' : 'none' }};">
                    <div class="image-skeleton"></div>
                    <img class="preview-img" loading="lazy" src="{{ $profile->anh_mat_sau ?? '' }}" alt="{{ $__kyc('back_alt') ?? 'Mặt sau giấy tờ' }}">
                    <button type="button" class="remove-btn" onclick="event.stopPropagation(); removeImage('anh_mat_sau')"><i class="fas fa-times"></i></button>
                </div>
                <div id="placeholder_anh_mat_sau" class="thumb" style="display: {{ $profile && $profile->anh_mat_sau ? 'none' : 'flex' }};">
                    <div>
                        <i class="fas fa-id-card" style="font-size:28px;"></i>
                        <div class="helper mt-2">{{ $__kyc('tap_to_select') ?? 'Nhấn để chọn ảnh' }}</div>
                    </div>
                </div>
                <input type="file" id="anh_mat_sau" accept="image/*" style="display:none">
            </div>
        </div>

        <div class="d-grid">
            <button type="button" id="btnSaveKyc" class="save-btn"><i class="fas fa-upload me-2"></i>{{ $__kyc('upload') ?? 'Tải lên' }}</button>
        </div>
    </div>
</div>

<script>
    (function(){
        const fields = ['anh_chan_dung','anh_mat_truoc','anh_mat_sau'];
        fields.forEach(id => {
            const input = document.getElementById(id);
            if (!input) return;
            input.addEventListener('change', function(){
                if (this.files && this.files[0]) {
                    const url = URL.createObjectURL(this.files[0]);
                    const preview = document.getElementById('preview_' + id);
                    const placeholder = document.getElementById('placeholder_' + id);
                    if (preview && preview.querySelector('img')) {
                        const img = preview.querySelector('img');
                        preview.classList.remove('loaded');
                        img.onload = function(){ preview.classList.add('loaded'); };
                        img.src = url;
                        preview.style.display = 'block';
                    }
                    if (placeholder) placeholder.style.display = 'none';
                }
            });
        });

        window.removeImage = function(id){
            const input = document.getElementById(id);
            const preview = document.getElementById('preview_' + id);
            const placeholder = document.getElementById('placeholder_' + id);
            if (input) { input.value = ''; }
            if (preview) { preview.style.display = 'none'; const img = preview.querySelector('img'); if (img) img.src = ''; }
            if (placeholder) { placeholder.style.display = 'flex'; }
        }

        // Mark existing previews as loaded after their images load
        document.querySelectorAll('.preview-wrapper img').forEach(function(img){
            const wrapper = img.closest('.preview-wrapper');
            if (!wrapper) return;
            if (img.complete && img.naturalWidth > 0) {
                wrapper.classList.add('loaded');
            } else {
                img.addEventListener('load', function(){ wrapper.classList.add('loaded'); });
                img.addEventListener('error', function(){ wrapper.classList.add('loaded'); });
            }
        });

        const btn = document.getElementById('btnSaveKyc');
        if (btn) {
            btn.addEventListener('click', async function(){
                const formData = new FormData();
                fields.forEach(id => {
                    const input = document.getElementById(id);
                    if (input && input.files && input.files[0]) {
                        formData.append(id, input.files[0]);
                    }
                });
                formData.append('_token', '{{ csrf_token() }}');

                try {
                    const res = await axios.post('{{ route('account.kyc.update') }}', formData, {
                        headers: { 'Content-Type': 'multipart/form-data', 'Accept': 'application/json' }
                    });
                    if (res && res.data && res.data.success) {
                        if (typeof window.showToast === 'function') {
                            window.showToast('success', '{{ $__account('success_title') ?? 'Thành công' }}', res.data.message || '{{ $__account('update_success') ?? 'Cập nhật thành công.' }}');
                        }
                        setTimeout(function(){ window.location.reload(); }, 3000);
                    } else {
                        const msg = (res && res.data && (res.data.message || (res.data.errors && Object.values(res.data.errors)[0][0]))) || '{{ $__account('please_fill_all') ?? 'Vui lòng điền đầy đủ thông tin.' }}';
                        if (typeof window.showToast === 'function') {
                            window.showToast('error', '{{ $__account('error_title') ?? 'Lỗi' }}', msg);
                        }
                    }
                } catch (err) {
                    let msg = '{{ $__account('please_fill_all') ?? 'Vui lòng điền đầy đủ thông tin.' }}';
                    try {
                        if (err.response && err.response.data) {
                            const d = err.response.data;
                            msg = d.message || (d.errors && Object.values(d.errors)[0][0]) || msg;
                        }
                    } catch (e) {}
                    if (typeof window.showToast === 'function') {
                        window.showToast('error', '{{ $__account('error_title') ?? 'Lỗi' }}', msg);
                    }
                }
            });
        }
    })();
</script>

@endsection


