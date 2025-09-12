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
        <button class="receive-order-btn" onclick="receiveOrder()">
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
}

.receive-order-btn:hover {
    background: #f4d03f;
    color: #8b4513;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(244, 208, 63, 0.3);
}

.receive-order-btn:active {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(244, 208, 63, 0.2);
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
}

.agent-quantity {
    font-size: 14px;
    font-weight: 600;
    color: #000;
    flex: 0 0 50%;
    text-align: left;
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
}




</style>

<script>
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


function receiveOrder() {
    // Haptic feedback
    hapticFeedback();
    
    // Show loading state
    const btn = document.querySelector('.receive-order-btn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';
    btn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        
        // Show success message
        alert('Đã nhận đơn thành công!');
    }, 2000);
}

// Top Agents Random Data Generator
class TopAgentsGenerator {
    constructor() {
        this.agentsList = document.getElementById('topAgentsList');
        this.updateInterval = null;
        this.currentAgents = [];
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
        
        // Render lại danh sách (không sắp xếp để giữ thứ tự trượt)
        this.renderAgents();
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
    window.bannerCarousel = new BannerCarousel();
    window.topAgentsGenerator = new TopAgentsGenerator();
});
</script>
@endsection
