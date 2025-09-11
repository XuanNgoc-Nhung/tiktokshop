@extends('admin.layouts.app')

@section('title', __('admin::cms.user_management'))

@section('breadcrumb', __('admin::cms.user_management'))

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('admin::cms.user_list') }}</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.user-management') }}" style="margin-bottom: 0.75rem; display: flex; gap: 0.4rem; align-items: center;">
                <input type="text" name="q" value="{{ $keyword ?? '' }}" placeholder="{{ __('admin::cms.search_placeholder_users') }}" style="flex: 1; padding: 0.35rem 0.5rem; font-size: 0.875rem; border: 1px solid var(--gray-400); border-radius: var(--border-radius); background: var(--gray-100); color: var(--gray-800); height: 32px;">
                <button type="submit" class="btn btn-primary" style="height: 32px; padding: 0.35rem 0.6rem; font-size: 0.8125rem;"><i class="fas fa-search"></i> {{ __('admin::cms.search') }}</button>
                <a href="{{ route('admin.user-management') }}" class="btn btn-secondary" style="height: 32px; padding: 0.35rem 0.6rem; font-size: 0.8125rem;"><i class="fas fa-rotate"></i> {{ __('admin::cms.reset') }}</a>
                <a href="{{ route('admin.user-management.create') }}" id="openCreateUserModal" class="btn btn-primary" style="height: 32px; padding: 0.35rem 0.6rem; font-size: 0.8125rem;"><i class="fas fa-plus"></i> {{ __('admin::cms.add_new') }}</a>
            </form>

            <div style="margin-bottom: 0.5rem; color: var(--gray-600); font-size: 0.875rem;">{{ __('admin::cms.total') }}: {{ $users->total() }}</div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:48px;">#</th>
                            <th class="text-left" style="width:280px;">{{ __('admin::cms.name') }}</th>
                            <th class="text-left" style="width:300px;">{{ __('admin::cms.additional_info') }}</th>
                            <th class="text-left" style="width:280px;">{{ __('admin::cms.bank_name') }}</th>
                            <th class="text-left" style="width:140px;">{{ __('admin::cms.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(($users ?? []) as $index => $user)
                            <tr>
                                <td class="text-center">{{ $users->firstItem() + $index }}</td>
                                <td style="width: 280px;">
                                    <div class="user-card" style="display: flex; align-items: center; gap: 12px; padding: 12px; border-radius: 10px; background: var(--gray-50); border: 1px solid var(--gray-200); min-height: 120px;">
                                        <!-- Phần bên trái: Avatar + Tên -->
                                        <div class="user-left" style="display: flex; flex-direction: column; align-items: center; gap: 10px; flex-shrink: 0; width: 30%; min-width: 150px;">
                                            <div class="user-avatar" style="width: 85px; height: 85px; border-radius: 50%; overflow: hidden; background: var(--gray-300); display: flex; align-items: center; justify-content: center; border: 3px solid var(--gray-200); position: relative; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                                @if($user->profile && $user->profile->anh_chan_dung)
                                                    <img src="{{ $user->profile->anh_chan_dung }}" alt="{{ $user->name }}" style="width: 85px; height: 85px; object-fit: cover; object-position: center; border-radius: 50%;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                @endif
                                                <div class="avatar-placeholder" style="width: 85px; height: 85px; display: {{ $user->profile && $user->profile->anh_chan_dung ? 'none' : 'flex' }}; align-items: center; justify-content: center; background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%); position: relative;">
                                                    <i class="fas fa-user" style="font-size: 24px; color: #9ca3af; opacity: 0.8;"></i>
                                                    <div style="position: absolute; top: 5px; right: 5px; width: 12px; height: 12px; background: #6b7280; border-radius: 50%; opacity: 0.3;"></div>
                                                </div>
                                            </div>
                                            <div class="user-name" style="font-weight: 700; font-size: 0.85rem; color: var(--gray-800); text-align: center; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 140px; line-height: 1.2;">{{ $user->name }}</div>
                                        </div>
                                        
                                        <!-- Phần bên phải: Thông tin chi tiết -->
                                        <div class="user-right" style="width: 70%; min-width: 0;">
                                            <div class="user-details" style="font-size: 0.8rem; color: var(--gray-600); line-height: 1.4;">
                                                @if($user->profile && $user->profile->so_du)
                                                    <div style="margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                                                        <i class="fas fa-coins" style="color: #f59e0b; flex-shrink: 0;"></i>
                                                        <span style="font-weight: 600; color: var(--success-color); font-size: 0.8rem;">{{ number_format($user->profile->so_du, 0, ',', '.') }} 💰</span>
                                                    </div>
                                                @endif
                                                <div style="margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                                                    <i class="fas fa-phone" style="color: #10b981; flex-shrink: 0;"></i>
                                                    <span style="font-size: 0.8rem;">{{ $user->phone }}</span>
                                                </div>
                                                @if($user->profile)
                                                    @if($user->profile->gioi_tinh)
                                                        <div style="margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                                                            <i class="fas {{ $user->profile->gioi_tinh === 'nam' ? 'fa-mars' : 'fa-venus' }}" style="color: {{ $user->profile->gioi_tinh === 'nam' ? '#3b82f6' : '#ec4899' }}; flex-shrink: 0;"></i>
                                                            <span style="font-size: 0.8rem;">{{ $user->profile->gioi_tinh === 'nam' ? 'Nam' : ($user->profile->gioi_tinh === 'nu' ? 'Nữ' : $user->profile->gioi_tinh) }}</span>
                                                        </div>
                                                    @endif
                                                    @if($user->profile->ngay_sinh)
                                                        <div style="margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                                                            <i class="fas fa-calendar-alt" style="color: #6b7280; flex-shrink: 0;"></i>
                                                            <span style="font-size: 0.8rem;">{{ \Carbon\Carbon::parse($user->profile->ngay_sinh)->format('d/m/Y') }}</span>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 300px;">
                                    <div style="font-size: 0.8rem; color: var(--gray-700); line-height: 1.4;">
                                        <!-- Ngày tham gia -->
                                        <div style="margin-bottom: 6px; padding: 6px 10px; background: var(--gray-50); border-radius: 6px; border-left: 4px solid #6b7280; display: flex; align-items: flex-start; gap: 8px;">
                                            <i class="fas fa-calendar-plus" style="color: #6b7280; flex-shrink: 0; margin-top: 2px;"></i>
                                            <div style="flex: 1; min-width: 0;">
                                                <div style="font-weight: 500; color: var(--gray-800);">{{ $user->created_at_formatted ?? '' }}</div>
                                            </div>
                                        </div>
                                        
                                        @if($user->profile)
                                            @if($user->profile->dia_chi)
                                                <div style="margin-bottom: 6px; padding: 6px 10px; border-radius: 6px; border-left: 4px solid var(--primary-color); display: flex; align-items: flex-start; gap: 8px;">
                                                    <i class="fas fa-map-marker-alt" style="color: #3b82f6; flex-shrink: 0; margin-top: 2px;"></i>
                                                    <div style="flex: 1; min-width: 0;">
                                                        <div style="word-wrap: break-word; line-height: 1.3;">{{ $user->profile->dia_chi }}</div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($user->profile->cap_do)
                                                <div style="margin-bottom: 6px; padding: 6px 10px; background: var(--warning-50); border-radius: 6px; border-left: 4px solid var(--warning-color); display: flex; align-items: flex-start; gap: 8px;">
                                                    <i class="fas fa-crown" style="color: #f59e0b; flex-shrink: 0; margin-top: 2px;"></i>
                                                    <div style="flex: 1; min-width: 0;">
                                                        <div style="font-weight: 500; color: var(--warning-color);">{{ $user->profile->cap_do }}</div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($user->profile->luot_trung)
                                                <div style="margin-bottom: 6px; padding: 6px 10px; background: var(--success-50); border-radius: 6px; border-left: 4px solid var(--success-color); display: flex; align-items: flex-start; gap: 8px;">
                                                    <i class="fas fa-trophy" style="color: #10b981; flex-shrink: 0; margin-top: 2px;"></i>
                                                    <div style="flex: 1; min-width: 0;">
                                                        <div style="font-weight: 500; color: var(--success-color);">{{ $user->profile->luot_trung }} lần</div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                        @if(!$user->profile || (!$user->profile->dia_chi && !$user->profile->cap_do && !$user->profile->luot_trung))
                                            <div style="color: var(--gray-500); font-style: italic; text-align: center; padding: 12px; background: var(--gray-50); border-radius: 6px; border: 1px dashed var(--gray-300);">
                                                <i class="fas fa-info-circle" style="margin-right: 4px;"></i>
                                                Chưa có thông tin bổ sung
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td style="width: 280px;">
                                    @if($user->profile && ($user->profile->ngan_hang || $user->profile->so_tai_khoan || $user->profile->chu_tai_khoan))
                                        <div style="font-size: 0.8rem; line-height: 1.4;">
                                            @if($user->profile->ngan_hang)
                                                <div style="margin-bottom: 6px; padding: 6px 10px; background: var(--gray-50); border-radius: 6px; border-left: 4px solid #6b7280; display: flex; align-items: flex-start; gap: 8px;">
                                                    <i class="fas fa-university" style="color: #6b7280; flex-shrink: 0; margin-top: 2px;"></i>
                                                    <div style="flex: 1; min-width: 0;">
                                                        <div style="word-wrap: break-word; line-height: 1.3;">{{ $user->profile->ngan_hang }}</div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($user->profile->so_tai_khoan)
                                                <div style="margin-bottom: 6px; padding: 6px 10px; background: var(--gray-50); border-radius: 6px; border-left: 4px solid #6b7280; display: flex; align-items: flex-start; gap: 8px;">
                                                    <i class="fas fa-credit-card" style="color: #6b7280; flex-shrink: 0; margin-top: 2px;"></i>
                                                    <div style="flex: 1; min-width: 0;">
                                                        <div style="font-family: monospace; font-size: 0.75rem; word-wrap: break-word; line-height: 1.3;">{{ $user->profile->so_tai_khoan }}</div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($user->profile->chu_tai_khoan)
                                                <div style="margin-bottom: 6px; padding: 6px 10px; background: var(--gray-50); border-radius: 6px; border-left: 4px solid #6b7280; display: flex; align-items: flex-start; gap: 8px;">
                                                    <i class="fas fa-user-tie" style="color: #6b7280; flex-shrink: 0; margin-top: 2px;"></i>
                                                    <div style="flex: 1; min-width: 0;">
                                                        <div style="word-wrap: break-word; line-height: 1.3;">{{ $user->profile->chu_tai_khoan }}</div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div style="color: var(--gray-500); font-style: italic; text-align: center; padding: 12px; background: var(--gray-50); border-radius: 6px; border: 1px dashed var(--gray-300);">
                                            <i class="fas fa-info-circle" style="margin-right: 4px;"></i>
                                            Chưa có thông tin ngân hàng
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-secondary edit-user-btn" 
                                        onclick="loadUserDataFromButton({
                                            id: {{ $user->id }},
                                            name: '{{ addslashes($user->name) }}',
                                            phone: '{{ addslashes($user->phone) }}',
                                            email: '{{ addslashes($user->email) }}',
                                            profile: {
                                                gioi_tinh: '{{ addslashes($user->profile->gioi_tinh ?? '') }}',
                                                ngay_sinh: '{{ addslashes($user->profile->ngay_sinh ?? '') }}',
                                                dia_chi: '{{ addslashes($user->profile->dia_chi ?? '') }}',
                                                so_du: {{ $user->profile->so_du ?? 0 }},
                                                luot_trung: {{ $user->profile->luot_trung ?? 0 }},
                                                ngan_hang: '{{ addslashes($user->profile->ngan_hang ?? '') }}',
                                                so_tai_khoan: '{{ addslashes($user->profile->so_tai_khoan ?? '') }}',
                                                chu_tai_khoan: '{{ addslashes($user->profile->chu_tai_khoan ?? '') }}',
                                                cap_do: '{{ addslashes($user->profile->cap_do ?? '') }}',
                                                giai_thuong_id: '{{ addslashes($user->profile->giai_thuong_id ?? '') }}',
                                                anh_mat_truoc: '{{ addslashes($user->profile->anh_mat_truoc ?? '') }}',
                                                anh_mat_sau: '{{ addslashes($user->profile->anh_mat_sau ?? '') }}',
                                                anh_chan_dung: '{{ addslashes($user->profile->anh_chan_dung ?? '') }}'
                                            }
                                        })"
                                        style="height: 30px; padding: 0.25rem 0.5rem; font-size: 0.8125rem;" 
                                        title="{{ __('admin::cms.edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning adjust-balance-btn" 
                                        onclick="loadUserDataForAdjustment(this)"
                                        data-user-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-current-balance="{{ $user->profile->so_du ?? 0 }}"
                                        style="height: 30px; padding: 0.25rem 0.5rem; font-size: 0.8125rem;" 
                                        title="{{ __('admin::cms.adjust_balance') }}">
                                        <i class="fas fa-coins"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger delete-user-btn" 
                                        onclick="showDeleteConfirmation({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                        style="height: 30px; padding: 0.25rem 0.5rem; font-size: 0.8125rem;" 
                                        title="{{ __('admin::cms.delete') }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center; color: var(--gray-600);">{{ __('admin::cms.no_data') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <x-pagination :paginator="$users" />
        </div>
    </div>

    <!-- Adjust Balance Modal -->
    <div id="adjustBalanceModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="adjustBalanceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" style="min-width: 600px; max-width: 800px;" role="document">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="adjustBalanceModalLabel">{{ __('admin::cms.adjust_balance') }}</h5>
                    <button type="button" id="closeAdjustBalanceModal" class="btn-close" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div id="adjustBalanceError" class="alert alert-danger" style="display:none;"></div>
                    
                    <form id="adjustBalanceForm">
                        <input type="hidden" id="adjust_user_id" name="user_id">
                        
                        
                        <!-- Balance Adjustment - 3 inputs in one row -->
                        <div class="row mb-3">
                            <!-- Current Balance -->
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label for="current_balance" class="form-label fw-semibold">
                                    <i class="fas fa-money-bill me-1 text-primary"></i>
                                    {{ __('admin::cms.current_balance') }}
                                </label>
                                <div class="input-group">
                                    <input type="number" id="current_balance" class="form-control" 
                                           step="0.01" readonly style="background-color: #f8f9fa; border-color: #d1d5db;">
                                    <span class="input-group-text bg-light">💰</span>
                                </div>
                            </div>
                            
                            <!-- Balance Adjustment -->
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                <label for="balance_adjustment" class="form-label fw-semibold">
                                    <i class="fas fa-plus-minus me-1 text-warning"></i>
                                    {{ __('admin::cms.balance_adjustment') }}
                                </label>
                                <div class="input-group">
                                    <input type="number" id="balance_adjustment" oninput="calculateNewBalance()" name="balance_adjustment" class="form-control" 
                                           step="0.01" placeholder="0.00" required style="border-color: #d1d5db;">
                                    <span class="input-group-text bg-light">💰</span>
                                </div>
                            </div>
                            
                            <!-- New Balance Preview -->
                            <div class="col-lg-4 col-md-12 col-sm-12 mb-3">
                                <label for="new_balance_preview" class="form-label fw-semibold">
                                    <i class="fas fa-calculator me-1 text-success"></i>
                                    {{ __('admin::cms.new_balance') }}
                                </label>
                                <div class="input-group">
                                    <input type="number" id="new_balance_preview" class="form-control" 
                                           step="0.01" disabled style="background-color: #f8f9fa; font-weight: 600; color: #6b7280; border-color: #d1d5db;">
                                    <span class="input-group-text bg-light">💰</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Help text -->
                        <div class="mb-3">
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                {{ __('admin::cms.balance_adjustment_help') }}
                            </small>
                        </div>
                    </form>
                </div>
                
                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" id="submitAdjustBalance" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>{{ __('admin::cms.update_balance') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="createUserModal" style="display:none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1050; align-items: center; justify-content: center;">
        <div style="background: var(--gray-200); color: var(--gray-800); width: 520px; max-width: 92vw; border-radius: var(--border-radius-lg); box-shadow: var(--shadow-lg);">
            <div style="padding: 1rem 1.25rem; border-bottom: 1px solid var(--gray-300); background: var(--gray-300); display:flex; align-items:center; justify-content: space-between;">
                <div style="font-weight:600;">{{ __('admin::cms.add_user_title') }}</div>
                <div style="display:flex; gap: 0.5rem; align-items:center;">
                    <button type="button" id="fillSampleData" class="btn btn-info" style="height: 30px; padding: 0.25rem 0.6rem; font-size: 0.8125rem;"><i class="fas fa-magic"></i> {{ __('admin::cms.fill_sample_data') }}</button>
                    <button type="button" id="closeCreateUserModal" class="btn btn-secondary" style="height: 30px; padding: 0.25rem 0.6rem; font-size: 0.8125rem;">{{ __('admin::cms.cancel') }}</button>
                </div>
            </div>
            <div style="padding: 1rem 1.25rem;">
                <div id="createUserError" style="display:none; margin-bottom: 0.75rem; padding: 0.5rem 0.75rem; background: var(--danger-color); color: #fff; border-radius: var(--border-radius);"></div>
                <form id="createUserForm">
                    <div style="display:flex; flex-direction:column; gap: 0.6rem;">
                        <div>
                            <label for="cu_name" style="display:block; margin-bottom: 0.25rem; color: #ffffff; font-weight: 600; font-size: 0.9rem;">{{ __('admin::cms.name') }}</label>
                            <input id="cu_name" name="name" type="text" placeholder="{{ __('admin::cms.placeholder_name') }}" style="width:100%; padding: 0.5rem 0.6rem; border: 1px solid var(--gray-400); border-radius: var(--border-radius); background: var(--gray-100); color: var(--gray-800);">
                            <div class="field-error" id="error_cu_name" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: var(--danger-color);"></div>
                        </div>
                        <div>
                            <label for="cu_phone" style="display:block; margin-bottom: 0.25rem; color: #ffffff; font-weight: 600; font-size: 0.9rem;">{{ __('admin::cms.phone') }}</label>
                            <input id="cu_phone" name="phone" type="text" placeholder="{{ __('admin::cms.placeholder_phone') }}" style="width:100%; padding: 0.5rem 0.6rem; border: 1px solid var(--gray-400); border-radius: var(--border-radius); background: var(--gray-100); color: var(--gray-800);">
                            <div class="field-error" id="error_cu_phone" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: var(--danger-color);"></div>
                        </div>
                        <div>
                            <label for="cu_password" style="display:block; margin-bottom: 0.25rem; color: #ffffff; font-weight: 600; font-size: 0.9rem;">{{ __('admin::cms.password') }}</label>
                            <input id="cu_password" name="password" type="password" placeholder="{{ __('admin::cms.placeholder_password') }}" style="width:100%; padding: 0.5rem 0.6rem; border: 1px solid var(--gray-400); border-radius: var(--border-radius); background: var(--gray-100); color: var(--gray-800);">
                            <div class="field-error" id="error_cu_password" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: var(--danger-color);"></div>
                        </div>
                        <div>
                            <label for="cu_password_confirmation" style="display:block; margin-bottom: 0.25rem; color: #ffffff; font-weight: 600; font-size: 0.9rem;">{{ __('admin::cms.password_confirmation') }}</label>
                            <input id="cu_password_confirmation" name="password_confirmation" type="password" placeholder="{{ __('admin::cms.placeholder_password_confirmation') }}" style="width:100%; padding: 0.5rem 0.6rem; border: 1px solid var(--gray-400); border-radius: var(--border-radius); background: var(--gray-100); color: var(--gray-800);">
                            <div class="field-error" id="error_cu_password_confirmation" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: var(--danger-color);"></div>
                        </div>
                        <div>
                            <label for="cu_referral_code" style="display:block; margin-bottom: 0.25rem; color: #ffffff; font-weight: 600; font-size: 0.9rem;">{{ __('admin::cms.referral_code') }}</label>
                            <input id="cu_referral_code" name="referral_code" type="text" placeholder="{{ __('admin::cms.placeholder_referral_code') }}" style="width:100%; padding: 0.5rem 0.6rem; border: 1px solid var(--gray-400); border-radius: var(--border-radius); background: var(--gray-100); color: var(--gray-800);">
                            <div class="field-error" id="error_cu_referral_code" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: var(--danger-color);"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div style="padding: 0.9rem 1.25rem; border-top: 1px solid var(--gray-300); display:flex; gap: 0.5rem; justify-content: flex-end;">
                <button type="button" id="submitCreateUser" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('admin::cms.save') }}</button>
            </div>
        </div>
    </div>

    <!-- Bootstrap Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" style="min-width: 300px; max-width: 350px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="deleteConfirmModalLabel">{{ __('admin::cms.confirm_delete') }}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-dark mb-0" id="deleteConfirmMessage">{{ __('admin::cms.confirm_delete_user') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{ __('admin::cms.cancel') }}</button>
                    <button type="button" class="btn btn-danger btn-sm" id="confirmDeleteBtn">{{ __('admin::cms.delete') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit User Modal -->
    <div id="editUserModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">{{ __('admin::cms.edit_user_title') }}</h5>
                <button type="button" id="closeEditUserModal" class="btn-close" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div id="editUserError" class="alert alert-danger" style="display:none;"></div>
                
                <form id="editUserForm">
                    <input type="hidden" id="edit_user_id" name="user_id">
                    
                    <!-- Main Content with 2 columns -->
                    <div class="row">
                        
                        <!-- Left Column: Portrait Image -->
                        <div class="col-lg-3 col-md-4 col-sm-12 mb-3">
                            <div class="text-center">
                                <!-- Portrait Image Display -->
                                <div class="mb-3">
                                    <div class="mx-auto" style="width: 200px; height: 250px; border-radius: 12px; overflow: hidden; background: #f8fafc; border: 2px solid #e2e8f0; display: flex; align-items: center; justify-content: center;">
                                        <div id="preview_anh_chan_dung_placeholder" class="d-flex flex-column align-items-center justify-content-center text-muted" style="width: 100%; height: 100%; background: #f8fafc; border: 2px dashed #cbd5e0;">
                                            <i class="fas fa-image fa-2x mb-2"></i>
                                            <small>{{ __('admin::cms.portrait_image') }}</small>
                                        </div>
                                        <img id="preview_anh_chan_dung" src="" alt="Ảnh chân dung" class="img-fluid d-none" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div class="mt-2">
                                        <label for="edit_anh_chan_dung" class="form-label" style="color: #000000; font-weight: 600; font-size: 0.9rem;">{{ __('admin::cms.portrait_image') }}</label>
                                        <input id="edit_anh_chan_dung" name="anh_chan_dung" type="text" class="form-control form-control-sm" placeholder="{{ __('admin::cms.placeholder_image_url') }}">
                                        <div class="field-error" id="error_edit_anh_chan_dung" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Column: Form Information -->
                        <div class="col-lg-9 col-md-8 col-sm-12">
                            <div class="mb-3">
                                <!-- Form Fields in 4 columns (responsive) -->
                                <div class="row g-2">
                                    <!-- Name -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_name" class="form-label" style="color: #000000; font-weight: 600; font-size: 0.9rem;">{{ __('admin::cms.name') }}</label>
                                        <input id="edit_name" name="name" type="text" class="form-control form-control-sm" placeholder="{{ __('admin::cms.placeholder_name') }}">
                                        <div class="field-error" id="error_edit_name" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Phone -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_phone" class="form-label" style="color: #000000; font-weight: 600; font-size: 0.9rem;">{{ __('admin::cms.phone') }}</label>
                                        <input id="edit_phone" name="phone" type="text" class="form-control form-control-sm" placeholder="{{ __('admin::cms.placeholder_phone') }}" readonly>
                                        <div class="field-error" id="error_edit_phone" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Email -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_email" class="form-label" style="color: #000000; font-weight: 600; font-size: 0.9rem;">{{ __('admin::cms.email') }}</label>
                                        <input id="edit_email" name="email" type="email" class="form-control form-control-sm" placeholder="{{ __('admin::cms.placeholder_email') }}" readonly>
                                        <div class="field-error" id="error_edit_email" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Gender -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_gioi_tinh" class="form-label" style="color: #000000; font-weight: 600; font-size: 0.9rem;">{{ __('admin::cms.gender') }}</label>
                                        <select id="edit_gioi_tinh" name="gioi_tinh" class="form-select form-select-sm">
                                            <option value="">{{ __('admin::cms.select_gender') }}</option>
                                            <option value="Nam">Nam</option>
                                            <option value="Nữ">Nữ</option>
                                            <option value="Khác">Khác</option>
                                        </select>
                                        <div class="field-error" id="error_edit_gioi_tinh" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Birth Date -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_ngay_sinh" class="form-label" style="color: #000000; font-weight: 600; font-size: 0.9rem;">{{ __('admin::cms.birth_date') }}</label>
                                        <input id="edit_ngay_sinh" name="ngay_sinh" type="text" class="form-control form-control-sm" placeholder="{{ __('admin::cms.placeholder_birth_date') }}">
                                        <div class="field-error" id="error_edit_ngay_sinh" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Address -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_dia_chi" class="form-label" style="color: #000000; font-weight: 600; font-size: 0.9rem;">{{ __('admin::cms.address') }}</label>
                                        <input id="edit_dia_chi" name="dia_chi" type="text" class="form-control form-control-sm" placeholder="{{ __('admin::cms.placeholder_address') }}">
                                        <div class="field-error" id="error_edit_dia_chi" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Balance -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_so_du" class="form-label" style="color: #000000; font-weight: 600; font-size: 0.9rem;">{{ __('admin::cms.balance') }}</label>
                                        <input readonly id="edit_so_du" name="so_du" type="number" step="0.01" min="0" placeholder="0" class="form-control form-control-sm">
                                        <div class="field-error" id="error_edit_so_du" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Win Count -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_luot_trung" class="form-label" style="color: #000000; font-weight: 600; font-size: 0.9rem;">{{ __('admin::cms.win_count') }}</label>
                                        <input id="edit_luot_trung" name="luot_trung" type="number" min="0" placeholder="0" class="form-control form-control-sm">
                                        <div class="field-error" id="error_edit_luot_trung" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Bank -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_ngan_hang" class="form-label" style="color: #000000; font-weight: 600; font-size: 0.9rem;">{{ __('admin::cms.bank') }}</label>
                                        <input id="edit_ngan_hang" name="ngan_hang" type="text" class="form-control form-control-sm" placeholder="{{ __('admin::cms.placeholder_bank') }}">
                                        <div class="field-error" id="error_edit_ngan_hang" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Account Number -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_so_tai_khoan" class="form-label" style="color: #000000; font-weight: 600; font-size: 0.9rem;">{{ __('admin::cms.account_number') }}</label>
                                        <input id="edit_so_tai_khoan" name="so_tai_khoan" type="text" class="form-control form-control-sm" placeholder="{{ __('admin::cms.placeholder_account_number') }}">
                                        <div class="field-error" id="error_edit_so_tai_khoan" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Account Holder -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_chu_tai_khoan" class="form-label" style="color: #000000; font-weight: 600; font-size: 0.9rem;">{{ __('admin::cms.account_holder') }}</label>
                                        <input id="edit_chu_tai_khoan" name="chu_tai_khoan" type="text" class="form-control form-control-sm" placeholder="{{ __('admin::cms.placeholder_account_holder') }}">
                                        <div class="field-error" id="error_edit_chu_tai_khoan" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Level -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_cap_do" class="form-label" style="color: #000000; font-weight: 600; font-size: 0.9rem;">{{ __('admin::cms.level') }}</label>
                                        <select id="edit_cap_do" name="cap_do" class="form-select form-select-sm">
                                            <option value="">{{ __('admin::cms.select_level') }}</option>
                                            <option value="VIP 1">VIP 1</option>
                                            <option value="VIP 2">VIP 2</option>
                                            <option value="VIP 3">VIP 3</option>
                                            <option value="VIP 4">VIP 4</option>
                                            <option value="VIP 5">VIP 5</option>
                                            <option value="VIP 6">VIP 6</option>
                                            <option value="VIP 7">VIP 7</option>
                                            <option value="VIP 8">VIP 8</option>
                                            <option value="VIP 9">VIP 9</option>
                                            <option value="VIP 10">VIP 10</option>
                                            <option value="VIP 11">VIP 11</option>
                                            <option value="VIP 12">VIP 12</option>
                                            <option value="VIP 13">VIP 13</option>
                                            <option value="VIP 14">VIP 14</option>
                                            <option value="VIP 15">VIP 15</option>
                                        </select>
                                        <div class="field-error" id="error_edit_cap_do" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Prize ID -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_giai_thuong_id" class="form-label" style="color: #000000; font-weight: 600; font-size: 0.9rem;">{{ __('admin::cms.prize_id') }}</label>
                                        <input id="edit_giai_thuong_id" name="giai_thuong_id" type="text" class="form-control form-control-sm" placeholder="{{ __('admin::cms.placeholder_prize_id') }}">
                                        <div class="field-error" id="error_edit_giai_thuong_id" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Additional Images Section -->
                            <div class="mt-4 pt-3 border-top">
                                <h5 class="mb-3" style="color: #000000; font-weight: 600; font-size: 0.9rem;">{{ __('admin::cms.additional_images') }}</h5>
                                <div class="row g-2">
                                    <!-- Front Image -->
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <label for="edit_anh_mat_truoc" class="form-label" style="color: #000000; font-weight: 600; font-size: 0.9rem;">{{ __('admin::cms.front_image') }}</label>
                                        <div class="mb-2">
                                            <div id="preview_anh_mat_truoc_placeholder" class="d-flex flex-column align-items-center justify-content-center text-muted rounded border" style="width: 100%; height: 160px; background: #f9fafb; border: 2px dashed #cbd5e0 !important;">
                                                <i class="fas fa-image fa-lg mb-1"></i>
                                                <small>{{ __('admin::cms.front_image') }}</small>
                                            </div>
                                            <img id="preview_anh_mat_truoc" src="" alt="Ảnh mặt trước" class="img-fluid rounded border d-none" style="width: 100%; height: 160px; object-fit: cover; background: #f9fafb;">
                                        </div>
                                        <input id="edit_anh_mat_truoc" name="anh_mat_truoc" type="text" class="form-control form-control-sm" placeholder="{{ __('admin::cms.placeholder_image_url') }}">
                                        <div class="field-error" id="error_edit_anh_mat_truoc" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Back Image -->
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <label for="edit_anh_mat_sau" class="form-label" style="color: #000000; font-weight: 600; font-size: 0.9rem;">{{ __('admin::cms.back_image') }}</label>
                                        <div class="mb-2">
                                            <div id="preview_anh_mat_sau_placeholder" class="d-flex flex-column align-items-center justify-content-center text-muted rounded border" style="width: 100%; height: 160px; background: #f9fafb; border: 2px dashed #cbd5e0 !important;">
                                                <i class="fas fa-image fa-lg mb-1"></i>
                                                <small>{{ __('admin::cms.back_image') }}</small>
                                            </div>
                                            <img id="preview_anh_mat_sau" src="" alt="Ảnh mặt sau" class="img-fluid rounded border d-none" style="width: 100%; height: 160px; object-fit: cover; background: #f9fafb;">
                                        </div>
                                        <input id="edit_anh_mat_sau" name="anh_mat_sau" type="text" class="form-control form-control-sm" placeholder="{{ __('admin::cms.placeholder_image_url') }}">
                                        <div class="field-error" id="error_anh_mat_sau" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" id="fillSampleDataBtn" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-magic me-2"></i>{{ __('admin::cms.fill_sample_data') }}
                </button>
                <button type="button" id="submitEditUser" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>{{ __('admin::cms.update') }}
                </button>
            </div>
            
            <!-- Confirmation Modal (nested inside edit modal) -->
            <div class="modal fade" id="confirmUpdateModal" tabindex="-1" role="dialog" aria-labelledby="confirmUpdateModalLabel" aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmUpdateModalLabel">{{ __('admin::cms.confirm_update') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-exclamation-triangle text-warning" style="font-size: 2rem;"></i>
                                </div>
                                <div>
                                    <p class="mb-0">{{ __('admin::cms.confirm_update_user') }}</p>
                                    <small class="text-muted">{{ __('admin::cms.confirm_update_description') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i>{{ __('admin::cms.cancel') }}
                            </button>
                            <button type="button" class="btn btn-primary" id="confirmUpdateBtn">
                                <i class="fas fa-check me-1"></i>{{ __('admin::cms.confirm') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@push('styles')
<style>
    .modal.show {
        /* display: flex !important; */
    }
    
    .modal-dialog {
        margin: 1.75rem auto;
        max-width: 90%;
    }
    
    .modal-content {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        display: flex;
        flex-direction: column;
        max-height: 90vh;
    }
    
    .modal-header {
        border-bottom: 1px solid #dee2e6;
        background-color: #f8f9fa;
        flex-shrink: 0;
    }
    
    .modal-body {
        flex: 1;
        overflow-y: auto;
        padding: 1rem 1.25rem;
    }
    
    .modal-footer {
        border-top: 1px solid #dee2e6;
        background-color: #f8f9fa;
        flex-shrink: 0;
    }
    
    .form-control-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.25rem;
    }
    
    .form-select-sm {
        padding: 0.375rem 2.25rem 0.375rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.25rem;
    }
    .table-responsive { width: 100%; overflow-x: auto; }
    
    /* Responsive user card layout */
    @media (max-width: 768px) {
        .user-left {
            width: 25% !important;
            min-width: 120px !important;
        }
        .user-right {
            width: 75% !important;
        }
        .user-avatar {
            width: 60px !important;
            height: 60px !important;
        }
        .user-avatar img {
            width: 60px !important;
            height: 60px !important;
        }
        .avatar-placeholder {
            width: 60px !important;
            height: 60px !important;
        }
        .user-name {
            font-size: 0.75rem !important;
            max-width: 110px !important;
        }
    }
    
    @media (min-width: 1200px) {
        .user-left {
            width: 25% !important;
        }
        .user-right {
            width: 75% !important;
        }
    }
    
    /* Modal title color */
    .modal-title {
        color: #000000 !important;
    }
    
    /* Edit Modal Styles */
    #editUserModal .modal-content {
        position: relative;
        z-index: 1050;
    }
    
    /* Confirmation Modal Styles (nested) */
    #confirmUpdateModal {
        z-index: 1060;
    }
    
    #confirmUpdateModal .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1059;
    }
    
    #confirmUpdateModal .modal-content {
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        box-shadow: 0 2rem 6rem rgba(0, 0, 0, 0.7), 0 1rem 3rem rgba(0, 0, 0, 0.5), 0 0.5rem 1.5rem rgba(0, 0, 0, 0.3);
        z-index: 1060;
        background: #fff;
    }
    
    #confirmUpdateModal .modal-dialog {
        z-index: 1061;
        position: relative;
        transition: transform 0.2s ease-in-out;
        filter: drop-shadow(0 0 2rem rgba(0, 0, 0, 0.3));
    }
    
    #confirmUpdateModal .modal-content {
        transition: box-shadow 0.2s ease-in-out;
    }
    
    #confirmUpdateModal .modal-content:hover {
        box-shadow: 0 3rem 8rem rgba(0, 0, 0, 0.8), 0 2rem 5rem rgba(0, 0, 0, 0.6), 0 1rem 2.5rem rgba(0, 0, 0, 0.4);
    }
    
    /* Enhanced shadow when modal is shown */
    #confirmUpdateModal.modal.show .modal-content {
        box-shadow: 0 4rem 10rem rgba(0, 0, 0, 0.8), 0 2rem 6rem rgba(0, 0, 0, 0.6), 0 1rem 3rem rgba(0, 0, 0, 0.4), 0 0 0 2px rgba(0, 123, 255, 0.2);
    }
    
    #confirmUpdateModal .modal-header {
        background: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        border-radius: 0.5rem 0.5rem 0 0;
    }
    
    #confirmUpdateModal .modal-body {
        padding: 1.5rem;
        background: #fff;
    }
    
    #confirmUpdateModal .modal-footer {
        background: #f8f9fa;
        border-top: 1px solid #dee2e6;
        border-radius: 0 0 0.5rem 0.5rem;
        padding: 1rem 1.5rem;
    }
    
    #confirmUpdateModal .modal-title {
        color: #000;
        font-weight: 600;
    }
    
    #confirmUpdateModal p,
    #confirmUpdateModal small {
        color: #333;
    }
    
    #confirmUpdateModal .btn {
        border-radius: 0.375rem;
        font-weight: 500;
        padding: 0.5rem 1rem;
    }
    
    #confirmUpdateModal .btn-primary {
        background: #0d6efd;
        border: 1px solid #0d6efd;
        color: #fff;
    }
    
    #confirmUpdateModal .btn-primary:hover {
        background: #0b5ed7;
        border-color: #0a58ca;
    }
    
    #confirmUpdateModal .btn-secondary {
        background: #6c757d;
        border: 1px solid #6c757d;
        color: #000000;
    }
    
    #confirmUpdateModal .btn-secondary:hover {
        background: #5c636a;
        border-color: #565e64;
    }
    
    #confirmUpdateModal .text-warning {
        color: #ffc107;
    }
    
    
    /* Disabled input styling */
    #editUserForm input[disabled],
    #editUserForm input[readonly] {
        background-color: #f8f9fa !important;
        color: #000000 !important;
        cursor: default;
        opacity: 1;
    }
    
    #editUserForm input[disabled]:focus,
    #editUserForm input[readonly]:focus {
        box-shadow: none;
        border-color: #ced4da;
    }
    
    /* Removed blur effects - keeping it simple */
    
    /* Confirmation modal styles */
    
    /* Ensure confirmation modal appears above everything */
    #confirmUpdateModal.modal.show {
        z-index: 1060;
    }
    
    #confirmUpdateModal.modal.show .modal-dialog {
        z-index: 1061;
    }
    
    /* Force modal to be visible */
    #confirmUpdateModal.modal {
        display: none !important;
    }
    
    #confirmUpdateModal.modal.show {
        display: flex !important;
        align-items: center;
        justify-content: center;
        opacity: 1 !important;
        visibility: visible !important;
    }
    
    #confirmUpdateModal.modal.show .modal-dialog {
        transform: scale(1) !important;
        opacity: 1 !important;
    }
    
    /* Override Bootstrap modal styles */
    #confirmUpdateModal.modal.fade .modal-dialog {
        transition: transform 0.3s ease-out;
        transform: scale(1);
    }
    
    #confirmUpdateModal.modal.show .modal-dialog {
        transform: scale(1) !important;
    }
