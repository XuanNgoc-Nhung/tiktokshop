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
                <input type="text" id="searchInput" placeholder="Tìm theo tiêu đề hoặc nội dung" class="form-control" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" style="flex: 4 1 0; min-width: 320px; padding: 0.35rem 0.5rem; font-size: 0.875rem; height: 32px;">
                <select id="statusFilter" class="form-select" style="flex: 0 0 280px; width: 280px; height: 32px; padding: 0.2rem 1.6rem 0.2rem 0.5rem; font-size: 0.8125rem;">
                    <option value="">Tất cả trạng thái</option>
                    <option value="1">Hoạt động</option>
                    <option value="0">Không hoạt động</option>
                </select>
                <button type="submit" class="btn btn-primary" style="height: 32px; padding: 0.35rem 0.8rem; font-size: 0.8125rem; min-width: 110px; white-space: nowrap;"><i class="fas fa-search"></i> {{ __('admin::cms.search') }}</button>
                <button type="button" class="btn btn-secondary" id="resetBtn" style="height: 32px; padding: 0.35rem 0.8rem; font-size: 0.8125rem; min-width: 110px; white-space: nowrap;"><i class="fas fa-rotate"></i> {{ __('admin::cms.reset') }}</button>
                <button type="button" class="btn btn-primary" id="addBtn" style="height: 32px; padding: 0.35rem 0.8rem; font-size: 0.8125rem; min-width: 120px; white-space: nowrap;"><i class="fas fa-plus"></i> {{ __('admin::cms.add_new') }}</button>
            </form>
            <div class="table-responsive">
                <table class="table" id="thongBaoTable">
                    <thead>
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th>Tiêu đề</th>
                            <th>Nội dung</th>
                            <th style="width: 140px;">Trạng thái</th>
                            <th style="width: 180px;">{{ __('admin::cms.created_at') }}</th>
                            <th style="width: 160px;" class="text-center">{{ __('admin::cms.actions') }}</th>
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
        <div class="modal-dialog">
            <div class="modal-content" style="background: var(--gray-200); color: var(--gray-800);">
                <div class="modal-header" style="background: var(--gray-300);">
                    <h5 class="modal-title" id="modalTitle">Thêm thông báo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="thongBaoForm">
                        <input type="hidden" id="thongBaoId">
                        <div class="mb-3">
                            <label for="tieuDe" class="form-label">Tiêu đề</label>
                            <input type="text" id="tieuDe" class="form-control" placeholder="Nhập tiêu đề" required>
                        </div>
                        <div class="mb-3">
                            <label for="noiDung" class="form-label">Nội dung</label>
                            <textarea id="noiDung" class="form-control" rows="4" placeholder="Nhập nội dung" required></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Trạng thái</label>
                            <select id="trangThai" class="form-select">
                                <option value="1">Hoạt động</option>
                                <option value="0">Không hoạt động</option>
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
            <div class="modal-content" style="background: var(--gray-200); color: var(--gray-800);">
                <div class="modal-header" style="background: var(--gray-300);">
                    <h5 class="modal-title">{{ __('admin::cms.confirm_delete') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa thông báo này không?</p>
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
                tableBody.innerHTML = `<tr><td colspan="6" class="text-center">{{ __('admin::cms.no_data') }}</td></tr>`;
                return;
            }
            tableBody.innerHTML = items.map(it => `
                <tr>
                    <td>${it.id}</td>
                    <td>${escapeHtml(it.tieu_de)}</td>
                    <td style="max-width: 420px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="${escapeHtml(it.noi_dung)}">${escapeHtml(it.noi_dung)}</td>
                    <td>
                        <span class="badge ${it.trang_thai ? 'bg-success' : 'bg-secondary'}">${it.trang_thai ? 'Hoạt động' : 'Không hoạt động'}</span>
                        <button class="btn btn-sm btn-warning ms-2" data-action="toggle" data-id="${it.id}"><i class="fas fa-exchange-alt"></i></button>
                    </td>
                    <td>${formatDate(it.created_at)}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary" data-action="edit" data-id="${it.id}"><i class="fas fa-edit"></i> {{ __('admin::cms.edit') }}</button>
                        <button class="btn btn-sm btn-danger" data-action="delete" data-id="${it.id}"><i class="fas fa-trash"></i> {{ __('admin::cms.delete') }}</button>
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
            paginationInfo.textContent = `${meta.total} thông báo`;
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
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center">{{ __('admin::cms.loading') }}</td></tr>`;
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
                tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">{{ __('admin::cms.error_generic') }}</td></tr>`;
            });
        }

        function openCreate(){
            idInput.value = '';
            tieuDe.value = '';
            noiDung.value = '';
            trangThai.value = '1';
            modalTitle.textContent = 'Thêm thông báo';
            modal.show();
        }

        function openEdit(row){
            idInput.value = row.id;
            tieuDe.value = row.tieu_de || '';
            noiDung.value = row.noi_dung || '';
            trangThai.value = String(row.trang_thai ?? 1);
            modalTitle.textContent = 'Chỉnh sửa thông báo';
            modal.show();
        }

        function save(){
            const id = idInput.value;
            const payload = {
                tieu_de: tieuDe.value.trim(),
                noi_dung: noiDung.value.trim(),
                trang_thai: Number(trangThai.value)
            };
            if(!payload.tieu_de){ return showToast('Vui lòng nhập tiêu đề', {type: 'warning'}); }
            if(!payload.noi_dung){ return showToast('Vui lòng nhập nội dung', {type: 'warning'}); }

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
                showToast(id ? 'Cập nhật thành công' : 'Tạo thành công', {type: 'success'});
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
                .catch(function(){ showToast('Không thể đổi trạng thái', {type:'error'}); });
            }
        }

        function confirmDelete(){
            if(!state.deletingId) return;
            const id = state.deletingId;
            const btn = document.getElementById('confirmDeleteBtn');
            btn.disabled = true; btn.innerHTML = '<span class="loading"></span>';
            axios.delete(routes.destroy(id), { headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' } })
            .then(function(){ deleteModal.hide(); showToast('Đã xóa', {type:'success'}); load(); })
            .catch(function(){ showToast('Xóa thất bại', {type:'error'}); })
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


