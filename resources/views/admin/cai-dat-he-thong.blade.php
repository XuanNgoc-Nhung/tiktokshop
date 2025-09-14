@extends('admin.layouts.app')

@section('title', __('admin::cms.system_configuration'))

@section('content')
<style>
/* Dark Theme System Settings Form */
.system-settings-container {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    min-height: 100vh;
    padding: 20px 0;
}

.system-settings-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    overflow: hidden;
    transition: all 0.3s ease;
}

.system-settings-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
}

.system-settings-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 25px 30px;
    border-bottom: none;
    position: relative;
    overflow: hidden;
}

.system-settings-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.05"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.05"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.system-settings-title {
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0;
    position: relative;
    z-index: 1;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.system-settings-title i {
    margin-right: 12px;
    color: #ffd700;
    text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
}

.system-settings-body {
    padding: 40px;
    background: rgba(255, 255, 255, 0.02);
}

.form-section {
    margin-bottom: 40px;
    padding: 30px;
    background: rgba(255, 255, 255, 0.03);
    border-radius: 15px;
    border: 1px solid rgba(255, 255, 255, 0.08);
    transition: all 0.3s ease;
}

.form-section:hover {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(255, 255, 255, 0.12);
}

.section-title {
    color: #e0e6ed;
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 25px;
    padding-bottom: 10px;
    border-bottom: 2px solid rgba(102, 126, 234, 0.3);
    position: relative;
}

.section-title i {
    margin-right: 10px;
    color: #667eea;
    text-shadow: 0 0 8px rgba(102, 126, 234, 0.5);
}

.form-group {
    margin-bottom: 25px;
    position: relative;
}

.form-label {
    color: #b8c5d1;
    font-weight: 600;
    font-size: 0.95rem;
    margin-bottom: 8px;
    display: block;
    transition: all 0.3s ease;
}

.form-label i {
    margin-right: 8px;
    width: 16px;
    text-align: center;
    color: #667eea;
    transition: all 0.3s ease;
}

.form-group:focus-within .form-label {
    color: #667eea;
    transform: translateX(5px);
}

.form-group:focus-within .form-label i {
    color: #ffd700;
    transform: scale(1.1);
}

.form-control {
    background: rgba(255, 255, 255, 0.05);
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    color: #e0e6ed;
    padding: 12px 16px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.form-control:focus {
    background: rgba(255, 255, 255, 0.08);
    border-color: #667eea;
    color: #ffffff;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    transform: translateY(-2px);
}

.form-control::placeholder {
    color: rgba(224, 230, 237, 0.6);
    font-style: italic;
}

.custom-file {
    position: relative;
}

.custom-file-input {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.custom-file-label {
    background: rgba(255, 255, 255, 0.05);
    border: 2px dashed rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    color: #b8c5d1;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    position: relative;
    overflow: hidden;
}

.custom-file-label::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.2), transparent);
    transition: left 0.5s ease;
}

.custom-file-label:hover {
    border-color: #667eea;
    background: rgba(102, 126, 234, 0.1);
    color: #ffffff;
    transform: translateY(-2px);
}

.custom-file-label:hover::before {
    left: 100%;
}

.image-preview {
    margin-top: 20px;
    text-align: center;
    padding: 20px;
    background: rgba(255, 255, 255, 0.03);
    border: 2px dashed rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    transition: all 0.3s ease;
}

.image-preview:hover {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(102, 126, 234, 0.3);
}

.image-preview img {
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease;
    max-width: 100%;
    height: auto;
    display: block;
    margin: 0 auto;
}

.image-preview img:hover {
    transform: scale(1.02);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.4);
}

.image-preview-placeholder {
    padding: 40px 20px;
    color: rgba(184, 197, 209, 0.6);
    font-style: italic;
    border: 2px dashed rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    background: rgba(255, 255, 255, 0.02);
    transition: all 0.3s ease;
}

