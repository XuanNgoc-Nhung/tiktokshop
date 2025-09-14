@extends('user.layouts.app')

@section('title', __('auth.endow'))

@section('content')
<!-- Navigation Header -->
<div class="nav-header">
    <button class="nav-button" onclick="goBack()">
        <i class="fas fa-chevron-left"></i>
    </button>
    <div class="nav-title">{{ __('auth.endow') }}</div>
    <x-user.language-switcher />
</div>

<div class="container">
    <!-- User Info -->
    <x-user-info-card />

    <!-- Special Product - Coming Soon -->
    <div class="special-product-card">
        <div class="special-product-thumbnail">
            <img src="{{ $sanPhamVip->hinh_anh? asset( $sanPhamVip->hinh_anh) : asset('products/special-product.jpg') }}" 
                 alt="Special Product" 
                 loading="lazy"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div class="special-thumbnail-placeholder">
                <i class="fas fa-gift"></i>
            </div>
            <div class="special-product-overlay">
                <div class="coming-soon-badge">
                    <i class="fas fa-clock"></i>
                    <span>{{ __('auth.coming_soon') }}</span>
                </div>
                <div class="special-badge">
                    <i class="fas fa-star"></i>
                    <span>{{ __('auth.special') }}</span>
                </div>
            </div>
        </div>
        
        <div class="special-product-info">
            <h3 class="special-product-title">{{ $sanPhamVip->ten }}</h3>
            
            <div class="special-product-details">
                <div class="special-product-pricing-section">
                    <div class="special-product-pricing">
                        <span class="special-price-value">{{ number_format($sanPhamVip->gia, 0, ',', '.') }}$</span>
                    </div>
                    
                    <div class="special-commission-section">
                        <span class="special-commission-value">+{{ number_format($sanPhamVip->hoa_hong, 0, ',', '.') }}$</span>
                    </div>
                </div>
                
                <div class="special-product-sidebar">
                    <div class="special-product-timestamp">
                        <i class="fas fa-clock"></i>
                        <span>{{ $sanPhamVip->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    
                    <button class="btn-special-receive" disabled>
                        <i class="fas fa-lock"></i>
                        <span>{{ __('auth.coming_soon') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Products List -->
    <div class="products-container" id="productsContainer">
        @forelse($nhanDons as $sanPham)
        <div class="product-card" data-category="{{ $sanPham->cap_do }}" data-name="{{ strtolower($sanPham->ten) }}">
            <div class="product-thumbnail">
                @if($sanPham->hinh_anh && file_exists(public_path('products/' . $sanPham->hinh_anh)))
                    <img src="{{ asset('products/' . $sanPham->hinh_anh) }}" 
                         alt="{{ $sanPham->ten }}" 
                         loading="lazy"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                @else
                    <div class="thumbnail-placeholder" style="display: flex;">
                        <i class="fas fa-image"></i>
                    </div>
                @endif
                <div class="thumbnail-placeholder">
                    <i class="fas fa-image"></i>
                </div>
                @if($sanPham->cap_do >= 3)
                <div class="hot-badge">
                    <i class="fas fa-fire"></i>
                </div>
                @endif
            </div>
            
            <div class="product-info">
                <h3 class="product-title">{{ Str::limit($sanPham->ten_san_pham, 50) }}</h3>
                
                <div class="product-details">
                    <div class="product-left">
                        <div class="product-pricing">
                            <span class="price-value">{{ number_format($sanPham->gia_tri, 0, ',', '.') }}$</span>
                        </div>
                        
                        <div class="commission-section">
                            <span class="commission-value">+{{ number_format($sanPham->hoa_hong, 0, ',', '.') }}$</span>
                        </div>
                    </div>
                    
                    <div class="product-right">
                        <div class="product-timestamp">
                            <i class="fas fa-clock"></i>
                            <span>{{ $sanPham->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        
                        <button class="btn-receive">
                            <i class="fas fa-hand-holding-usd"></i>
                            {{ __('auth.already_received') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-gift"></i>
            </div>
            <h3>{{ __('auth.no_products') }}</h3>
            <p>{{ __('auth.no_products_description') }}</p>
        </div>
        @endforelse
    </div>
</div>

<style>

/* Special Product Card */
.special-product-card {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 250, 252, 0.9));
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    backdrop-filter: blur(20px);
    border: 2px solid transparent;
    display: flex;
    align-items: center;
    padding: 16px;
    gap: 16px;
    position: relative;
    margin-bottom: 12px;
    animation: specialGlow 3s ease-in-out infinite alternate;
}

.special-product-card::before {
    content: '';
    position: absolute;
    top: -3px;
    left: -3px;
    right: -3px;
    bottom: -3px;
    background: conic-gradient(
        from 0deg,
        #f4d03f,
        #f7dc6f,
        #ff6b6b,
        #ee5a24,
        #38a169,
        #48bb78,
        #4299e1,
        #3182ce,
        #9f7aea,
        #f4d03f
    );
    border-radius: 19px;
    z-index: -1;
    animation: borderRotate 3s linear infinite;
}

.special-product-card::after {
    content: '';
    position: absolute;
    top: -1px;
    left: -1px;
    right: -1px;
    bottom: -1px;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 250, 252, 0.9));
    border-radius: 17px;
    z-index: -1;
}

@keyframes borderRotate {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}


@keyframes specialGlow {
    0% { 
        box-shadow: 0 4px 20px rgba(244, 208, 63, 0.1);
        border-color: rgba(244, 208, 63, 0.3);
    }
    100% { 
        box-shadow: 0 6px 24px rgba(244, 208, 63, 0.2);
        border-color: rgba(244, 208, 63, 0.5);
    }
}

.special-product-card::before {
    content: '';
    position: absolute;
    top: -3px;
    left: -3px;
    right: -3px;
    bottom: -3px;
    background: conic-gradient(
        from 0deg,
        #f4d03f,
        #f7dc6f,
        #ff6b6b,
        #ee5a24,
        #38a169,
        #48bb78,
        #4299e1,
        #3182ce,
        #9f7aea,
        #f4d03f
    );
    border-radius: 19px;
    z-index: -1;
    animation: borderRotate 3s linear infinite;
}

.special-product-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
    border-color: rgba(244, 208, 63, 0.4);
}

.special-product-thumbnail {
    position: relative;
    width: 100px;
    height: 100px;
    flex-shrink: 0;
    border-radius: 12px;
    overflow: hidden;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.special-product-card:hover .special-product-thumbnail {
    transform: scale(1.05);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
}

.special-product-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.special-product-card:hover .special-product-thumbnail img {
    transform: scale(1.05);
}

.special-thumbnail-placeholder {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f4d03f, #f7dc6f);
    display: none;
    align-items: center;
    justify-content: center;
    color: #8b4513;
    font-size: 24px;
    border-radius: 12px;
    border: 2px dashed #cbd5e0;
    transition: all 0.3s ease;
}

.special-product-card:hover .special-thumbnail-placeholder {
    background: linear-gradient(135deg, #edf2f7, #e2e8f0);
    color: #718096;
}

.special-thumbnail-placeholder i {
    opacity: 0.6;
    transition: opacity 0.3s ease;
}

.special-product-card:hover .special-thumbnail-placeholder i {
    opacity: 0.8;
}

.special-product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(244, 208, 63, 0.1), rgba(247, 220, 111, 0.1));
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: space-between;
    padding: 6px;
}

.coming-soon-badge {
    background: linear-gradient(135deg, #f4d03f, #f7dc6f);
    color: #8b4513;
    padding: 4px 8px;
    border-radius: 8px;
    font-size: 8px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 3px;
    box-shadow: 0 2px 8px rgba(244, 208, 63, 0.4);
    animation: pulse 2s infinite;
}

.coming-soon-badge i {
    font-size: 6px;
}

.special-badge {
    background: linear-gradient(135deg, #ff6b6b, #ee5a24);
    color: white;
    padding: 4px 6px;
    border-radius: 8px;
    font-size: 8px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 2px;
    box-shadow: 0 2px 8px rgba(255, 107, 107, 0.4);
    animation: bounce 2s infinite;
    align-self: flex-end;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-2px); }
    60% { transform: translateY(-1px); }
}

@keyframes specialButtonPulse {
    0%, 100% { 
        transform: scale(1);
        box-shadow: 0 3px 8px rgba(244, 208, 63, 0.4), 0 0 0 1px rgba(244, 208, 63, 0.2);
    }
    50% { 
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(244, 208, 63, 0.6), 0 0 0 2px rgba(244, 208, 63, 0.3);
    }
}

.special-badge i {
    font-size: 6px;
}

.special-product-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 12px;
    min-width: 0;
}

.special-product-title {
    font-size: 16px;
    font-weight: 700;
    color: #2d3748;
    line-height: 1.4;
    margin-bottom: 8px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    transition: color 0.3s ease;
    background: linear-gradient(135deg, #2d3748, #4a5568);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.special-product-details {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 12px;
    min-width: 0;
}

.special-product-pricing-section {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 4px;
    min-width: 0;
}

.special-product-card:hover .special-product-title {
    color: #1a202c;
}

.special-product-pricing {
    display: flex;
    align-items: center;
    margin: 2px 0;
}

.special-commission-section {
    display: flex;
    align-items: center;
    margin: 2px 0;
}

.special-product-sidebar {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 8px;
    flex-shrink: 0;
}

.special-product-timestamp {
    display: flex;
    align-items: center;
    gap: 4px;
}

.special-product-timestamp i {
    font-size: 10px;
    color: #666;
}

.special-product-timestamp span {
    font-size: 9px;
    font-weight: 500;
    color: #666;
}

.special-price-value {
    font-size: 15px;
    font-weight: 800;
    color: #e53e3e;
    text-shadow: 0 1px 2px rgba(229, 62, 62, 0.1);
}

.special-commission-value {
    font-size: 12px;
    font-weight: 700;
    color: #38a169;
    background: linear-gradient(135deg, rgba(56, 161, 105, 0.1), rgba(72, 187, 120, 0.1));
    padding: 4px 8px;
    border-radius: 6px;
    border: 1px solid rgba(56, 161, 105, 0.2);
    box-shadow: 0 1px 3px rgba(56, 161, 105, 0.1);
}


.btn-special-receive {
    padding: 6px 12px;
    background: linear-gradient(135deg, #f4d03f, #f7dc6f);
    color: #8b4513;
    border: none;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 800;
    cursor: not-allowed;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    box-shadow: 0 3px 8px rgba(244, 208, 63, 0.4), 0 0 0 1px rgba(244, 208, 63, 0.2);
    align-self: flex-end;
    min-width: 80px;
    position: relative;
    overflow: hidden;
    animation: specialButtonPulse 2s ease-in-out infinite;
}

.btn-special-receive::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.5s ease;
}

.btn-special-receive:hover::before {
    left: 100%;
}

.btn-special-receive:hover {
    background: linear-gradient(135deg, #f1c40f, #f4d03f);
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 6px 20px rgba(244, 208, 63, 0.6), 0 0 0 3px rgba(244, 208, 63, 0.4);
    animation: none;
}

.btn-special-receive:active {
    transform: scale(0.95);
}

.btn-special-receive i {
    font-size: 12px;
}

/* Products List */
.products-container {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 20px;
}

.product-card {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 250, 252, 0.9));
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    display: flex;
    align-items: center;
    padding: 12px;
    gap: 12px;
    position: relative;
}

.product-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(244, 208, 63, 0.02), rgba(247, 220, 111, 0.02));
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.product-card:hover::before {
    opacity: 1;
}

.product-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
    border-color: rgba(244, 208, 63, 0.3);
}

