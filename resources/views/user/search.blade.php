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
                <div class="stats-value">{{ number_format($so_du, 0, '.', '.') }} <i class="fas fa-coins"></i></div>
                <div class="stats-subtitle">{{ $__home('current_commission') }}</div>
                <div class="stats-subvalue positive">{{ number_format($tong_hoa_hong, 0, '.', '.') }} <i class="fas fa-coins"></i></div>
            </div>
            
            <!-- Level & Tickets Card -->
            <div class="stats-card">
                <div class="stats-title">{{ $__home('current_level') }}</div>
                <div class="stats-value">{{ $cap_do }}</div>
                <div class="stats-subtitle">{{ $__home('completed_tickets') }}</div>
                <div class="stats-subvalue positive">{{ $luot_quay_hom_nay }}</div>
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

/* Balance Warning Styles */
.balance-warning {
    background: #fef3cd;
    border: 1px solid #fde68a;
    border-radius: 8px;
    padding: 12px;
    margin-top: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
    color: #92400e;
    font-size: 14px;
    font-weight: 500;
}

.balance-warning i {
    color: #f59e0b;
    font-size: 16px;
}

/* Deposit Button Styles */
.btn-deposit {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 12px 24px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    cursor: pointer;
    min-width: 120px;
}

.btn-deposit:hover {
    background: linear-gradient(135deg, #059669, #047857);
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
}

.btn-deposit:active {
    transform: translateY(0);
}

/* Disabled Confirm Button */
.btn-confirm:disabled {
    background: #9ca3af;
    cursor: not-allowed;
    opacity: 0.6;
}

.btn-confirm:disabled:hover {
    background: #9ca3af;
    transform: none;
    box-shadow: none;
}

/* Insufficient Balance Modal Styles */
.insufficient-balance-modal-overlay {
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

.insufficient-balance-modal-overlay[style*="opacity: 1"] {
    visibility: visible;
}

.insufficient-balance-modal {
    background: white;
    border-radius: 16px;
    width: 90%;
    max-width: 400px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    transform: scale(0.9);
    transition: transform 0.3s ease;
    text-align: center;
}

.insufficient-balance-modal-overlay[style*="opacity: 1"] .insufficient-balance-modal {
    transform: scale(1);
}

.insufficient-balance-modal-header {
    padding: 30px 20px 20px 20px;
    border-bottom: 1px solid #eee;
}

.insufficient-balance-icon {
    font-size: 48px;
    color: #ff6b6b;
    margin-bottom: 15px;
}

.insufficient-balance-modal-header h3 {
    margin: 0;
    color: #333;
    font-size: 20px;
    font-weight: 600;
}

.insufficient-balance-modal-body {
    padding: 20px;
}

.insufficient-balance-message {
    color: #666;
    font-size: 16px;
    line-height: 1.5;
    margin-bottom: 25px;
}

.insufficient-balance-modal-footer {
    padding: 0 20px 30px 20px;
}

.insufficient-balance-buttons {
    display: flex;
    gap: 10px;
    justify-content: center;
}

.btn-cancel {
    background: #f8f9fa;
    color: #666;
    border: 1px solid #dee2e6;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-cancel:hover {
    background: #e9ecef;
    color: #495057;
    text-decoration: none;
}

.btn-recharge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-recharge:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.product-modal-overlay[style*="opacity: 1"] {
    visibility: visible;
}

.product-modal {
    background: white;
    border-radius: 12px;
    width: 80%;
    max-width: 80vw;
    max-height: 85vh;
    overflow-y: auto;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.25);
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
    padding: 15px 15px 0 15px;
    border-bottom: 1px solid #eee;
    margin-bottom: 15px;
}

.product-modal-header h3 {
    margin: 0;
    color: #8b4513;
    font-size: 16px;
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
    padding: 0 15px 15px 15px;
}

.product-image {
    text-align: center;
    margin-bottom: 15px;
}

.product-image img {
    width: 140px;
    height: 140px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
}

.product-info {
    text-align: center;
}

.product-name {
    color: #333;
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 8px;
    line-height: 1.3;
}

.product-description {
    color: #666;
    font-size: 12px;
    line-height: 1.4;
    margin-bottom: 15px;
    min-height: 32px;
}

.product-details {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 12px;
    margin-bottom: 15px;
}

.product-details > div {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
    padding: 6px 0;
}

.product-details > div:last-child {
    margin-bottom: 0;
}

.product-details .label {
    color: #8b4513;
    font-weight: 600;
    font-size: 12px;
}

.product-details .value {
    color: #333;
    font-weight: 700;
    font-size: 12px;
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
    padding: 0 15px 15px 15px;
    text-align: center;
}

.modal-buttons {
    display: flex;
    gap: 6px;
    flex-wrap: nowrap;
    justify-content: center;
    width: 100%;
}

.btn-confirm,
.btn-change-product {
    border: none;
    border-radius: 8px;
    padding: 10px 18px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 38px;
    min-width: 160px;
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
        width: 85%;
        max-width: 85vw;
        margin: 15px;
    }
    
    .product-image img {
        width: 120px;
        height: 120px;
    }
    
    .product-name {
        font-size: 14px;
    }
    
    .product-details .label,
    .product-details .value {
        font-size: 11px;
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
        gap: 4px;
        justify-content: center;
    }
    
    .btn-confirm,
    .btn-change-product {
        font-size: 11px;
        padding: 8px 16px;
        height: 36px;
        min-width: 140px;
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
    confirm: '{{ $__home("confirm") }}',
    order_confirmed_successfully: '{{ $__home("order_confirmed_successfully") }}',
    error_receiving_order: '{{ $__home("error_receiving_order") }}',
    error_connecting_server: '{{ $__home("error_connecting_server") }}',
    security_error: '{{ $__home("security_error") }}',
    session_expired: '{{ $__home("session_expired") }}',
    login_required: '{{ $__home("login_required") }}',
    success_title: '{{ $__home("success_title") }}',
    error_title: '{{ $__home("error_title") }}',
    // Insufficient Balance Modal translations
    insufficient_balance_title: '{{ $__home("insufficient_balance_title") }}',
    insufficient_balance_message: '{{ $__home("insufficient_balance_message") }}',
    recharge_now: '{{ $__home("recharge_now") }}',
    close: '{{ $__home("close") }}',
    // Balance check translations
    insufficient_balance_condition: '{{ $__home("insufficient_balance_condition") }}',
    deposit_more: '{{ $__home("deposit_more") }}'
};

// Current user balance from PHP
const currentUserBalance = {{ $so_du ?? 0 }};

// Haptic feedback simulation
function hapticFeedback() {
    console.log('📳 [HAPTIC] Triggering haptic feedback...');
    if ('vibrate' in navigator) {
        navigator.vibrate(10);
        console.log('📳 [HAPTIC] Vibration triggered');
    } else {
        console.log('📳 [HAPTIC] Vibration not supported on this device');
    }
}

// Banner Carousel functionality
class BannerCarousel {
    constructor() {
        console.log('🎠 [BANNER] Initializing banner carousel...');
        this.currentSlide = 0;
        this.slides = document.querySelectorAll('.banner-slide');
        this.dots = document.querySelectorAll('.banner-dot');
        this.autoPlayInterval = null;
        this.autoPlayDelay = 3000; // 3 seconds
        
        console.log(`🎠 [BANNER] Found ${this.slides.length} slides and ${this.dots.length} dots`);
        this.init();
    }

    init() {
        console.log('🎠 [BANNER] Setting up banner carousel events...');
        this.bindEvents();
        this.startAutoPlay();
        console.log('🎠 [BANNER] Banner carousel initialized successfully');
    }

    bindEvents() {
        console.log('🎠 [BANNER] Binding dot navigation events...');
        // Dots navigation
        this.dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                console.log(`🎠 [BANNER] Dot ${index} clicked, switching to slide ${index}`);
                hapticFeedback();
                this.stopAutoPlay();
                this.goToSlide(index);
                this.startAutoPlay();
            });
        });

        console.log('🎠 [BANNER] Adding touch/swipe support...');
        // Touch/swipe support
        this.addTouchSupport();
        
        console.log('🎠 [BANNER] Adding mouse drag support...');
        // Mouse drag support for desktop
        this.addMouseSupport();

        console.log('🎠 [BANNER] Adding hover pause functionality...');
        // Pause on hover
        const carousel = document.querySelector('.banner-carousel-container');
        carousel.addEventListener('mouseenter', () => {
            console.log('🎠 [BANNER] Mouse entered, pausing autoplay');
            this.stopAutoPlay();
        });
        carousel.addEventListener('mouseleave', () => {
            console.log('🎠 [BANNER] Mouse left, resuming autoplay');
            this.startAutoPlay();
        });
    }

    addTouchSupport() {
        console.log('🎠 [BANNER] Setting up touch support...');
        let startX = 0;
        let endX = 0;
        let isDragging = false;
        let currentX = 0;
        const carousel = document.querySelector('.banner-carousel');

        carousel.addEventListener('touchstart', (e) => {
            console.log('🎠 [BANNER] Touch started');
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
            console.log('🎠 [BANNER] Touch ended');
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
        console.log('🎠 [BANNER] Setting up mouse support...');
        let startX = 0;
        let endX = 0;
        let isDragging = false;
        let currentX = 0;
        const carousel = document.querySelector('.banner-carousel');

        carousel.addEventListener('mousedown', (e) => {
            console.log('🎠 [BANNER] Mouse down');
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
            console.log('🎠 [BANNER] Mouse up');
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
        console.log(`🎠 [BANNER] Handling swipe: diff=${diff}, threshold=${threshold}`);

        if (Math.abs(diff) > threshold) {
            console.log('🎠 [BANNER] Swipe threshold exceeded, changing slide');
            hapticFeedback();
            
            // Add swiping class for smooth transition
            this.slides[this.currentSlide].classList.add('swiping');
            
            if (diff > 0) {
                console.log('🎠 [BANNER] Swiping to next slide');
                this.nextSlide();
            } else {
                console.log('🎠 [BANNER] Swiping to previous slide');
                this.previousSlide();
            }
            
            // Remove swiping class after transition
            setTimeout(() => {
                this.slides.forEach(slide => {
                    slide.classList.remove('swiping');
                });
            }, 500);
        } else {
            console.log('🎠 [BANNER] Swipe not strong enough, ignoring');
        }
    }

    goToSlide(index) {
        console.log(`🎠 [BANNER] Going to slide ${index} (from ${this.currentSlide})`);
        // Remove active class from current slide and dot
        this.slides[this.currentSlide].classList.remove('active');
        this.dots[this.currentSlide].classList.remove('active');

        // Set new current slide
        this.currentSlide = index;

        // Add active class to new slide and dot
        this.slides[this.currentSlide].classList.add('active');
        this.dots[this.currentSlide].classList.add('active');
        console.log(`🎠 [BANNER] Now on slide ${this.currentSlide}`);
    }

    nextSlide() {
        const nextIndex = (this.currentSlide + 1) % this.slides.length;
        console.log(`🎠 [BANNER] Moving to next slide: ${nextIndex}`);
        this.goToSlide(nextIndex);
    }

    previousSlide() {
        const prevIndex = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
        console.log(`🎠 [BANNER] Moving to previous slide: ${prevIndex}`);
        this.goToSlide(prevIndex);
    }

    startAutoPlay() {
        console.log('🎠 [BANNER] Starting autoplay...');
        this.stopAutoPlay();
        this.autoPlayInterval = setInterval(() => {
            console.log('🎠 [BANNER] Autoplay tick - moving to next slide');
            this.nextSlide();
        }, this.autoPlayDelay);
    }

    stopAutoPlay() {
        console.log('🎠 [BANNER] Stopping autoplay...');
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.autoPlayInterval = null;
        }
    }
}


// Navigation functions
function goBack() {
    console.log('🔙 [NAVIGATION] Going back...');
    if (window.history.length > 1) {
        console.log('🔙 [NAVIGATION] Using browser back button');
        window.history.back();
    } else {
        console.log('🔙 [NAVIGATION] No history, redirecting to dashboard');
        window.location.href = '/dashboard';
    }
}


// Loading utility functions
function showLoading(text = translations.loading_data) {
    console.log('⏳ [LOADING] Showing loading overlay with text:', text);
    const overlay = document.getElementById('loadingOverlay');
    const loadingText = document.getElementById('loadingText');
    loadingText.textContent = text;
    overlay.classList.add('show');
    console.log('⏳ [LOADING] Loading overlay displayed');
}

function hideLoading() {
    console.log('⏳ [LOADING] Hiding loading overlay...');
    const overlay = document.getElementById('loadingOverlay');
    overlay.classList.remove('show');
    console.log('⏳ [LOADING] Loading overlay hidden');
}

function showButtonLoading(button, text = translations.processing) {
    console.log('⏳ [BUTTON LOADING] Showing button loading state with text:', text);
    const originalText = button.innerHTML;
    button.innerHTML = `<i class="fas fa-spinner fa-spin me-2"></i>${text}`;
    button.disabled = true;
    console.log('⏳ [BUTTON LOADING] Button loading state activated');
    return originalText;
}

function hideButtonLoading(button, originalText) {
    console.log('⏳ [BUTTON LOADING] Hiding button loading state...');
    button.innerHTML = originalText;
    button.disabled = false;
    console.log('⏳ [BUTTON LOADING] Button loading state deactivated');
}

async function receiveOrder() {
    console.log('🛒 [RECEIVE ORDER] Starting receive order process...');
    // Haptic feedback
    hapticFeedback();
    
    const btn = document.getElementById('receiveOrderBtn');
    const originalText = showButtonLoading(btn, translations.receiving_order);
    console.log('🛒 [RECEIVE ORDER] Button loading state activated');
    
    try {
        // Show loading overlay
        console.log('🛒 [RECEIVE ORDER] Showing loading overlay...');
        showLoading(translations.finding_suitable_order);
        
        // Gọi API để nhận đơn hàng
        console.log('🛒 [RECEIVE ORDER] Calling /receive-order API...');
        const response = await fetch('/receive-order', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({})
        });
        
        console.log(`🛒 [RECEIVE ORDER] API response status: ${response.status}`);
        const data = await response.json();
        console.log('🛒 [RECEIVE ORDER] API response data:', data);
        
        if (data.success) {
            console.log('🛒 [RECEIVE ORDER] Order received successfully!');
            // Hiển thị toast thông báo nhận đơn thành công
            showToast('success', translations.success_title, data.message || 'Nhận đơn hàng thành công!');
            
            // Cập nhật loading text
            console.log('🛒 [RECEIVE ORDER] Updating loading text to preparing order...');
            showLoading(translations.preparing_order);
            
            // Loading 2 giây trước khi hiển thị modal
            console.log('🛒 [RECEIVE ORDER] Waiting 2 seconds before showing product modal...');
            setTimeout(() => {
                console.log('🛒 [RECEIVE ORDER] Showing product modal...');
                hideLoading();
                showProductModal(data.product);
                hideButtonLoading(btn, originalText);
                console.log('🛒 [RECEIVE ORDER] Product modal displayed, button restored');
            }, 2000);
        } else {
            console.log('🛒 [RECEIVE ORDER] Order receive failed:', data.message);
            hideLoading();
            hideButtonLoading(btn, originalText);
            
            // Kiểm tra nếu là lỗi số dư không đủ thì hiển thị modal
            if (data.type === 'balance') {
                console.log('🛒 [RECEIVE ORDER] Insufficient balance, showing balance modal');
                showInsufficientBalanceModal();
            } else {
                console.log('🛒 [RECEIVE ORDER] Showing error toast');
                showToast('error', translations.error_title, data.message || translations.error_receiving_order);
            }
        }
    } catch (error) {
        console.error('🛒 [RECEIVE ORDER] Error occurred:', error);
        hideLoading();
        hideButtonLoading(btn, originalText);
        showToast('error', translations.error_title, translations.error_connecting_server);
    }
}

function showInsufficientBalanceModal() {
    console.log('💰 [BALANCE MODAL] Showing insufficient balance modal...');
    // Xóa modal cũ nếu có
    const existingModal = document.getElementById('insufficientBalanceModal');
    if (existingModal) {
        console.log('💰 [BALANCE MODAL] Removing existing modal');
        existingModal.remove();
    }
    
    // Tạo modal HTML với đa ngôn ngữ
    console.log('💰 [BALANCE MODAL] Creating modal HTML with multilingual support...');
    const modalHTML = `
        <div class="insufficient-balance-modal-overlay" id="insufficientBalanceModal">
            <div class="insufficient-balance-modal">
                <div class="insufficient-balance-modal-header">
                    <div class="insufficient-balance-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h3>${translations.insufficient_balance_title}</h3>
                </div>
                <div class="insufficient-balance-modal-body">
                    <p class="insufficient-balance-message">${translations.insufficient_balance_message}</p>
                </div>
                <div class="insufficient-balance-modal-footer">
                    <div class="insufficient-balance-buttons">
                        <button class="btn-cancel" onclick="closeInsufficientBalanceModal()">
                            <i class="fas fa-times me-2"></i>${translations.close}
                        </button>
                        <a href="{{ route('nap-tien') }}" class="btn-recharge">
                            <i class="fas fa-plus-circle me-2"></i>${translations.recharge_now}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Thêm modal vào body
    console.log('💰 [BALANCE MODAL] Adding modal to DOM...');
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    // Hiển thị modal với animation
    setTimeout(() => {
        const modal = document.getElementById('insufficientBalanceModal');
        if (modal) {
            console.log('💰 [BALANCE MODAL] Showing modal with animation...');
            modal.style.opacity = '1';
        }
    }, 10);
}

function closeInsufficientBalanceModal() {
    console.log('💰 [BALANCE MODAL] Closing insufficient balance modal...');
    const modal = document.getElementById('insufficientBalanceModal');
    if (modal) {
        console.log('💰 [BALANCE MODAL] Starting fade out animation...');
        modal.style.opacity = '0';
        setTimeout(() => {
            console.log('💰 [BALANCE MODAL] Removing modal from DOM...');
            modal.remove();
        }, 300);
    }
}

function showProductModal(product) {
    console.log('📦 [PRODUCT MODAL] Showing product modal for product:', product);
    // Xóa modal cũ nếu có
    const existingModal = document.getElementById('productModal');
    if (existingModal) {
        console.log('📦 [PRODUCT MODAL] Removing existing modal');
        existingModal.remove();
    }
    
    // Kiểm tra số dư
    const productPrice = parseFloat(product.gia);
    const hasEnoughBalance = currentUserBalance >= productPrice;
    
    console.log('💰 [BALANCE CHECK] Current balance:', currentUserBalance, 'Product price:', productPrice, 'Has enough:', hasEnoughBalance);
    
    // Tạo modal HTML
    console.log('📦 [PRODUCT MODAL] Creating product modal HTML...');
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
                                <span class="value">${Number(product.gia).toLocaleString('vi-VN')} $</span>
                            </div>
                            <div class="product-commission">
                                <span class="label">${translations.profit}</span>
                                <span class="value">${Number(product.hoa_hong).toLocaleString('vi-VN')} $</span>
                            </div>
                        </div>
                        ${!hasEnoughBalance ? `
                        <div class="balance-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>${translations.insufficient_balance_condition}</span>
                        </div>
                        ` : ''}
                    </div>
                </div>
                <div class="product-modal-footer">
                    <div class="modal-buttons">
                        ${hasEnoughBalance ? `
                        <button class="btn-confirm" onclick="confirmProduct()">
                            <i class="fas fa-check me-2"></i>${translations.confirm}
                        </button>
                        ` : `
                        <a href="{{ route('nap-tien') }}" class="btn-deposit">
                            <i class="fas fa-plus-circle me-2"></i>${translations.deposit_more}
                        </a>
                        `}
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Thêm modal vào body
    console.log('📦 [PRODUCT MODAL] Adding modal to DOM...');
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    // Kiểm tra modal đã được thêm chưa
    const modal = document.getElementById('productModal');
    
    if (modal) {
        console.log('📦 [PRODUCT MODAL] Modal added successfully, starting fade in animation...');
        // Hiệu ứng fade in
        modal.style.opacity = '0';
        modal.style.display = 'flex';
        modal.style.visibility = 'hidden';
        
        setTimeout(() => {
            console.log('📦 [PRODUCT MODAL] Showing modal with fade in effect...');
            modal.style.visibility = 'visible';
            modal.style.opacity = '1';
        }, 10);
    } else {
        console.error('📦 [PRODUCT MODAL] Failed to create modal element');
    }
}

function closeProductModal() {
    console.log('📦 [PRODUCT MODAL] Closing product modal...');
    const modal = document.getElementById('productModal');
    if (modal) {
        // Haptic feedback
        hapticFeedback();
        
        console.log('📦 [PRODUCT MODAL] Starting fade out animation...');
        modal.style.opacity = '0';
        modal.style.visibility = 'hidden';
        setTimeout(() => {
            console.log('📦 [PRODUCT MODAL] Removing modal from DOM...');
            modal.remove();
        }, 300);
    } else {
        console.log('📦 [PRODUCT MODAL] Modal not found, already closed');
    }
}



async function confirmProduct() {
    console.log('✅ [CONFIRM PRODUCT] Starting product confirmation process...');
    // Haptic feedback
    hapticFeedback();
    
    // Hiển thị loading
    console.log('✅ [CONFIRM PRODUCT] Showing loading overlay...');
    showLoading(translations.confirming_order);
    
    try {
        // Lấy thông tin sản phẩm từ modal
        console.log('✅ [CONFIRM PRODUCT] Extracting product information from modal...');
        const productModal = document.getElementById('productModal');
        const productId = productModal.querySelector('[data-product-id]')?.getAttribute('data-product-id');
        const productName = productModal.querySelector('[data-product-name]')?.getAttribute('data-product-name');
        const productPrice = productModal.querySelector('[data-product-price]')?.getAttribute('data-product-price');
        const productCommission = productModal.querySelector('[data-product-commission]')?.getAttribute('data-product-commission');
        
        console.log('✅ [CONFIRM PRODUCT] Product details:', {
            id: productId,
            name: productName,
            price: productPrice,
            commission: productCommission
        });
        
        if (!productId || !productName || !productPrice || !productCommission) {
            throw new Error('Thông tin sản phẩm không đầy đủ');
        }
        
        // Gọi API để xác nhận đơn hàng
        console.log('✅ [CONFIRM PRODUCT] Calling /confirm-order API...');
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
        
        console.log('✅ [CONFIRM PRODUCT] API response status:', response.status);
        const data = await response.json();
        console.log('✅ [CONFIRM PRODUCT] API response data:', data);
        
        if (data.success) {
            console.log('✅ [CONFIRM PRODUCT] Order confirmed successfully!');
            hideLoading();
            closeProductModal();
            
            // Hiển thị thông báo thành công bằng toast
            showToast('success', translations.success_title, translations.order_confirmed_successfully);
            
            // Có thể thêm logic cập nhật UI ở đây
            // Ví dụ: cập nhật số dư, thống kê, etc.
            console.log('✅ [CONFIRM PRODUCT] Order data:', data.data);
            console.log('✅ [CONFIRM PRODUCT] Reloading page in 1.5 seconds...');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            console.log('✅ [CONFIRM PRODUCT] Order confirmation failed:', data.message);
            hideLoading();
            showToast('error', translations.error_title, data.message || 'Có lỗi xảy ra khi xác nhận đơn hàng');
        }
    } catch (error) {
        console.error('✅ [CONFIRM PRODUCT] Error occurred:', error);
        hideLoading();
        showToast('error', translations.error_title, 'Có lỗi xảy ra khi kết nối đến server');
    }
}


// Top Agents Random Data Generator
class TopAgentsGenerator {
    constructor() {
        console.log('👥 [TOP AGENTS] Initializing top agents generator...');
        this.agentsList = document.getElementById('topAgentsList');
        this.updateInterval = null;
        this.currentAgents = [];
        this.fixedContainerHeightSet = false;
        console.log('👥 [TOP AGENTS] Agents list element found:', !!this.agentsList);
        this.init();
    }

    init() {
        console.log('👥 [TOP AGENTS] Starting initialization...');
        this.generateInitialAgents();
        this.startAutoUpdate();
        console.log('👥 [TOP AGENTS] Initialization complete');
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
        console.log('👥 [TOP AGENTS] Generating initial 8 agents...');
        // Tạo 8 bản ghi ban đầu
        for (let i = 0; i < 8; i++) {
            this.currentAgents.push(this.generateSingleAgent());
        }
        console.log('👥 [TOP AGENTS] Generated agents:', this.currentAgents.length);
        
        // Sắp xếp theo số tiền giảm dần
        console.log('👥 [TOP AGENTS] Sorting agents by amount...');
        this.sortAgents();
        this.renderAgents();

        // Khóa chiều cao container sau lần render đầu tiên để tránh nhảy layout
        if (!this.fixedContainerHeightSet && this.agentsList) {
            const measuredHeight = this.agentsList.offsetHeight;
            console.log('👥 [TOP AGENTS] Measured container height:', measuredHeight);
            if (measuredHeight > 0) {
                this.agentsList.style.minHeight = measuredHeight + 'px';
                this.fixedContainerHeightSet = true;
                console.log('👥 [TOP AGENTS] Fixed container height set to:', measuredHeight + 'px');
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
        console.log('👥 [TOP AGENTS] Adding new agent...');
        // Tạo bản ghi mới
        const newAgent = this.generateSingleAgent();
        console.log('👥 [TOP AGENTS] New agent generated:', newAgent);
        
        // Thêm vào đầu danh sách (vị trí 0)
        this.currentAgents.unshift(newAgent);
        console.log('👥 [TOP AGENTS] Agent added to list, total agents:', this.currentAgents.length);
        
        // Xóa bản ghi cuối cùng (thứ 8) nếu danh sách có hơn 8 phần tử
        if (this.currentAgents.length > 8) {
            const removedAgent = this.currentAgents.pop();
            console.log('👥 [TOP AGENTS] Removed last agent to maintain limit:', removedAgent);
        }
        
        // Render lại danh sách với hiệu ứng fade
        console.log('👥 [TOP AGENTS] Rendering agents with animation...');
        this.renderAgentsWithAnimation();
    }

    renderAgentsWithAnimation() {
        console.log('👥 [TOP AGENTS] Starting fade animation...');
        const agentsList = this.agentsList;
        
        // Thêm class fade-out
        agentsList.style.opacity = '0.7';
        agentsList.style.transform = 'translateY(10px)';
        console.log('👥 [TOP AGENTS] Fade out applied');
        
        setTimeout(() => {
            console.log('👥 [TOP AGENTS] Rendering agents and applying fade in...');
            this.renderAgents();
            
            // Thêm class fade-in
            agentsList.style.opacity = '1';
            agentsList.style.transform = 'translateY(0)';
            console.log('👥 [TOP AGENTS] Fade in applied');
        }, 150);
    }

    renderAgents() {
        console.log('👥 [TOP AGENTS] Rendering agents to DOM...');
        const agentsHTML = this.currentAgents.map(agent => `
            <div class="agent-item">
                <div class="agent-profit"><i class="fas fa-user-circle me-2"></i>${agent.phone}</div>
                <div class="agent-quantity"><i class="fas fa-coins me-2"></i>${agent.amount}</div>
            </div>
        `).join('');
        
        this.agentsList.innerHTML = agentsHTML;
        console.log('👥 [TOP AGENTS] Agents rendered successfully, count:', this.currentAgents.length);
    }

    startAutoUpdate() {
        console.log('👥 [TOP AGENTS] Starting auto-update every 1 second...');
        // Cập nhật mỗi giây
        this.updateInterval = setInterval(() => {
            console.log('👥 [TOP AGENTS] Auto-update tick...');
            this.addNewAgent();
        }, 1000);
    }

    stopAutoUpdate() {
        console.log('👥 [TOP AGENTS] Stopping auto-update...');
        if (this.updateInterval) {
            clearInterval(this.updateInterval);
            this.updateInterval = null;
            console.log('👥 [TOP AGENTS] Auto-update stopped');
        }
    }
}

// Initialize banner carousel when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    console.log('🔍 [SEARCH] Page loaded, initializing search screen...');
    
    // Show initial loading
    console.log('🔍 [SEARCH] Showing initial loading overlay...');
    showLoading(translations.loading_data);
    
    // Simulate loading time for better UX
    setTimeout(() => {
        console.log('🔍 [SEARCH] Starting component initialization...');
        
        // Initialize components
        console.log('🔍 [SEARCH] Initializing banner carousel...');
        window.bannerCarousel = new BannerCarousel();
        
        console.log('🔍 [SEARCH] Initializing top agents generator...');
        window.topAgentsGenerator = new TopAgentsGenerator();
        
        // Hide loading after components are initialized
        console.log('🔍 [SEARCH] Components initialized, hiding loading overlay...');
        hideLoading();
        
        console.log('🔍 [SEARCH] Search screen fully loaded and ready!');
    }, 1500);
});
</script>
@endsection