.image-preview-placeholder:hover {
    border-color: rgba(102, 126, 234, 0.3);
    background: rgba(102, 126, 234, 0.05);
    color: rgba(184, 197, 209, 0.8);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 12px;
    padding: 12px 30px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    position: relative;
    overflow: hidden;
}

.btn-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
}

.btn-primary:hover::before {
    left: 100%;
}

.btn-secondary {
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.2);
    color: #b8c5d1;
    border-radius: 12px;
    padding: 12px 30px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.btn-secondary:hover {
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.3);
    color: #ffffff;
    transform: translateY(-3px);
}

.alert {
    border: none;
    border-radius: 12px;
    padding: 15px 20px;
    margin-bottom: 25px;
    backdrop-filter: blur(10px);
    border-left: 4px solid;
}

.alert-success {
    background: rgba(40, 167, 69, 0.1);
    border-left-color: #28a745;
    color: #d4edda;
}

.alert-danger {
    background: rgba(220, 53, 69, 0.1);
    border-left-color: #dc3545;
    color: #f8d7da;
}

.invalid-feedback {
    color: #ff6b6b;
    font-size: 0.85rem;
    margin-top: 5px;
    font-weight: 500;
}

.text-muted {
    color: rgba(184, 197, 209, 0.7) !important;
}

/* Animation for form elements */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-group {
    animation: slideInUp 0.6s ease forwards;
}

.form-group:nth-child(1) { animation-delay: 0.1s; }
.form-group:nth-child(2) { animation-delay: 0.2s; }
.form-group:nth-child(3) { animation-delay: 0.3s; }
.form-group:nth-child(4) { animation-delay: 0.4s; }
.form-group:nth-child(5) { animation-delay: 0.5s; }
.form-group:nth-child(6) { animation-delay: 0.6s; }

/* Responsive adjustments */
@media (max-width: 768px) {
    .system-settings-body {
        padding: 20px;
    }
    
    .form-section {
        padding: 20px;
        margin-bottom: 25px;
    }
    
    .system-settings-title {
        font-size: 1.5rem;
    }
}

/* Scrollbar styling */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05);
}

