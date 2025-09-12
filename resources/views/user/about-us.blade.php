@php
    use App\Helpers\LanguageHelper;
    use Illuminate\Support\Facades\Auth;
    $__ = [LanguageHelper::class, 'getUserTranslation'];
    $__home = [LanguageHelper::class, 'getHomeTranslation'];
    $__account = fn($key) => LanguageHelper::getTranslationFromFile('account', $key, 'user');
    $user = Auth::user();
@endphp

@extends('user.layouts.app')

@section('title', ($__account('about_us') ?? 'Về chúng tôi') . ' - ' . ($__('tiktok_shop') ?? 'TikTok Shop'))

@section('content')
<!-- Navigation Header -->
<div class="nav-header">
    <button class="nav-button" onclick="goBack()">
        <i class="fas fa-chevron-left"></i>
    </button>
    <div class="nav-title">{{ $__account('about_us') ?? 'Về chúng tôi' }}</div>
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
</div>

<div class="container">
    <!-- Company Header -->
    <div class="about-header text-center mb-4">
        <div class="company-logo mb-3">
            <div class="logo-icon" style="width: 80px; height: 80px; font-size: 36px; margin: 0 auto;">
                <i class="fas fa-store"></i>
            </div>
        </div>
        <h1 class="company-name">TikTok Shop</h1>
        <p class="company-tagline">Nền tảng thương mại điện tử hàng đầu</p>
    </div>

    <!-- Company Introduction -->
    <div class="about-card mb-4">
        <div class="card-header">
            <h3><i class="fas fa-info-circle"></i> Giới thiệu công ty</h3>
        </div>
        <div class="card-content">
            <p>TikTok Shop là nền tảng thương mại điện tử được phát triển bởi ByteDance, kết hợp sức mạnh của mạng xã hội TikTok với trải nghiệm mua sắm trực tuyến hiện đại.</p>
            <p>Chúng tôi cam kết mang đến cho người dùng trải nghiệm mua sắm tuyệt vời với các sản phẩm chất lượng cao, giá cả cạnh tranh và dịch vụ khách hàng chuyên nghiệp.</p>
        </div>
    </div>

    <!-- Our Mission -->
    <div class="about-card mb-4">
        <div class="card-header">
            <h3><i class="fas fa-bullseye"></i> Sứ mệnh</h3>
        </div>
        <div class="card-content">
            <p>Kết nối người mua và người bán thông qua công nghệ tiên tiến, tạo ra một hệ sinh thái thương mại điện tử bền vững và phát triển.</p>
        </div>
    </div>

    <!-- Our Vision -->
    <div class="about-card mb-4">
        <div class="card-header">
            <h3><i class="fas fa-eye"></i> Tầm nhìn</h3>
        </div>
        <div class="card-content">
            <p>Trở thành nền tảng thương mại điện tử hàng đầu tại Việt Nam và khu vực Đông Nam Á, mang đến cơ hội kinh doanh cho mọi người.</p>
        </div>
    </div>

    <!-- Key Features -->
    <div class="about-card mb-4">
        <div class="card-header">
            <h3><i class="fas fa-star"></i> Điểm nổi bật</h3>
        </div>
        <div class="card-content">
            <div class="feature-list">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-shield-check"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Bảo mật cao</h4>
                        <p>Hệ thống bảo mật tiên tiến, bảo vệ thông tin khách hàng</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Giao hàng nhanh</h4>
                        <p>Mạng lưới logistics rộng khắp, giao hàng trong 24h</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Hỗ trợ 24/7</h4>
                        <p>Đội ngũ chăm sóc khách hàng chuyên nghiệp</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div class="feature-text">
                        <h4>Giao diện thân thiện</h4>
                        <p>Thiết kế đơn giản, dễ sử dụng trên mọi thiết bị</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="about-card mb-4">
        <div class="card-header">
            <h3><i class="fas fa-chart-line"></i> Thành tựu</h3>
        </div>
        <div class="card-content">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">1M+</div>
                    <div class="stat-label">Người dùng</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">50K+</div>
                    <div class="stat-label">Sản phẩm</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">99.9%</div>
                    <div class="stat-label">Uptime</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Hỗ trợ</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="about-card mb-4">
        <div class="card-header">
            <h3><i class="fas fa-phone"></i> Thông tin liên hệ</h3>
        </div>
        <div class="card-content">
            <div class="contact-info">
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>support@tiktokshop.vn</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <span>1900 1234</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Hà Nội, Việt Nam</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-globe"></i>
                    <span>www.tiktokshop.vn</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Social Media -->
    <div class="about-card mb-4">
        <div class="card-header">
            <h3><i class="fas fa-share-alt"></i> Kết nối với chúng tôi</h3>
        </div>
        <div class="card-content">
            <div class="social-links">
                <a href="#" class="social-link facebook">
                    <i class="fab fa-facebook-f"></i>
                    <span>Facebook</span>
                </a>
                <a href="#" class="social-link instagram">
                    <i class="fab fa-instagram"></i>
                    <span>Instagram</span>
                </a>
                <a href="#" class="social-link youtube">
                    <i class="fab fa-youtube"></i>
                    <span>YouTube</span>
                </a>
                <a href="#" class="social-link tiktok">
                    <i class="fab fa-tiktok"></i>
                    <span>TikTok</span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.about-header {
    padding: 20px 0;
}

.company-name {
    font-size: 28px;
    font-weight: 700;
    color: #000000;
    margin-bottom: 8px;
}

.company-tagline {
    font-size: 16px;
    color: #8e8e93;
    font-weight: 400;
}

.about-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    overflow: hidden;
}

.card-header {
    background: linear-gradient(135deg, #f4d03f, #f7dc6f);
    padding: 16px 20px;
    border-bottom: 1px solid #e5e7eb;
}

.card-header h3 {
    font-size: 18px;
    font-weight: 600;
    color: #8b4513;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.card-content {
    padding: 20px;
}

.card-content p {
    font-size: 15px;
    line-height: 1.6;
    color: #374151;
    margin-bottom: 16px;
}

.card-content p:last-child {
    margin-bottom: 0;
}

.feature-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.feature-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.feature-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #f4d03f, #f7dc6f);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #8b4513;
    font-size: 18px;
    flex-shrink: 0;
}

.feature-text h4 {
    font-size: 16px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 4px;
}

.feature-text p {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.stat-item {
    text-align: center;
    padding: 16px;
    background: #f8f9fa;
    border-radius: 8px;
}

.stat-number {
    font-size: 24px;
    font-weight: 700;
    color: #8b4513;
    margin-bottom: 4px;
}

.stat-label {
    font-size: 14px;
    color: #6b7280;
    font-weight: 500;
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: #f8f9fa;
    border-radius: 8px;
}

.contact-item i {
    width: 20px;
    color: #8b4513;
    font-size: 16px;
}

.contact-item span {
    font-size: 15px;
    color: #374151;
    font-weight: 500;
}

.social-links {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}

.social-link {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 16px;
    background: #f8f9fa;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.2s ease;
    font-size: 14px;
    font-weight: 500;
}

.social-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.social-link.facebook {
    color: #4267b2;
}

.social-link.instagram {
    color: #e4405f;
}

.social-link.youtube {
    color: #ff0000;
}

.social-link.tiktok {
    color: #000000;
}

.social-link i {
    font-size: 16px;
}

@media (max-width: 375px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .social-links {
        grid-template-columns: 1fr;
    }
}
</style>

@endsection
