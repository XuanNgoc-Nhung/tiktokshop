@php
    use App\Helpers\LanguageHelper;
    use Illuminate\Support\Facades\Auth;
    $__ = [LanguageHelper::class, 'getUserTranslation'];
    $__account = fn($key) => LanguageHelper::getTranslationFromFile('account', $key, 'user');
    $__deposit = fn($key) => LanguageHelper::getTranslationFromFile('deposit', $key, 'user');
    $user = Auth::user();
    $profile = optional($user)->profile;
@endphp
@extends('user.layouts.app')

@section('title', $__deposit('title') . ' - ' . $__('tiktok_shop'))

@section('content')
<!-- Navigation Header -->
<div class="nav-header">
    <button class="nav-button" onclick="goBack()">
        <i class="fas fa-chevron-left"></i>
    </button>
    <div class="nav-title">{{ $__deposit('title') }}</div>
    <x-user.language-switcher />
</div>

<div class="container">
    <!-- User Info Card -->
        <x-user-info-card />


    <!-- Payment Methods -->
    <div style="margin-bottom: 24px;">
        <h3 style="font-size: 18px; font-weight: 600; color: #111827; margin-bottom: 16px;">{{ $__deposit('payment_methods') }}</h3>
        
        <!-- E-Wallet Method -->
        <div class="payment-method-card" id="ewallet-method" onclick="selectMethod('ewallet')">
            <div class="method-header">
                <div class="method-icon ewallet">
                    <i class="fab fa-bitcoin"></i>
                </div>
                <div class="method-info">
                    <div class="method-title">{{ $__deposit('e_wallet') }}</div>
                    <div class="method-desc">{{ $__deposit('e_wallet_desc') }}</div>
                </div>
                <div class="method-radio">
                    <input type="radio" name="payment_method" value="ewallet" id="ewallet-radio">
                    <label for="ewallet-radio"></label>
                </div>
            </div>
            <div class="method-details" id="ewallet-details">
                <div class="crypto-wallets">
                    <!-- Bitcoin -->
                    <div class="crypto-wallet-item">
                        <div class="crypto-header">
                            <div class="crypto-icon">
                                <i class="fab fa-bitcoin"></i>
                            </div>
                            <div class="crypto-info">
                                <div class="crypto-name">{{ $__deposit('bitcoin') }}</div>
                                <div class="crypto-desc">{{ $__deposit('bitcoin_desc') }}</div>
                            </div>
                        </div>
                        <div class="crypto-address">
                            <div class="address-label">{{ $__deposit('bitcoin_address') }}</div>
                            <div class="address-value">bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh</div>
                            <button class="copy-btn" onclick="copyToClipboard('bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh')">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Ethereum -->
                    <div class="crypto-wallet-item">
                        <div class="crypto-header">
                            <div class="crypto-icon">
                                <i class="fab fa-ethereum"></i>
                            </div>
                            <div class="crypto-info">
                                <div class="crypto-name">{{ $__deposit('ethereum') }}</div>
                                <div class="crypto-desc">{{ $__deposit('ethereum_desc') }}</div>
                            </div>
                        </div>
                        <div class="crypto-address">
                            <div class="address-label">{{ $__deposit('ethereum_address') }}</div>
                            <div class="address-value">0x742d35Cc6634C0532925a3b8D4C9db96C4b4d8b6</div>
                            <button class="copy-btn" onclick="copyToClipboard('0x742d35Cc6634C0532925a3b8D4C9db96C4b4d8b6')">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tether USDT -->
                    <div class="crypto-wallet-item">
                        <div class="crypto-header">
                            <div class="crypto-icon">
                                <i class="fas fa-coins"></i>
                            </div>
                            <div class="crypto-info">
                                <div class="crypto-name">{{ $__deposit('tether') }}</div>
                                <div class="crypto-desc">{{ $__deposit('tether_desc') }}</div>
                            </div>
                        </div>
                        <div class="crypto-address">
                            <div class="address-label">{{ $__deposit('usdt_address') }}</div>
                            <div class="address-value">TQn9Y2khEsLJW1ChVWFMSMeRDow5KcbLSE</div>
                            <button class="copy-btn" onclick="copyToClipboard('TQn9Y2khEsLJW1ChVWFMSMeRDow5KcbLSE')">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="crypto-note">
                    <i class="fas fa-info-circle"></i>
                    <span>{{ $__deposit('crypto_warning') }}</span>
                </div>
            </div>
        </div>

        <!-- Chat Support Method -->
        <div class="payment-method-card" id="chat-method" onclick="selectMethod('chat')">
            <div class="method-header">
                <div class="method-icon chat">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="method-info">
                    <div class="method-title">{{ $__deposit('chat_support') }}</div>
                    <div class="method-desc">{{ $__deposit('chat_support_desc') }}</div>
                </div>
                <div class="method-radio">
                    <input type="radio" name="payment_method" value="chat" id="chat-radio">
                    <label for="chat-radio"></label>
                </div>
            </div>
            <div class="method-details" id="chat-details">
                <div class="chat-info">
                    <div class="chat-item">
                        <div class="chat-icon">
                            <i class="fab fa-telegram"></i>
                        </div>
                        <div class="chat-content">
                            <div class="chat-title">{{ $__deposit('telegram') }}</div>
                            <div class="chat-desc">{{ $__deposit('telegram_desc') }}</div>
                        </div>
                        <a href="https://t.me/tiktokshop_support" target="_blank" class="chat-link">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                    <div class="chat-item">
                        <div class="chat-icon">
                            <i class="fab fa-facebook-messenger"></i>
                        </div>
                        <div class="chat-content">
                            <div class="chat-title">{{ $__deposit('facebook_messenger') }}</div>
                            <div class="chat-desc">{{ $__deposit('facebook_messenger_desc') }}</div>
                        </div>
                        <a href="https://m.me/tiktokshop.support" target="_blank" class="chat-link">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                    <div class="chat-item">
                        <div class="chat-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div class="chat-content">
                            <div class="chat-title">{{ $__deposit('whatsapp') }}</div>
                            <div class="chat-desc">{{ $__deposit('whatsapp_desc') }}</div>
                        </div>
                        <a href="https://wa.me/84901234567" target="_blank" class="chat-link">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="chat-note">
                    <i class="fas fa-info-circle"></i>
                    <span>{{ $__deposit('chat_note') }}</span>
                </div>
            </div>
        </div>
    </div>


    <!-- Instructions -->
    <div class="instructions-card">
        <h4 style="font-size: 16px; font-weight: 600; color: #111827; margin-bottom: 12px;">
            <i class="fas fa-lightbulb"></i>
            {{ $__deposit('instructions_title') }}
        </h4>
        <div class="instruction-list">
            <div class="instruction-item">
                <div class="instruction-number">1</div>
                <div class="instruction-text">{{ $__deposit('step_1') }}</div>
            </div>
            <div class="instruction-item">
                <div class="instruction-number">2</div>
                <div class="instruction-text">{{ $__deposit('step_2') }}</div>
            </div>
            <div class="instruction-item">
                <div class="instruction-number">3</div>
                <div class="instruction-text">{{ $__deposit('step_3') }}</div>
            </div>
            <div class="instruction-item">
                <div class="instruction-number">4</div>
                <div class="instruction-text">{{ $__deposit('step_4') }}</div>
            </div>
        </div>
    </div>