::-webkit-scrollbar-thumb {
    background: rgba(102, 126, 234, 0.5);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(102, 126, 234, 0.7);
}
</style>
<div class="container-fluid system-settings-container">
    <div class="row">
        <div class="col-12">
            <div class="card system-settings-card">
                <div class="card-header system-settings-header">
                    <h3 class="card-title system-settings-title">
                        <i class="fas fa-cog"></i> {{ __('admin::cms.system_configuration') }}
                    </h3>
                </div>
                <div class="card-body system-settings-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('admin::cms.close') }}">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i> {{ __('admin::cms.config_validation_required') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('admin::cms.close') }}">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('admin.cai-dat-he-thong.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Thông tin cơ bản -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="fas fa-info-circle"></i> {{ __('admin::cms.config_contact_info') }}
                            </h5>
                            
                            <!-- Hình nền - Full width -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="hinh_nen" class="form-label">
                                            <i class="fas fa-image"></i> {{ __('admin::cms.config_background_image') }}
                                        </label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('hinh_nen') is-invalid @enderror" 
                                                   id="hinh_nen" name="hinh_nen" accept="image/*,.webp">
                                            <label class="custom-file-label" for="hinh_nen">
                                                <i class="fas fa-cloud-upload-alt"></i> {{ __('admin::cms.config_upload_image') }}...
                                            </label>
                                        </div>
                                        @error('hinh_nen')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        
                                        <!-- Khung preview hình ảnh -->
                                        <div class="image-preview-container">
                                            @if($cauHinh && $cauHinh->hinh_nen)
                                                <div class="image-preview" id="image-preview">
                                                    <img src="{{ asset($cauHinh->hinh_nen) }}" alt="Hình nền hiện tại" 
                                                         class="img-thumbnail">
                                                    <small class="text-muted d-block mt-2">{{ __('admin::cms.config_current_image') }}</small>
                                                </div>
                                            @else
                                                <div class="image-preview-placeholder" id="image-preview-placeholder">
                                                    <i class="fas fa-image fa-3x mb-3" style="color: rgba(102, 126, 234, 0.3);"></i>
                                                    <p class="mb-0">{{ __('admin::cms.config_no_image') }}</p>
                                                    <small>Chọn file để xem preview</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hotline và Email - Cùng một hàng -->
                            <div class="row">
                                <!-- Hotline -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hotline" class="form-label">
                                            <i class="fas fa-phone"></i> {{ __('admin::cms.config_hotline') }}
                                        </label>
                                        <input type="text" class="form-control @error('hotline') is-invalid @enderror" 
                                               id="hotline" name="hotline" value="{{ old('hotline', $cauHinh->hotline ?? '') }}" 
                                               placeholder="{{ __('admin::cms.config_placeholder_hotline') }}">
                                        @error('hotline')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">
                                            <i class="fas fa-envelope"></i> {{ __('admin::cms.config_email') }}
                                        </label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', $cauHinh->email ?? '') }}" 
                                               placeholder="{{ __('admin::cms.config_placeholder_email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Liên kết mạng xã hội -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="fas fa-share-alt"></i> {{ __('admin::cms.config_social_links') }}
                            </h5>
                            
                            <div class="row">
                                <!-- Link Zalo -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="link_zalo" class="form-label">
                                            <i class="fab fa-zalo"></i> {{ __('admin::cms.config_zalo_link') }}
                                        </label>
                                        <input type="url" class="form-control @error('link_zalo') is-invalid @enderror" 
                                               id="link_zalo" name="link_zalo" value="{{ old('link_zalo', $cauHinh->link_zalo ?? '') }}" 
                                               placeholder="{{ __('admin::cms.config_placeholder_zalo') }}">
                                        @error('link_zalo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Link Facebook -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="link_facebook" class="form-label">
                                            <i class="fab fa-facebook"></i> {{ __('admin::cms.config_facebook_link') }}
                                        </label>
                                        <input type="url" class="form-control @error('link_facebook') is-invalid @enderror" 
                                               id="link_facebook" name="link_facebook" value="{{ old('link_facebook', $cauHinh->link_facebook ?? '') }}" 
                                               placeholder="{{ __('admin::cms.config_placeholder_facebook') }}">
                                        @error('link_facebook')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Link Telegram -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="link_telegram" class="form-label">
                                            <i class="fab fa-telegram"></i> {{ __('admin::cms.config_telegram_link') }}
                                        </label>
                                        <input type="url" class="form-control @error('link_telegram') is-invalid @enderror" 
                                               id="link_telegram" name="link_telegram" value="{{ old('link_telegram', $cauHinh->link_telegram ?? '') }}" 
                                               placeholder="{{ __('admin::cms.config_placeholder_telegram') }}">
                                        @error('link_telegram')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Link WhatsApp -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="link_whatapp" class="form-label">
                                            <i class="fab fa-whatsapp"></i> {{ __('admin::cms.config_whatsapp_link') }}
                                        </label>
                                        <input type="url" class="form-control @error('link_whatapp') is-invalid @enderror" 
                                               id="link_whatapp" name="link_whatapp" value="{{ old('link_whatapp', $cauHinh->link_whatapp ?? '') }}" 
                                               placeholder="{{ __('admin::cms.config_placeholder_whatsapp') }}">
                                        @error('link_whatapp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ví tiền điện tử -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="fas fa-wallet"></i> {{ __('admin::cms.config_wallet_addresses') }}
                            </h5>
                            
                            <div class="row">
                                <!-- Ví BTC -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="vi_btc" class="form-label">
                                            <i class="fab fa-bitcoin"></i> {{ __('admin::cms.config_btc_address') }}
                                        </label>
                                        <input type="text" class="form-control @error('vi_btc') is-invalid @enderror" 
                                               id="vi_btc" name="vi_btc" value="{{ old('vi_btc', $cauHinh->vi_btc ?? '') }}" 
                                               placeholder="{{ __('admin::cms.config_placeholder_btc') }}">
                                        @error('vi_btc')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Ví ETH -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="vi_eth" class="form-label">
                                            <i class="fab fa-ethereum"></i> {{ __('admin::cms.config_eth_address') }}
                                        </label>
                                        <input type="text" class="form-control @error('vi_eth') is-invalid @enderror" 
                                               id="vi_eth" name="vi_eth" value="{{ old('vi_eth', $cauHinh->vi_eth ?? '') }}" 
                                               placeholder="{{ __('admin::cms.config_placeholder_eth') }}">
                                        @error('vi_eth')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Ví USDT -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="vi_usdt" class="form-label">
                                            <i class="fas fa-coins"></i> {{ __('admin::cms.config_usdt_address') }}
                                        </label>
                                        <input type="text" class="form-control @error('vi_usdt') is-invalid @enderror" 
                                               id="vi_usdt" name="vi_usdt" value="{{ old('vi_usdt', $cauHinh->vi_usdt ?? '') }}" 
                                               placeholder="{{ __('admin::cms.config_placeholder_usdt') }}">
                                        @error('vi_usdt')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Nút hành động -->
                        <div class="form-section text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> {{ __('admin::cms.config_save_button') }}
                            </button>
                            <button type="reset" class="btn btn-secondary btn-lg ml-3">
                                <i class="fas fa-undo"></i> {{ __('admin::cms.config_reset_button') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hiển thị tên file khi chọn
    const fileInput = document.getElementById('hinh_nen');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || '{{ __('admin::cms.config_upload_image') }}...';
            const label = e.target.nextElementSibling;
            if (label) {
                label.innerHTML = `<i class="fas fa-cloud-upload-alt"></i> ${fileName}`;
            }
        });

        // Preview hình ảnh trước khi upload
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Ẩn placeholder nếu có
                    const placeholder = document.getElementById('image-preview-placeholder');
                    if (placeholder) {
                        placeholder.style.display = 'none';
                    }
                    
                    // Tạo hoặc cập nhật preview
                    let preview = document.getElementById('image-preview');
                    if (!preview) {
                        preview = document.createElement('div');
                        preview.id = 'image-preview';
                        preview.className = 'image-preview';
                        const container = document.querySelector('.image-preview-container');
                        container.appendChild(preview);
                    }
                    
                    preview.innerHTML = `
                        <img src="${e.target.result}" alt="Preview" class="img-thumbnail">
                        <small class="text-muted d-block mt-2">Hình ảnh mới</small>
                    `;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                // Nếu không có file, hiển thị lại placeholder
                const placeholder = document.getElementById('image-preview-placeholder');
                const preview = document.getElementById('image-preview');
                if (placeholder) {
                    placeholder.style.display = 'block';
                }
                if (preview) {
                    preview.style.display = 'none';
                }
            }
        });
    }

    // Thêm hiệu ứng focus cho các input
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });

    // Thêm hiệu ứng hover cho các form section
    const formSections = document.querySelectorAll('.form-section');
    formSections.forEach(section => {
        section.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        section.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Xử lý submit form với axios
    const form = document.querySelector('form');
    const submitBtn = document.querySelector('button[type="submit"]');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang lưu...';
            submitBtn.disabled = true;
            
            // Tạo FormData để gửi dữ liệu
            const formData = new FormData(form);
            
            // Gửi dữ liệu qua axios
            axios.post('{{ route("admin.cai-dat-he-thong.save-config") }}', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(function(response) {
                if (response.data.success) {
                    // Hiển thị thông báo thành công với đếm ngược
                    showCountdownToast('success', response.data.message, 3);
                    
                    // Reset form sau khi lưu thành công
                    form.reset();
                    
                    // Reset file input label
                    const fileLabel = document.querySelector('.custom-file-label');
                    if (fileLabel) {
                        fileLabel.innerHTML = '<i class="fas fa-cloud-upload-alt"></i> Chọn hình nền...';
                    }
                    
                    // Reset image preview
                    const placeholder = document.getElementById('image-preview-placeholder');
                    const preview = document.getElementById('image-preview');
                    if (placeholder) {
                        placeholder.style.display = 'block';
                    }
                    if (preview) {
                        preview.style.display = 'none';
                    }
                    
                    // Tải lại trang sau 3 giây
                    setTimeout(function() {
                        window.location.reload();
                    }, 3000);
                } else {
                    showToast('error', response.data.message || '{{ __('admin::cms.config_error_occurred') }}');
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
                let errorMessage = '{{ __('admin::cms.config_error_occurred') }}';
                
                if (error.response && error.response.data && error.response.data.message) {
                    errorMessage = error.response.data.message;
                } else if (error.response && error.response.data && error.response.data.errors) {
                    // Xử lý validation errors
                    const errors = error.response.data.errors;
                    const firstError = Object.values(errors)[0][0];
                    errorMessage = firstError;
                }
                
                showToast('error', errorMessage);
            })
            .finally(function() {
                // Khôi phục nút submit
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    }
    
    // Hàm hiển thị toast notification
    function showToast(type, message) {
        // Tạo toast element
        const toast = document.createElement('div');
        toast.className = `toast-notification toast-${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                <span>${message}</span>
            </div>
        `;
        
        // Thêm styles cho toast
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#28a745' : '#dc3545'};
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            z-index: 9999;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            max-width: 400px;
        `;
        
        // Thêm vào body
        document.body.appendChild(toast);
        
        // Hiển thị toast
        setTimeout(() => {
            toast.style.transform = 'translateX(0)';
        }, 100);
        
        // Tự động ẩn sau 5 giây
        setTimeout(() => {
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 5000);
    }

    // Hàm hiển thị toast notification với đếm ngược
    function showCountdownToast(type, message, seconds) {
        // Tạo toast element
        const toast = document.createElement('div');
        toast.className = `toast-notification toast-${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                <span>${message}</span>
                  <div class="countdown-text" style="margin-top: 8px; font-size: 0.9em; opacity: 0.9;">
                     {{ __('admin::cms.page_reload_countdown') }} <span class="countdown-number" style="font-weight: bold;">${seconds}</span> {{ __('admin::cms.page_reload_seconds') }}...
                  </div>
            </div>
        `;
        
        // Thêm styles cho toast
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#28a745' : '#dc3545'};
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            z-index: 9999;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            max-width: 400px;
        `;
        
        // Thêm vào body
        document.body.appendChild(toast);
        
        // Hiển thị toast
        setTimeout(() => {
            toast.style.transform = 'translateX(0)';
        }, 100);
        
        // Đếm ngược
        const countdownElement = toast.querySelector('.countdown-number');
        let countdown = seconds;
        
        const countdownInterval = setInterval(() => {
            countdown--;
            if (countdownElement) {
                countdownElement.textContent = countdown;
            }
            
            if (countdown <= 0) {
                clearInterval(countdownInterval);
                // Ẩn toast trước khi reload
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }
        }, 1000);
    }

    // Thêm hiệu ứng cho nút reset
    const resetBtn = document.querySelector('button[type="reset"]');
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            // Reset file input label
            const fileLabel = document.querySelector('.custom-file-label');
            if (fileLabel) {
                fileLabel.innerHTML = '<i class="fas fa-cloud-upload-alt"></i> {{ __('admin::cms.config_upload_image') }}...';
            }
            
            // Reset file input
            const fileInput = document.getElementById('hinh_nen');
            if (fileInput) {
                fileInput.value = '';
            }
            
            // Hiển thị lại placeholder và ẩn preview
            const placeholder = document.getElementById('image-preview-placeholder');
            const preview = document.getElementById('image-preview');
            if (placeholder) {
                placeholder.style.display = 'block';
            }
            if (preview) {
                preview.style.display = 'none';
            }
        });
    }
});
</script>
@endsection
