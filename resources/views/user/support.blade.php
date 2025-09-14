@php
    use App\Helpers\LanguageHelper;
    use Illuminate\Support\Facades\Auth;
    $__ = [LanguageHelper::class, 'getUserTranslation'];
    $__account = fn($key) => LanguageHelper::getTranslationFromFile('account', $key, 'user');
    $user = Auth::user();
    $profile = optional($user)->profile;
    
    // Lấy cấu hình hỗ trợ từ database
    $supportConfig = $cauHinh ?? new \App\Models\CauHinh();
@endphp

@extends('user.layouts.app')

@section('title', ($__account('support') ?? 'Hỗ trợ') . ' - ' . ($__('tiktok_shop') ?? 'TikTok Shop'))

@section('content')
<div class="nav-header">
    <button class="nav-button" onclick="goBack()">
        <i class="fas fa-chevron-left"></i>
    </button>
    <div class="nav-title">{{ $__account('support') ?? 'Hỗ trợ' }}</div>
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
    <style>
        .form-control { border-radius: 10px; }
        .save-btn {
            background: #111827;
            color: #ffffff;
            border-radius: 12px;
            padding: 10px 16px;
            border: none;
        }
    </style>
</div>

<div class="container">
     <!-- User Info -->
     <x-user-info-card />
     
     <!-- Support Channels -->
     <div class="account-card p-3">
         <h5 class="mb-3">{{ $__account('support_channels') ?? 'Kênh hỗ trợ' }}</h5>
         
         <!-- Facebook Support -->
         <div class="support-item" onclick="openSupport('facebook')" data-channel="facebook">
             <div class="support-icon facebook-icon">
                 <i class="fab fa-facebook-f"></i>
             </div>
             <div class="support-content">
                 <h6 class="support-title">{{ $__account('facebook_support') ?? 'Facebook' }}</h6>
                 <p class="support-desc">{{ $__account('facebook_desc') ?? 'Liên hệ qua Facebook Messenger' }}</p>
                 <div class="support-status">
                     <span class="status-dot online"></span>
                     <span class="status-text">{{ $__account('available_24_7') ?? 'Có sẵn 24/7' }}</span>
                 </div>
             </div>
             <div class="support-arrow">
                 <i class="fas fa-external-link-alt"></i>
             </div>
         </div>

         <!-- Zalo Support -->
         <div class="support-item" onclick="openSupport('zalo')" data-channel="zalo">
             <div class="support-icon zalo-icon">
                 <i class="fas fa-comments"></i>
             </div>
             <div class="support-content">
                 <h6 class="support-title">{{ $__account('zalo_support') ?? 'Zalo' }}</h6>
                 <p class="support-desc">{{ $__account('zalo_desc') ?? 'Chat trực tiếp qua Zalo' }}</p>
                 <div class="support-status">
                     <span class="status-dot online"></span>
                     <span class="status-text">{{ $__account('available_24_7') ?? 'Có sẵn 24/7' }}</span>
                 </div>
             </div>
             <div class="support-arrow">
                 <i class="fas fa-external-link-alt"></i>
             </div>
         </div>

         <!-- Telegram Support -->
         <div class="support-item" onclick="openSupport('telegram')" data-channel="telegram">
             <div class="support-icon telegram-icon">
                 <i class="fab fa-telegram-plane"></i>
             </div>
             <div class="support-content">
                 <h6 class="support-title">{{ $__account('telegram_support') ?? 'Telegram' }}</h6>
                 <p class="support-desc">{{ $__account('telegram_desc') ?? 'Tham gia nhóm Telegram' }}</p>
                 <div class="support-status">
                     <span class="status-dot online"></span>
                     <span class="status-text">{{ $__account('available_24_7') ?? 'Có sẵn 24/7' }}</span>
                 </div>
             </div>
             <div class="support-arrow">
                 <i class="fas fa-external-link-alt"></i>
             </div>
         </div>

         <!-- WhatsApp Support -->
         <div class="support-item" onclick="openSupport('whatsapp')" data-channel="whatsapp">
             <div class="support-icon whatsapp-icon">
                 <i class="fab fa-whatsapp"></i>
             </div>
             <div class="support-content">
                 <h6 class="support-title">{{ $__account('whatsapp_support') ?? 'WhatsApp' }}</h6>
                 <p class="support-desc">{{ $__account('whatsapp_desc') ?? 'Liên hệ qua WhatsApp' }}</p>
                 <div class="support-status">
                     <span class="status-dot online"></span>
                     <span class="status-text">{{ $__account('available_24_7') ?? 'Có sẵn 24/7' }}</span>
                 </div>
             </div>
             <div class="support-arrow">
                 <i class="fas fa-external-link-alt"></i>
             </div>
         </div>

         <!-- Hotline Support -->
         <div class="support-item" onclick="openSupport('hotline')" data-channel="hotline">
             <div class="support-icon hotline-icon">
                 <i class="fas fa-phone"></i>
             </div>
             <div class="support-content">
                 <h6 class="support-title">{{ $__account('hotline_support') ?? 'Hotline' }}</h6>
                 <p class="support-desc">{{ $__account('hotline_desc') ?? 'Gọi điện trực tiếp' }}</p>
                 <div class="support-status">
                     <span class="status-dot online"></span>
                     <span class="status-text">{{ $__account('available_24_7') ?? 'Có sẵn 24/7' }}</span>
                 </div>
             </div>
             <div class="support-arrow">
                 <i class="fas fa-phone"></i>
             </div>
         </div>

         <!-- Email Support -->
         <div class="support-item" onclick="openSupport('email')" data-channel="email">
             <div class="support-icon email-icon">
                 <i class="fas fa-envelope"></i>
             </div>
             <div class="support-content">
                 <h6 class="support-title">{{ $__account('email_support') ?? 'Email' }}</h6>
                 <p class="support-desc">{{ $__account('email_desc') ?? 'Gửi email hỗ trợ' }}</p>
                 <div class="support-status">
                     <span class="status-dot online"></span>
                     <span class="status-text">{{ $__account('response_time') ?? 'Phản hồi trong 24h' }}</span>
                 </div>
             </div>
             <div class="support-arrow">
                 <i class="fas fa-envelope"></i>
             </div>
         </div>
     </div>