.product-thumbnail {
    position: relative;
    width: 100px;
    height: 100px;
    flex-shrink: 0;
    border-radius: 12px;
    overflow: hidden;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.product-card:hover .product-thumbnail {
    transform: scale(1.05);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
}

.product-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-thumbnail img {
    transform: scale(1.05);
}

.thumbnail-placeholder {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    display: none;
    align-items: center;
    justify-content: center;
    color: #a0aec0;
    font-size: 24px;
    border-radius: 12px;
    border: 2px dashed #cbd5e0;
    transition: all 0.3s ease;
}

.product-card:hover .thumbnail-placeholder {
    background: linear-gradient(135deg, #edf2f7, #e2e8f0);
    color: #718096;
}

.thumbnail-placeholder i {
    opacity: 0.6;
    transition: opacity 0.3s ease;
}

.product-card:hover .thumbnail-placeholder i {
    opacity: 0.8;
}

.hot-badge {
    position: absolute;
    top: 6px;
    right: 6px;
    background: linear-gradient(135deg, #ff6b6b, #ee5a24);
    color: white;
    padding: 4px 6px;
    border-radius: 8px;
    font-size: 8px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 2px;
    box-shadow: 0 2px 8px rgba(255, 107, 107, 0.4);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.hot-badge i {
    font-size: 6px;
}

.product-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 8px;
    min-width: 0;
}

.product-details {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
    min-width: 0;
    flex-wrap: nowrap;
}

.product-left {
    display: flex;
    flex-direction: column;
    gap: 6px;
    flex: 1;
    min-width: 0;
    max-width: 60%;
}

.product-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 6px;
    flex-shrink: 0;
    min-width: 120px;
    max-width: 200px;
    flex: 0 0 auto;
}

.product-title {
    font-size: 16px;
    font-weight: 700;
    color: #2d3748;
    line-height: 1.4;
    margin-bottom: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    transition: color 0.3s ease;
    width: 100%;
}

.product-card:hover .product-title {
    color: #1a202c;
}

.product-pricing {
    display: flex;
    align-items: center;
    margin: 0;
}

.commission-section {
    display: flex;
    align-items: center;
    margin: 0;
}

/* Removed .product-actions as it's no longer needed */

.product-timestamp {
    display: flex;
    align-items: center;
    gap: 4px;
}

.product-timestamp i {
    font-size: 10px;
    color: #666;
}

.product-timestamp span {
    font-size: 9px;
    font-weight: 500;
    color: #666;
}

.price-value {
    font-size: 15px;
    font-weight: 800;
    color: #e53e3e;
    text-shadow: 0 1px 2px rgba(229, 62, 62, 0.1);
}

.commission-value {
    font-size: 12px;
    font-weight: 700;
    color: #38a169;
    background: linear-gradient(135deg, rgba(56, 161, 105, 0.1), rgba(72, 187, 120, 0.1));
    padding: 4px 8px;
    border-radius: 6px;
    border: 1px solid rgba(56, 161, 105, 0.2);
    box-shadow: 0 1px 3px rgba(56, 161, 105, 0.1);
}

.btn-receive {
    padding: 4px 8px;
    background: linear-gradient(135deg, #f4d03f, #f7dc6f);
    color: #8b4513;
    border: none;
    border-radius: 6px;
    font-size: 9px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 3px;
    box-shadow: 0 2px 6px rgba(244, 208, 63, 0.3);
    align-self: flex-end;
    min-width: 60px;
    position: relative;
    overflow: hidden;
}

.btn-receive::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.5s ease;
}

.btn-receive:hover::before {
    left: 100%;
}

.btn-receive:hover {
    background: linear-gradient(135deg, #f1c40f, #f4d03f);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(244, 208, 63, 0.4);
}

.btn-receive:active {
    transform: scale(0.95);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    backdrop-filter: blur(10px);
}

.empty-icon {
    font-size: 64px;
    color: #f4d03f;
    margin-bottom: 20px;
}

.empty-state h3 {
    font-size: 24px;
    font-weight: 700;
    color: #333;
    margin-bottom: 12px;
}

.empty-state p {
    font-size: 16px;
    color: #666;
    line-height: 1.5;
}

/* Responsive Design */
@media (max-width: 768px) {
    .special-product-card {
        margin-bottom: 10px;
        padding: 10px;
        gap: 10px;
    }
    
    .special-product-thumbnail {
        width: 85px;
        height: 85px;
    }
    
    .special-thumbnail-placeholder {
        font-size: 20px;
    }
    
    .special-product-info {
        gap: 8px;
    }
    
    .special-product-details {
        gap: 8px;
    }
    
    .special-product-pricing-section {
        gap: 3px;
    }
    
    .special-product-title {
        font-size: 14px;
    }
    
    .special-price-value {
        font-size: 13px;
    }
    
    .special-commission-value {
        font-size: 11px;
    }
    
    
    .btn-special-receive {
        padding: 5px 10px;
        font-size: 10px;
        min-width: 70px;
    }
    
    .special-product-timestamp i {
        font-size: 9px;
    }
    
    .special-product-timestamp span {
        font-size: 8px;
    }
    
    .coming-soon-badge {
        font-size: 7px;
        padding: 3px 6px;
    }
    
    .special-badge {
        font-size: 7px;
        padding: 3px 5px;
    }
    
    .products-container {
        gap: 6px;
    }
    
    
    .product-card {
        padding: 8px;
        gap: 8px;
    }
    
    .product-thumbnail {
        width: 85px;
        height: 85px;
    }
    
    .thumbnail-placeholder {
        font-size: 20px;
    }
    
    .product-info {
        gap: 6px;
    }
    
    .product-details {
        gap: 8px;
        flex-direction: column;
    }
    
    .product-left {
        gap: 4px;
    }
    
    .product-right {
        gap: 4px;
        align-items: flex-start;
        min-width: auto;
        flex-direction: row;
        justify-content: space-between;
        width: 100%;
    }
    
    .product-title {
        font-size: 14px;
        max-width: 100%;
    }
    
    .price-value {
        font-size: 13px;
    }
    
    .commission-value {
        font-size: 11px;
    }
    
    .btn-receive {
        padding: 3px 6px;
        font-size: 8px;
        min-width: 50px;
    }
    
    .product-timestamp i {
        font-size: 9px;
    }
    
    .product-timestamp span {
        font-size: 8px;
    }
}

@media (max-width: 480px) {
    .special-product-card {
        margin-bottom: 8px;
        padding: 8px;
        gap: 8px;
    }
    
    .special-product-thumbnail {
        width: 75px;
        height: 75px;
    }
    
    .special-thumbnail-placeholder {
        font-size: 16px;
    }
    
    .special-product-info {
        gap: 6px;
    }
    
    .special-product-details {
        gap: 6px;
    }
    
    .special-product-pricing-section {
        gap: 2px;
    }
    
    .special-product-title {
        font-size: 13px;
    }
    
    .special-price-value {
        font-size: 12px;
    }
    
    .special-commission-value {
        font-size: 10px;
        padding: 3px 6px;
    }
    
    
    .btn-special-receive {
        padding: 4px 8px;
        font-size: 9px;
        min-width: 60px;
    }
    
    .special-product-timestamp i {
        font-size: 8px;
    }
    
    .special-product-timestamp span {
        font-size: 7px;
    }
    
    .coming-soon-badge {
        font-size: 6px;
        padding: 2px 4px;
    }
    
    .special-badge {
        font-size: 6px;
        padding: 2px 4px;
    }
    
    .products-container {
        gap: 6px;
    }
    
    .product-card {
        padding: 6px;
        gap: 6px;
    }
    
    .product-thumbnail {
        width: 75px;
        height: 75px;
    }
    
    .thumbnail-placeholder {
        font-size: 16px;
    }
    
    .product-info {
        gap: 4px;
    }
    
    .product-details {
        gap: 6px;
        flex-direction: column;
    }
    
    .product-left {
        gap: 3px;
    }
    
    .product-right {
        gap: 3px;
        align-items: flex-start;
        min-width: auto;
        flex-direction: row;
        justify-content: space-between;
        width: 100%;
    }
    
    .product-title {
        font-size: 13px;
        max-width: 100%;
    }
    
    .product-pricing {
        margin: 0;
    }
    
    .commission-section {
        margin: 0;
    }
    
    .btn-receive {
        padding: 2px 4px;
        font-size: 7px;
        min-width: 40px;
    }
    
    .product-timestamp i {
        font-size: 8px;
    }
    
    .product-timestamp span {
        font-size: 7px;
    }
    
    .hot-badge {
        padding: 1px 3px;
        font-size: 7px;
    }
    
    .hot-badge i {
        font-size: 5px;
    }
}
</style>

<script>

// Navigation functions
function goBack() {
    if ('vibrate' in navigator) {
        navigator.vibrate(10);
    }
    if (window.history.length > 1) {
        window.history.back();
    } else {
        window.location.href = '/';
    }
}


// Receive product function
function receiveProduct(productId) {
    if (confirm('{{ __("auth.confirm_receive_order") }}')) {
        // Add loading state
        const button = event.target.closest('.btn-receive');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __("auth.processing") }}...';
        button.disabled = true;
        
        // Simulate API call
        fetch('/receive-order', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_id: productId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('success', '{{ __("auth.success") }}', data.message);
                // Remove the product card
                const productCard = button.closest('.product-card');
                productCard.style.animation = 'fadeOut 0.3s ease-out';
                setTimeout(() => {
                    productCard.remove();
                }, 300);
            } else {
                showToast('error', '{{ __("auth.error") }}', data.message);
                // Restore button
                button.innerHTML = originalText;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', '{{ __("auth.error") }}', '{{ __("auth.network_error") }}');
            // Restore button
            button.innerHTML = originalText;
            button.disabled = false;
        });
    }
}

// Add fade out animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeOut {
        from { opacity: 1; transform: scale(1); }
        to { opacity: 0; transform: scale(0.8); }
    }
`;
document.head.appendChild(style);

</script>
@endsection
