@extends('admin.layouts.app')

@section('title', __('admin::cms.slider_management'))

@section('breadcrumb', __('admin::cms.slider_management'))

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('admin::cms.slider_management') }}</h3>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.slider-management') }}" style="margin-bottom: 0.75rem; display: flex; gap: 0.4rem; align-items: center;">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="{{ __('admin::cms.search') }}" style="flex: 1; padding: 0.35rem 0.5rem; font-size: 0.875rem; border: 1px solid var(--gray-400); border-radius: var(--border-radius); background: var(--gray-100); color: var(--gray-800); height: 32px;">
            <button type="submit" class="btn btn-primary" style="height: 32px; padding: 0.35rem 0.6rem; font-size: 0.8125rem;"><i class="fas fa-search"></i> {{ __('admin::cms.search') }}</button>
            <a href="{{ route('admin.slider-management') }}" class="btn btn-secondary" style="height: 32px; padding: 0.35rem 0.6rem; font-size: 0.8125rem;"><i class="fas fa-rotate"></i> {{ __('admin::cms.reset') }}</a>
            <button type="button" id="openCreateSliderModal" class="btn btn-primary" style="height: 32px; padding: 0.35rem 0.6rem; font-size: 0.8125rem;" data-bs-toggle="modal" data-bs-target="#createSliderModal"><i class="fas fa-plus"></i> {{ __('admin::cms.add_slider') }}</button>
        </form>

        <div style="margin-bottom: 0.5rem; color: var(--gray-600); font-size: 0.875rem;">{{ __('admin::cms.total') }}: {{ ($sliders ?? null) ? $sliders->total() : 0 }}</div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center" style="width:48px;">#</th>
                        <th style="width:150px;" class="text-left">{{ __('admin::cms.image') }}</th>
                        <th class="text-left">{{ __('admin::cms.title') }}</th>
                        <th class="text-left">{{ __('admin::cms.position') }}</th>
                        <th class="text-left">{{ __('admin::cms.status') }}</th>
                        <th class="text-left">{{ __('admin::cms.created_at') }}</th>
                        <th class="text-left" style="width:140px;">{{ __('admin::cms.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($sliders ?? []) as $index => $slider)
                        <tr>
                            <td class="text-center">{{ $sliders->firstItem() + $index }}</td>
                            <td>
                                @php 
                                    $img = $slider->hinh_anh ?: 'https://via.placeholder.com/60x60?text=IMG';
                                    $isUrl = filter_var($img, FILTER_VALIDATE_URL) !== false;
                                    $src = $isUrl ? $img : asset($img);
                                @endphp
                                <img src="{{ $src }}" alt="img" style="width:100px; height:100px; object-fit:cover; border-radius:6px;">
                            </td>
                            <td>
                                <div style="font-weight:600;">{{ $slider->tieu_de }}</div>
                            </td>
                            <td>
                                @if($slider->vi_tri == 1)
                                    {{ __('admin::cms.homepage') }}
                                @elseif($slider->vi_tri == 2)
                                    {{ __('admin::cms.search') }}
                                @elseif($slider->vi_tri == 3)
                                    {{ __('admin::cms.about') }}
                                @else
                                    {{ $slider->vi_tri ?? 0 }}
                                @endif
                            </td>
                            <td>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <button type="button" class="btn btn-warning btn-sm" title="{{ __('admin::cms.confirm') }}" onclick="onToggleSliderStatus({{ $slider->id }})" style="padding:2px 6px; line-height:1;">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>
                                    @if($slider->trang_thai == 1)
                                        <span class="badge bg-success">{{ __('admin::cms.active') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ __('admin::cms.inactive') }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                {{ $slider->created_at ? $slider->created_at->locale(app()->getLocale())->translatedFormat('d M Y H:i') : '' }}
                            </td>
                            <td class="text-center">
                                <button 
                                    type="button" 
                                    class="btn btn-secondary btn-sm" 
                                    title="{{ __('admin::cms.edit') }}"
                                    onclick='onEditSlider(@json($slider))'
                                >
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button 
                                    type="button" 
                                    class="btn btn-danger btn-sm" 
                                    title="{{ __('admin::cms.delete') }}"
                                    onclick="onRequestDeleteSlider({{ $slider }})"
                                ><i class="fas fa-trash"></i></button>
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
        @if(!empty($sliders))
            <x-pagination :paginator="$sliders" />
        @endif
    </div>
</div>

<!-- Create Slider Modal (Bootstrap) -->
<div class="modal fade" id="createSliderModal" tabindex="-1" aria-labelledby="createSliderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="createSliderModalLabel">{{ __('admin::cms.add_slider') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="createSliderError" class="alert alert-danger" style="display:none;"></div>
                <form id="createSliderForm" enctype="multipart/form-data">
                    <!-- Image Dropzone on top -->
                    <div class="mb-3">
                        <div style="width:100%; max-width:420px; margin:0 auto; text-align:left;">
                            <div class="form-label" style="margin-bottom:6px;">{{ __('admin::cms.image') }}</div>
                        </div>
                        <div id="cp_dropzone" 
                             style="position: relative; width: 100%; max-width: 420px; margin: 0 auto; height: 200px; border: 2px dashed #cbd5e0; border-radius: 10px; background: #f9fafb; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                            <div id="cp_placeholder" class="text-center" style="color:#64748b;">
                                <i class="fas fa-cloud-upload-alt" style="font-size: 2rem;"></i>
                                <div style="margin-top:6px; font-weight:600;">{{ __('admin::cms.image') }}</div>
                                <small>{{ __('admin::cms.drag_drop_or_click') ?? 'Drag & drop or click to select' }}</small>
                            </div>
                            <img id="cp_preview" src="" alt="Preview" class="d-none" 
                                 style="position:absolute; inset:10px; width: calc(100% - 20px); height: calc(100% - 20px); object-fit: contain; border-radius: 6px; background: #fff;" />
                            <input id="cp_hinh_anh" name="hinh_anh" type="file" accept="image/*" class="form-control" 
                                   style="position:absolute; inset:0; opacity:0; cursor:pointer;" />
                        </div>
                        <div class="field-error" id="error_cp_hinh_anh" style="display:none; margin: 6px auto 0; font-size: 0.8125rem; color: #dc2626; max-width: 420px; text-align: center;"></div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="cp_tieu_de" class="form-label">{{ __('admin::cms.title') }}</label>
                            <input id="cp_tieu_de" name="tieu_de" type="text" placeholder="{{ __('admin::cms.title') }}" class="form-control">
                            <div class="field-error" id="error_cp_tieu_de" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: #dc2626;"></div>
                        </div>
                        <div class="col-12 col-md-3">
                            <label for="cp_vi_tri" class="form-label">{{ __('admin::cms.position') }}</label>
                            <select id="cp_vi_tri" name="vi_tri" class="form-control">
                                <option value="">{{ __('admin::cms.select_position') }}</option>
                                <option value="1">{{ __('admin::cms.homepage') }}</option>
                                <option value="2">{{ __('admin::cms.search') }}</option>
                                <option value="3">{{ __('admin::cms.about') }}</option>
                            </select>
                            <div class="field-error" id="error_cp_vi_tri" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: #dc2626;"></div>
                        </div>
                        <div class="col-12 col-md-3">
                            <label for="cp_trang_thai" class="form-label">{{ __('admin::cms.status') }}</label>
                            <select id="cp_trang_thai" name="trang_thai" class="form-control">
                                <option value="1">{{ __('admin::cms.active') }}</option>
                                <option value="2">{{ __('admin::cms.inactive') }}</option>
                            </select>
                            <div class="field-error" id="error_cp_trang_thai" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: #dc2626;"></div>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin::cms.cancel') }}</button>
                <button type="button" id="submitCreateSlider" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('admin::cms.save') }}</button>
            </div>
        </div>
    </div>
    
</div>

<!-- Edit Slider Modal (Bootstrap) -->
<div class="modal fade" id="editSliderModal" tabindex="-1" aria-labelledby="editSliderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="editSliderModalLabel">{{ __('admin::cms.edit_slider') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="editSliderError" class="alert alert-danger" style="display:none;"></div>
                <form id="editSliderForm" enctype="multipart/form-data">
                    <input type="hidden" id="es_id" name="id" />
                    <div class="mb-3">
                        <div style="width:100%; max-width:420px; margin:0 auto; text-align:left;">
                            <div class="form-label" style="margin-bottom:6px;">{{ __('admin::cms.image') }}</div>
                        </div>
                        <div style="flex:1; min-width:260px;">
                            <div id="ep_dropzone" 
                                 style="position: relative; width: 100%; max-width: 420px; height: 200px; border: 2px dashed #cbd5e0; border-radius: 10px; background: #f9fafb; display: flex; align-items: center; justify-content: center; cursor: pointer; margin: 0 auto;">
                                <div id="ep_placeholder" class="text-center" style="color:#64748b;">
                                    <i class="fas fa-cloud-upload-alt" style="font-size: 2rem;"></i>
                                    <div style="margin-top:6px; font-weight:600;">{{ __('admin::cms.change_image_optional') ?? 'Change image (optional)' }}</div>
                                    <small>{{ __('admin::cms.drag_drop_or_click') ?? 'Drag & drop or click to select' }}</small>
                                </div>
                                <img id="ep_preview" src="" alt="Preview" class="d-none" 
                                     style="position:absolute; inset:10px; width: calc(100% - 20px); height: calc(100% - 20px); object-fit: contain; border-radius: 6px; background: #fff;" />
                                <input id="ep_hinh_anh" name="hinh_anh" type="file" accept="image/*" class="form-control" 
                                       style="position:absolute; inset:0; opacity:0; cursor:pointer;" />
                            </div>
                            <div class="field-error" id="error_ep_hinh_anh" style="display:none; margin: 6px 0 0; font-size: 0.8125rem; color: #dc2626;"></div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="es_tieu_de" class="form-label">{{ __('admin::cms.title') }}</label>
                            <input id="es_tieu_de" name="tieu_de" type="text" class="form-control">
                            <div class="field-error" id="error_es_tieu_de" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: #dc2626;"></div>
                        </div>
                        <div class="col-12 col-md-3">
                            <label for="es_vi_tri" class="form-label">{{ __('admin::cms.position') }}</label>
                            <select id="es_vi_tri" name="vi_tri" class="form-control">
                                <option value="">{{ __('admin::cms.select_position') }}</option>
                                <option value="1">{{ __('admin::cms.homepage') }}</option>
                                <option value="2">{{ __('admin::cms.search') }}</option>
                                <option value="3">{{ __('admin::cms.about') }}</option>
                            </select>
                            <div class="field-error" id="error_es_vi_tri" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: #dc2626;"></div>
                        </div>
                        <div class="col-12 col-md-3">
                            <label for="es_trang_thai" class="form-label">{{ __('admin::cms.status') }}</label>
                            <select id="es_trang_thai" name="trang_thai" class="form-control">
                                <option value="1">{{ __('admin::cms.active') }}</option>
                                <option value="2">{{ __('admin::cms.inactive') }}</option>
                            </select>
                            <div class="field-error" id="error_es_trang_thai" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: #dc2626;"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin::cms.cancel') }}</button>
                <button type="button" id="submitEditSlider" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('admin::cms.save') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirm Modal -->
<div class="modal fade" id="deleteSliderModal" tabindex="-1" aria-labelledby="deleteSliderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="deleteSliderModalLabel">{{ __('admin::cms.delete_slider') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="deleteSliderMessage" class="text-dark" style="font-size:0.95rem;">
                    {{ __('admin::cms.delete_slider_confirm') }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin::cms.cancel') }}</button>
                <button type="button" id="confirmDeleteSliderBtn" class="btn btn-danger">
                    <i class="fas fa-trash"></i> {{ __('admin::cms.delete') }}
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
@endpush
@include('components.pagination-styles')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    (function(){
        if (!window.showToast) {
            window.showToast = function(message, opts){
                try { alert(message); } catch(_) {}
            }
        }
        const modalEl = document.getElementById('createSliderModal');
        const bsModal = modalEl ? new bootstrap.Modal(modalEl) : null;
        if (modalEl) {
            modalEl.addEventListener('show.bs.modal', function(){
                console.log('[Modal] show.bs.modal fired');
                // Reset input so selecting the same file triggers change
                const inp = document.getElementById('cp_hinh_anh');
                const ph = document.getElementById('cp_placeholder');
                const prev = document.getElementById('cp_preview');
                if (inp) inp.value = '';
                if (prev) { prev.src = ''; prev.classList.add('d-none'); }
                if (ph) ph.style.display = 'block';
                droppedFile = null;
            });
        }
        const submitBtn = document.getElementById('submitCreateSlider');
        const form = document.getElementById('createSliderForm');
        const errorBox = document.getElementById('createSliderError');

        const inputImage = document.getElementById('cp_hinh_anh');
        const previewImage = document.getElementById('cp_preview');
        const dropzone = document.getElementById('cp_dropzone');
        const placeholder = document.getElementById('cp_placeholder');
        let droppedFile = null;

        function showPreview(file){
            console.log('[Preview] showPreview called with file:', file);
            if (!file) { 
                previewImage.classList.add('d-none');
                placeholder.style.display = 'block';
                previewImage.src='';
                return; 
            }
            const reader = new FileReader();
            reader.onload = function(e){
                console.log('[Preview] FileReader onload. size:', file.size, 'type:', file.type);
                previewImage.src = e.target.result;
                previewImage.classList.remove('d-none');
                placeholder.style.display = 'none';
            };
            reader.onerror = function(err){ console.error('[Preview] FileReader error:', err); };
            reader.readAsDataURL(file);
        }

        if (inputImage && previewImage) {
            // Ensure selecting same file still triggers change
            inputImage.addEventListener('click', function(){
                console.log('[Input] click -> reset value to allow re-selecting same file');
                this.value = '';
                droppedFile = null;
            });
            inputImage.addEventListener('change', function(){
                const file = this.files && this.files[0];
                console.log('[Input] change event. file:', file);
                showPreview(file);
                droppedFile = null; // prioritize picked file
                validateCreateField('cp_hinh_anh');
            });
        }

        if (dropzone) {
            ['dragenter','dragover','dragleave','drop'].forEach(evt => {
                dropzone.addEventListener(evt, function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    if (evt !== 'dragover') console.log('[Dropzone]', evt);
                });
            });
            dropzone.addEventListener('dragover', function(){
                console.log('[Dropzone] dragover');
                dropzone.style.borderColor = '#0d6efd';
                dropzone.style.background = '#eef6ff';
            });
            dropzone.addEventListener('dragleave', function(){
                console.log('[Dropzone] dragleave');
                dropzone.style.borderColor = '#cbd5e0';
                dropzone.style.background = '#f9fafb';
            });
            dropzone.addEventListener('drop', function(e){
                console.log('[Dropzone] drop');
                dropzone.style.borderColor = '#cbd5e0';
                dropzone.style.background = '#f9fafb';
                const files = e.dataTransfer.files;
                if (files && files[0]) {
                    droppedFile = files[0];
                    console.log('[Dropzone] droppedFile:', droppedFile);
                    showPreview(droppedFile);
                    validateCreateField('cp_hinh_anh');
                }
            });
            // Do not manually trigger input click here because the input already overlays the dropzone
        }

        // Real-time validation for create form
        (function(){
            const t = document.getElementById('cp_tieu_de');
            const p = document.getElementById('cp_vi_tri');
            const s = document.getElementById('cp_trang_thai');
            const i = document.getElementById('cp_hinh_anh');
            if (t){ t.addEventListener('input', function(){ validateCreateField('cp_tieu_de'); }); t.addEventListener('blur', function(){ validateCreateField('cp_tieu_de'); }); }
            if (p){ p.addEventListener('change', function(){ validateCreateField('cp_vi_tri'); }); }
            if (s){ s.addEventListener('change', function(){ validateCreateField('cp_trang_thai'); }); }
            if (i){ i.addEventListener('change', function(){ validateCreateField('cp_hinh_anh'); }); }
        })();

        function clearErrors(){
            document.querySelectorAll('#createSliderForm .field-error').forEach(el=>{ el.style.display='none'; el.textContent=''; });
            ['cp_tieu_de','cp_vi_tri','cp_trang_thai','cp_hinh_anh'].forEach(id=>{
                const input = document.getElementById(id);
                if (input) input.style.borderColor = 'var(--gray-400)';
            });
        }

        function clearFieldError(fieldId){
            const input = document.getElementById(fieldId);
            const error = document.getElementById('error_' + fieldId);
            if (input) input.style.borderColor = 'var(--gray-400)';
            if (error) { error.textContent = ''; error.style.display = 'none'; }
        }

        function setFieldError(fieldId, message){
            const input = document.getElementById(fieldId);
            const error = document.getElementById('error_' + fieldId);
            if (input) input.style.borderColor = 'var(--danger-color)';
            if (error) { error.textContent = message; error.style.display = 'block'; }
        }

        function validateCreateField(fieldId){
            if (fieldId === 'cp_tieu_de'){
                const val = (document.getElementById('cp_tieu_de')?.value || '').trim();
                if (!val) { setFieldError('cp_tieu_de', '{{ __('admin::cms.title_required') }}'); return false; }
                clearFieldError('cp_tieu_de'); return true;
            }
            if (fieldId === 'cp_vi_tri'){
                const val = document.getElementById('cp_vi_tri')?.value || '';
                if (!val) { setFieldError('cp_vi_tri', '{{ __('admin::cms.position_required') }}'); return false; }
                clearFieldError('cp_vi_tri'); return true;
            }
            if (fieldId === 'cp_trang_thai'){
                const val = document.getElementById('cp_trang_thai')?.value || '';
                if (!val) { setFieldError('cp_trang_thai', '{{ __('admin::cms.status') }}'); return false; }
                clearFieldError('cp_trang_thai'); return true;
            }
            if (fieldId === 'cp_hinh_anh'){
                const hasImage = !!(droppedFile || (document.getElementById('cp_hinh_anh') && document.getElementById('cp_hinh_anh').files && document.getElementById('cp_hinh_anh').files[0]));
                if (!hasImage) { setFieldError('cp_hinh_anh', '{{ __('admin::cms.image_required') }}'); return false; }
                clearFieldError('cp_hinh_anh'); return true;
            }
            return true;
        }

        submitBtn && submitBtn.addEventListener('click', function(){
            clearErrors();
            console.log('[Submit] Start building FormData');
            const fd = new FormData();
            fd.append('tieu_de', document.getElementById('cp_tieu_de').value.trim());
            fd.append('vi_tri', document.getElementById('cp_vi_tri').value);
            fd.append('trang_thai', document.getElementById('cp_trang_thai').value);
            const inp = document.getElementById('cp_hinh_anh');
            if (droppedFile) {
                console.log('[Submit] using droppedFile');
                fd.append('hinh_anh', droppedFile);
            } else if (inp && inp.files && inp.files[0]) {
                console.log('[Submit] using input file');
                fd.append('hinh_anh', inp.files[0]);
            }

            const clientErrors = [];
            const vTieuDe = fd.get('tieu_de');
            const vViTri = document.getElementById('cp_vi_tri').value;
            const vTrangThai = document.getElementById('cp_trang_thai').value;
            const hasImage = !!(droppedFile || (document.getElementById('cp_hinh_anh') && document.getElementById('cp_hinh_anh').files && document.getElementById('cp_hinh_anh').files[0]));
            // Check image first
            if (!hasImage) clientErrors.push({ f:'cp_hinh_anh', m:'{{ __('admin::cms.image_required') }}' });
            if (!vTieuDe) clientErrors.push({ f:'cp_tieu_de', m:'{{ __('admin::cms.title_required') }}' });
            if (!vViTri) clientErrors.push({ f:'cp_vi_tri', m:'{{ __('admin::cms.position_required') }}' });
            if (!vTrangThai) clientErrors.push({ f:'cp_trang_thai', m:'{{ __('admin::cms.status') }}' });

            if (clientErrors.length){
                console.warn('[Validate] client errors:', clientErrors);
                setFieldError(clientErrors[0].f, clientErrors[0].m);
                if (window.showToast) window.showToast(clientErrors[0].m, { type: 'error' });
                return;
            }

            submitBtn.disabled = true;
            const originalHtml = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="loading" style="width:16px; height:16px; border-width:2px; margin-right:6px;"></span> {{ __('admin::cms.saving') }}';

            console.log('[Submit] sending request to store route');
            axios.post("{{ route('admin.slider.store') }}", fd, {
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Accept': 'application/json', 'Content-Type': 'multipart/form-data' }
            }).then(function(res){
                console.log('[Submit] response:', res.status, res.data);
                if (res.data && res.data.success){
                    if (bsModal) bsModal.hide();
                    if (window.showToast) window.showToast('{{ __('admin::cms.slider_created_success') }}', { type: 'success' });
                    setTimeout(()=>{ location.reload(); }, 600);
                } else {
                    const msg = res.data && (res.data.message || res.data.errors) || '{{ __('admin::cms.error_generic') }}';
                    if (window.showToast) window.showToast(Array.isArray(msg) ? msg[0] : String(msg), { type: 'error' });
                }
            }).catch(function(err){
                console.error('[Submit] error:', err);
                if (err.response && err.response.status === 422 && err.response.data && err.response.data.errors){
                    const errors = err.response.data.errors;
                    const map = { tieu_de:'cp_tieu_de', vi_tri:'cp_vi_tri', trang_thai:'cp_trang_thai', hinh_anh:'cp_hinh_anh' };
                    const firstKey = Object.keys(errors)[0];
                    const firstMsg = Array.isArray(errors[firstKey]) ? errors[firstKey][0] : String(errors[firstKey]);
                    Object.keys(errors).forEach(k=> setFieldError(map[k] || k, Array.isArray(errors[k]) ? errors[k][0] : String(errors[k])));
                    if (window.showToast) window.showToast(firstMsg, { type: 'error' });
                } else {
                    if (window.showToast) window.showToast('{{ __('admin::cms.error_network') }}', { type: 'error' });
                }
            }).finally(function(){
                console.log('[Submit] finally: re-enable button');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;
            });
        });
        const editModalEl = document.getElementById('editSliderModal');
        const editBsModal = editModalEl ? new bootstrap.Modal(editModalEl) : null;
        const editForm = document.getElementById('editSliderForm');
        const editErrorBox = document.getElementById('editSliderError');
        const btnSaveEdit = document.getElementById('submitEditSlider');

        // Inputs
        const esId = document.getElementById('es_id');
        const esTieuDe = document.getElementById('es_tieu_de');
        const esViTri = document.getElementById('es_vi_tri');
        const esTrangThai = document.getElementById('es_trang_thai');
        const esInputImage = document.getElementById('ep_hinh_anh');
        const esPreviewImage = document.getElementById('ep_preview');
        const esDropzone = document.getElementById('ep_dropzone');
        const esPlaceholder = document.getElementById('ep_placeholder');
        let esDroppedFile = null;

        function esClearErrors(){
            if (!editForm) return;
            editForm.querySelectorAll('.field-error').forEach(el=>{ el.style.display='none'; el.textContent=''; });
            ['es_tieu_de','es_vi_tri','es_trang_thai','ep_hinh_anh'].forEach(id=>{
                const input = document.getElementById(id);
                if (input) input.style.borderColor = 'var(--gray-400)';
            });
            if (editErrorBox) { editErrorBox.style.display='none'; editErrorBox.textContent=''; }
        }

        function esSetFieldError(fieldId, message){
            const input = document.getElementById(fieldId);
            const error = document.getElementById('error_' + fieldId);
            if (input) input.style.borderColor = 'var(--danger-color)';
            if (error) { error.textContent = message; error.style.display = 'block'; }
        }

        function esShowPreview(file){
            if (!esPreviewImage || !esPlaceholder) return;
            if (!file) { 
                esPreviewImage.classList.add('d-none');
                esPlaceholder.style.display = 'block';
                esPreviewImage.src='';
                return; 
            }
            const reader = new FileReader();
            reader.onload = function(e){
                esPreviewImage.src = e.target.result;
                esPreviewImage.classList.remove('d-none');
                esPlaceholder.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }

        // Setup input behaviors
        if (esInputImage && esPreviewImage) {
            esInputImage.addEventListener('click', function(){ this.value=''; esDroppedFile=null; });
            esInputImage.addEventListener('change', function(){
                const file = this.files && this.files[0];
                esShowPreview(file);
                esDroppedFile = null;
            });
        }
        if (esDropzone) {
            ['dragenter','dragover','dragleave','drop'].forEach(evt => {
                esDropzone.addEventListener(evt, function(e){ e.preventDefault(); e.stopPropagation(); });
            });
            esDropzone.addEventListener('dragover', function(){
                esDropzone.style.borderColor = '#0d6efd';
                esDropzone.style.background = '#eef6ff';
            });
            esDropzone.addEventListener('dragleave', function(){
                esDropzone.style.borderColor = '#cbd5e0';
                esDropzone.style.background = '#f9fafb';
            });
            esDropzone.addEventListener('drop', function(e){
                esDropzone.style.borderColor = '#cbd5e0';
                esDropzone.style.background = '#f9fafb';
                const files = e.dataTransfer.files;
                if (files && files[0]) { esDroppedFile = files[0]; esShowPreview(esDroppedFile); }
            });
        }

        // Open and populate modal on Edit button click
        window.onEditSlider = function(p){
            esClearErrors();
            if (!p || !p.id) {
                if (window.showToast) window.showToast('Slider not found', { type: 'error' });
                return;
            }

            if (esId) esId.value = p.id;
            if (esTieuDe) esTieuDe.value = p.tieu_de || '';
            if (esViTri) esViTri.value = p.vi_tri || '';
            if (esTrangThai) esTrangThai.value = p.trang_thai || '1';
            const hinh_anh = p.hinh_anh || '';
            const isUrl = /^https?:\/\//i.test(hinh_anh);
            const resolvedUrl = isUrl ? hinh_anh : (hinh_anh ? `${window.location.origin}/${hinh_anh}` : '');
            // Also show current image directly in the dropzone preview
            if (esPreviewImage && esPlaceholder) {
                if (resolvedUrl) {
                    esPreviewImage.src = resolvedUrl;
                    esPreviewImage.classList.remove('d-none');
                    esPlaceholder.style.display = 'none';
                } else {
                    esPreviewImage.src = '';
                    esPreviewImage.classList.add('d-none');
                    esPlaceholder.style.display = 'block';
                }
            }
            // reset optional new image selection
            if (esInputImage) esInputImage.value = '';
            esDroppedFile = null;

            if (editBsModal) editBsModal.show();
        };

        // Submit edit
        btnSaveEdit && btnSaveEdit.addEventListener('click', function(){
            esClearErrors();
            if (!esId) return;
            const id = esId.value;
            const fd = new FormData();
            fd.append('tieu_de', (esTieuDe && esTieuDe.value.trim()) || '');
            fd.append('vi_tri', (esViTri && esViTri.value) || '');
            fd.append('trang_thai', (esTrangThai && esTrangThai.value) || '1');
            // Optional image
            if (esDroppedFile) {
                fd.append('hinh_anh', esDroppedFile);
            } else if (esInputImage && esInputImage.files && esInputImage.files[0]) {
                fd.append('hinh_anh', esInputImage.files[0]);
            }
            fd.append('_method', 'PUT'); // spoofing PUT for form-data

            // simple client-side validation
            const errs = [];
            const vTieuDe = fd.get('tieu_de');
            const vViTri = document.getElementById('es_vi_tri').value;
            const vTrangThai = document.getElementById('es_trang_thai').value;
            if (!vTieuDe) errs.push({ f:'es_tieu_de', m:'{{ __('admin::cms.title_required') }}' });
            if (!vViTri) errs.push({ f:'es_vi_tri', m:'{{ __('admin::cms.position_required') }}' });
            if (!vTrangThai) errs.push({ f:'es_trang_thai', m:'{{ __('admin::cms.status') }}' });

            if (errs.length){
                esSetFieldError(errs[0].f, errs[0].m);
                if (window.showToast) window.showToast(errs[0].m, { type: 'error' });
                return;
            }

            btnSaveEdit.disabled = true;
            const originalHtml = btnSaveEdit.innerHTML;
            btnSaveEdit.innerHTML = '<span class="loading" style="width:16px; height:16px; border-width:2px; margin-right:6px;"></span> {{ __('admin::cms.saving') }}';

            axios.post(`{{ url('/admin/slider') }}/${id}`, fd, {
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Accept': 'application/json' }
            }).then(function(res){
                if (res.data && res.data.success){
                    if (editBsModal) editBsModal.hide();
                    if (window.showToast) window.showToast('{{ __('admin::cms.slider_updated_success') }}', { type: 'success' });
                    setTimeout(()=>{ location.reload(); }, 1500);
                } else {
                    const msg = res.data && (res.data.message || res.data.errors) || '{{ __('admin::cms.error_generic') }}';
                    if (window.showToast) window.showToast(Array.isArray(msg) ? msg[0] : String(msg), { type: 'error' });
                }
            }).catch(function(err){
                if (err.response && err.response.status === 422 && err.response.data && err.response.data.errors){
                    const errors = err.response.data.errors;
                    const map = { tieu_de:'es_tieu_de', vi_tri:'es_vi_tri', trang_thai:'es_trang_thai', hinh_anh:'ep_hinh_anh' };
                    const firstKey = Object.keys(errors)[0];
                    const firstMsg = Array.isArray(errors[firstKey]) ? errors[firstKey][0] : String(errors[firstKey]);
                    Object.keys(errors).forEach(k=> esSetFieldError(map[k] || k, Array.isArray(errors[k]) ? errors[k][0] : String(errors[k])));
                    if (window.showToast) window.showToast(firstMsg, { type: 'error' });
                } else {
                    if (window.showToast) window.showToast('{{ __('admin::cms.error_network') }}', { type: 'error' });
                }
            }).finally(function(){
                btnSaveEdit.disabled = false;
                btnSaveEdit.innerHTML = originalHtml;
            });
        });

        // ========================= DELETE SLIDER LOGIC =========================
        const deleteModalEl = document.getElementById('deleteSliderModal');
        let deleteBsModal = deleteModalEl ? new bootstrap.Modal(deleteModalEl) : null;
        const deleteMsgEl = document.getElementById('deleteSliderMessage');
        const confirmDeleteBtn = document.getElementById('confirmDeleteSliderBtn');
        let deleteTargetId = null;

        window.onRequestDeleteSlider = function(p){
            const id = p.id;
            const name = p.tieu_de;
            deleteTargetId = id;
            if (deleteMsgEl) {
                deleteMsgEl.textContent = name 
                    ? `{{ __('admin::cms.delete_slider_confirm') }} (${name})`
                    : `{{ __('admin::cms.delete_slider_confirm') }}`;
            }
            if (!deleteBsModal && deleteModalEl) {
                deleteBsModal = new bootstrap.Modal(deleteModalEl);
            }
            if (deleteBsModal) deleteBsModal.show();
        };

        confirmDeleteBtn && confirmDeleteBtn.addEventListener('click', function(){
            if (!deleteTargetId) return;
            confirmDeleteBtn.disabled = true;
            const originalHtml = confirmDeleteBtn.innerHTML;
            confirmDeleteBtn.innerHTML = '<span class="loading" style="width:16px; height:16px; border-width:2px; margin-right:6px;"></span> {{ __('admin::cms.deleting') }}';

            axios.post(`{{ url('/admin/slider') }}/${deleteTargetId}`, {
                _method: 'DELETE'
            }, {
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Accept': 'application/json' }
            }).then(function(res){
                if (res.data && res.data.success){
                    if (deleteBsModal) deleteBsModal.hide();
                    if (window.showToast) window.showToast('{{ __('admin::cms.slider_deleted_success') }}', { type: 'success' });
                    setTimeout(()=>{ location.reload(); }, 600);
                } else {
                    const msg = res.data && (res.data.message || res.data.errors) || '{{ __('admin::cms.error_generic') }}';
                    if (window.showToast) window.showToast(Array.isArray(msg) ? msg[0] : String(msg), { type: 'error' });
                }
            }).catch(function(){
                if (window.showToast) window.showToast('{{ __('admin::cms.error_network') }}', { type: 'error' });
            }).finally(function(){
                confirmDeleteBtn.disabled = false;
                confirmDeleteBtn.innerHTML = originalHtml;
            });
        });

        // ========================= TOGGLE STATUS (QUICK) =========================
        window.onToggleSliderStatus = function(id){
            if (!id) return;
            axios.patch(`{{ url('/admin/slider') }}/${id}/toggle`, {}, {
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Accept': 'application/json' }
            }).then(function(res){
                if (res && res.data) {
                    if (window.showToast) window.showToast('{{ __('admin::cms.success_slider_status_updated') ?? __('admin::cms.updated_success') }}', { type: 'success' });
                    setTimeout(()=>{ location.reload(); }, 400);
                } else {
                    if (window.showToast) window.showToast('{{ __('admin::cms.error_generic') }}', { type: 'error' });
                }
            }).catch(function(){
                if (window.showToast) window.showToast('{{ __('admin::cms.error_network') }}', { type: 'error' });
            });
        }
    })();
</script>
@endpush