</div>

<style>
/* Payment Method Styles */
.payment-method-card {
    background: #ffffff;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    margin-bottom: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    overflow: hidden;
}

.payment-method-card:hover {
    border-color: #f4d03f;
    box-shadow: 0 4px 12px rgba(244, 208, 63, 0.1);
}

.payment-method-card.selected {
    border-color: #f4d03f;
    background: linear-gradient(135deg, #fef3c7, #fde68a);
}

.method-header {
    display: flex;
    align-items: center;
    padding: 16px;
    gap: 12px;
}

.method-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
}

.method-icon.ewallet {
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
}

.method-icon.chat {
    background: linear-gradient(135deg, #06b6d4, #0891b2);
}

.method-info {
    flex: 1;
}

.method-title {
    font-size: 16px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 4px;
}

.method-desc {
    font-size: 14px;
    color: #6b7280;
}

.method-radio {
    position: relative;
}

.method-radio input[type="radio"] {
    display: none;
}

.method-radio label {
    width: 20px;
    height: 20px;
    border: 2px solid #d1d5db;
    border-radius: 50%;
    cursor: pointer;
    position: relative;
    transition: all 0.3s ease;
}

.method-radio input[type="radio"]:checked + label {
    border-color: #f4d03f;
    background: #f4d03f;
}

.method-radio input[type="radio"]:checked + label::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 8px;
    height: 8px;
    background: white;
    border-radius: 50%;
}

.method-details {
    padding: 0 16px 16px 16px;
    display: none;
}

.payment-method-card.selected .method-details {
    display: block;
}

/* Crypto Wallet Styles */
.crypto-wallets {
    background: #f8fafc;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 12px;
}

