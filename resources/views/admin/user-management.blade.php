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

            <div style="margin-bottom: 0.5rem; color: var(--gray-600); font-size: 0.875rem;">{{ __('admin::cms.total') }}: {{ $total ?? 0 }}</div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:48px;">#</th>
                            <th>{{ __('admin::cms.name') }}</th>
                            <th>{{ __('admin::cms.email') }}</th>
                            <th>{{ __('admin::cms.phone') }}</th>
                            <th>{{ __('admin::cms.role') }}</th>
                            <th>{{ __('admin::cms.joined') }}</th>
                            <th style="width:140px;">{{ __('admin::cms.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(($users ?? []) as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $user['name'] }}</td>
                                <td>{{ $user['email'] }}</td>
                                <td>{{ $user['phone'] }}</td>
                                <td>
                                    @php
                                        $role = $user['role'] ?? 'user';
                                        $color = $role === 'admin' ? 'var(--danger-color)' : ($role === 'seller' ? 'var(--warning-color)' : 'var(--primary-color)');
                                    @endphp
                                    <span style="padding: 0.15rem 0.4rem; border-radius: 0.25rem; background: var(--gray-300); color: {{ $color }}; text-transform: capitalize; font-weight: 600; font-size: 0.8125rem;">{{ $role === 'seller' ? __('admin::cms.seller') : ($role === 'admin' ? __('admin::cms.admin') : __('admin::cms.user')) }}</span>
                                </td>
                                <td>{{ $user['created_at_formatted'] ?? '' }}</td>
                                <td style="display: flex; gap: 0.4rem;">
                                    <a href="{{ route('admin.user-management.edit', ['id' => $index + 1]) }}" class="btn btn-secondary" style="height: 30px; padding: 0.25rem 0.5rem; font-size: 0.8125rem;" title="{{ __('admin::cms.edit') }}"><i class="fas fa-edit"></i></a>
                                    <form method="POST" action="{{ route('admin.user-management.destroy', ['id' => $index + 1]) }}" onsubmit="return confirm('{{ __('admin::cms.confirm_delete_user') }}');">
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
@endsection

@push('styles')
<style>
    .table-responsive { width: 100%; overflow-x: auto; }
</style>
@endpush

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
</script>
@endpush