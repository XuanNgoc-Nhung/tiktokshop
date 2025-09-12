@php
    use App\Helpers\LanguageHelper;
    $__account = fn($key) => LanguageHelper::getTranslationFromFile('account', $key, 'user');
@endphp

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

<style>
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
