@php
    use App\Helpers\LanguageHelper;
    $__ = [LanguageHelper::class, 'getUserTranslation'];
    $__home = [LanguageHelper::class, 'getHomeTranslation'];
@endphp

@extends('user.layouts.app')

@section('title', $__('search') . ' - ' . $__('tiktok_shop'))

@section('content')
<!-- Navigation Header -->
<div class="nav-header">
    <button class="nav-button" onclick="goBack()">
        <i class="fas fa-chevron-left"></i>
    </button>
    <div class="nav-title">{{ $__('search') }}</div>
    <x-user.language-switcher />
</div>

<div class="container-fluid px-0">
    <!-- Banner Carousel -->
    <div class="banner-carousel-container mb-3 mx-3 mt-4">
        <div class="banner-carousel" id="bannerCarousel">
            <!-- Slide 1 -->
            <div class="banner-slide active">
                <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" 
                     alt="Shopping Mall" 
                     class="banner-image">
                <div class="banner-overlay">
                    <div class="banner-content">
                        <h3 class="banner-title">{{ $__home('discover_amazing_products') }}</h3>
                        <p class="banner-subtitle">{{ $__home('find_best_deals_here') }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Slide 2 -->
            <div class="banner-slide">
                <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" 
                     alt="Fashion Store" 
                     class="banner-image">
                <div class="banner-overlay">
                    <div class="banner-content">
                        <h3 class="banner-title">{{ $__home('fashion_trends') }}</h3>
                        <p class="banner-subtitle">{{ $__home('latest_fashion_collection') }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Slide 3 -->
            <div class="banner-slide">
                <img src="https://images.unsplash.com/photo-1556742111-a301076d9d18?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" 
                     alt="Tech Gadgets" 
                     class="banner-image">
                <div class="banner-overlay">
                    <div class="banner-content">
                        <h3 class="banner-title">{{ $__home('tech_gadgets') }}</h3>
                        <p class="banner-subtitle">{{ $__home('cutting_edge_technology') }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Slide 4 -->
            <div class="banner-slide">
                <img src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" 
                     alt="Beauty Products" 
                     class="banner-image">
                <div class="banner-overlay">
                    <div class="banner-content">
                        <h3 class="banner-title">{{ $__home('beauty_products') }}</h3>
                        <p class="banner-subtitle">{{ $__home('enhance_your_beauty') }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Slide 5 -->
            <div class="banner-slide">
                <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" 
                     alt="Lifestyle Products" 
                     class="banner-image">
                <div class="banner-overlay">
                    <div class="banner-content">
                        <h3 class="banner-title">{{ $__home('lifestyle_products') }}</h3>
                        <p class="banner-subtitle">{{ $__home('improve_your_lifestyle') }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigation Dots -->
        <div class="banner-dots">
            <span class="banner-dot active" data-slide="0"></span>
            <span class="banner-dot" data-slide="1"></span>
            <span class="banner-dot" data-slide="2"></span>
            <span class="banner-dot" data-slide="3"></span>
            <span class="banner-dot" data-slide="4"></span>
        </div>
    </div>

    <!-- Receive Order Button -->
    <div class="receive-order-section px-3 py-3">
        <button class="receive-order-btn" id="receiveOrderBtn" onclick="receiveOrder()">
            <i class="fas fa-hand-holding-usd me-2"></i>
            {{ $__home('receive_order') }}
        </button>
        
    </div>

    <!-- Stats Cards Section -->
    <div class="stats-section px-3 mb-3">
        <div class="stats-grid">
            <!-- Account Balance Card -->
            <div class="stats-card">
                <div class="stats-title">{{ $__home('account_balance') }}</div>
                <div class="stats-value">0 <i class="fas fa-coins"></i></div>
                <div class="stats-subtitle">{{ $__home('current_commission') }}</div>
                <div class="stats-subvalue positive">0 <i class="fas fa-coins"></i></div>
            </div>
            
            <!-- Level & Tickets Card -->
            <div class="stats-card">
                <div class="stats-title">{{ $__home('current_level') }}</div>
                <div class="stats-value">Bronze</div>
                <div class="stats-subtitle">{{ $__home('completed_tickets') }}</div>
                <div class="stats-subvalue positive">0/0</div>
            </div>
        </div>
    </div>

    <!-- Top Agents Section -->
    <div class="top-agents-section px-3 mb-3">
        <div class="top-agents-header">
            <h6 class="top-agents-title">{{ $__home('recently') }}</h6>
        </div>
        <div class="top-agents-list" id="topAgentsList">
            <!-- Agents will be generated dynamically -->
        </div>
    </div>
    <div class="px-3">
        <x-upgrade-tiers />
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-container">
            <div class="loading-spinner">
                <div class="spinner"></div>
            </div>
            <div class="loading-text" id="loadingText">{{ $__home('loading_data') }}</div>
        </div>
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

/* Responsive Design for Banner */
@media (max-width: 768px) {
    .banner-title {
        font-size: 20px;
    }
    
    .banner-subtitle {
        font-size: 14px;
    }
}

/* Receive Order Button Styles */
.receive-order-section {
    margin-bottom: 15px;
}

.receive-order-btn {
    width: 100%;
    background: #fce7f3;
    border: 2px solid #f4d03f;
    border-radius: 12px;
    padding: 15px 20px;
    font-size: 16px;
    font-weight: 600;
    color: #8b4513;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(244, 208, 63, 0.1);
    position: relative;
    overflow: hidden;
}

.receive-order-btn:hover:not(:disabled) {
    background: #f4d03f;
    color: #8b4513;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(244, 208, 63, 0.3);
}

.receive-order-btn:active:not(:disabled) {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(244, 208, 63, 0.2);
}

.receive-order-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

.receive-order-btn .fa-spinner {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Stats Cards Styles */
.stats-section {
    margin-bottom: 20px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}

.stats-card {
    background: white;
    border: 1px solid #000;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.stats-title {
    font-size: 14px;
    font-weight: 600;
    color: #8b4513;
    margin-bottom: 8px;
}

.stats-value {
    font-size: 18px;
    font-weight: 700;
    color: #000;
    margin-bottom: 8px;
}

.stats-value.negative {
    color: #ef4444;
}

.stats-subtitle {
    font-size: 12px;
    font-weight: 500;
    color: #8b4513;
    margin-bottom: 4px;
}

.stats-subvalue {
    font-size: 14px;
    font-weight: 600;
}

.stats-subvalue.positive {
    color: #10b981;
}

.stats-subvalue.negative {
    color: #ef4444;
}

/* Coin icon styling */
.stats-value .fa-coins,
.stats-subvalue .fa-coins {
    color: #f4d03f;
    font-size: 0.9em;
    margin-left: 2px;
}

/* Top Agents Styles */
.top-agents-section {
    margin-bottom: 20px;
}

.top-agents-header {
    background: #fce7f3;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 10px;
    text-align: center;
}

.top-agents-title {
    font-size: 16px;
    font-weight: 600;
    color: #8b4513;
    margin: 0;
}

.top-agents-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
    /* Giữ chiều cao ổn định, tránh layout shift khi cập nhật */
    overflow: hidden;
}

.agent-item {
    background: #fce7f3;
    border: 1px solid #000;
    border-radius: 12px;
    padding: 12px 15px;
    display: flex;
    flex-direction: row;
    align-items: center;
    transition: all 0.3s ease;
}

.agent-item:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.agent-profit {
    font-size: 14px;
    font-weight: 500;
    color: #000;
    flex: 0 0 50%;
    text-align: left;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.agent-quantity {
    font-size: 14px;
    font-weight: 600;
    color: #000;
    flex: 0 0 50%;
    text-align: left;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Agent icons styling */
.agent-profit i,
.agent-quantity i {
    color: #8b4513;
    font-size: 16px;
}

/* Simple styling for agents list */
.top-agents-list {
    opacity: 1;
    transition: all 0.3s ease;
    transform: translateY(0);
}

/* Product Modal Styles */
.product-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 99999;
    opacity: 0;
    transition: opacity 0.3s ease;
    visibility: hidden;
}

.product-modal-overlay[style*="opacity: 1"] {
    visibility: visible;
}

.product-modal {
    background: white;
    border-radius: 16px;
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    transform: scale(0.9);
    transition: transform 0.3s ease;
}

.product-modal-overlay[style*="opacity: 1"] .product-modal {
    transform: scale(1);
}

.product-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 20px 0 20px;
    border-bottom: 1px solid #eee;
    margin-bottom: 20px;
}

.product-modal-header h3 {
    margin: 0;
    color: #8b4513;
    font-size: 18px;
    font-weight: 600;
}

.product-modal-close {
    background: none;
    border: none;
    font-size: 20px;
    color: #666;
    cursor: pointer;
    padding: 5px;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.product-modal-close:hover {
    background: #f5f5f5;
    color: #333;
}

.product-modal-body {
    padding: 0 20px 20px 20px;
}

.product-image {
    text-align: center;
    margin-bottom: 20px;
}

.product-image img {
    width: 200px;
    height: 200px;
    object-fit: cover;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.product-info {
    text-align: center;
}

.product-name {
    color: #333;
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 10px;
    line-height: 1.3;
}

.product-description {
    color: #666;
    font-size: 14px;
    line-height: 1.5;
    margin-bottom: 20px;
    min-height: 40px;
}

.product-details {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 20px;
}

.product-details > div {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    padding: 8px 0;
}

.product-details > div:last-child {
    margin-bottom: 0;
}

.product-details .label {
    color: #8b4513;
    font-weight: 600;
    font-size: 14px;
}

.product-details .value {
    color: #333;
    font-weight: 700;
    font-size: 14px;
}

.product-price .value {
    color: #e74c3c;
}

.product-commission .value {
    color: #27ae60;
}

.product-level .value {
    color: #f39c12;
}

.product-modal-footer {
    padding: 0 20px 20px 20px;
    text-align: center;
}

.modal-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: nowrap;
    justify-content: space-between;
    width: 100%;
}

.btn-confirm,
.btn-change-product {
    border: none;
    border-radius: 12px;
    padding: 12px 8px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    flex: 1;
    min-width: 0;
    max-width: calc(50% - 4px);
    display: flex;
    align-items: center;
    justify-content: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 44px;
}

.btn-confirm {
    background: linear-gradient(135deg, #f4d03f, #f7dc6f);
    color: #8b4513;
    box-shadow: 0 4px 12px rgba(244, 208, 63, 0.3);
}

.btn-confirm:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(244, 208, 63, 0.4);
}

.btn-change-product {
    background: linear-gradient(135deg, #3498db, #5dade2);
    color: white;
    box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
}

.btn-change-product:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(52, 152, 219, 0.4);
}


.btn-confirm:active,
.btn-change-product:active {
    transform: translateY(0);
}

/* Loading Overlay Styles */
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 10000;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.loading-overlay.show {
    display: flex;
    opacity: 1;
}

.loading-container {
    text-align: center;
    color: white;
}

.loading-spinner {
    margin-bottom: 20px;
}

.spinner {
    width: 50px;
    height: 50px;
    border: 4px solid rgba(255, 255, 255, 0.3);
    border-top: 4px solid #f4d03f;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto;
}

.loading-text {
    font-size: 16px;
    font-weight: 600;
    color: white;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
}

/* Pulse animation for loading text */
.loading-text {
    animation: pulse 1.5s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}

/* Responsive Design for Modal */
@media (max-width: 768px) {
    .product-modal {
        width: 95%;
        margin: 20px;
    }
    
    .product-image img {
        width: 150px;
        height: 150px;
    }
    
    .product-name {
        font-size: 18px;
    }
    
    .product-details .label,
    .product-details .value {
        font-size: 13px;
    }
    
    .loading-text {
        font-size: 14px;
    }
    
    .spinner {
        width: 40px;
        height: 40px;
    }
    
    .modal-buttons {
        flex-direction: row;
        gap: 6px;
        justify-content: space-between;
    }
    
    .btn-confirm,
    .btn-change-product {
        flex: 1;
        min-width: 0;
        max-width: calc(50% - 3px);
        font-size: 11px;
        padding: 8px 6px;
        height: 40px;
    }
}




</style>

<script>
// Translation data from PHP
const translations = {
    loading_data: '{{ $__home("loading_data") }}',
    processing: '{{ $__home("processing") }}',
    receiving_order: '{{ $__home("receiving_order") }}',
    finding_suitable_order: '{{ $__home("finding_suitable_order") }}',
    preparing_order: '{{ $__home("preparing_order") }}',
    confirming_order: '{{ $__home("confirming_order") }}',
    finding_new_product: '{{ $__home("finding_new_product") }}',
    your_order: '{{ $__home("your_order") }}',
    product_price: '{{ $__home("product_price") }}',
    profit: '{{ $__home("profit") }}',
    level: '{{ $__home("level") }}',
    no_description: '{{ $__home("no_description") }}',
    change_product: '{{ $__home("change_product") }}',
    confirm: '{{ $__home("confirm") }}',
    order_confirmed_successfully: '{{ $__home("order_confirmed_successfully") }}',
    error_receiving_order: '{{ $__home("error_receiving_order") }}',
    error_connecting_server: '{{ $__home("error_connecting_server") }}',
    error_changing_product: '{{ $__home("error_changing_product") }}',
    security_error: '{{ $__home("security_error") }}',
    session_expired: '{{ $__home("session_expired") }}',
    login_required: '{{ $__home("login_required") }}',
    success_title: '{{ $__home("success_title") }}',
    error_title: '{{ $__home("error_title") }}'
};

// Haptic feedback simulation
function hapticFeedback() {
    if ('vibrate' in navigator) {
        navigator.vibrate(10);
    }
}

// Banner Carousel functionality
class BannerCarousel {
    constructor() {
        this.currentSlide = 0;
        this.slides = document.querySelectorAll('.banner-slide');
        this.dots = document.querySelectorAll('.banner-dot');
        this.autoPlayInterval = null;
        this.autoPlayDelay = 3000; // 3 seconds
        
        this.init();
    }

    init() {
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
        this.autoPlayInterval = setInterval(() => {
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


// Navigation functions
function goBack() {
    if (window.history.length > 1) {
        window.history.back();
    } else {
        window.location.href = '/dashboard';
    }
}


// Loading utility functions
function showLoading(text = translations.loading_data) {
    const overlay = document.getElementById('loadingOverlay');
    const loadingText = document.getElementById('loadingText');
    loadingText.textContent = text;
    overlay.classList.add('show');
}

function hideLoading() {
    const overlay = document.getElementById('loadingOverlay');
    overlay.classList.remove('show');
}

function showButtonLoading(button, text = translations.processing) {
    const originalText = button.innerHTML;
    button.innerHTML = `<i class="fas fa-spinner fa-spin me-2"></i>${text}`;
    button.disabled = true;
    return originalText;
}

function hideButtonLoading(button, originalText) {
    button.innerHTML = originalText;
    button.disabled = false;
}

async function receiveOrder() {
    // Haptic feedback
    hapticFeedback();
    
    const btn = document.getElementById('receiveOrderBtn');
    const originalText = showButtonLoading(btn, translations.receiving_order);
    
    try {
        // Show loading overlay
        showLoading(translations.finding_suitable_order);
        
        // Gọi API để nhận đơn hàng
        const response = await fetch('/receive-order', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({})
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Hiển thị toast thông báo nhận đơn thành công
            showToast('success', translations.success_title, data.message || 'Nhận đơn hàng thành công!');
            
            // Cập nhật loading text
            showLoading(translations.preparing_order);
            
            // Loading 2 giây trước khi hiển thị modal
            setTimeout(() => {
                hideLoading();
                showProductModal(data.product);
                hideButtonLoading(btn, originalText);
            }, 2000);
        } else {
            hideLoading();
            hideButtonLoading(btn, originalText);
            showToast('error', translations.error_title, data.message || translations.error_receiving_order);
        }
    } catch (error) {
        hideLoading();
        hideButtonLoading(btn, originalText);
        console.error('Error:', error);
        showToast('error', translations.error_title, translations.error_connecting_server);
    }
}

function showProductModal(product) {
    // Xóa modal cũ nếu có
    const existingModal = document.getElementById('productModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Tạo modal HTML
    const modalHTML = `
        <div class="product-modal-overlay" id="productModal">
            <div class="product-modal">
                <div class="product-modal-header">
                    <h3>${translations.your_order}</h3>
                    <button class="product-modal-close" onclick="closeProductModal()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="product-modal-body" 
                     data-product-id="${product.id}"
                     data-product-name="${product.ten}"
                     data-product-price="${product.gia}"
                     data-product-commission="${product.hoa_hong}">
                    <div class="product-image">
                        <img src="${product.hinh_anh ? '/' + product.hinh_anh : '/products/prod_68c130da61910.png'}" 
                             alt="${product.ten}" 
                             onerror="this.src='/products/prod_68c130da61910.png'">
                    </div>
                    <div class="product-info">
                        <h4 class="product-name">${product.ten}</h4>
                        <p class="product-description">${product.mo_ta || translations.no_description}</p>
                        <div class="product-details">
                            <div class="product-price">
                                <span class="label">${translations.product_price}</span>
                                <span class="value">${Number(product.gia).toLocaleString('vi-VN')} VNĐ</span>
                            </div>
                            <div class="product-commission">
                                <span class="label">${translations.profit}</span>
                                <span class="value">${Number(product.hoa_hong).toLocaleString('vi-VN')} VNĐ</span>
                            </div>
                            <div class="product-level">
                                <span class="label">${translations.level}</span>
                                <span class="value">${product.cap_do || 'N/A'}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-modal-footer">
                    <div class="modal-buttons">
                        <button class="btn-change-product" onclick="changeProduct()">
                            <i class="fas fa-exchange-alt me-2"></i>${translations.change_product}
                        </button>
                        <button class="btn-confirm" onclick="confirmProduct()">
                            <i class="fas fa-check me-2"></i>${translations.confirm}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Thêm modal vào body
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    // Kiểm tra modal đã được thêm chưa
    const modal = document.getElementById('productModal');
    
    if (modal) {
        // Hiệu ứng fade in
        modal.style.opacity = '0';
        modal.style.display = 'flex';
        modal.style.visibility = 'hidden';
        
        setTimeout(() => {
            modal.style.visibility = 'visible';
            modal.style.opacity = '1';
        }, 10);
    }
}

function closeProductModal() {
    const modal = document.getElementById('productModal');
    if (modal) {
        // Haptic feedback
        hapticFeedback();
        
        modal.style.opacity = '0';
        modal.style.visibility = 'hidden';
        setTimeout(() => {
            modal.remove();
        }, 300);
    }
}


async function changeProduct() {
    // Haptic feedback
    hapticFeedback();
    
    // Đóng modal hiện tại
    closeProductModal();
    
    // Hiển thị loading overlay toàn màn hình
    showLoading(translations.finding_new_product);
    
    try {
        console.log('Đang gọi API /receive-order...');
        
        // Lấy CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        console.log('CSRF Token:', csrfToken);
        if (!csrfToken) {
            throw new Error('CSRF token không tìm thấy');
        }
        
        // Gọi API để nhận sản phẩm mới
        const response = await fetch('/receive-order', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({}),
            credentials: 'same-origin' // Đảm bảo gửi cookies session
        });
        
        console.log('Response status:', response.status);
        console.log('Response ok:', response.ok);
        
        // Kiểm tra nếu response không phải JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            console.log('Response text:', text);
            throw new Error('Server trả về response không phải JSON. Status: ' + response.status);
        }
        
        const data = await response.json();
        console.log('Response data:', data);
        
        if (data.success) {
            console.log('API thành công, hiển thị modal với sản phẩm:', data.product);
            // Ẩn loading và hiển thị modal mới với sản phẩm mới
            hideLoading();
            showProductModal(data.product);
        } else {
            console.log('API thất bại:', data.message);
            // Ẩn loading và hiển thị thông báo lỗi
            hideLoading();
            showToast('error', translations.error_title, data.message || translations.error_changing_product);
        }
    } catch (error) {
        console.error('Lỗi khi gọi API:', error);
        // Ẩn loading và hiển thị thông báo lỗi
        hideLoading();
        
        if (error.message.includes('CSRF token')) {
            showToast('error', translations.error_title, translations.security_error);
        } else if (error.message.includes('419')) {
            showToast('warning', translations.error_title, translations.session_expired);
        } else if (error.message.includes('401')) {
            showToast('warning', translations.error_title, translations.login_required);
        } else {
            showToast('error', translations.error_title, translations.error_connecting_server + ': ' + error.message);
        }
    }
}

async function confirmProduct() {
    // Haptic feedback
    hapticFeedback();
    
    // Hiển thị loading
    showLoading(translations.confirming_order);
    
    try {
        // Lấy thông tin sản phẩm từ modal
        const productModal = document.getElementById('productModal');
        const productId = productModal.querySelector('[data-product-id]')?.getAttribute('data-product-id');
        const productName = productModal.querySelector('[data-product-name]')?.getAttribute('data-product-name');
        const productPrice = productModal.querySelector('[data-product-price]')?.getAttribute('data-product-price');
        const productCommission = productModal.querySelector('[data-product-commission]')?.getAttribute('data-product-commission');
        
        if (!productId || !productName || !productPrice || !productCommission) {
            throw new Error('Thông tin sản phẩm không đầy đủ');
        }
        
        // Gọi API để xác nhận đơn hàng
        const response = await fetch('/confirm-order', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                san_pham_id: parseInt(productId),
                ten_san_pham: productName,
                gia_tri: parseFloat(productPrice),
                hoa_hong: parseFloat(productCommission)
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            hideLoading();
            closeProductModal();
            
            // Hiển thị thông báo thành công bằng toast
            showToast('success', translations.success_title, translations.order_confirmed_successfully);
            
            // Có thể thêm logic cập nhật UI ở đây
            // Ví dụ: cập nhật số dư, thống kê, etc.
            console.log('Đơn hàng đã được xác nhận:', data.data);
        } else {
            hideLoading();
            showToast('error', translations.error_title, data.message || 'Có lỗi xảy ra khi xác nhận đơn hàng');
        }
    } catch (error) {
        hideLoading();
        console.error('Error:', error);
        showToast('error', translations.error_title, 'Có lỗi xảy ra khi kết nối đến server');
    }
}


// Top Agents Random Data Generator
class TopAgentsGenerator {
    constructor() {
        this.agentsList = document.getElementById('topAgentsList');
        this.updateInterval = null;
        this.currentAgents = [];
        this.fixedContainerHeightSet = false;
        this.init();
    }

    init() {
        this.generateInitialAgents();
        this.startAutoUpdate();
    }

    generateRandomPhone() {
        const prefixes = ['079', '039', '034', '078', '096', '097', '098', '032', '033', '035'];
        const prefix = prefixes[Math.floor(Math.random() * prefixes.length)];
        const suffix = Math.floor(10000000 + Math.random() * 90000000);
        return prefix + suffix.toString().substring(0, 1) + '******';
    }

    generateRandomAmount() {
        const min = 1000000; // 1 triệu
        const max = 100000000; // 100 triệu
        const amount = Math.floor(Math.random() * (max - min + 1)) + min;
        return amount.toLocaleString('vi-VN') + '💰';
    }

    generateSingleAgent() {
        return {
            phone: this.generateRandomPhone(),
            amount: this.generateRandomAmount()
        };
    }

    generateInitialAgents() {
        // Tạo 8 bản ghi ban đầu
        for (let i = 0; i < 8; i++) {
            this.currentAgents.push(this.generateSingleAgent());
        }
        // Sắp xếp theo số tiền giảm dần
        this.sortAgents();
        this.renderAgents();

        // Khóa chiều cao container sau lần render đầu tiên để tránh nhảy layout
        if (!this.fixedContainerHeightSet && this.agentsList) {
            const measuredHeight = this.agentsList.offsetHeight;
            if (measuredHeight > 0) {
                this.agentsList.style.minHeight = measuredHeight + 'px';
                this.fixedContainerHeightSet = true;
            }
        }
    }

    sortAgents() {
        this.currentAgents.sort((a, b) => {
            const amountA = parseInt(a.amount.replace(/[^\d]/g, ''));
            const amountB = parseInt(b.amount.replace(/[^\d]/g, ''));
            return amountB - amountA;
        });
    }

    addNewAgent() {
        // Tạo bản ghi mới
        const newAgent = this.generateSingleAgent();
        
        // Thêm vào đầu danh sách (vị trí 0)
        this.currentAgents.unshift(newAgent);
        
        // Xóa bản ghi cuối cùng (thứ 8) nếu danh sách có hơn 8 phần tử
        if (this.currentAgents.length > 8) {
            this.currentAgents.pop();
        }
        
        // Render lại danh sách với hiệu ứng fade
        this.renderAgentsWithAnimation();
    }

    renderAgentsWithAnimation() {
        const agentsList = this.agentsList;
        
        // Thêm class fade-out
        agentsList.style.opacity = '0.7';
        agentsList.style.transform = 'translateY(10px)';
        
        setTimeout(() => {
            this.renderAgents();
            
            // Thêm class fade-in
            agentsList.style.opacity = '1';
            agentsList.style.transform = 'translateY(0)';
        }, 150);
    }

    renderAgents() {
        const agentsHTML = this.currentAgents.map(agent => `
            <div class="agent-item">
                <div class="agent-profit"><i class="fas fa-user-circle me-2"></i>${agent.phone}</div>
                <div class="agent-quantity"><i class="fas fa-coins me-2"></i>${agent.amount}</div>
            </div>
        `).join('');
        
        this.agentsList.innerHTML = agentsHTML;
    }

    startAutoUpdate() {
        // Cập nhật mỗi giây
        this.updateInterval = setInterval(() => {
            this.addNewAgent();
        }, 1000);
    }

    stopAutoUpdate() {
        if (this.updateInterval) {
            clearInterval(this.updateInterval);
            this.updateInterval = null;
        }
    }
}

// Initialize banner carousel when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Show initial loading
    showLoading(translations.loading_data);
    
    // Simulate loading time for better UX
    setTimeout(() => {
        // Initialize components
        window.bannerCarousel = new BannerCarousel();
        window.topAgentsGenerator = new TopAgentsGenerator();
        
        // Hide loading after components are initialized
        hideLoading();
    }, 1500);
});
</script>
@endsection
