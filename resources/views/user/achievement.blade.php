@php
    use App\Helpers\LanguageHelper;
    use Illuminate\Support\Facades\Auth;
    $__ = [LanguageHelper::class, 'getUserTranslation'];
    $__account = fn($key) => LanguageHelper::getTranslationFromFile('account', $key, 'user');
    $user = Auth::user();
@endphp

@extends('user.layouts.app')

@section('title', ($__account('achievement') ?? 'Thành tích') . ' - ' . ($__('tiktok_shop') ?? 'TikTok Shop'))

@section('content')
<div class="nav-header">
    <button class="nav-button" onclick="goBack()">
        <i class="fas fa-chevron-left"></i>
    </button>
    <div class="nav-title">{{ $__account('achievement') ?? 'Thành tích' }}</div>
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
    
    <!-- User Info -->
    <x-user-info-card />
    <!-- card info achievement -->
    <div class="card-info-achievement">
        <div class="card-info-achievement-item">
            <div class="achievement-stats">
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ number_format($totalDeposited, 0, '.', '.') }} 💰</div>
                        <div class="stat-label">{{ $__account('current_limit') ?? 'Hiện tại' }}</div>
                    </div>
                </div>
                
                <div class="stat-divider"></div>
                
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ number_format($amountNeededForNextTier, 0, '.', '.') }} 💰</div>
                        <div class="stat-label">{{ $__account('upgrade_needed') ?? 'Nâng hạng' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Upgrade Tiers -->
    <div class="upgrade-tiers">
        <!-- Tier 1: PHỔ THÔNG -->
        <div class="tier-card">
            <div class="tier-header">
                <h6 class="tier-name">{{ $__account('tier_common') ?? 'PHỔ THÔNG' }}</h6>
                <span class="tier-amount">{{ $tiers[0]['display_amount'] ?? '5.000.000 💰' }}</span>
            </div>
            <div class="tier-details">
                <div class="tier-detail">
                    <span class="detail-label">{{ $__account('profit_per_order') ?? 'Lợi nhuận mỗi đơn' }}:</span>
                    <span class="detail-value">0,3% - 0,5%</span>
                </div>
                <div class="tier-detail">
                    <span class="detail-label">{{ $__account('quantity') ?? 'Số lượng đơn/ngày' }}:</span>
                    <span class="detail-value">50 {{ $__account('orders') ?? 'đơn' }}</span>
                </div>
                <div class="tier-detail">
                    <span class="detail-label">{{ $__account('daily_withdrawals') ?? 'Số lượt rút tiền/ngày' }}:</span>
                    <span class="detail-value">3 {{ $__account('times') ?? 'lần' }}</span>
                </div>
            </div>
        </div>

        <!-- Tier 2: TIÊU THƯƠNG -->
        <div class="tier-card">
            <div class="tier-header">
                <h6 class="tier-name">{{ $__account('tier_small_merchant') ?? 'TIÊU THƯƠNG' }}</h6>
                <span class="tier-amount">{{ $tiers[1]['display_amount'] ?? '25.000.000 💰' }}</span>
            </div>
            <div class="tier-details">
                <div class="tier-detail">
                    <span class="detail-label">{{ $__account('profit_per_order') ?? 'Lợi nhuận mỗi đơn' }}:</span>
                    <span class="detail-value">0,5% - 0,7%</span>
                </div>
                <div class="tier-detail">
                    <span class="detail-label">{{ $__account('quantity') ?? 'Số lượng đơn/ngày' }}:</span>
                    <span class="detail-value">60 {{ $__account('orders') ?? 'đơn' }}</span>
                </div>
                <div class="tier-detail">
                    <span class="detail-label">{{ $__account('daily_withdrawals') ?? 'Số lượt rút tiền/ngày' }}:</span>
                    <span class="detail-value">5 {{ $__account('times') ?? 'lần' }}</span>
                </div>
            </div>
        </div>

        <!-- Tier 3: THƯƠNG GIA -->
        <div class="tier-card">
            <div class="tier-header">
                <h6 class="tier-name">{{ $__account('tier_merchant') ?? 'THƯƠNG GIA' }}</h6>
                <span class="tier-amount">{{ $tiers[2]['display_amount'] ?? '125.000.000 💰' }}</span>
            </div>
            <div class="tier-details">
                <div class="tier-detail">
                    <span class="detail-label">{{ $__account('profit_per_order') ?? 'Lợi nhuận mỗi đơn' }}:</span>
                    <span class="detail-value">0,7% - 0,9%</span>
                </div>
                <div class="tier-detail">
                    <span class="detail-label">{{ $__account('quantity') ?? 'Số lượng đơn/ngày' }}:</span>
                    <span class="detail-value">70 {{ $__account('orders') ?? 'đơn' }}</span>
                </div>
                <div class="tier-detail">
                    <span class="detail-label">{{ $__account('daily_withdrawals') ?? 'Số lượt rút tiền/ngày' }}:</span>
                    <span class="detail-value">7 {{ $__account('times') ?? 'lần' }}</span>
                </div>
            </div>
        </div>

        <!-- Tier 4: ĐẠI LÝ -->
        <div class="tier-card">
            <div class="tier-header">
                <h6 class="tier-name">{{ $__account('tier_agent') ?? 'ĐẠI LÝ' }}</h6>
                <span class="tier-amount">{{ $tiers[3]['display_amount'] ?? '500.000.000 💰' }}</span>
            </div>
            <div class="tier-details">
                <div class="tier-detail">
                    <span class="detail-label">{{ $__account('profit_per_order') ?? 'Lợi nhuận mỗi đơn' }}:</span>
                    <span class="detail-value">0,9% - 1,2%</span>
                </div>
                <div class="tier-detail">
                    <span class="detail-label">{{ $__account('quantity') ?? 'Số lượng đơn/ngày' }}:</span>
                    <span class="detail-value">80 {{ $__account('orders') ?? 'đơn' }}</span>
                </div>
                <div class="tier-detail">
                    <span class="detail-label">{{ $__account('daily_withdrawals') ?? 'Số lượt rút tiền/ngày' }}:</span>
                    <span class="detail-value">10 {{ $__account('times') ?? 'lần' }}</span>
                </div>
            </div>
        </div>

        <!-- Tier 5: DOANH NGHIỆP -->
        <div class="tier-card">
            <div class="tier-header">
                <h6 class="tier-name">{{ $__account('tier_enterprise') ?? 'DOANH NGHIỆP' }}</h6>
                <span class="tier-amount">{{ $tiers[4]['display_amount'] ?? '1.000.000.000 💰' }}</span>
            </div>
            <div class="tier-details">
                <div class="tier-detail">
                    <span class="detail-label">{{ $__account('profit_per_order') ?? 'Lợi nhuận mỗi đơn' }}:</span>
                    <span class="detail-value">1,2% - 1,5%</span>
                </div>
                <div class="tier-detail">
                    <span class="detail-label">{{ $__account('quantity') ?? 'Số lượng đơn/ngày' }}:</span>
                    <span class="detail-value">100 {{ $__account('orders') ?? 'đơn' }}</span>
                </div>
                <div class="tier-detail">
                    <span class="detail-label">{{ $__account('daily_withdrawals') ?? 'Số lượt rút tiền/ngày' }}:</span>
                    <span class="detail-value">15 {{ $__account('times') ?? 'lần' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Card Info Achievement */
.card-info-achievement {
    background: white;
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.achievement-stats {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex: 1;
}

.stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
}

.stat-content {
    flex: 1;
    position: relative;
}

.stat-value {
    font-size: 0.95rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 12px;
    color: #7f8c8d;
    font-weight: 300;
    margin-top: 0.25rem;
    text-align: left;
}

.stat-divider {
    width: 1px;
    height: 40px;
    background: #e9ecef;
    margin: 0 0.5rem;
}

.achievement-stat {
    padding: 1rem 0;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: bold;
    color: #007bff;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    color: #6c757d;
}

.achievement-category {
    border-bottom: 1px solid #e9ecef;
    padding-bottom: 1rem;
}

.achievement-category:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.category-header {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    font-weight: 600;
    color: #495057;
}

.category-header i {
    margin-right: 0.5rem;
    font-size: 1.1rem;
}

.achievement-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    margin-bottom: 0.75rem;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.achievement-item.unlocked {
    background: #d4edda;
    border-color: #c3e6cb;
}

.achievement-item.locked {
    opacity: 0.6;
}

.achievement-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.2rem;
    color: #6c757d;
}

.achievement-item.unlocked .achievement-icon {
    background: #28a745;
    color: white;
}

.achievement-content {
    flex: 1;
}

.achievement-name {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.25rem;
}

.achievement-desc {
    font-size: 0.875rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.achievement-progress {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.progress-bar {
    flex: 1;
    height: 6px;
    background: #e9ecef;
    border-radius: 3px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: #007bff;
    transition: width 0.3s ease;
}

.achievement-item.unlocked .progress-fill {
    background: #28a745;
}

.progress-text {
    font-size: 0.75rem;
    color: #6c757d;
    font-weight: 500;
}

.achievement-status {
    margin-left: 1rem;
}

.achievement-item.unlocked .achievement-status i {
    color: #28a745;
}

/* Current Store Header */
.current-store-header {
    padding: 1rem 0;
}

.store-title {
    font-size: 1rem;
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.75rem;
}

.store-info p {
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
    color: #6c757d;
}

.null-value {
    color: #dc3545;
    font-weight: 500;
}

.store-reference {
    font-size: 0.8rem !important;
    color: #6c757d !important;
}

/* Upgrade Tiers */
.upgrade-tiers {
    margin-top: 1rem;
}

.tier-card {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    margin-bottom: 0.5rem;
    background: white;
    overflow: hidden;
}

.tier-header {
    padding: 0.5rem 1rem;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    align-items: center;
    justify-content: space-between;
    min-height: 2.5rem;
}

.tier-name {
    font-size: 0.9rem;
    font-weight: 600;
    color: #495057;
    margin: 0;
}

.tier-amount {
    font-size: 0.85rem;
    font-weight: 600;
    color: #28a745;
    text-align: right;
    white-space: nowrap;
}

.tier-details {
    padding: 0.5rem 1rem;
}

.tier-detail {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.25rem;
    font-size: 0.8rem;
    min-height: 1.2rem;
}

.tier-detail:last-child {
    margin-bottom: 0;
}

.detail-label {
    color: #6c757d;
    font-weight: 500;
    font-size: 0.75rem;
}

.detail-value {
    color: #28a745;
    font-weight: 600;
    font-size: 0.8rem;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .achievement-stats {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .stat-divider {
        width: 100%;
        height: 1px;
        margin: 0.5rem 0;
    }
    
    .stat-item {
        justify-content: center;
        text-align: center;
    }
    
    .stat-value {
        font-size: 0.9rem;
    }
    
    .stat-label {
        font-size: 11px;
    }
    
    .tier-header {
        padding: 0.4rem 0.75rem;
        min-height: 2rem;
    }
    
    .tier-details {
        padding: 0.4rem 0.75rem;
    }
    
    .tier-name {
        font-size: 0.8rem;
    }
    
    .tier-amount {
        font-size: 0.75rem;
    }
    
    .tier-detail {
        margin-bottom: 0.2rem;
        min-height: 1rem;
    }
    
    .detail-label {
        font-size: 0.7rem;
    }
    
    .detail-value {
        font-size: 0.7rem;
    }
}
</style>

@endsection
