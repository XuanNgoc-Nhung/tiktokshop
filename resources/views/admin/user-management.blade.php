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
                            <th class="text-left">{{ __('admin::cms.name') }}</th>
                            <th>{{ __('admin::cms.email') }}</th>
                            <th class="text-left">{{ __('admin::cms.phone') }}</th>
                            <th class="text-left">{{ __('admin::cms.role') }}</th>
                            <th class="text-left">{{ __('admin::cms.joined') }}</th>
                            <th class="text-left" style="width:140px;">{{ __('admin::cms.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(($users ?? []) as $index => $user)
                            <tr>
                                <td class="text-center">{{ $users->firstItem() + $index }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>
                                    @php
                                        $role = $user->role ?? 'user';
                                        $color = $role === 'admin' ? 'var(--danger-color)' : ($role === 'seller' ? 'var(--warning-color)' : 'var(--primary-color)');
                                    @endphp
                                    <span style="padding: 0.15rem 0.4rem; border-radius: 0.25rem; background: var(--gray-300); color: {{ $color }}; text-transform: capitalize; font-weight: 600; font-size: 0.8125rem;">{{ $role === 'seller' ? __('admin::cms.seller') : ($role === 'admin' ? __('admin::cms.admin') : __('admin::cms.user')) }}</span>
                                </td>
                                <td>{{ $user->created_at_formatted ?? '' }}</td>
                                <td class="text-center" style="display: flex; gap: 0.4rem;">
                                    <button type="button" class="btn btn-secondary edit-user-btn" 
                                        data-user-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-phone="{{ $user->phone }}"
                                        data-email="{{ $user->email }}"
                                        data-gioi-tinh="{{ $user->profile->gioi_tinh ?? '' }}"
                                        data-ngay-sinh="{{ $user->profile->ngay_sinh ?? '' }}"
                                        data-dia-chi="{{ $user->profile->dia_chi ?? '' }}"
                                        data-so-du="{{ $user->profile->so_du ?? 0 }}"
                                        data-luot-trung="{{ $user->profile->luot_trung ?? 0 }}"
                                        data-ngan-hang="{{ $user->profile->ngan_hang ?? '' }}"
                                        data-so-tai-khoan="{{ $user->profile->so_tai_khoan ?? '' }}"
                                        data-chu-tai-khoan="{{ $user->profile->chu_tai_khoan ?? '' }}"
                                        data-cap-do="{{ $user->profile->cap_do ?? '' }}"
                                        data-giai-thuong-id="{{ $user->profile->giai_thuong_id ?? '' }}"
                                        data-anh-mat-truoc="{{ $user->profile->anh_mat_truoc ?? '' }}"
                                        data-anh-mat-sau="{{ $user->profile->anh_mat_sau ?? '' }}"
                                        data-anh-chan-dung="{{ $user->profile->anh_chan_dung ?? '' }}"
                                        style="height: 30px; padding: 0.25rem 0.5rem; font-size: 0.8125rem;" 
                                        title="{{ __('admin::cms.edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form method="POST" action="{{ route('admin.user-management.destroy', ['id' => $user->id]) }}" onsubmit="return confirm('{{ __('admin::cms.confirm_delete_user') }}');">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary" title="{{ __('admin::cms.delete') }}" style="background: var(--danger-color); border-color: var(--danger-color); height: 30px; padding: 0.25rem 0.5rem; font-size: 0.8125rem;"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center; color: var(--gray-600);">{{ __('admin::cms.no_data') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <x-pagination :paginator="$users" />
        </div>
    </div>

    <div id="createUserModal" style="display:none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1050; align-items: center; justify-content: center;">
        <div style="background: var(--gray-200); color: var(--gray-800); width: 520px; max-width: 92vw; border-radius: var(--border-radius-lg); box-shadow: var(--shadow-lg);">
            <div style="padding: 1rem 1.25rem; border-bottom: 1px solid var(--gray-300); background: var(--gray-300); display:flex; align-items:center; justify-content: space-between;">
                <div style="font-weight:600;">{{ __('admin::cms.add_user_title') }}</div>
                <button type="button" id="closeCreateUserModal" class="btn btn-secondary" style="height: 30px; padding: 0.25rem 0.6rem; font-size: 0.8125rem;">{{ __('admin::cms.cancel') }}</button>
            </div>
            <div style="padding: 1rem 1.25rem;">
                <div id="createUserError" style="display:none; margin-bottom: 0.75rem; padding: 0.5rem 0.75rem; background: var(--danger-color); color: #fff; border-radius: var(--border-radius);"></div>
                <form id="createUserForm">
                    <div style="display:flex; flex-direction:column; gap: 0.6rem;">
                        <div>
                            <label for="cu_name" style="display:block; margin-bottom: 0.25rem;">{{ __('admin::cms.name') }}</label>
                            <input id="cu_name" name="name" type="text" placeholder="{{ __('admin::cms.placeholder_name') }}" style="width:100%; padding: 0.5rem 0.6rem; border: 1px solid var(--gray-400); border-radius: var(--border-radius); background: var(--gray-100); color: var(--gray-800);">
                            <div class="field-error" id="error_cu_name" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: var(--danger-color);"></div>
                        </div>
                        <div>
                            <label for="cu_phone" style="display:block; margin-bottom: 0.25rem;">{{ __('admin::cms.phone') }}</label>
                            <input id="cu_phone" name="phone" type="text" placeholder="{{ __('admin::cms.placeholder_phone') }}" style="width:100%; padding: 0.5rem 0.6rem; border: 1px solid var(--gray-400); border-radius: var(--border-radius); background: var(--gray-100); color: var(--gray-800);">
                            <div class="field-error" id="error_cu_phone" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: var(--danger-color);"></div>
                        </div>
                        <div>
                            <label for="cu_password" style="display:block; margin-bottom: 0.25rem;">{{ __('admin::cms.password') }}</label>
                            <input id="cu_password" name="password" type="password" placeholder="{{ __('admin::cms.placeholder_password') }}" style="width:100%; padding: 0.5rem 0.6rem; border: 1px solid var(--gray-400); border-radius: var(--border-radius); background: var(--gray-100); color: var(--gray-800);">
                            <div class="field-error" id="error_cu_password" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: var(--danger-color);"></div>
                        </div>
                        <div>
                            <label for="cu_password_confirmation" style="display:block; margin-bottom: 0.25rem;">{{ __('admin::cms.password_confirmation') }}</label>
                            <input id="cu_password_confirmation" name="password_confirmation" type="password" placeholder="{{ __('admin::cms.placeholder_password_confirmation') }}" style="width:100%; padding: 0.5rem 0.6rem; border: 1px solid var(--gray-400); border-radius: var(--border-radius); background: var(--gray-100); color: var(--gray-800);">
                            <div class="field-error" id="error_cu_password_confirmation" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: var(--danger-color);"></div>
                        </div>
                        <div>
                            <label for="cu_referral_code" style="display:block; margin-bottom: 0.25rem;">{{ __('admin::cms.referral_code') }}</label>
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
                                        <label for="edit_anh_chan_dung" class="form-label">{{ __('admin::cms.portrait_image') }}</label>
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
                                        <label for="edit_name" class="form-label">{{ __('admin::cms.name') }}</label>
                                        <input id="edit_name" name="name" type="text" class="form-control form-control-sm" placeholder="{{ __('admin::cms.placeholder_name') }}">
                                        <div class="field-error" id="error_edit_name" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Phone -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_phone" class="form-label">{{ __('admin::cms.phone') }}</label>
                                        <input id="edit_phone" name="phone" type="text" class="form-control form-control-sm" placeholder="{{ __('admin::cms.placeholder_phone') }}">
                                        <div class="field-error" id="error_edit_phone" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Email -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_email" class="form-label">{{ __('admin::cms.email') }}</label>
                                        <input id="edit_email" name="email" type="email" class="form-control form-control-sm" placeholder="{{ __('admin::cms.placeholder_email') }}">
                                        <div class="field-error" id="error_edit_email" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Gender -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_gioi_tinh" class="form-label">{{ __('admin::cms.gender') }}</label>
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
                                        <label for="edit_ngay_sinh" class="form-label">{{ __('admin::cms.birth_date') }}</label>
                                        <input id="edit_ngay_sinh" name="ngay_sinh" type="text" class="form-control form-control-sm" placeholder="{{ __('admin::cms.placeholder_birth_date') }}">
                                        <div class="field-error" id="error_edit_ngay_sinh" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Address -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_dia_chi" class="form-label">{{ __('admin::cms.address') }}</label>
                                        <input id="edit_dia_chi" name="dia_chi" type="text" class="form-control form-control-sm" placeholder="{{ __('admin::cms.placeholder_address') }}">
                                        <div class="field-error" id="error_edit_dia_chi" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Balance -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_so_du" class="form-label">{{ __('admin::cms.balance') }}</label>
                                        <input id="edit_so_du" name="so_du" type="number" step="0.01" min="0" placeholder="0" class="form-control form-control-sm">
                                        <div class="field-error" id="error_edit_so_du" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Win Count -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_luot_trung" class="form-label">{{ __('admin::cms.win_count') }}</label>
                                        <input id="edit_luot_trung" name="luot_trung" type="number" min="0" placeholder="0" class="form-control form-control-sm">
                                        <div class="field-error" id="error_edit_luot_trung" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Bank -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_ngan_hang" class="form-label">{{ __('admin::cms.bank') }}</label>
                                        <input id="edit_ngan_hang" name="ngan_hang" type="text" class="form-control form-control-sm" placeholder="{{ __('admin::cms.placeholder_bank') }}">
                                        <div class="field-error" id="error_edit_ngan_hang" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Account Number -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_so_tai_khoan" class="form-label">{{ __('admin::cms.account_number') }}</label>
                                        <input id="edit_so_tai_khoan" name="so_tai_khoan" type="text" class="form-control form-control-sm" placeholder="{{ __('admin::cms.placeholder_account_number') }}">
                                        <div class="field-error" id="error_edit_so_tai_khoan" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Account Holder -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_chu_tai_khoan" class="form-label">{{ __('admin::cms.account_holder') }}</label>
                                        <input id="edit_chu_tai_khoan" name="chu_tai_khoan" type="text" class="form-control form-control-sm" placeholder="{{ __('admin::cms.placeholder_account_holder') }}">
                                        <div class="field-error" id="error_edit_chu_tai_khoan" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Level -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_cap_do" class="form-label">{{ __('admin::cms.level') }}</label>
                                        <input id="edit_cap_do" name="cap_do" type="text" class="form-control form-control-sm" placeholder="{{ __('admin::cms.placeholder_level') }}">
                                        <div class="field-error" id="error_edit_cap_do" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                    
                                    <!-- Prize ID -->
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <label for="edit_giai_thuong_id" class="form-label">{{ __('admin::cms.prize_id') }}</label>
                                        <input id="edit_giai_thuong_id" name="giai_thuong_id" type="text" class="form-control form-control-sm" placeholder="{{ __('admin::cms.placeholder_prize_id') }}">
                                        <div class="field-error" id="error_edit_giai_thuong_id" style="display:none; margin-top: 0.25rem; font-size: 0.75rem; color: #dc2626;"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Additional Images Section -->
                            <div class="mt-4 pt-3 border-top">
                                <h5 class="mb-3 text-dark">{{ __('admin::cms.additional_images') }}</h5>
                                <div class="row g-2">
                                    <!-- Front Image -->
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <label for="edit_anh_mat_truoc" class="form-label">{{ __('admin::cms.front_image') }}</label>
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
                                        <label for="edit_anh_mat_sau" class="form-label">{{ __('admin::cms.back_image') }}</label>
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
                <button type="button" id="submitEditUser" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>{{ __('admin::cms.update') }}
                </button>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .modal.show {
        display: flex !important;
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
    
    /* Modal title color */
    .modal-title {
        color: #000000 !important;
    }
</style>
@endpush

{{-- Include pagination styles --}}
@include('components.pagination-styles')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    (function() {
        const openBtn = document.getElementById('openCreateUserModal');
        const closeBtn = document.getElementById('closeCreateUserModal');
        const modal = document.getElementById('createUserModal');
        const submitBtn = document.getElementById('submitCreateUser');
        const form = document.getElementById('createUserForm');
        const errorBox = document.getElementById('createUserError');

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
            const editUserBtns = document.querySelectorAll('.edit-user-btn');
            
            if (!editModal || !closeEditBtn || !submitEditBtn || !editForm || !editErrorBox) {
                console.error('Edit modal elements not found!');
                return;
            }

            const editI18n = {
                updating: "{{ __('admin::cms.updating') }}",
                errorGeneric: "{{ __('admin::cms.error_generic') }}",
                networkError: "{{ __('admin::cms.error_network') }}",
                updatedSuccess: "{{ __('admin::cms.updated_success') }}",
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
                // Use Bootstrap modal hide method
                const modal = bootstrap.Modal.getInstance(editModal);
                if (modal) {
                    modal.hide();
                }
            }

            function clearEditFieldErrors() {
                document.querySelectorAll('#editUserForm .field-error').forEach(el => { 
                    el.style.display = 'none'; 
                    el.textContent = ''; 
                });
                const editFields = ['edit_name','edit_phone','edit_email','edit_gioi_tinh','edit_ngay_sinh','edit_dia_chi','edit_so_du','edit_luot_trung','edit_ngan_hang','edit_so_tai_khoan','edit_chu_tai_khoan','edit_cap_do','edit_giai_thuong_id','edit_anh_mat_truoc','edit_anh_mat_sau','edit_anh_chan_dung','edit_anh_chan_dung_small'];
                editFields.forEach(id => {
                    const input = document.getElementById(id);
                    if (input) input.style.borderColor = '#d1d5db';
                });
            }

            function setEditFieldError(field, message) {
                const input = document.getElementById('edit_' + field);
                if (input) input.style.borderColor = '#dc2626';
            }

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

            // Event listeners for edit modal
            closeEditBtn.addEventListener('click', closeEditModal);
            editModal.addEventListener('click', function(e){ if (e.target === editModal) closeEditModal(); });

            // Event listeners for edit buttons
            editUserBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    loadUserDataFromButton(this);
                });
            });

            // Load user data from button data attributes
            function loadUserDataFromButton(button) {
                clearEditFieldErrors();
                editErrorBox.style.display = 'none';
                
                // Get data from button attributes
                const data = {
                    user_id: button.getAttribute('data-user-id'),
                    name: button.getAttribute('data-name') || '',
                    phone: button.getAttribute('data-phone') || '',
                    email: button.getAttribute('data-email') || '',
                    gioi_tinh: button.getAttribute('data-gioi-tinh') || '',
                    ngay_sinh: button.getAttribute('data-ngay-sinh') || '',
                    dia_chi: button.getAttribute('data-dia-chi') || '',
                    so_du: button.getAttribute('data-so-du') || 0,
                    luot_trung: button.getAttribute('data-luot-trung') || 0,
                    ngan_hang: button.getAttribute('data-ngan-hang') || '',
                    so_tai_khoan: button.getAttribute('data-so-tai-khoan') || '',
                    chu_tai_khoan: button.getAttribute('data-chu-tai-khoan') || '',
                    cap_do: button.getAttribute('data-cap-do') || '',
                    giai_thuong_id: button.getAttribute('data-giai-thuong-id') || '',
                    anh_mat_truoc: button.getAttribute('data-anh-mat-truoc') || '',
                    anh_mat_sau: button.getAttribute('data-anh-mat-sau') || '',
                    anh_chan_dung: button.getAttribute('data-anh-chan-dung') || ''
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
                
                openEditModal();
            }

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

            // Submit edit form
            submitEditBtn.addEventListener('click', function() {
                editErrorBox.style.display = 'none';
                clearEditFieldErrors();
                
                const formData = new FormData(editForm);
                const data = Object.fromEntries(formData.entries());
                
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
                        closeEditModal();
                        if (window.showToast) { window.showToast(editI18n.updatedSuccess, { type: 'success' }); }
                        location.reload();
                    } else {
                        const msg = res.data && (res.data.message || res.data.errors) || editI18n.errorGeneric;
                        if (window.showToast) { window.showToast(Array.isArray(msg) ? msg[0] : String(msg), { type: 'error' }); }
                    }
                }).catch(function(err) {
                    if (err.response && err.response.data) {
                        const data = err.response.data;
                        if (data && data.errors && typeof data.errors === 'object') {
                            Object.keys(data.errors).forEach(k => setEditFieldError(k));
                            const firstError = Object.values(data.errors)[0];
                            if (window.showToast) { window.showToast(Array.isArray(firstError) ? firstError[0] : String(firstError), { type: 'error' }); }
                        } else {
                            if (window.showToast) { window.showToast(data.message || editI18n.errorGeneric, { type: 'error' }); }
                        }
                    } else {
                        if (window.showToast) { window.showToast(editI18n.networkError, { type: 'error' }); }
                    }
                }).finally(function() {
                    submitEditBtn.disabled = false;
                    submitEditBtn.innerHTML = originalHtml;
                });
            });
        }
        
        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initEditModal);
        } else {
            initEditModal();
        }
    })();
</script>
@endpush