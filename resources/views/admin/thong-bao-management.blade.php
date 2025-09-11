@extends('admin.layouts.app')

@section('title', __('admin::cms.thong_bao_management'))
@section('breadcrumb', __('admin::cms.thong_bao_management'))

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">{{ __('admin::cms.thong_bao_management') }}</h3>
        </div>
        <div class="card-body">
            <form id="searchForm" method="GET" action="#" style="margin-bottom: 0.75rem; display: flex; gap: 0.4rem; align-items: center; flex-wrap: nowrap;">
                <input type="text" id="searchInput" placeholder="{{ __('admin::auth.search_placeholder') }}" class="form-control" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" style="flex: 4 1 0; min-width: 320px; padding: 0.35rem 0.5rem; font-size: 0.875rem; height: 32px;">
                <select id="statusFilter" class="form-select" style="flex: 0 0 280px; width: 280px; height: 32px; padding: 0.2rem 1.6rem 0.2rem 0.5rem; font-size: 0.8125rem;">
                    <option value="">{{ __('admin::auth.all_status') }}</option>
                    <option value="1">{{ __('admin::auth.active') }}</option>
                    <option value="0">{{ __('admin::auth.inactive') }}</option>
                </select>
                <button type="submit" class="btn btn-primary" style="height: 32px; padding: 0.35rem 0.8rem; font-size: 0.8125rem; min-width: 110px; white-space: nowrap;"><i class="fas fa-search"></i> {{ __('admin::cms.search') }}</button>
                <button type="button" class="btn btn-secondary" id="resetBtn" style="height: 32px; padding: 0.35rem 0.8rem; font-size: 0.8125rem; min-width: 110px; white-space: nowrap;"><i class="fas fa-rotate"></i> {{ __('admin::auth.reset') }}</button>
                <button type="button" class="btn btn-primary" id="addBtn" style="height: 32px; padding: 0.35rem 0.8rem; font-size: 0.8125rem; min-width: 120px; white-space: nowrap;"><i class="fas fa-plus"></i> {{ __('admin::auth.add_new') }}</button>
            </form>
            <div class="table-responsive">
                <table class="table" id="thongBaoTable">
                    <thead>
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th>{{ __('admin::auth.notification_title') }}</th>
                            <th>{{ __('admin::auth.notification_content') }}</th>
                            <th style="width: 180px;">{{ __('admin::auth.status') }}</th>
                            <th style="width: 180px;">{{ __('admin::cms.created_at') }}</th>
                            <th style="width: 200px;" class="text-center">{{ __('admin::cms.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td colspan="6" class="text-center">{{ __('admin::cms.loading') }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div id="paginationInfo" class="text-muted"></div>
                <nav>
                    <ul class="pagination pagination-sm mb-0" id="pagination"></ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Modal Create/Edit -->
    <div class="modal fade" id="thongBaoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: white; color: #333;">
                <div class="modal-header" style="background: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                    <h5 class="modal-title" id="modalTitle">{{ __('admin::auth.add_notification') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="thongBaoForm">
                        <input type="hidden" id="thongBaoId">
                        <div class="mb-3">
                            <label for="tieuDe" class="form-label">{{ __('admin::auth.notification_title') }}</label>
                            <input type="text" id="tieuDe" class="form-control" placeholder="{{ __('admin::auth.notification_title') }}" required style="border: 2px solid #dee2e6;">
                        </div>
                        <div class="mb-3">
                            <label for="noiDung" class="form-label">{{ __('admin::auth.notification_content') }}</label>
                            <textarea id="noiDung" class="form-control" rows="4" placeholder="{{ __('admin::auth.notification_content') }}" required style="border: 2px solid #dee2e6;"></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">{{ __('admin::auth.notification_status') }}</label>
                            <select id="trangThai" class="form-select" style="border: 2px solid #dee2e6;">
                                <option value="1">{{ __('admin::auth.active') }}</option>
                                <option value="0">{{ __('admin::auth.inactive') }}</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin::cms.cancel') }}</button>
                    <button type="button" class="btn btn-primary" id="saveBtn">{{ __('admin::cms.save') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background: white; color: #333;">
                <div class="modal-header" style="background: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                    <h5 class="modal-title">{{ __('admin::auth.confirm_delete_notification') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('admin::auth.confirm_delete_notification_message') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin::cms.cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">{{ __('admin::cms.delete') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    (function(){
        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const routes = {
            index: "{{ route('admin.thong-bao.index') }}",
            store: "{{ route('admin.thong-bao.store') }}",
            update: id => "{{ url('admin/thong-bao') }}/" + id,
            destroy: id => "{{ url('admin/thong-bao') }}/" + id,
            toggle: id => "{{ url('admin/thong-bao') }}/" + id + "/toggle",
        };

        let state = {
            page: 1,
            per_page: 10,
            search: '',
            trang_thai: '',
            deletingId: null
        };

        const tableBody = document.querySelector('#thongBaoTable tbody');
        const pagination = document.getElementById('pagination');
        const paginationInfo = document.getElementById('paginationInfo');
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const resetBtn = document.getElementById('resetBtn');
        const addBtn = document.getElementById('addBtn');
        const modalEl = document.getElementById('thongBaoModal');
        const modal = new bootstrap.Modal(modalEl);
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        const saveBtn = document.getElementById('saveBtn');

        const idInput = document.getElementById('thongBaoId');
        const tieuDe = document.getElementById('tieuDe');
        const noiDung = document.getElementById('noiDung');
        const trangThai = document.getElementById('trangThai');
        const modalTitle = document.getElementById('modalTitle');

        function encodeQuery(params){
            const esc = encodeURIComponent;
            return Object.keys(params).filter(k => params[k] !== '' && params[k] !== undefined && params[k] !== null)
                .map(k => esc(k) + '=' + esc(params[k]))
                .join('&');
        }

        function renderRows(items){
            if(!items.length){
                tableBody.innerHTML = `<tr><td colspan="6" class="text-center">{{ __("admin::auth.no_data") }}</td></tr>`;
                return;
            }
            tableBody.innerHTML = items.map(it => `
                <tr>
                    <td>${it.id}</td>
                    <td>${escapeHtml(it.tieu_de)}</td>
                    <td style="max-width: 420px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="${escapeHtml(it.noi_dung)}">${escapeHtml(it.noi_dung)}</td>
                    <td style="white-space: nowrap;">
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-sm btn-warning" data-action="toggle" data-id="${it.id}" title="Đổi trạng thái"><i class="fas fa-exchange-alt"></i></button>
                            <span class="badge ${it.trang_thai ? 'bg-success' : 'bg-secondary'}">${it.trang_thai ? '{{ __("admin::auth.active") }}' : '{{ __("admin::auth.inactive") }}'}</span>
                        </div>
                    </td>
                    <td>${formatDate(it.created_at)}</td>
                    <td class="text-center" style="white-space: nowrap;">
                        <div class="d-flex justify-content-center gap-1">
                            <button class="btn btn-sm btn-primary" data-action="edit" data-id="${it.id}"><i class="fas fa-edit"></i> {{ __('admin::cms.edit') }}</button>
                            <button class="btn btn-sm btn-danger" data-action="delete" data-id="${it.id}"><i class="fas fa-trash"></i> {{ __('admin::cms.delete') }}</button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function renderPagination(meta){
            pagination.innerHTML = '';
            if(!meta || meta.last_page <= 1){
                paginationInfo.textContent = '';
                return;
            }
            paginationInfo.textContent = `${meta.total} {{ __("admin::auth.notification_management") }}`;
            const createItem = (label, page, disabled=false, active=false) => {
                const li = document.createElement('li');
                li.className = 'page-item' + (disabled ? ' disabled' : '') + (active ? ' active' : '');
                const a = document.createElement('a');
                a.className = 'page-link';
                a.href = '#';
                a.textContent = label;
                a.addEventListener('click', e => { e.preventDefault(); if(!disabled && !active){ state.page = page; load(); }});
                li.appendChild(a);
                return li;
            };
            pagination.appendChild(createItem('«', 1, state.page === 1));
            pagination.appendChild(createItem('‹', Math.max(1, state.page - 1), state.page === 1));
            const start = Math.max(1, state.page - 2);
            const end = Math.min(meta.last_page, state.page + 2);
            for(let p = start; p <= end; p++){
                pagination.appendChild(createItem(String(p), p, false, p === state.page));
            }
            pagination.appendChild(createItem('›', Math.min(meta.last_page, state.page + 1), state.page === meta.last_page));
            pagination.appendChild(createItem('»', meta.last_page, state.page === meta.last_page));
        }

        function load(){
                tableBody.innerHTML = `<tr><td colspan="6" class="text-center">{{ __('admin::auth.loading') }}</td></tr>`;
            const q = encodeQuery({
                page: state.page,
                per_page: state.per_page,
                search: state.search,
                trang_thai: state.trang_thai
            });
            axios.get(routes.index + '?' + q, { headers: { 'Accept': 'application/json' } })
            .then(function(res){
                const payload = res && res.data ? res.data : {};
                renderRows(payload.data || []);
                renderPagination(payload.meta || null);
            })
            .catch(function(){
                tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">{{ __('admin::auth.error_generic') }}</td></tr>`;
            });
        }

        function openCreate(){
            idInput.value = '';
            tieuDe.value = '';
            noiDung.value = '';
            trangThai.value = '1';
            modalTitle.textContent = '{{ __("admin::auth.add_notification") }}';
            clearValidationErrors();
            modal.show();
        }

        function openEdit(row){
            idInput.value = row.id;
            tieuDe.value = row.tieu_de || '';
            noiDung.value = row.noi_dung || '';
            trangThai.value = String(row.trang_thai ?? 1);
            modalTitle.textContent = '{{ __("admin::auth.edit_notification") }}';
            clearValidationErrors();
            modal.show();
        }

        function clearValidationErrors(){
            tieuDe.style.borderColor = '#dee2e6';
            noiDung.style.borderColor = '#dee2e6';
            trangThai.style.borderColor = '#dee2e6';
        }

        function setValidationError(element, message){
            element.style.borderColor = '#dc3545';
            element.focus();
            showToast(message, {type: 'warning'});
        }

        function save(){
            const id = idInput.value;
            const payload = {
                tieu_de: tieuDe.value.trim(),
                noi_dung: noiDung.value.trim(),
                trang_thai: Number(trangThai.value)
            };

            // Clear previous validation errors
            clearValidationErrors();

            // Validation với focus và toast
            if(!payload.tieu_de){ 
                setValidationError(tieuDe, '{{ __("admin::auth.validation_title_required") }}');
                return;
            }
            if(!payload.noi_dung){ 
                setValidationError(noiDung, '{{ __("admin::auth.validation_content_required") }}');
                return;
            }
            if(payload.trang_thai === '' || isNaN(payload.trang_thai)){ 
                setValidationError(trangThai, '{{ __("admin::auth.validation_status_required") }}');
                return;
            }

            const url = id ? routes.update(id) : routes.store;
            const method = id ? 'PUT' : 'POST';
            saveBtn.disabled = true; saveBtn.innerHTML = '<span class="loading"></span>';
            const config = { headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' } };
            const req = method === 'PUT' 
                ? axios.put(url, payload, config)
                : axios.post(url, payload, config);
            req
            .then(function(){
                modal.hide();
                showToast(id ? '{{ __("admin::auth.notification_updated_success") }}' : '{{ __("admin::auth.notification_created_success") }}', {type: 'success'});
                load();
            })
            .catch(function(err){
                const msg = (err && err.response && (err.response.data && (err.response.data.message || JSON.stringify(err.response.data.errors)))) || err.message || 'Lưu thất bại';
                showToast(msg, {type: 'error'});
            })
            .finally(function(){ saveBtn.disabled = false; saveBtn.innerHTML = '{{ __('admin::cms.save') }}'; });
        }

        function onTableClick(e){
            const btn = e.target.closest('button[data-action]');
            if(!btn) return;
            const action = btn.getAttribute('data-action');
            const id = Number(btn.getAttribute('data-id'));
            if(!id) return;

            if(action === 'edit'){
                // find row data by reading current table row
                const tr = btn.closest('tr');
                const row = {
                    id,
                    tieu_de: tr.children[1].textContent.trim(),
                    noi_dung: tr.children[2].getAttribute('title') || tr.children[2].textContent.trim(),
                    trang_thai: tr.querySelector('.badge')?.classList.contains('bg-success') ? 1 : 0
                };
                openEdit(row);
            } else if(action === 'delete'){
                state.deletingId = id;
                deleteModal.show();
            } else if(action === 'toggle'){
                axios.patch(routes.toggle(id), {}, { headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' } })
                .then(function(){ load(); })
                .catch(function(){ showToast('{{ __("admin::auth.notification_toggle_failed") }}', {type:'error'}); });
            }
        }

        function confirmDelete(){
            if(!state.deletingId) return;
            const id = state.deletingId;
            const btn = document.getElementById('confirmDeleteBtn');
            btn.disabled = true; btn.innerHTML = '<span class="loading"></span>';
            axios.delete(routes.destroy(id), { headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' } })
            .then(function(){ deleteModal.hide(); showToast('{{ __("admin::auth.notification_deleted_success") }}', {type:'success'}); load(); })
            .catch(function(){ showToast('{{ __("admin::auth.error_generic") }}', {type:'error'}); })
            .finally(function(){ btn.disabled = false; btn.innerHTML = '{{ __('admin::cms.delete') }}'; });
        }

        function escapeHtml(str){
            return String(str ?? '').replace(/[&<>"]+/g, s => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[s]));
        }

        function formatDate(iso){
            if(!iso) return '';
            try { const d = new Date(iso); return d.toLocaleString(); } catch { return iso; }
        }

        // Events
        addBtn.addEventListener('click', openCreate);
        saveBtn.addEventListener('click', save);
        document.getElementById('thongBaoTable').addEventListener('click', onTableClick);
        document.getElementById('confirmDeleteBtn').addEventListener('click', confirmDelete);
        
        // Clear validation errors when user starts typing
        tieuDe.addEventListener('input', function(){ this.style.borderColor = '#dee2e6'; });
        noiDung.addEventListener('input', function(){ this.style.borderColor = '#dee2e6'; });
        trangThai.addEventListener('change', function(){ this.style.borderColor = '#dee2e6'; });
        // Submit search form like product layout
        const searchForm = document.getElementById('searchForm');
        searchForm && searchForm.addEventListener('submit', function(e){
            e.preventDefault();
            state.search = searchInput.value.trim();
            state.trang_thai = statusFilter.value;
            state.page = 1;
            load();
        });
        // Still support instant typing
        searchInput.addEventListener('input', function(){ state.search = this.value.trim(); state.page = 1; debounceLoad(); });
        statusFilter.addEventListener('change', function(){ state.trang_thai = this.value; state.page = 1; load(); });
        resetBtn.addEventListener('click', function(){ searchInput.value=''; statusFilter.value=''; state.search=''; state.trang_thai=''; state.page=1; load(); });

        let debounceTimer;
        function debounceLoad(){
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(load, 350);
        }

        // init
        load();
    })();
</script>
@endpush


