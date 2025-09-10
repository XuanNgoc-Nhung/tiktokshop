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
        color: #fff;
    }
    
    #confirmUpdateModal .btn-secondary:hover {
        background: #5c636a;
        border-color: #565e64;
    }
    
    #confirmUpdateModal .text-warning {
        color: #ffc107;
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
                window.showToast('Đã điền dữ liệu mẫu thành công!', { type: 'success' });
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
                // Use Bootstrap modal hide method
                const modal = bootstrap.Modal.getInstance(editModal);
                if (modal) {
                    modal.hide();
                }
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

            // Fill sample data function
            function fillSampleData() {
                // Sample data for all form fields
                const sampleData = {
                    name: 'Nguyễn Văn A',
                    phone: '0123456789',
                    email: 'nguyenvana@example.com',
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
                    window.showToast('Đã điền dữ liệu mẫu thành công!', { type: 'success' });
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
                        closeEditModal();
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
</script>
@endpush