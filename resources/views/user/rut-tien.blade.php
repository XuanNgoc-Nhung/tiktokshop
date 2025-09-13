@php
    use App\Helpers\LanguageHelper;
    use Illuminate\Support\Facades\Auth;
    $__ = [LanguageHelper::class, 'getUserTranslation'];
    $__withdraw = fn($key) => LanguageHelper::getTranslationFromFile('withdraw', $key, 'user');
    $user = Auth::user();
    $profile = optional($user)->profile;
    $maxWithdrawAmount = ($profile->so_du ?? 0) + ($profile->hoa_hong ?? 0);
@endphp
@extends('user.layouts.app')

@section('title', $__withdraw('title') . ' - ' . $__('tiktok_shop'))

@section('content')
<!-- Navigation Header -->
<div class="nav-header">
    <button class="nav-button" onclick="goBack()">
        <i class="fas fa-chevron-left"></i>
    </button>
    <div class="nav-title">{{ $__withdraw('title') }}</div>
    <x-user.language-switcher />
</div>

<div class="container">
    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- User Info Card -->
    <x-user-info-card />
    <!-- Withdrawal Form -->
    <form id="withdrawalForm">
        @csrf
        
        <!-- Bank Information Section -->
        <div class="mb-3">
            @if($profile->ngan_hang && $profile->so_tai_khoan && $profile->chu_tai_khoan)
                <!-- Display existing bank info -->
                <div class="bank-info-compact">
                    <div class="bank-info-main">
                        <div class="bank-icon">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="bank-details">
                            <div class="bank-name">{{ $profile->ngan_hang }}</div>
                            <div class="bank-account">{{ $profile->so_tai_khoan }}</div>
                            <div class="bank-holder">{{ $profile->chu_tai_khoan }}</div>
                        </div>
                        <div class="bank-edit">
                            <a href="{{ route('account.bank') }}" class="edit-btn" title="{{ $__withdraw('edit_bank_info') }}">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Hidden inputs for form submission -->
                <input type="hidden" name="bank_name" value="{{ $profile->ngan_hang }}">
                <input type="hidden" name="account_holder" value="{{ $profile->chu_tai_khoan }}">
                <input type="hidden" name="account_number" value="{{ $profile->so_tai_khoan }}">
                <input type="hidden" name="branch" value="{{ $profile->chi_nhanh ?? '' }}">
            @else
                <!-- Show form if no bank info -->
                <div class="no-bank-info">
                    <div class="no-bank-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="no-bank-text">
                        <h4>{{ $__withdraw('no_bank_info_title') }}</h4>
                        <p>{{ $__withdraw('no_bank_info_message') }}</p>
                        <a href="{{ route('account.bank') }}" class="btn-primary">
                            <i class="fas fa-plus"></i>
                            {{ $__withdraw('update_bank_info') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Withdrawal Amount Section -->
        <div class="form-section">
            <!-- Quick Amount Buttons -->
            <div class="quick-amount-section">
                <div class="quick-amount-label">{{ $__withdraw('quick_amounts') }}</div>
                <div class="quick-amount-buttons">
                    <button type="button" class="quick-amount-btn" data-amount="10">$10</button>
                    <button type="button" class="quick-amount-btn" data-amount="50">$50</button>
                    <button type="button" class="quick-amount-btn" data-amount="100">$100</button>
                    <button type="button" class="quick-amount-btn" data-amount="200">$200</button>
                    <button type="button" class="quick-amount-btn" data-amount="500">$500</button>
                    <button type="button" class="quick-amount-btn" data-amount="1000">$1000</button>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">{{ $__withdraw('withdrawal_amount') }} <span class="required">*</span></label>
                <div class="amount-input-group">
                    <span class="currency-symbol">$</span>
                    <input type="number" 
                           name="amount" 
                           id="amountInput"
                           class="form-input amount-input" 
                           placeholder="{{ $__withdraw('amount_placeholder') }}"
                           value="{{ old('amount') }}"
                           min="10"
                           max="{{ $maxWithdrawAmount }}"
                           step="0.01"
                           required>
                </div>
                <div class="amount-info">
                    <div class="amount-limit">
                        <span>{{ $__withdraw('min_amount') }}: $10</span>
                        <span>{{ $__withdraw('max_amount') }}: ${{ number_format($maxWithdrawAmount, 0) }}</span>
                    </div>
                </div>
                @error('amount')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Withdrawal Password -->
            <div class="form-group">
                <label class="form-label">{{ $__withdraw('withdrawal_password') }} <span class="required">*</span></label>
                @if($user->mat_khau_chuyen_tien)
                    <!-- Password field enabled -->
                    <div class="password-field">
                        <input type="text" 
                               name="withdrawal_password" 
                               id="withdrawalPassword"
                               class="form-input" 
                               placeholder="{{ $__withdraw('password_placeholder') }}"
                               required>
                    </div>
                @else
                    <!-- Password not set - show disabled field with setup message -->
                    <div class="password-field disabled">
                        <input type="text" 
                               class="form-input disabled" 
                               placeholder="{{ $__withdraw('password_not_set') }}"
                               disabled>
                        <div class="password-setup-message">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>{{ $__withdraw('password_setup_required') }}</span>
                        </div>
                        <a href="{{ route('account.password') }}" class="btn-setup-password">
                            <i class="fas fa-key"></i>
                            {{ $__withdraw('go_to_password') }}
                        </a>
                    </div>
                @endif
                @error('withdrawal_password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <button type="button" class="btn-secondary" onclick="goBack()">
                {{ $__withdraw('cancel') }}
            </button>
            @if($profile->ngan_hang && $profile->so_tai_khoan && $profile->chu_tai_khoan && $user->mat_khau_chuyen_tien)
                <button type="submit" class="btn-primary" id="submitBtn" disabled>
                    <i class="fas fa-paper-plane"></i>
                    {{ $__withdraw('submit_withdrawal') }}
                </button>
            @elseif(!$user->mat_khau_chuyen_tien)
                <button type="button" class="btn-primary" disabled>
                    <i class="fas fa-key"></i>
                    {{ $__withdraw('password_setup_required') }}
                </button>
            @else
                <button type="button" class="btn-primary" disabled>
                    <i class="fas fa-lock"></i>
                    {{ $__withdraw('bank_info_required') }}
                </button>
            @endif
        </div>
    </form>

    <!-- Instructions -->
    <div class="instructions-card">
        <h4 class="instructions-title">
            <i class="fas fa-lightbulb"></i>
            {{ $__withdraw('instructions_title') }}
        </h4>
        <div class="instruction-list">
            <div class="instruction-item">
                <div class="instruction-number">1</div>
                <div class="instruction-text">{{ $__withdraw('step_1') }}</div>
            </div>
            <div class="instruction-item">
                <div class="instruction-number">2</div>
                <div class="instruction-text">{{ $__withdraw('step_2') }}</div>
            </div>
            <div class="instruction-item">
                <div class="instruction-number">3</div>
                <div class="instruction-text">{{ $__withdraw('step_3') }}</div>
            </div>
            <div class="instruction-item">
                <div class="instruction-number">4</div>
                <div class="instruction-text">{{ $__withdraw('step_4') }}</div>
            </div>
        </div>
    </div>

    <!-- Important Notes -->
    <div class="notes-card">
        <h4 class="notes-title">
            <i class="fas fa-exclamation-triangle"></i>
            {{ $__withdraw('note_title') }}
        </h4>
        <div class="notes-list">
            <div class="note-item">
                <i class="fas fa-check-circle"></i>
                <span>{{ $__withdraw('note_1') }}</span>
            </div>
            <div class="note-item">
                <i class="fas fa-info-circle"></i>
                <span>{{ $__withdraw('note_2') }}</span>
            </div>
            <div class="note-item">
                <i class="fas fa-clock"></i>
                <span>{{ $__withdraw('note_3') }}</span>
            </div>
            <div class="note-item">
                <i class="fas fa-headset"></i>
                <span>{{ $__withdraw('note_4') }}</span>
            </div>
        </div>
    </div>
</div>

<style>
/* Alert Styles */
.alert {
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
    font-weight: 500;
}

.alert-success {
    background: #d1fae5;
    border: 1px solid #10b981;
    color: #065f46;
}

.alert-success i {
    color: #10b981;
    font-size: 16px;
}

/* Balance Card Styles */
.balance-card {
    background: linear-gradient(135deg, #f4d03f, #f7dc6f);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 24px;
    box-shadow: 0 4px 12px rgba(244, 208, 63, 0.3);
}

.balance-header {
    display: flex;
    align-items: center;
    gap: 16px;
}

.balance-icon {
    width: 48px;
    height: 48px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #8b4513;
}

.balance-info {
    flex: 1;
}

.balance-label {
    font-size: 14px;
    color: #8b4513;
    font-weight: 500;
    margin-bottom: 4px;
}

.balance-amount {
    font-size: 24px;
    font-weight: 700;
    color: #8b4513;
    margin-bottom: 4px;
}

.balance-updated {
    font-size: 12px;
    color: #8b4513;
    opacity: 0.8;
}

/* Form Section Styles */
.form-section {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 16px;
    margin-bottom: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
}

/* Bank Info Compact Styles */
.bank-info-compact {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 16px;
}

.bank-info-main {
    display: flex;
    align-items: center;
    gap: 12px;
}

.bank-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #f4d03f, #f7dc6f);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #8b4513;
    font-size: 16px;
    flex-shrink: 0;
}

.bank-details {
    flex: 1;
    min-width: 0;
}

.bank-name {
    font-size: 16px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 2px;
}

.bank-account {
    font-size: 14px;
    color: #374151;
    font-weight: 500;
    margin-bottom: 2px;
    word-break: break-all;
}

.bank-holder {
    font-size: 13px;
    color: #6b7280;
}

.bank-edit {
    flex-shrink: 0;
}

.edit-btn {
    width: 32px;
    height: 32px;
    background: #ffffff;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6b7280;
    text-decoration: none;
    transition: all 0.2s ease;
}

.edit-btn:hover {
    background: #f4d03f;
    border-color: #f4d03f;
    color: #8b4513;
    transform: scale(1.05);
}

/* No Bank Info Styles */
.no-bank-info {
    text-align: center;
    padding: 40px 20px;
}

.no-bank-icon {
    width: 64px;
    height: 64px;
    background: #fef3c7;
    border: 2px solid #f59e0b;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 24px;
    color: #f59e0b;
}

.no-bank-text h4 {
    font-size: 18px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 8px;
}

.no-bank-text p {
    font-size: 14px;
    color: #6b7280;
    margin-bottom: 20px;
    line-height: 1.5;
}

.no-bank-info .btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    font-size: 14px;
    width: auto;
}

.section-title {
    font-size: 16px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.section-title i {
    color: #f4d03f;
}

/* Form Group Styles */
.form-group {
    margin-bottom: 16px;
}

.form-label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: #111827;
    font-size: 13px;
}

.required {
    color: #dc2626;
}

.form-input {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 14px;
    transition: all 0.2s ease;
    background: #ffffff;
    color: #111827;
}

.form-input:focus {
    outline: none;
    border-color: #f4d03f;
    box-shadow: 0 0 0 3px rgba(244, 208, 63, 0.1);
}

.form-input.disabled {
    background-color: #f9fafb;
    color: #9ca3af;
    cursor: not-allowed;
    border-color: #e5e7eb;
}

.password-field.disabled {
    position: relative;
}

.password-setup-message {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 8px;
    padding: 8px 12px;
    background: #fef3c7;
    border: 1px solid #f59e0b;
    border-radius: 6px;
    font-size: 12px;
    color: #92400e;
}

.password-setup-message i {
    color: #f59e0b;
    font-size: 14px;
}

.btn-setup-password {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 8px;
    padding: 8px 16px;
    background: #f4d03f;
    color: #111827;
    text-decoration: none;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.btn-setup-password:hover {
    background: #e6c42f;
    color: #111827;
    text-decoration: none;
}

.btn-setup-password i {
    font-size: 12px;
}

.error-message {
    color: #dc2626;
    font-size: 12px;
    margin-top: 4px;
}

/* Quick Amount Styles */
.quick-amount-section {
    margin-bottom: 20px;
}

.quick-amount-label {
    font-size: 13px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 10px;
}

.quick-amount-buttons {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
}

.quick-amount-btn {
    padding: 8px 10px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    color: #475569;
    cursor: pointer;
    transition: all 0.2s ease;
}

.quick-amount-btn:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
}

.quick-amount-btn.active {
    background: #f4d03f;
    border-color: #f4d03f;
    color: #8b4513;
}

/* Amount Input Styles */
.amount-input-group {
    position: relative;
    display: flex;
    align-items: center;
}

.currency-symbol {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    font-weight: 600;
    font-size: 14px;
    z-index: 1;
}

.amount-input {
    padding-left: 35px;
    padding-right: 14px;
}

.amount-info {
    margin-top: 8px;
}

.amount-limit {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    color: #6b7280;
}


/* Password Field Styles */
.password-field {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6b7280;
    cursor: pointer;
    font-size: 14px;
    transition: color 0.2s ease;
}

.password-toggle:hover {
    color: #374151;
}

.password-help {
    margin-top: 8px;
    text-align: right;
}

.forgot-password-link {
    color: #f4d03f;
    text-decoration: none;
    font-size: 12px;
    font-weight: 500;
}

.forgot-password-link:hover {
    color: #f1c40f;
    text-decoration: underline;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 8px;
    margin-bottom: 20px;
}

.btn-secondary {
    flex: 1;
    padding: 8px 12px;
    background: #f2f2f7;
    color: #6b7280;
    border: none;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    height: 36px;
}

.btn-secondary:hover {
    background: #e5e5ea;
    color: #374151;
}

.btn-primary {
    flex: 2;
    padding: 8px 12px;
    background: linear-gradient(135deg, #f4d03f, #f7dc6f);
    color: #8b4513;
    border: none;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    height: 36px;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #f1c40f, #f4d03f);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(244, 208, 63, 0.3);
}

.btn-primary:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

/* Instructions Card */
.instructions-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
}

.instructions-title {
    font-size: 16px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.instructions-title i {
    color: #f4d03f;
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

/* Notes Card */
.notes-card {
    background: #fef3c7;
    border: 1px solid #f59e0b;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 24px;
}

.notes-title {
    font-size: 16px;
    font-weight: 600;
    color: #92400e;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.notes-title i {
    color: #f59e0b;
}

.notes-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.note-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    font-size: 14px;
    color: #92400e;
}

.note-item i {
    color: #f59e0b;
    margin-top: 2px;
    flex-shrink: 0;
}

/* Responsive Design */
@media (max-width: 375px) {
    .quick-amount-buttons {
        grid-template-columns: repeat(2, 1fr);
        gap: 6px;
    }
    
    .quick-amount-btn {
        padding: 6px 8px;
        font-size: 12px;
    }
    
    .form-actions {
        flex-direction: column;
        gap: 6px;
    }
    
    .btn-secondary,
    .btn-primary {
        flex: 1;
        padding: 6px 10px;
        font-size: 11px;
        height: 32px;
    }
    
    .bank-info-main {
        gap: 8px;
    }
    
    .bank-icon {
        width: 32px;
        height: 32px;
        font-size: 12px;
    }
    
    .bank-name {
        font-size: 14px;
    }
    
    .bank-account {
        font-size: 12px;
    }
    
    .bank-holder {
        font-size: 11px;
    }
    
    .edit-btn {
        width: 26px;
        height: 26px;
        font-size: 11px;
    }
    
    .form-input {
        padding: 8px 12px;
        font-size: 13px;
    }
    
    .form-label {
        font-size: 12px;
        margin-bottom: 4px;
    }
}
</style>

<!-- Axios is already included in the layout -->

<script>
let selectedAmount = 0;

// Quick amount button functionality
document.addEventListener('DOMContentLoaded', function() {
    const quickAmountBtns = document.querySelectorAll('.quick-amount-btn');
    const amountInput = document.getElementById('amountInput');
    const submitBtn = document.getElementById('submitBtn');
    
    // Only initialize if form elements exist (user has bank info and password)
    if (!amountInput || !submitBtn) {
        // Show appropriate message if form is not available
        const noBankInfo = document.querySelector('.no-bank-info');
        if (noBankInfo) {
            showToast('warning', '{{ $__withdraw('toast_notification') }}', '{{ $__withdraw('js_bank_info_required') }}');
        }
        return;
    }
    
    // Check if password field is disabled (password not set)
    const passwordField = document.getElementById('withdrawalPassword');
    if (!passwordField || passwordField.disabled) {
        showToast('warning', '{{ $__withdraw('toast_notification') }}', '{{ $__withdraw('js_password_required') }}');
        return;
    }

    // Quick amount button clicks
    quickAmountBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            quickAmountBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            // Set amount
            const amount = parseFloat(this.dataset.amount);
            amountInput.value = amount;
            selectedAmount = amount;
            updateCalculations();
            
            // Show confirmation toast
            showToast('success', '{{ $__withdraw('js_amount_selected') }}', `{{ $__withdraw('js_withdrawal_amount') }}: $${amount.toLocaleString()}`);
        });
    });

    // Amount input change
    amountInput.addEventListener('input', function() {
        selectedAmount = parseFloat(this.value) || 0;
        updateCalculations();
        
        // Remove active class from quick amount buttons
        quickAmountBtns.forEach(btn => btn.classList.remove('active'));
        
        // Show warning if amount is too high
        if (selectedAmount > {{ $maxWithdrawAmount }}) {
            showToast('warning', '{{ $__withdraw('toast_warning') }}', '{{ $__withdraw('js_amount_exceeds') }}');
        } else if (selectedAmount >= 10) {
            // Show confirmation for valid amount
            showToast('success', '{{ $__withdraw('js_amount_valid') }}', `{{ $__withdraw('js_withdrawal_amount') }}: $${selectedAmount.toLocaleString()}`);
        }
    });

    // Update calculations
    function updateCalculations() {
        // Enable/disable submit button
        submitBtn.disabled = selectedAmount < 10 || selectedAmount > {{ $maxWithdrawAmount }};
    }

    // Form submission with axios
    document.getElementById('withdrawalForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (selectedAmount < 10) {
            showToast('error', '{{ $__withdraw('toast_error') }}', '{{ $__withdraw('js_min_amount_error') }}');
            return;
        }
        
        if (selectedAmount > {{ $maxWithdrawAmount }}) {
            showToast('error', '{{ $__withdraw('toast_error') }}', '{{ $__withdraw('js_max_amount_error') }}');
            return;
        }
        
        // Check if password is entered
        const password = document.getElementById('withdrawalPassword').value;
        if (!password || password.trim() === '') {
            showToast('error', '{{ $__withdraw('toast_error') }}', '{{ $__withdraw('js_password_required_error') }}');
            return;
        }
        
        // Show loading state
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ $__withdraw('js_processing') }}';
        submitBtn.disabled = true;
        
        // Show processing toast
        showToast('info', '{{ $__withdraw('toast_processing') }}', '{{ $__withdraw('js_processing_request') }}');
        
        // Prepare form data
        const formData = new FormData();
        formData.append('_token', document.querySelector('input[name="_token"]').value);
        formData.append('amount', selectedAmount);
        formData.append('withdrawal_password', password);
        
        // Add bank info if available
        const bankName = document.querySelector('input[name="bank_name"]');
        const accountHolder = document.querySelector('input[name="account_holder"]');
        const accountNumber = document.querySelector('input[name="account_number"]');
        const branch = document.querySelector('input[name="branch"]');
        
        if (bankName) formData.append('bank_name', bankName.value);
        if (accountHolder) formData.append('account_holder', accountHolder.value);
        if (accountNumber) formData.append('account_number', accountNumber.value);
        if (branch) formData.append('branch', branch.value);
        
        // Send axios request
        axios.post('{{ route("withdraw.submit") }}', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(function(response) {
            if (response.data.success) {
                showToast('success', '{{ $__withdraw('toast_success') }}', response.data.message);
                
                // Update balance display if available
                if (response.data.data) {
                    console.log('New balance:', response.data.data.newBalance);
                    console.log('New hoa hong:', response.data.data.newHoaHong);
                    
                    // Update balance display in user info card if it exists
                    const balanceElement = document.querySelector('.balance-amount');
                    if (balanceElement && response.data.data.newBalance !== undefined) {
                        balanceElement.textContent = '$' + response.data.data.newBalance.toLocaleString();
                    }
                }
                
                // Reset form
                document.getElementById('withdrawalForm').reset();
                selectedAmount = 0;
                quickAmountBtns.forEach(btn => btn.classList.remove('active'));
                updateCalculations();
                
                // Show reset confirmation
                showToast('info', '{{ $__withdraw('js_form_reset') }}', '{{ $__withdraw('js_new_transaction') }}');
                
                // Redirect after 2 seconds
                setTimeout(() => {
                    window.location.href = '{{ route("account.account-history") }}';
                }, 2000);
            } else {
                showToast('error', '{{ $__withdraw('toast_error') }}', response.data.message);
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
            
            if (error.response && error.response.data) {
                const errorData = error.response.data;
                
                if (errorData.errors) {
                    // Show validation errors - only show the first error to avoid spam
                    const firstErrorField = Object.keys(errorData.errors)[0];
                    const firstErrorMessage = errorData.errors[firstErrorField][0];
                    showToast('error', '{{ $__withdraw('toast_validation_error') }}', firstErrorMessage);
                    
                    // Highlight the specific field with error
                    const fieldElement = document.querySelector(`[name="${firstErrorField}"]`);
                    if (fieldElement) {
                        fieldElement.style.borderColor = '#dc2626';
                        fieldElement.style.boxShadow = '0 0 0 3px rgba(220, 38, 38, 0.1)';
                        
                        // Remove error styling after 3 seconds
                        setTimeout(() => {
                            fieldElement.style.borderColor = '';
                            fieldElement.style.boxShadow = '';
                        }, 3000);
                    }
                } else {
                    showToast('error', '{{ $__withdraw('toast_error') }}', errorData.message || '{{ $__withdraw('js_request_error') }}');
                }
            } else {
                showToast('error', '{{ $__withdraw('toast_connection_error') }}', '{{ $__withdraw('js_connection_error') }}');
            }
        })
        .finally(function() {
            // Reset button state
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });
});

// Password toggle functionality
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const toggle = input.nextElementSibling;
    const icon = toggle.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Go back function
function goBack() {
    if (window.history.length > 1) {
        window.history.back();
    } else {
        window.location.href = '{{ route("dashboard") }}';
    }
}
</script>
@endsection
