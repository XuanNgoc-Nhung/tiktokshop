@php
use App\Helpers\LanguageHelper;
$__ = [LanguageHelper::class, 'getUserTranslation'];
$__home = [LanguageHelper::class, 'getHomeTranslation'];
@endphp

@extends('user.layouts.app')

@section('title', $__home('dashboard') . ' - ' . $__('tiktok_shop'))

@section('content')
<!-- Navigation Header -->
<div class="nav-header">
    <button class="nav-button" onclick="goBack()">
        <i class="fas fa-chevron-left"></i>
    </button>
    <div class="nav-title">{{ $__home('dashboard') }}</div>
    <x-user.language-switcher />
</div>

<div class="container-fluid px-0">
    <!-- Banner Carousel -->
    <div class="banner-carousel-container mb-3 mx-3 mt-4">
        <div class="banner-carousel" id="bannerCarousel">
            @if ($slide->count() > 0)
            @for ($i = 0; $i < $slide->count(); $i++)
                <div class="banner-slide {{ $i === 0 ? 'active' : '' }}">
                    <img src="{{ $slide[$i]->hinh_anh }}" alt="Beauty Products" class="banner-image">
                    <div class="banner-overlay">
                        <div class="banner-content">
                            {{-- <h3 class="banner-title">{{ $slide[$i]->tieu_de }}</h3> --}}
                            {{-- <p class="banner-subtitle">{{ $slide[$i]->mo_ta }}</p> --}}
                        </div>
                    </div>
                </div>
                @endfor
                @else
                <!-- Slide 1 -->
                <div class="banner-slide active">
                    <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                        alt="Shopping Mall" class="banner-image">
                    <div class="banner-overlay">
                        <div class="banner-content">
                            <h3 class="banner-title">{{ $__home('discover_tiktok_shop') }}</h3>
                            <p class="banner-subtitle">{{ $__home('smart_shopping_max_savings') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="banner-slide">
                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                        alt="Fashion Store" class="banner-image">
                    <div class="banner-overlay">
                        <div class="banner-content">
                            <h3 class="banner-title">{{ $__home('attractive_offers') }}</h3>
                            <p class="banner-subtitle">{{ $__home('discount_up_to_50') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="banner-slide">
                    <img src="https://images.unsplash.com/photo-1556742111-a301076d9d18?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                        alt="Tech Gadgets" class="banner-image">
                    <div class="banner-overlay">
                        <div class="banner-content">
                            <h3 class="banner-title">{{ $__home('advanced_technology') }}</h3>
                            <p class="banner-subtitle">{{ $__home('amazing_shopping_experience') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Slide 4 -->
                <div class="banner-slide">
                    <img src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                        alt="Beauty Products" class="banner-image">
                    <div class="banner-overlay">
                        <div class="banner-content">
                            <h3 class="banner-title">{{ $__home('modern_fashion') }}</h3>
                            <p class="banner-subtitle">{{ $__home('latest_trends_2024') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Slide 5 -->
                <div class="banner-slide">
                    <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                        alt="Lifestyle Products" class="banner-image">
                    <div class="banner-overlay">
                        <div class="banner-content">
                            <h3 class="banner-title">{{ $__home('lifestyle') }}</h3>
                            <p class="banner-subtitle">{{ $__home('elevate_your_life') }}</p>
                        </div>
                    </div>
                </div>
                @endif
        </div>

        <!-- Navigation Dots -->
        <div class="banner-dots">
            @if ($slide->count() > 0)
                @for ($i = 0; $i < $slide->count(); $i++)
                    <span class="banner-dot {{ $i === 0 ? 'active' : '' }}" data-slide="{{ $i }}"></span>
                @endfor
            @else
                <span class="banner-dot active" data-slide="0"></span>
                <span class="banner-dot" data-slide="1"></span>
                <span class="banner-dot" data-slide="2"></span>
                <span class="banner-dot" data-slide="3"></span>
                <span class="banner-dot" data-slide="4"></span>
            @endif
        </div>

    </div>

    <!-- Navigation Icons -->
    <div class="d-flex justify-content-around py-3">
        <div class="nav-icon text-center" onclick="window.location.href='{{ route('nap-tien') }}'">
            <i class="fas fa-credit-card fs-4 d-block mb-2"></i>
            <span class="small">{{ $__home('recharge') }}</span>
        </div>
        <div class="nav-icon text-center" onclick="window.location.href='{{ route('rut-tien') }}'">
            <i class="fas fa-money-bill fs-4 d-block mb-2"></i>
            <span class="small">{{ $__home('withdraw') }}</span>
        </div>
        <div class="nav-icon text-center" onclick="window.location.href='{{ route('account.achievement') }}'">
            <i class="fas fa-hand-holding-usd fs-4 d-block mb-2"></i>
            <span class="small">{{ $__home('invest') }}</span>
        </div>
        <div class="nav-icon text-center" onclick="window.location.href='{{ route('account.support') }}'">
            <i class="fas fa-headset fs-4 d-block mb-2"></i>
            <span class="small">{{ $__home('service') }}</span>
        </div>
        <div class="nav-icon text-center" onclick="window.location.href='{{ route('notification') }}'">
            <i class="fas fa-bell fs-4 d-block mb-2"></i>
            <span class="small">{{ $__home('notification') }}</span>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="px-3 mb-3">
        <div class="input-group rounded-3" style="background: #fce7f3;">
            <input type="text" class="form-control border-0 bg-transparent"
                placeholder="{{ $__home('search_placeholder') }}">
            <span class="input-group-text border-0 bg-transparent">
                <i class="fas fa-search text-muted"></i>
            </span>
        </div>
    </div>

    <!-- Feature Highlights -->
    <div class="row g-2 px-3 mb-3">
        <div class="col-6">
            <div class="feature-item d-flex align-items-center p-1 bg-white rounded-3 shadow-sm">
                <div class="feature-icon me-3">
                    <i class="fas fa-tag"></i>
                </div>
                <div class="feature-text flex-grow-1">
                    <div class="feature-title">{{ $__home('attractive_discounts') }}</div>
                    <div class="feature-desc">{{ $__home('profit_up_to_35') }}</div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="feature-item d-flex align-items-center p-1 bg-white rounded-3 shadow-sm">
                <div class="feature-icon me-3">
                    <i class="fas fa-hand-holding-dollar"></i>
                </div>
                <div class="feature-text flex-grow-1">
                    <div class="feature-title">{{ $__home('secure_payment') }}</div>
                    <div class="feature-desc">{{ $__home('secure_payment_desc') }}</div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="feature-item d-flex align-items-center p-1 bg-white rounded-3 shadow-sm">
                <div class="feature-icon me-3">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="feature-text flex-grow-1">
                    <div class="feature-title">{{ $__home('quick_refund') }}</div>
                    <div class="feature-desc">{{ $__home('instant_refund') }}</div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="feature-item d-flex align-items-center p-1 bg-white rounded-3 shadow-sm">
                <div class="feature-icon me-3">
                    <i class="fas fa-phone"></i>
                </div>
                <div class="feature-text flex-grow-1">
                    <div class="feature-title">{{ $__home('support_24_7') }}</div>
                    <div class="feature-desc">{{ $__home('support_24_7_desc') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Cards -->
    <div class="row g-3 px-3 pb-3">
        @if ($sanPhamTrangChu->count() > 0)
        @for ($i = 0; $i < $sanPhamTrangChu->count(); $i++)
            <div class="col-6">
                <div class="product-card bg-white rounded-3 shadow-sm">
                    <div class="product-image-container">
                        <img src="{{ $sanPhamTrangChu[$i]->hinh_anh }}" alt="{{ $sanPhamTrangChu[$i]->ten_san_pham }}"
                            class="product-image">
                    </div>
                    <div class="p-2">
                        <h6 class="product-title mb-1">{{ $sanPhamTrangChu[$i]->ten_san_pham }}</h6>
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <div class="product-price fw-bold">{{ $sanPhamTrangChu[$i]->gia_san_pham }}</div>
                            <div class="product-discount text-muted small">{{ $sanPhamTrangChu[$i]->hoa_hong }}</div>
                        </div>
                        <div class="product-rating d-flex align-items-center">
                            <i class="fas fa-star text-warning me-1" style="font-size: 10px;"></i>
                            <span class="text-muted"
                                style="font-size: 10px;">{{ $sanPhamTrangChu[$i]->sao_vote }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endfor
            @endif
    </div>
</div>

<style>
    /* Banner Carousel Styles */
    .banner-carousel-container {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .banner-carousel {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .banner-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: all 0.5s ease-in-out;
        display: flex;
        align-items: center;
        justify-content: center;
        transform: translateX(0);
    }

    .banner-slide.active {
        opacity: 1 !important;
    }

    /* Đảm bảo slide đầu tiên hiển thị ngay lập tức */
    .banner-slide:first-child {
        opacity: 1;
    }

    .banner-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        border-radius: 5px;
        transition: transform 0.3s ease;
    }

    .banner-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .banner-content {
        text-align: center;
        color: white;
        padding: 20px;
    }

    .banner-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .banner-subtitle {
        font-size: 16px;
        font-weight: 400;
        margin: 0;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }

    /* Navigation Dots */
    .banner-dots {
        position: absolute;
        bottom: 15px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 8px;
        z-index: 10;
    }

    .banner-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        border: 2px solid rgba(255, 255, 255, 0.3);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .banner-dot.active {
        background: #ffffff;
        border: 2px solid #ffffff;
        transform: scale(1.2);
    }

    .banner-dot:hover {
        background: rgba(255, 255, 255, 0.8);
        transform: scale(1.1);
    }

    /* Swipe animation classes */
    .banner-slide.swiping {
        transition: transform 0.1s ease-out;
    }

    .banner-slide.swipe-left {
        transform: translateX(-100%);
    }

    .banner-slide.swipe-right {
        transform: translateX(100%);
    }

    /* Touch feedback */
    .banner-carousel.touching {
        cursor: grabbing;
    }

    .banner-carousel.touching .banner-image {
        transform: scale(0.98);
    }


    /* Responsive Design */
    @media (max-width: 768px) {
        .banner-title {
            font-size: 20px;
        }

        .banner-subtitle {
            font-size: 14px;
        }
    }

    /* Navigation Icons */
    .nav-icon {
        color: #ffc107;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .nav-icon i {
        font-size: 1.5rem !important;
        text-shadow: 0 2px 6px rgba(255, 140, 66, 0.6);
        transition: color 0.3s ease, text-shadow 0.3s ease;
    }

    .nav-icon:hover {
        color: #ff6b6b;
    }

    .nav-icon:hover i {
        text-shadow: 0 4px 12px rgba(255, 140, 66, 0.8);
    }

    /* Feature Items */
    .feature-item {
        border: 2px solid #e5e7eb !important;
        transition: all 0.3s ease;
    }

    .feature-item:hover {
        border-color: #ff8c42 !important;
        transform: translateY(-1px);
    }

    /* Feature Icons */
    .feature-icon {
        width: 40px;
        height: 40px;
        background: #ff8c42;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
        flex-shrink: 0;
    }

    .feature-title {
        font-size: 14px;
        font-weight: 600;
        color: #ff8c42;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 85%;
        display: block;
    }

    .feature-desc {
        font-size: 12px;
        color: #000000;
        max-width: 85%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Product Cards */
    .product-card {
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .product-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        transform: translateY(-2px);
    }

    /* Product Image Container */
    .product-image-container {
        width: 100%;
        height: 120px;
        overflow: hidden;
        position: relative;
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    .product-title {
        font-size: 13px;
        font-weight: 500;
        color: #000000;
        line-height: 1.3;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 1em;
    }

    .product-price {
        font-size: 14px;
        color: #ff6b6b;
        font-weight: 600;
    }

    .product-discount {
        font-size: 10px;
        color: #6b7280;
    }

    .product-rating {
        color: #374151;
    }

    .product-rating .text-muted {
        color: #6b7280 !important;
    }

    /* Hide scrollbar for product cards */
    .overflow-auto::-webkit-scrollbar {
        display: none;
    }

    .overflow-auto {
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    /* Remove default focus outline from search input */
    .form-control:focus {
        outline: none !important;
        box-shadow: none !important;
        border-color: transparent !important;
    }

    /* Search icon cursor pointer */
    .input-group-text {
        cursor: pointer;
    }

</style>

<script>
    // Haptic feedback simulation
    function hapticFeedback() {
        if ('vibrate' in navigator) {
            navigator.vibrate(10);
        }
    }

    // Navigation functions
    function goBack() {
        hapticFeedback();
        if (window.history.length > 1) {
            window.history.back();
        } else {
            window.location.href = '/';
        }
    }

    // Banner Carousel functionality
    class BannerCarousel {
        constructor() {
            this.currentSlide = 0;
            this.slides = document.querySelectorAll('.banner-slide');
            this.dots = document.querySelectorAll('.banner-dot');
            this.autoPlayInterval = null;
            this.autoPlayDelay = 4000; // 4 seconds

            console.log('BannerCarousel constructor called');
            console.log('Slides found:', this.slides.length);
            console.log('Dots found:', this.dots.length);

            this.init();
        }

        init() {
            // Đảm bảo slide đầu tiên được đánh dấu là active ngay lập tức
            if (this.slides.length > 0) {
                this.slides[0].classList.add('active');
                if (this.dots.length > 0) {
                    this.dots[0].classList.add('active');
                }
            }
            
            this.bindEvents();
            this.startAutoPlay();
        }

        bindEvents() {
            // Dots navigation
            this.dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    hapticFeedback();
                    this.stopAutoPlay();
                    this.goToSlide(index);
                    this.startAutoPlay();
                });
            });

            // Touch/swipe support
            this.addTouchSupport();

            // Mouse drag support for desktop
            this.addMouseSupport();

            // Pause on hover
            const carousel = document.querySelector('.banner-carousel-container');
            carousel.addEventListener('mouseenter', () => this.stopAutoPlay());
            carousel.addEventListener('mouseleave', () => this.startAutoPlay());
        }

        addTouchSupport() {
            let startX = 0;
            let endX = 0;
            let isDragging = false;
            let currentX = 0;
            const carousel = document.querySelector('.banner-carousel');

            carousel.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                currentX = startX;
                isDragging = true;
                carousel.classList.add('touching');
                this.stopAutoPlay();
            });

            carousel.addEventListener('touchmove', (e) => {
                if (!isDragging) return;
                e.preventDefault();
                currentX = e.touches[0].clientX;
                const diff = startX - currentX;
                const threshold = 30;

                if (Math.abs(diff) > threshold) {
                    const activeSlide = this.slides[this.currentSlide];
                    if (diff > 0) {
                        activeSlide.classList.add('swipe-left');
                    } else {
                        activeSlide.classList.add('swipe-right');
                    }
                }
            });

            carousel.addEventListener('touchend', (e) => {
                if (!isDragging) return;
                endX = e.changedTouches[0].clientX;
                isDragging = false;
                carousel.classList.remove('touching');

                // Remove swipe classes
                this.slides.forEach(slide => {
                    slide.classList.remove('swipe-left', 'swipe-right', 'swiping');
                });

                this.handleSwipe(startX, endX);
                this.startAutoPlay();
            });
        }

        addMouseSupport() {
            let startX = 0;
            let endX = 0;
            let isDragging = false;
            let currentX = 0;
            const carousel = document.querySelector('.banner-carousel');

            carousel.addEventListener('mousedown', (e) => {
                startX = e.clientX;
                currentX = startX;
                isDragging = true;
                carousel.classList.add('touching');
                this.stopAutoPlay();
                e.preventDefault();
            });

            carousel.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                e.preventDefault();
                currentX = e.clientX;
                const diff = startX - currentX;
                const threshold = 30;

                if (Math.abs(diff) > threshold) {
                    const activeSlide = this.slides[this.currentSlide];
                    if (diff > 0) {
                        activeSlide.classList.add('swipe-left');
                    } else {
                        activeSlide.classList.add('swipe-right');
                    }
                }
            });

            carousel.addEventListener('mouseup', (e) => {
                if (!isDragging) return;
                endX = e.clientX;
                isDragging = false;
                carousel.classList.remove('touching');

                // Remove swipe classes
                this.slides.forEach(slide => {
                    slide.classList.remove('swipe-left', 'swipe-right', 'swiping');
                });

                this.handleSwipe(startX, endX);
                this.startAutoPlay();
            });

            carousel.addEventListener('mouseleave', () => {
                if (isDragging) {
                    isDragging = false;
                    carousel.classList.remove('touching');
                    this.slides.forEach(slide => {
                        slide.classList.remove('swipe-left', 'swipe-right', 'swiping');
                    });
                    this.startAutoPlay();
                }
            });
        }

        handleSwipe(startX, endX) {
            const threshold = 50;
            const diff = startX - endX;

            if (Math.abs(diff) > threshold) {
                hapticFeedback();

                // Add swiping class for smooth transition
                this.slides[this.currentSlide].classList.add('swiping');

                if (diff > 0) {
                    this.nextSlide();
                } else {
                    this.previousSlide();
                }

                // Remove swiping class after transition
                setTimeout(() => {
                    this.slides.forEach(slide => {
                        slide.classList.remove('swiping');
                    });
                }, 500);
            }
        }

        goToSlide(index) {
            console.log('Going to slide:', index);

            // Remove active class from current slide and dot
            this.slides[this.currentSlide].classList.remove('active');
            this.dots[this.currentSlide].classList.remove('active');

            // Set new current slide
            this.currentSlide = index;

            // Add active class to new slide and dot
            this.slides[this.currentSlide].classList.add('active');
            this.dots[this.currentSlide].classList.add('active');
        }

        nextSlide() {
            const nextIndex = (this.currentSlide + 1) % this.slides.length;
            this.goToSlide(nextIndex);
        }

        previousSlide() {
            const prevIndex = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
            this.goToSlide(prevIndex);
        }

        startAutoPlay() {
            this.stopAutoPlay();
            console.log('Starting autoplay with delay:', this.autoPlayDelay);
            this.autoPlayInterval = setInterval(() => {
                console.log('Auto advancing slide');
                this.nextSlide();
            }, this.autoPlayDelay);
        }

        stopAutoPlay() {
            if (this.autoPlayInterval) {
                clearInterval(this.autoPlayInterval);
                this.autoPlayInterval = null;
            }
        }
    }

    // Simple initialization function
    function initCarousel() {
        console.log('Initializing carousel...');
        try {
            new BannerCarousel();
            console.log('Carousel initialized successfully');
            window.carouselInitialized = true;
        } catch (error) {
            console.error('Error initializing carousel:', error);
        }
    }

    // Khởi tạo carousel ngay lập tức
    function initCarouselImmediately() {
        // Kiểm tra xem các element cần thiết đã có chưa
        const slides = document.querySelectorAll('.banner-slide');
        const dots = document.querySelectorAll('.banner-dot');
        
        if (slides.length > 0) {
            console.log('Elements found, initializing carousel immediately');
            initCarousel();
        } else {
            console.log('Elements not found yet, waiting...');
            // Thử lại sau 100ms
            setTimeout(initCarouselImmediately, 100);
        }
    }

    // Khởi tạo ngay lập tức
    initCarouselImmediately();

    // Fallback initialization khi DOM loaded
    document.addEventListener('DOMContentLoaded', () => {
        if (!window.carouselInitialized) {
            console.log('DOM loaded, initializing carousel');
            initCarousel();
        }
    });

    // Final fallback after a short delay
    setTimeout(() => {
        if (!window.carouselInitialized) {
            console.log('Fallback initialization after timeout');
            initCarousel();
        }
    }, 500);

</script>
@endsection