.crypto-wallet-item {
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 1px solid #e2e8f0;
}

.crypto-wallet-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.crypto-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
}

.crypto-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: white;
}

.crypto-wallet-item:nth-child(1) .crypto-icon {
    background: linear-gradient(135deg, #f7931a, #ff6b35);
}

.crypto-wallet-item:nth-child(2) .crypto-icon {
    background: linear-gradient(135deg, #627eea, #4f46e5);
}

.crypto-wallet-item:nth-child(3) .crypto-icon {
    background: linear-gradient(135deg, #26a17b, #1e7e34);
}

.crypto-info {
    flex: 1;
}

.crypto-name {
    font-size: 16px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 2px;
}

.crypto-desc {
    font-size: 13px;
    color: #6b7280;
}

.crypto-address {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 12px;
    position: relative;
}

.address-label {
    font-size: 12px;
    color: #6b7280;
    font-weight: 500;
    margin-bottom: 6px;
}

.address-value {
    font-size: 13px;
    color: #111827;
    font-weight: 600;
    font-family: 'Courier New', monospace;
    word-break: break-all;
    line-height: 1.4;
    margin-bottom: 8px;
}

.copy-btn {
    background: #f4d03f;
    border: none;
    border-radius: 6px;
    padding: 6px 8px;
    color: #8b4513;
    cursor: pointer;
    font-size: 12px;
    transition: all 0.2s ease;
    position: absolute;
    top: 8px;
    right: 8px;
}

.copy-btn:hover {
    background: #f1c40f;
    transform: scale(1.05);
}

.crypto-note {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    padding: 12px;
    background: #fef3c7;
    border-radius: 8px;
    font-size: 13px;
    color: #92400e;
    border: 1px solid #f59e0b;
}

.crypto-note i {
    margin-top: 2px;
    flex-shrink: 0;
}

/* Chat Support Styles */
.chat-info {
    background: #f8fafc;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 12px;
}

.chat-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #e2e8f0;
}

.chat-item:last-child {
    border-bottom: none;
}

.chat-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: white;
}

.chat-item:nth-child(1) .chat-icon {
    background: linear-gradient(135deg, #0088cc, #0066aa);
}

.chat-item:nth-child(2) .chat-icon {
    background: linear-gradient(135deg, #0066ff, #0044cc);
}

.chat-item:nth-child(3) .chat-icon {
    background: linear-gradient(135deg, #25d366, #128c7e);
}

.chat-content {
    flex: 1;
}

.chat-title {
    font-size: 14px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 2px;
}

.chat-desc {
    font-size: 12px;
    color: #6b7280;
}

.chat-link {
    color: #f4d03f;
    font-size: 16px;
    text-decoration: none;
    transition: all 0.2s ease;
}

.chat-link:hover {
    color: #f1c40f;
    transform: scale(1.1);
}

.chat-note {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    padding: 12px;
    background: #dbeafe;
    border-radius: 8px;
    font-size: 13px;
    color: #1e40af;
}

.chat-note i {
    margin-top: 2px;
    flex-shrink: 0;
}


/* Instructions Styles */
.instructions-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 24px;
}

.instruction-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.instruction-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.instruction-number {
    width: 24px;
    height: 24px;
    background: #f4d03f;
    color: #8b4513;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 600;
    flex-shrink: 0;
}

.instruction-text {
    font-size: 14px;
    color: #374151;
    line-height: 1.5;
}

/* Responsive */
@media (max-width: 375px) {
    .quick-amount-buttons {
        gap: 6px;
    }
    
    .quick-amount-btn {
        padding: 6px 12px;
        font-size: 13px;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .form-actions .btn-secondary,
    .form-actions .btn-primary {
        flex: 1;
    }
}
</style>

<script>
let selectedMethod = null;

function selectMethod(method) {
    // Remove previous selection
    document.querySelectorAll('.payment-method-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    // Add selection to clicked method
    document.getElementById(method + '-method').classList.add('selected');
    
    // Update radio button
    document.getElementById(method + '-radio').checked = true;
    
    selectedMethod = method;
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        showToast('success', '{{ $__deposit("copied_success") }}', '{{ $__deposit("copied_message") }}');
    }).catch(function(err) {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        showToast('success', '{{ $__deposit("copied_success") }}', '{{ $__deposit("copied_message") }}');
    });
}

function goBack() {
    if (window.history.length > 1) {
        window.history.back();
    } else {
        window.location.href = '{{ route("dashboard") }}';
    }
}

</script>
@endsection