</style>
@endpush

{{-- Include pagination styles --}}
@include('components.pagination-styles')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    // Global function for balance calculation
    let calculateTimeout;
    function calculateNewBalance() {
        console.log('calculateNewBalance called'); // Debug log
        clearTimeout(calculateTimeout);
        calculateTimeout = setTimeout(() => {
            const currentBalance = parseFloat(document.getElementById('current_balance').value) || 0;
            const balanceAdjustmentInput = document.getElementById('balance_adjustment').value.trim();
            const balanceAdjustment = balanceAdjustmentInput === '' ? 0 : parseFloat(balanceAdjustmentInput) || 0;
            const newBalance = currentBalance + balanceAdjustment;
            
            console.log('Current:', currentBalance, 'Adjustment:', balanceAdjustment, 'New:', newBalance); // Debug log
            
            // Update preview field
            const previewField = document.getElementById('new_balance_preview');
            if (previewField) {
                previewField.value = newBalance.toFixed(2);
                
                // Change color based on whether it's positive or negative
                if (newBalance < 0) {
                    previewField.style.backgroundColor = '#fef2f2';
                    previewField.style.color = '#dc2626';
                    previewField.style.borderColor = '#fca5a5';
                } else if (balanceAdjustment > 0) {
                    previewField.style.backgroundColor = '#ecfdf5';
                    previewField.style.color = '#059669';
                    previewField.style.borderColor = '#10b981';
                } else if (balanceAdjustment < 0) {
                    previewField.style.backgroundColor = '#fef3c7';
                    previewField.style.color = '#d97706';
                    previewField.style.borderColor = '#f59e0b';
                } else {
                    // No adjustment or adjustment is 0
                    previewField.style.backgroundColor = '#f8f9fa';
                    previewField.style.color = '#6b7280';
                    previewField.style.borderColor = '#d1d5db';
                }
            } else {
                console.error('new_balance_preview field not found');
            }
        }, 100); // 100ms debounce
    }

    (function() {
        const openBtn = document.getElementById('openCreateUserModal');
        const closeBtn = document.getElementById('closeCreateUserModal');
        const modal = document.getElementById('createUserModal');
        const submitBtn = document.getElementById('submitCreateUser');
        const form = document.getElementById('createUserForm');
        const errorBox = document.getElementById('createUserError');
        const fillSampleDataBtn = document.getElementById('fillSampleData');

        const i18n = {
            enterName: "{{ __('admin::cms.validation_enter_name') }}",
            enterPhone: "{{ __('admin::cms.validation_enter_phone') }}",
            enterPassword: "{{ __('admin::cms.validation_enter_password') }}",
            enterPasswordConfirmation: "{{ __('admin::cms.validation_enter_password_confirmation') }}",
            passwordMismatch: "{{ __('admin::cms.validation_password_mismatch') }}",
            enterReferral: "{{ __('admin::cms.validation_enter_referral_code') }}",
            saving: "{{ __('admin::cms.saving') }}",
            errorGeneric: "{{ __('admin::cms.error_generic') }}",
            networkError: "{{ __('admin::cms.error_network') }}",
            createdSuccess: "{{ __('admin::cms.created_success') }}",
        };

        function openModal(e) {
            if (e) e.preventDefault();
            errorBox.style.display = 'none';
            errorBox.innerHTML = '';
            modal.style.display = 'flex';
        }
        function closeModal() {
            modal.style.display = 'none';
        }

        openBtn && openBtn.addEventListener('click', openModal);
        closeBtn && closeBtn.addEventListener('click', closeModal);
        modal && modal.addEventListener('click', function(e){ if (e.target === modal) closeModal(); });

        // Fill sample data function
        function fillSampleData() {
            const sampleData = {
                name: 'Nguyễn Văn A',
                phone: '0123456789',
                password: '123456',
                password_confirmation: '123456',
                referral_code: 'REF001'
            };
            
            // Fill form fields
            Object.keys(sampleData).forEach(key => {
                const fieldId = 'cu_' + key;
                const field = document.getElementById(fieldId);
                if (field) {
                    field.value = sampleData[key];
                }
            });
            
            // Clear any existing errors
            clearFieldErrors();
            
            // Show success message
            if (window.showToast) {
                window.showToast("{{ __('admin::cms.sample_data_filled') }}", { type: 'success' });
            }
        }

        // Event listener for fill sample data button
        fillSampleDataBtn && fillSampleDataBtn.addEventListener('click', fillSampleData);

        function showErrors(messages) {
            // Deprecated: use toast instead; keep for compatibility but do nothing visible
            const list = Array.isArray(messages) ? messages : (typeof messages === 'string' ? [messages] : Object.values(messages).flat());
            if (window.showToast && list.length) {
                window.showToast(list[0], { type: 'error' });
            }
        }

        function clearFieldErrors() {
            document.querySelectorAll('.field-error').forEach(el => { el.style.display = 'none'; el.textContent = ''; });
            ['cu_name','cu_phone','cu_password','cu_password_confirmation','cu_referral_code'].forEach(id => {
                const input = document.getElementById(id);
                if (input) input.style.borderColor = 'var(--gray-400)';
            });
        }

        function setFieldError(field, message) {
            const map = {
                name: 'cu_name',
                phone: 'cu_phone',
                password: 'cu_password',
                password_confirmation: 'cu_password_confirmation',
                referral_code: 'cu_referral_code'
            };
            const inputId = map[field];
            if (!inputId) return;
            const input = document.getElementById(inputId);
            if (input) input.style.borderColor = 'var(--danger-color)';
            // No inline error text; toast is used for messaging
        }

        function markInvalid(ids) {
            ids.forEach(id => {
                const input = document.getElementById(id);
                if (input) input.style.borderColor = 'var(--danger-color)';
            });
        }

        submitBtn && submitBtn.addEventListener('click', function() {
            errorBox.style.display = 'none';
            clearFieldErrors();
            const name = document.getElementById('cu_name').value.trim();
            const phone = document.getElementById('cu_phone').value.trim();
            const password = document.getElementById('cu_password').value;
            const password_confirmation = document.getElementById('cu_password_confirmation').value;
            const referral_code = document.getElementById('cu_referral_code').value.trim();

            const clientErrors = [];
            if (!name) clientErrors.push(i18n.enterName);
            if (!phone) clientErrors.push(i18n.enterPhone);
            if (!password) clientErrors.push(i18n.enterPassword);
            if (!password_confirmation) clientErrors.push(i18n.enterPasswordConfirmation);
            if (password && password_confirmation && password !== password_confirmation) clientErrors.push(i18n.passwordMismatch);
            if (!referral_code) clientErrors.push(i18n.enterReferral);

            if (clientErrors.length) {
                const invalidIds = [];
                if (!name) invalidIds.push('cu_name');
                if (!phone) invalidIds.push('cu_phone');
                if (!password) invalidIds.push('cu_password');
                if (!password_confirmation || (password && password_confirmation && password !== password_confirmation)) invalidIds.push('cu_password_confirmation');
                if (!referral_code) invalidIds.push('cu_referral_code');
                markInvalid(invalidIds);
                if (window.showToast) { window.showToast(clientErrors[0], { type: 'error' }); }
                return;
            }

            submitBtn.disabled = true;
            const originalHtml = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="loading" style="width:16px; height:16px; border-width:2px; margin-right:6px;"></span> ' + i18n.saving;

            axios.post("{{ route('admin.user-management.store') }}", {
                name,
                phone,
                password,
                password_confirmation,
                referral_code
            }, {
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
            }).then(function(res){
                if (res.data && res.data.success) {
                    closeModal();
                    if (window.showToast) { window.showToast(i18n.createdSuccess, { type: 'success' }); }
                    location.reload();
                } else {
                    const msg = res.data && (res.data.message || res.data.errors) || i18n.errorGeneric;
                    if (window.showToast) { window.showToast(Array.isArray(msg) ? msg[0] : String(msg), { type: 'error' }); }
                }
            }).catch(function(err){
                if (err.response && err.response.data) {
                    const data = err.response.data;
                    if (data && data.errors && typeof data.errors === 'object') {
                        Object.keys(data.errors).forEach(k => setFieldError(k));
                        const firstError = Object.values(data.errors)[0];
                        if (window.showToast) { window.showToast(Array.isArray(firstError) ? firstError[0] : String(firstError), { type: 'error' }); }
                    } else {
                        if (window.showToast) { window.showToast(data.message || i18n.errorGeneric, { type: 'error' }); }
                    }
                } else {
                    if (window.showToast) { window.showToast(i18n.networkError, { type: 'error' }); }
                }
            }).finally(function(){
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;
            });
        });
    })();

    // Edit User Modal Script
    (function() {
        // Wait for DOM to be ready
        function initEditModal() {
            const editModal = document.getElementById('editUserModal');
            const closeEditBtn = document.getElementById('closeEditUserModal');
            const submitEditBtn = document.getElementById('submitEditUser');
            const editForm = document.getElementById('editUserForm');
            const editErrorBox = document.getElementById('editUserError');
            
            if (!editModal || !closeEditBtn || !submitEditBtn || !editForm || !editErrorBox) {
                console.error('Edit modal elements not found!');
                return;
            }

            const editI18n = {
                updating: "{{ __('admin::cms.updating') }}",
                errorGeneric: "{{ __('admin::cms.error_generic') }}",
                networkError: "{{ __('admin::cms.error_network') }}",
                updatedSuccess: "{{ __('admin::cms.updated_success') }}",
                
                // Validation messages
                validationNameRequired: "{{ __('admin::cms.validation_name_required') }}",
                validationPhoneRequired: "{{ __('admin::cms.validation_phone_required') }}",
                validationEmailRequired: "{{ __('admin::cms.validation_email_required') }}",
                validationGioiTinhRequired: "{{ __('admin::cms.validation_gioi_tinh_required') }}",
                validationNgaySinhRequired: "{{ __('admin::cms.validation_ngay_sinh_required') }}",
                validationDiaChiRequired: "{{ __('admin::cms.validation_dia_chi_required') }}",
                validationSoDuRequired: "{{ __('admin::cms.validation_so_du_required') }}",
                validationLuotTrungRequired: "{{ __('admin::cms.validation_luot_trung_required') }}",
                validationNganHangRequired: "{{ __('admin::cms.validation_ngan_hang_required') }}",
                validationSoTaiKhoanRequired: "{{ __('admin::cms.validation_so_tai_khoan_required') }}",
                validationChuTaiKhoanRequired: "{{ __('admin::cms.validation_chu_tai_khoan_required') }}",
                validationCapDoRequired: "{{ __('admin::cms.validation_cap_do_required') }}",
                validationGiaiThuongIdRequired: "{{ __('admin::cms.validation_giai_thuong_id_required') }}",
                
                validationEmailInvalid: "{{ __('admin::cms.validation_email_invalid') }}",
                validationPhoneInvalid: "{{ __('admin::cms.validation_phone_invalid') }}",
                validationSoDuInvalid: "{{ __('admin::cms.validation_so_du_invalid') }}",
                validationLuotTrungInvalid: "{{ __('admin::cms.validation_luot_trung_invalid') }}",
                validationNgaySinhFormat: "{{ __('admin::cms.validation_ngay_sinh_format') }}",
                validationNgaySinhFuture: "{{ __('admin::cms.validation_ngay_sinh_future') }}",
            };

            function openEditModal(e) {
                if (e) e.preventDefault();
                editErrorBox.style.display = 'none';
                editErrorBox.innerHTML = '';
                // Use Bootstrap modal show method
                const modal = new bootstrap.Modal(editModal);
                modal.show();
            }

            function closeEditModal() {
                // Use global closeModal function to close only this modal
                closeModal('editUserModal');
            }

            function clearEditFieldErrors() {
                // Clear error messages
                document.querySelectorAll('#editUserForm .field-error').forEach(el => { 
                    el.style.display = 'none'; 
                    el.textContent = ''; 
                });
                
                // Reset border colors (bỏ edit_phone và edit_email)
                const editFields = ['edit_name','edit_gioi_tinh','edit_ngay_sinh','edit_dia_chi','edit_so_du','edit_luot_trung','edit_ngan_hang','edit_so_tai_khoan','edit_chu_tai_khoan','edit_cap_do','edit_giai_thuong_id','edit_anh_mat_truoc','edit_anh_mat_sau','edit_anh_chan_dung','edit_anh_chan_dung_small'];
                editFields.forEach(id => {
                    const input = document.getElementById(id);
                    if (input) {
                        input.style.borderColor = '#d1d5db';
                        // Remove any existing error div
                        const errorDiv = input.parentNode.querySelector('.field-error');
                        if (errorDiv) {
                            errorDiv.remove();
                        }
                    }
                });
            }

            function setEditFieldError(field, message) {
                const input = document.getElementById('edit_' + field);
                if (input) {
                    input.style.borderColor = '#dc2626';
                    // Show error message via toast
                    if (window.showToast) { 
                        window.showToast(message, { type: 'error' }); 
                    }
                }
            }

            function validateEditForm() {
                // Clear previous errors
                clearEditFieldErrors();
                
                // Required fields validation (chỉ validate name, bỏ email và phone)
                const requiredFields = [
                    { id: 'edit_name', name: 'Tên', message: editI18n.validationNameRequired },
                    { id: 'edit_gioi_tinh', name: 'Giới tính', message: editI18n.validationGioiTinhRequired },
                    { id: 'edit_ngay_sinh', name: 'Ngày sinh', message: editI18n.validationNgaySinhRequired },
                    { id: 'edit_dia_chi', name: 'Địa chỉ', message: editI18n.validationDiaChiRequired },
                    { id: 'edit_so_du', name: 'Số dư', message: editI18n.validationSoDuRequired },
                    { id: 'edit_luot_trung', name: 'Lượt trúng', message: editI18n.validationLuotTrungRequired },
                    { id: 'edit_ngan_hang', name: 'Ngân hàng', message: editI18n.validationNganHangRequired },
                    { id: 'edit_so_tai_khoan', name: 'Số tài khoản', message: editI18n.validationSoTaiKhoanRequired },
                    { id: 'edit_chu_tai_khoan', name: 'Chủ tài khoản', message: editI18n.validationChuTaiKhoanRequired },
                    { id: 'edit_cap_do', name: 'Cấp độ', message: editI18n.validationCapDoRequired },
                    { id: 'edit_giai_thuong_id', name: 'Giải thưởng ID', message: editI18n.validationGiaiThuongIdRequired }
                ];
                
                // Check required fields - return first error
                for (const field of requiredFields) {
                    const input = document.getElementById(field.id);
                    if (!input || !input.value.trim()) {
                        if (input) {
                            input.style.borderColor = '#dc2626';
                            input.focus();
                        }
                        if (window.showToast) { 
                            window.showToast(field.message, { type: 'error' }); 
                        }
                        return false;
                    }
                }
                
                // Bỏ validation cho email và phone vì không cập nhật
                
                // Number validation for so_du
                const soDuInput = document.getElementById('edit_so_du');
                if (soDuInput && soDuInput.value.trim()) {
                    if (isNaN(soDuInput.value.trim()) || parseFloat(soDuInput.value.trim()) < 0) {
                        soDuInput.style.borderColor = '#dc2626';
                        soDuInput.focus();
                        if (window.showToast) { 
                            window.showToast(editI18n.validationSoDuInvalid, { type: 'error' }); 
                        }
                        return false;
                    }
                }
                
                // Number validation for luot_trung
                const luotTrungInput = document.getElementById('edit_luot_trung');
                if (luotTrungInput && luotTrungInput.value.trim()) {
                    if (isNaN(luotTrungInput.value.trim()) || parseInt(luotTrungInput.value.trim()) < 0) {
                        luotTrungInput.style.borderColor = '#dc2626';
                        luotTrungInput.focus();
                        if (window.showToast) { 
                            window.showToast(editI18n.validationLuotTrungInvalid, { type: 'error' }); 
                        }
                        return false;
                    }
                }
                
                // Date validation
                const ngaySinhInput = document.getElementById('edit_ngay_sinh');
                if (ngaySinhInput && ngaySinhInput.value.trim()) {
                    const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
                    if (!dateRegex.test(ngaySinhInput.value.trim())) {
                        ngaySinhInput.style.borderColor = '#dc2626';
                        ngaySinhInput.focus();
                        if (window.showToast) { 
                            window.showToast(editI18n.validationNgaySinhFormat, { type: 'error' }); 
                        }
                        return false;
                    } else {
                        const inputDate = new Date(ngaySinhInput.value.trim());
                        const today = new Date();
                        if (inputDate > today) {
                            ngaySinhInput.style.borderColor = '#dc2626';
                            ngaySinhInput.focus();
                            if (window.showToast) { 
                                window.showToast(editI18n.validationNgaySinhFuture, { type: 'error' }); 
                            }
                            return false;
                        }
                    }
                }
                
                return true;
            }


            // Event listeners for edit modal
            closeEditBtn.addEventListener('click', closeEditModal);
            editModal.addEventListener('click', function(e){ if (e.target === editModal) closeEditModal(); });



            // Image preview updates
            document.getElementById('edit_anh_mat_truoc')?.addEventListener('input', function() {
                updateImagePreview('edit_anh_mat_truoc', 'preview_anh_mat_truoc');
            });
            document.getElementById('edit_anh_mat_sau')?.addEventListener('input', function() {
                updateImagePreview('edit_anh_mat_sau', 'preview_anh_mat_sau');
            });
            document.getElementById('edit_anh_chan_dung')?.addEventListener('input', function() {
                updateImagePreview('edit_anh_chan_dung', 'preview_anh_chan_dung');
            });

            // Fill sample data function
            function fillSampleData() {
                // Sample data for all form fields
                const sampleData = {
                    name: 'Nguyễn Văn A',
                    // phone: '0123456789',
                    // email: 'nguyenvana@example.com',
                    gioi_tinh: 'Nam',
                    ngay_sinh: '1990-01-15',
                    dia_chi: '123 Đường ABC, Quận 1, TP.HCM',
                    so_du: '1000000',
                    luot_trung: '5',
                    ngan_hang: 'Vietcombank',
                    so_tai_khoan: '1234567890',
                    chu_tai_khoan: 'Nguyễn Văn A',
                    cap_do: 'VIP',
                    giai_thuong_id: '1',
                    anh_chan_dung: 'https://via.placeholder.com/200x250/4F46E5/FFFFFF?text=Portrait',
                    anh_mat_truoc: 'https://via.placeholder.com/300x200/10B981/FFFFFF?text=Front+ID',
                    anh_mat_sau: 'https://via.placeholder.com/300x200/EF4444/FFFFFF?text=Back+ID'
                };
                
                // Fill all form fields with sample data
                Object.keys(sampleData).forEach(fieldName => {
                    const field = document.getElementById(`edit_${fieldName}`);
                    if (field) {
                        field.value = sampleData[fieldName];
                        
                        // Trigger change event for select fields
                        if (field.tagName === 'SELECT') {
                            field.dispatchEvent(new Event('change'));
                        }
                        
                        // Update image previews
                        if (fieldName === 'anh_chan_dung') {
                            updateImagePreview('edit_anh_chan_dung', 'preview_anh_chan_dung');
                        } else if (fieldName === 'anh_mat_truoc') {
                            updateImagePreview('edit_anh_mat_truoc', 'preview_anh_mat_truoc');
                        } else if (fieldName === 'anh_mat_sau') {
                            updateImagePreview('edit_anh_mat_sau', 'preview_anh_mat_sau');
                        }
                    }
                });
                
                // Show success message
                if (window.showToast) {
                    window.showToast("{{ __('admin::cms.sample_data_filled') }}", { type: 'success' });
                }
            }
            
            // Fill sample data button event listener
            document.getElementById('fillSampleDataBtn').addEventListener('click', function() {
                fillSampleData();
            });

            // Submit edit form
            submitEditBtn.addEventListener('click', function() {
                editErrorBox.style.display = 'none';
                clearEditFieldErrors();
                
                // Validate form before submitting
                if (!validateEditForm()) {
                    return; // Stop if validation fails
                }
                
                // Show Bootstrap confirmation modal
                const confirmModal = new bootstrap.Modal(document.getElementById('confirmUpdateModal'), {
                    backdrop: 'static',
                    keyboard: false,
                    focus: true
                });
                confirmModal.show();
            });

            // Handle confirmation modal
            document.getElementById('confirmUpdateBtn').addEventListener('click', function() {
                // Close confirmation modal
                const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmUpdateModal'));
                confirmModal.hide();
                
                // Proceed with update
                performUpdate();
            });

            function performUpdate() {
                const formData = new FormData(editForm);
                const data = Object.fromEntries(formData.entries());
                
                // Loại bỏ email và phone khỏi dữ liệu gửi đi
                delete data.email;
                delete data.phone;
                
                submitEditBtn.disabled = true;
                const originalHtml = submitEditBtn.innerHTML;
                submitEditBtn.innerHTML = '<span class="loading" style="width:16px; height:16px; border-width:2px; margin-right:6px;"></span> ' + editI18n.updating;

                axios.put(`/admin/user-management/${data.user_id}`, data, {
                    headers: { 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                }).then(function(res) {
                    if (res.data && res.data.success) {
                        closeModal('editUserModal');
                        if (window.showToast) { 
                            window.showToast(editI18n.updatedSuccess, { type: 'success' }); 
                        }
                        // Auto reload after 3 seconds
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    } else {
                        const msg = res.data && (res.data.message || res.data.errors) || editI18n.errorGeneric;
                        if (window.showToast) { 
                            window.showToast(Array.isArray(msg) ? msg[0] : String(msg), { type: 'error' }); 
                        }
                    }
                }).catch(function(err) {
                    if (err.response && err.response.data) {
                        const data = err.response.data;
                        if (data && data.errors && typeof data.errors === 'object') {
                            // Highlight fields with errors
                            Object.keys(data.errors).forEach(k => {
                                const input = document.getElementById('edit_' + k);
                                if (input) input.style.borderColor = '#dc2626';
                            });
                            const firstError = Object.values(data.errors)[0];
                            if (window.showToast) { 
                                window.showToast(Array.isArray(firstError) ? firstError[0] : String(firstError), { type: 'error' }); 
                            }
                        } else {
                            if (window.showToast) { 
                                window.showToast(data.message || editI18n.errorGeneric, { type: 'error' }); 
                            }
                        }
                    } else {
                        if (window.showToast) { 
                            window.showToast(editI18n.networkError, { type: 'error' }); 
                        }
                    }
                }).finally(function() {
                    submitEditBtn.disabled = false;
                    submitEditBtn.innerHTML = originalHtml;
                });
            }
        }
        
        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initEditModal);
        } else {
            initEditModal();
        }
    })();

    // Global function for loading user data from user object
    function loadUserDataFromButton(user) {
        const editModal = document.getElementById('editUserModal');
        const editErrorBox = document.getElementById('editUserError');
        
        if (!editModal || !editErrorBox) {
            console.error('Edit modal elements not found!');
            return;
        }

        // Clear errors
        document.querySelectorAll('#editUserForm .field-error').forEach(el => { 
            el.style.display = 'none'; 
            el.textContent = ''; 
        });
        editErrorBox.style.display = 'none';
        
        // Khai báo dữ liệu mẫu bên trong hàm
        const data = {
            user_id: user.id,
            name: user.name || '',
            phone: user.phone || '',
            email: user.email || '',
            gioi_tinh: user?.profile?.gioi_tinh || '',
            ngay_sinh: user?.profile?.ngay_sinh || '',
            dia_chi: user?.profile?.dia_chi || '',
            so_du: user?.profile?.so_du || 0,
            luot_trung: user?.profile?.luot_trung || 0,
            ngan_hang: user?.profile?.ngan_hang || '',
            so_tai_khoan: user?.profile?.so_tai_khoan || '',
            chu_tai_khoan: user?.profile?.chu_tai_khoan || '',
            cap_do: user?.profile?.cap_do || '',
            giai_thuong_id: user?.profile?.giai_thuong_id || '',
            anh_mat_truoc: user?.profile?.anh_mat_truoc || '',
            anh_mat_sau: user?.profile?.anh_mat_sau || '',
            anh_chan_dung: user?.profile?.anh_chan_dung || ''
        };
        
        // Fill form fields with null safety
        const setValue = (id, value) => {
            const element = document.getElementById(id);
            if (element) element.value = value || '';
        };
        
        setValue('edit_user_id', data.user_id);
        setValue('edit_name', data.name);
        setValue('edit_phone', data.phone);
        setValue('edit_email', data.email);
        setValue('edit_gioi_tinh', data.gioi_tinh);
        setValue('edit_ngay_sinh', data.ngay_sinh);
        setValue('edit_dia_chi', data.dia_chi);
        setValue('edit_so_du', data.so_du);
        setValue('edit_luot_trung', data.luot_trung);
        setValue('edit_ngan_hang', data.ngan_hang);
        setValue('edit_so_tai_khoan', data.so_tai_khoan);
        setValue('edit_chu_tai_khoan', data.chu_tai_khoan);
        setValue('edit_cap_do', data.cap_do);
        setValue('edit_giai_thuong_id', data.giai_thuong_id);
        setValue('edit_anh_mat_truoc', data.anh_mat_truoc);
        setValue('edit_anh_mat_sau', data.anh_mat_sau);
        setValue('edit_anh_chan_dung', data.anh_chan_dung);
        setValue('edit_anh_chan_dung_small', data.anh_chan_dung);
        
        // Update user display info with null safety
        const setTextContent = (id, text) => {
            const element = document.getElementById(id);
            if (element) element.textContent = text || '';
        };
        
        setTextContent('edit_user_name_display', data.name || 'User Name');
        setTextContent('edit_user_email_display', data.email || 'user@example.com');
        setTextContent('edit_user_phone_display', data.phone || '+84 123 456 789');
        
        // Update image previews with null safety
        updateImagePreview('edit_anh_mat_truoc', 'preview_anh_mat_truoc');
        updateImagePreview('edit_anh_mat_sau', 'preview_anh_mat_sau');
        updateImagePreview('edit_anh_chan_dung', 'preview_anh_chan_dung');
        
        // Add error handling for existing images
        const imageElements = ['preview_anh_mat_truoc', 'preview_anh_mat_sau', 'preview_anh_chan_dung'];
        imageElements.forEach(imgId => {
            const img = document.getElementById(imgId);
            const placeholder = document.getElementById(imgId + '_placeholder');
            if (img && placeholder) {
                img.onerror = function() {
                    // Image failed to load, show placeholder
                    img.classList.add('d-none');
                    placeholder.classList.remove('d-none');
                };
            }
        });
        
        // Open modal
        const modal = new bootstrap.Modal(editModal);
        modal.show();
    }

    // Global i18n object for delete functionality
    const deleteI18n = {
        deleting: "{{ __('admin::cms.deleting') }}",
        errorGeneric: "{{ __('admin::cms.error_generic') }}",
        networkError: "{{ __('admin::cms.error_network') }}",
        deletedSuccess: "{{ __('admin::cms.deleted_success') }}",
        confirmDeleteUser: "{{ __('admin::cms.confirm_delete_user') }}",
        confirmDeleteMessage: "{{ __('admin::cms.confirm_delete_message') }}",
        confirmDeleteTitle: "{{ __('admin::cms.confirm_delete') }}",
        confirmDeleteDescription: "{{ __('admin::cms.confirm_delete_description') }}"
    };

    // Global function for updating image preview
    function updateImagePreview(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const placeholder = document.getElementById(previewId + '_placeholder');
        
        if (input && preview) {
            const url = input.value ? input.value.trim() : '';
            if (url) {
                // Show placeholder while loading
                preview.classList.add('d-none');
                if (placeholder) placeholder.classList.remove('d-none');
                
                // Create new image to test if URL is valid
                const testImg = new Image();
                testImg.onload = function() {
                    // Image loaded successfully
                    preview.src = url;
                    preview.classList.remove('d-none');
                    if (placeholder) placeholder.classList.add('d-none');
                };
                testImg.onerror = function() {
                    // Image failed to load, keep showing placeholder
                    preview.classList.add('d-none');
                    if (placeholder) placeholder.classList.remove('d-none');
                };
                testImg.src = url;
            } else {
                preview.classList.add('d-none');
                if (placeholder) placeholder.classList.remove('d-none');
            }
        }
    }

    // Global function for showing delete confirmation
    function showDeleteConfirmation(userId, userName) {
        console.log('🔍 [DELETE] Hiển thị modal xác nhận xóa');
        console.log('📋 [DELETE] Dữ liệu:', { userId, userName });
        
        // Set global variables for delete process
        window.currentUserId = userId;
        window.currentUserName = userName;
        
        // Cập nhật message trong modal
        const confirmMessage = deleteI18n.confirmDeleteMessage.replace(':name', userName);
        const messageElement = document.getElementById('deleteConfirmMessage');
        if (messageElement) {
            messageElement.textContent = confirmMessage;
        }
        
        // Hiển thị modal
        const deleteModal = document.getElementById('deleteConfirmModal');
        if (deleteModal) {
            const modal = new bootstrap.Modal(deleteModal);
            
            // Thêm event listener để xử lý khi modal được ẩn
            deleteModal.addEventListener('hidden.bs.modal', function () {
                // Xóa backdrop nếu còn sót lại
                const backdrops = document.querySelectorAll('.modal-backdrop');
                backdrops.forEach(backdrop => backdrop.remove());
                
                // Xóa class modal-open từ body
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
            });
            
            modal.show();
        } else {
            console.error('❌ [DELETE] Không tìm thấy delete modal!');
        }
    }

    // Global function to close specific modal and clear backdrops
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            const bsModal = bootstrap.Modal.getInstance(modal);
            if (bsModal) {
                bsModal.hide();
            }
            
            // Clear backdrops after modal is hidden
            setTimeout(() => {
                const backdrops = document.querySelectorAll('.modal-backdrop');
                backdrops.forEach(backdrop => backdrop.remove());
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
            }, 150);
        }
    }

    // Global function for loading user data for balance adjustment
    function loadUserDataForAdjustment(button) {
        const adjustModal = document.getElementById('adjustBalanceModal');
        const adjustErrorBox = document.getElementById('adjustBalanceError');
        
        if (!adjustModal || !adjustErrorBox) {
            console.error('Adjust balance modal elements not found!');
            return;
        }

        // Clear errors
        document.querySelectorAll('#adjustBalanceForm .field-error').forEach(el => { 
            el.style.display = 'none'; 
            el.textContent = ''; 
        });
        adjustErrorBox.style.display = 'none';
        
        // Get data from button attributes
        const data = {
            user_id: button.getAttribute('data-user-id'),
            name: button.getAttribute('data-name') || '',
            current_balance: button.getAttribute('data-current-balance') || 0
        };
        
        console.log('📋 [ADJUST] Dữ liệu từ button:', data);
        
        // Fill form fields
        const setValue = (id, value) => {
            const element = document.getElementById(id);
            if (element) element.value = value || '';
        };
        
        setValue('adjust_user_id', data.user_id);
        setValue('current_balance', data.current_balance);
        setValue('balance_adjustment', ''); // Clear balance adjustment field
        setValue('new_balance_preview', data.current_balance); // Set initial value to current balance
        
        // Show modal
        const modal = new bootstrap.Modal(adjustModal);
        
        // Thêm event listener để xử lý khi modal được ẩn
        adjustModal.addEventListener('hidden.bs.modal', function () {
            // Xóa backdrop nếu còn sót lại
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => backdrop.remove());
            
            // Xóa class modal-open từ body
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        });
        
        modal.show();
    }

    // Delete User with Bootstrap Modal Confirmation Script
    (function() {
        // Global variables for delete functionality
        let currentUserId = null;
        let currentUserName = '';
        let deleteModal = null;


        function initDeleteUser() {
            console.log('🔧 [DELETE] Khởi tạo chức năng xóa người dùng với Bootstrap modal');
            
            deleteModal = document.getElementById('deleteConfirmModal');
            const deleteUserBtns = document.querySelectorAll('.delete-user-btn');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            
            console.log('📋 [DELETE] Tìm thấy:', {
                modal: deleteModal ? 'Có' : 'Không',
                deleteButtons: deleteUserBtns.length,
                confirmButton: confirmDeleteBtn ? 'Có' : 'Không'
            });

            if (!deleteModal || !confirmDeleteBtn) {
                console.error('❌ [DELETE] Không tìm thấy modal hoặc nút xác nhận!');
                return;
            }

            // Event listeners for delete buttons - REMOVED because using onclick directly
            // deleteUserBtns.forEach((btn, index) => {
            //     console.log(`🔗 [DELETE] Thêm event listener cho nút xóa ${index + 1}`);
            //     btn.addEventListener('click', function() {
            //         const userId = this.getAttribute('data-user-id');
            //         const userName = this.getAttribute('data-name');
            //         console.log(`🖱️ [DELETE] Click nút xóa ${index + 1}:`, { userId, userName });
            //         showDeleteConfirmation(userId, userName);
            //     });
            // });

            // Event listener for confirm delete button
            confirmDeleteBtn.addEventListener('click', function() {
                console.log('✅ [DELETE] Người dùng xác nhận xóa từ modal');
                performDelete();
            });
            
            console.log('✅ [DELETE] Khởi tạo hoàn tất');
            
            // Removed test delete trigger button and listener
        }

        function showDeleteConfirmation(userId, userName) {
            console.log('🔍 [DELETE] Bước 1: Hiển thị Bootstrap modal xác nhận xóa');
            console.log('📋 [DELETE] Dữ liệu:', { userId, userName });
            
            currentUserId = userId;
            currentUserName = userName;
            
            // Cập nhật message trong modal
            const confirmMessage = deleteI18n.confirmDeleteMessage.replace(':name', userName);
            const messageElement = document.getElementById('deleteConfirmMessage');
            if (messageElement) {
                messageElement.textContent = confirmMessage;
            }
            
            console.log('💬 [DELETE] Hiển thị modal với message:', confirmMessage);
            
            // Hiển thị Bootstrap modal
            const modal = new bootstrap.Modal(deleteModal, {
                backdrop: true,
                keyboard: true,
                focus: true
            });
            modal.show();
            console.log('✅ [DELETE] Modal đã hiển thị');
        }

        function performDelete() {
            console.log('🚀 [DELETE] Bước 2: Bắt đầu thực hiện xóa người dùng');
            console.log('📋 [DELETE] Dữ liệu hiện tại:', { currentUserId: window.currentUserId, currentUserName: window.currentUserName });
            
            if (!window.currentUserId) {
                console.error('❌ [DELETE] Lỗi: Không có User ID để xóa');
                return;
            }

            // Hiển thị toast loading
            if (window.showToast) {
                window.showToast(deleteI18n.deleting, { 
                    type: 'info',
                    title: 'Đang xử lý...'
                });
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const deleteUrl = `/admin/user-management/${window.currentUserId}`;
            
            console.log('🌐 [DELETE] Bước 3: Gửi request DELETE');
            console.log('📡 [DELETE] URL:', deleteUrl);
            console.log('🔑 [DELETE] CSRF Token:', csrfToken ? 'Có' : 'Không');

            axios.delete(deleteUrl, {
                headers: { 
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                }
            }).then(function(res) {
                console.log('✅ [DELETE] Bước 4: Nhận response thành công');
                console.log('📊 [DELETE] Response data:', res.data);
                
                if (res.data && res.data.success) {
                    console.log('🎉 [DELETE] Xóa thành công!');
                    
                    // Đóng modal
                    const modal = bootstrap.Modal.getInstance(deleteModal);
                    if (modal) {
                        modal.hide();
                        console.log('✅ [DELETE] Modal đã đóng');
                        
                        // Đảm bảo backdrop được xóa hoàn toàn
                        setTimeout(() => {
                            const backdrops = document.querySelectorAll('.modal-backdrop');
                            backdrops.forEach(backdrop => backdrop.remove());
                            document.body.classList.remove('modal-open');
                            document.body.style.overflow = '';
                            document.body.style.paddingRight = '';
                        }, 150);
                    }
                    
                    if (window.showToast) { 
                        console.log('💬 [DELETE] Hiển thị thông báo thành công');
                        window.showToast(deleteI18n.deletedSuccess, { type: 'success' }); 
                    }
                    
                    console.log('⏰ [DELETE] Lên lịch reload trang sau 2 giây');
                    setTimeout(function() {
                        console.log('🔄 [DELETE] Reload trang');
                        location.reload();
                    }, 2000);
                } else {
                    const msg = res.data && (res.data.message || res.data.errors) || deleteI18n.errorGeneric;
                    console.log('⚠️ [DELETE] Response không thành công:', msg);
                    if (window.showToast) { 
                        window.showToast(Array.isArray(msg) ? msg[0] : String(msg), { type: 'error' }); 
                    }
                }
            }).catch(function(err) {
                console.log('❌ [DELETE] Bước 5: Xảy ra lỗi');
                console.log('🚨 [DELETE] Error object:', err);
                console.log('📊 [DELETE] Error response:', err.response);
                
                // Đóng modal khi có lỗi
                const modal = bootstrap.Modal.getInstance(deleteModal);
                if (modal) {
                    modal.hide();
                    setTimeout(() => {
                        const backdrops = document.querySelectorAll('.modal-backdrop');
                        backdrops.forEach(backdrop => backdrop.remove());
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';
                    }, 150);
                }
                
                if (err.response && err.response.data) {
                    const data = err.response.data;
                    console.log('📋 [DELETE] Error data:', data);
                    if (window.showToast) { 
                        window.showToast(data.message || deleteI18n.errorGeneric, { type: 'error' }); 
                    }
                } else {
                    console.log('🌐 [DELETE] Network error hoặc lỗi không xác định');
                    if (window.showToast) { 
                        window.showToast(deleteI18n.networkError, { type: 'error' }); 
                    }
                }
            }).finally(function() {
                console.log('✨ [DELETE] Quá trình xóa hoàn tất');
            });
        }
        
        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initDeleteUser);
        } else {
            initDeleteUser();
        }
    })();

    // Adjust Balance Modal Script
    (function() {
        function initAdjustBalanceModal() {
            const adjustModal = document.getElementById('adjustBalanceModal');
            const closeAdjustBtn = document.getElementById('closeAdjustBalanceModal');
            const submitAdjustBtn = document.getElementById('submitAdjustBalance');
            const adjustForm = document.getElementById('adjustBalanceForm');
            const adjustErrorBox = document.getElementById('adjustBalanceError');
            const adjustBalanceBtns = document.querySelectorAll('.adjust-balance-btn');
            
            if (!adjustModal || !closeAdjustBtn || !submitAdjustBtn || !adjustForm || !adjustErrorBox) {
                console.error('Adjust balance modal elements not found!');
                return;
            }

            const adjustI18n = {
                updating: "{{ __('admin::cms.updating') }}",
                errorGeneric: "{{ __('admin::cms.error_generic') }}",
                networkError: "{{ __('admin::cms.error_network') }}",
                updatedSuccess: "{{ __('admin::cms.updated_success') }}",
                
                // Validation messages
                validationBalanceAdjustmentRequired: "{{ __('admin::cms.validation_balance_adjustment_required') }}",
                validationBalanceAdjustmentInvalid: "{{ __('admin::cms.validation_balance_adjustment_invalid') }}",
                balanceCannotBeNegative: "{{ __('admin::cms.balance_cannot_be_negative') }}",
            };

            function openAdjustModal(e) {
                if (e) e.preventDefault();
                adjustErrorBox.style.display = 'none';
                adjustErrorBox.innerHTML = '';
                // Use Bootstrap modal show method
                const modal = new bootstrap.Modal(adjustModal);
                modal.show();
            }

            function closeAdjustModal() {
                // Use global closeModal function to close only this modal
                closeModal('adjustBalanceModal');
            }

            function clearAdjustFieldErrors() {
                // Clear error messages
                document.querySelectorAll('#adjustBalanceForm .field-error').forEach(el => { 
                    el.style.display = 'none'; 
                    el.textContent = ''; 
                });
                
                // Reset border colors
                const adjustFields = ['balance_adjustment'];
                adjustFields.forEach(id => {
                    const input = document.getElementById(id);
                    if (input) {
                        input.style.borderColor = '#d1d5db';
                    }
                });
            }

            function setAdjustFieldError(field, message) {
                const input = document.getElementById(field);
                if (input) {
                    input.style.borderColor = '#dc2626';
                    // Show error message via toast
                    if (window.showToast) { 
                        window.showToast(message, { type: 'error' }); 
                    }
                }
            }


            function validateAdjustForm() {
                // Clear previous errors
                clearAdjustFieldErrors();
                
                // Required fields validation
                const balanceAdjustment = document.getElementById('balance_adjustment').value.trim();
                
                if (!balanceAdjustment) {
                    document.getElementById('balance_adjustment').style.borderColor = '#dc2626';
                    document.getElementById('balance_adjustment').focus();
                    if (window.showToast) { 
                        window.showToast(adjustI18n.validationBalanceAdjustmentRequired, { type: 'error' }); 
                    }
                    return false;
                }
                
                if (isNaN(balanceAdjustment)) {
                    document.getElementById('balance_adjustment').style.borderColor = '#dc2626';
                    document.getElementById('balance_adjustment').focus();
                    if (window.showToast) { 
                        window.showToast(adjustI18n.validationBalanceAdjustmentInvalid, { type: 'error' }); 
                    }
                    return false;
                }
                
                // Check if new balance would be negative
                const currentBalance = parseFloat(document.getElementById('current_balance').value) || 0;
                const adjustment = parseFloat(balanceAdjustment);
                const newBalance = currentBalance + adjustment;
                
                if (newBalance < 0) {
                    document.getElementById('balance_adjustment').style.borderColor = '#dc2626';
                    document.getElementById('balance_adjustment').focus();
                    if (window.showToast) { 
                        window.showToast(adjustI18n.balanceCannotBeNegative, { type: 'error' }); 
                    }
                    return false;
                }
                
                return true;
            }


            // Event listeners for adjust modal
            closeAdjustBtn.addEventListener('click', closeAdjustModal);
            adjustModal.addEventListener('click', function(e){ if (e.target === adjustModal) closeAdjustModal(); });
            
            // Global event listener for balance adjustment field using event delegation
            document.addEventListener('DOMContentLoaded', function() {
                // Use event delegation to catch events on dynamically loaded elements
                document.addEventListener('input', function(e) {
                    if (e.target && e.target.id === 'balance_adjustment') {
                        calculateNewBalance();
                    }
                });
                
                document.addEventListener('keyup', function(e) {
                    if (e.target && e.target.id === 'balance_adjustment') {
                        calculateNewBalance();
                    }
                });
                
                document.addEventListener('change', function(e) {
                    if (e.target && e.target.id === 'balance_adjustment') {
                        calculateNewBalance();
                    }
                });
                
                document.addEventListener('paste', function(e) {
                    if (e.target && e.target.id === 'balance_adjustment') {
                        setTimeout(calculateNewBalance, 10);
                    }
                });
            });
            
            // Thêm event listener để xử lý khi modal được ẩn
            adjustModal.addEventListener('hidden.bs.modal', function () {
                // Xóa backdrop nếu còn sót lại
                const backdrops = document.querySelectorAll('.modal-backdrop');
                backdrops.forEach(backdrop => backdrop.remove());
                
                // Xóa class modal-open từ body
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
            });

            // Event listeners for adjust buttons - REMOVED because using onclick directly
            // adjustBalanceBtns.forEach(btn => {
            //     btn.addEventListener('click', function() {
            //         loadUserDataForAdjustment(this);
            //     });
            // });

            // Load user data from button data attributes
            function loadUserDataForAdjustment(button) {
                clearAdjustFieldErrors();
                adjustErrorBox.style.display = 'none';
                
                // Get data from button attributes
                const data = {
                    user_id: button.getAttribute('data-user-id'),
                    current_balance: button.getAttribute('data-current-balance') || 0
                };
                
                // Fill form fields
                document.getElementById('adjust_user_id').value = data.user_id;
                document.getElementById('current_balance').value = data.current_balance;
                
                // Set initial value for new balance preview (same as current balance)
                document.getElementById('new_balance_preview').value = data.current_balance;
                
                // Reset adjustment field
                document.getElementById('balance_adjustment').value = '';
                
                // Get the balance adjustment field
                const balanceAdjustmentField = document.getElementById('balance_adjustment');
                
                // Remove existing event listeners if any
                balanceAdjustmentField.removeEventListener('input', calculateNewBalance);
                balanceAdjustmentField.removeEventListener('keyup', calculateNewBalance);
                balanceAdjustmentField.removeEventListener('change', calculateNewBalance);
                
                // Add multiple event listeners for real-time calculation
                balanceAdjustmentField.addEventListener('input', calculateNewBalance);
                balanceAdjustmentField.addEventListener('keyup', calculateNewBalance);
                balanceAdjustmentField.addEventListener('change', calculateNewBalance);
                
                // Also add event listener for paste events
                balanceAdjustmentField.addEventListener('paste', function() {
                    setTimeout(calculateNewBalance, 10);
                });
                
                // Test function call immediately
                console.log('Event listeners attached, testing calculation...');
                calculateNewBalance();
                
                openAdjustModal();
            }


            // Submit adjust form
            submitAdjustBtn.addEventListener('click', function() {
                adjustErrorBox.style.display = 'none';
                clearAdjustFieldErrors();
                
                // Validate form before submitting
                if (!validateAdjustForm()) {
                    return; // Stop if validation fails
                }
                
                // Proceed with update
                performBalanceAdjustment();
            });

            function performBalanceAdjustment() {
                const data = {
                    user_id: document.getElementById('adjust_user_id').value,
                    balance_adjustment: document.getElementById('balance_adjustment').value
                };
                
                submitAdjustBtn.disabled = true;
                const originalHtml = submitAdjustBtn.innerHTML;
                submitAdjustBtn.innerHTML = '<span class="loading" style="width:16px; height:16px; border-width:2px; margin-right:6px;"></span> ' + adjustI18n.updating;

                axios.put(`/admin/user-management/${data.user_id}/adjust-balance`, data, {
                    headers: { 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                }).then(function(res) {
                    if (res.data && res.data.success) {
                        closeModal('adjustBalanceModal');
                        if (window.showToast) { 
                            window.showToast(adjustI18n.updatedSuccess, { type: 'success' }); 
                        }
                        // Auto reload after 2 seconds
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        const msg = res.data && (res.data.message || res.data.errors) || adjustI18n.errorGeneric;
                        if (window.showToast) { 
                            window.showToast(Array.isArray(msg) ? msg[0] : String(msg), { type: 'error' }); 
                        }
                    }
                }).catch(function(err) {
                    // Đóng modal khi có lỗi
                    closeModal('adjustBalanceModal');
                    
                    if (err.response && err.response.data) {
                        const data = err.response.data;
                        if (data && data.errors && typeof data.errors === 'object') {
                            // Highlight fields with errors
                            Object.keys(data.errors).forEach(k => {
                                const input = document.getElementById(k);
                                if (input) input.style.borderColor = '#dc2626';
                            });
                            const firstError = Object.values(data.errors)[0];
                            if (window.showToast) { 
                                window.showToast(Array.isArray(firstError) ? firstError[0] : String(firstError), { type: 'error' }); 
                            }
                        } else {
                            if (window.showToast) { 
                                window.showToast(data.message || adjustI18n.errorGeneric, { type: 'error' }); 
                            }
                        }
                    } else {
                        if (window.showToast) { 
                            window.showToast(adjustI18n.networkError, { type: 'error' }); 
                        }
                    }
                }).finally(function() {
                    submitAdjustBtn.disabled = false;
                    submitAdjustBtn.innerHTML = originalHtml;
                });
            }
        }
        
        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initAdjustBalanceModal);
        } else {
            initAdjustBalanceModal();
        }
    })();
</script>
@endpush