</div>

<style>
/* Support Items Styles */
.support-item {
    display: flex;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #f1f5f9;
    cursor: pointer;
    transition: all 0.3s ease;
}

.support-item:last-child {
    border-bottom: none;
}

.support-item:hover {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 12px 8px;
    margin: 0 -8px;
}

.support-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    font-size: 16px;
    color: white;
}

.facebook-icon { background: linear-gradient(135deg, #1877f2, #42a5f5); }
.zalo-icon { background: linear-gradient(135deg, #0068ff, #00a8ff); }
.telegram-icon { background: linear-gradient(135deg, #0088cc, #00bcd4); }
.whatsapp-icon { background: linear-gradient(135deg, #25d366, #4caf50); }
.hotline-icon { background: linear-gradient(135deg, #ff5722, #ff9800); }
.email-icon { background: linear-gradient(135deg, #9c27b0, #e91e63); }

.support-content {
    flex: 1;
}

.support-title {
    font-size: 16px;
    font-weight: 600;
    color: #111827;
    margin: 0 0 2px 0;
}

.support-desc {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
}

.support-arrow {
    color: #9ca3af;
    font-size: 14px;
    transition: all 0.3s ease;
}

.support-item:hover .support-arrow {
    color: #3b82f6;
    transform: translateX(2px);
}

.support-status {
    display: flex;
    align-items: center;
    margin-top: 4px;
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-right: 6px;
    display: inline-block;
}

.status-dot.online {
    background-color: #10b981;
    box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
}

.status-dot.offline {
    background-color: #6b7280;
}

.status-dot.busy {
    background-color: #f59e0b;
}

.status-text {
    font-size: 12px;
    color: #6b7280;
    font-weight: 500;
}

.support-item[data-channel] {
    position: relative;
    overflow: hidden;
}

.support-item[data-channel]::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    transition: left 0.5s;
}

.support-item[data-channel]:hover::before {
    left: 100%;
}
</style>

<script>
// Support channel data from database configuration
const supportChannels = {
    facebook: {
        url: @json($supportConfig->link_facebook ?? 'https://m.me/tiktokshop.support'),
        name: '{{ $__account("facebook_support") ?? "Facebook" }}'
    },
    zalo: {
        url: @json($supportConfig->link_zalo ?? 'https://zalo.me/0123456789'),
        name: '{{ $__account("zalo_support") ?? "Zalo" }}'
    },
    telegram: {
        url: @json($supportConfig->link_telegram ?? 'https://t.me/tiktokshop_support'),
        name: '{{ $__account("telegram_support") ?? "Telegram" }}'
    },
    whatsapp: {
        url: @json($supportConfig->link_whatsapp ?? 'https://wa.me/84123456789'),
        name: '{{ $__account("whatsapp_support") ?? "WhatsApp" }}'
    },
    hotline: {
        url: @json($supportConfig->hotline ? 'tel:' . $supportConfig->hotline : 'tel:1900123456'),
        name: '{{ $__account("hotline_support") ?? "Hotline" }}'
    },
    email: {
        url: @json($supportConfig->email ? 'mailto:' . $supportConfig->email : 'mailto:support@tiktokshop.com'),
        name: '{{ $__account("email_support") ?? "Email" }}'
    }
};

function openSupport(channel) {
    const channelData = supportChannels[channel];
    const supportItem = document.querySelector(`[data-channel="${channel}"]`);
    
    if (channelData && channelData.url) {
        // Add loading effect
        if (supportItem) {
            supportItem.style.opacity = '0.7';
            supportItem.style.transform = 'scale(0.98)';
        }
        
        // Show loading message
        if (typeof window.showToast === 'function') {
            window.showToast('info', '{{ $__account("opening") ?? "Đang mở" }}', `${channelData.name}...`);
        }
        
        // Open the support channel
        setTimeout(() => {
            if (channel === 'email' || channel === 'hotline') {
                window.location.href = channelData.url;
            } else {
                const newWindow = window.open(channelData.url, '_blank', 'noopener,noreferrer');
                
                // Check if popup was blocked
                if (!newWindow || newWindow.closed || typeof newWindow.closed == 'undefined') {
                    // Popup was blocked, show alternative message
                    if (typeof window.showToast === 'function') {
                        window.showToast('warning', '{{ $__account("popup_blocked") ?? "Popup bị chặn" }}', '{{ $__account("popup_blocked_desc") ?? "Vui lòng cho phép popup và thử lại" }}');
                    }
                } else {
                    // Success
                    if (typeof window.showToast === 'function') {
                        window.showToast('success', '{{ $__account("open_support_channel") ?? "Mở kênh hỗ trợ" }}', `${channelData.name} {{ $__account("opened_successfully") ?? "đã được mở" }}`);
                    }
                }
            }
            
            // Reset item state
            if (supportItem) {
                supportItem.style.opacity = '1';
                supportItem.style.transform = 'scale(1)';
            }
        }, 300);
        
    } else {
        // Show error message if no URL configured
        if (typeof window.showToast === 'function') {
            window.showToast('error', '{{ $__account("error_title") ?? "Lỗi" }}', '{{ $__account("support_not_configured") ?? "Kênh hỗ trợ chưa được cấu hình" }}');
        }
    }
}

// Add click animation effect
document.addEventListener('DOMContentLoaded', function() {
    const supportItems = document.querySelectorAll('.support-item[data-channel]');
    
    supportItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // Add ripple effect
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(59, 130, 246, 0.3);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            `;
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
});

// Add ripple animation CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>

@endsection


