@extends('admin.layouts.app')

@section('title', __('admin::cms.product_management'))

@section('breadcrumb', __('admin::cms.product_management'))

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('admin::cms.product_management') }}</h3>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.product-management') }}" style="margin-bottom: 0.75rem; display: flex; gap: 0.4rem; align-items: center;">
            <input type="text" name="q" value="{{ $keyword ?? '' }}" placeholder="{{ __('admin::cms.search') }}" style="flex: 1; padding: 0.35rem 0.5rem; font-size: 0.875rem; border: 1px solid var(--gray-400); border-radius: var(--border-radius); background: var(--gray-100); color: var(--gray-800); height: 32px;">
            <button type="submit" class="btn btn-primary" style="height: 32px; padding: 0.35rem 0.6rem; font-size: 0.8125rem;"><i class="fas fa-search"></i> {{ __('admin::cms.search') }}</button>
            <a href="{{ route('admin.product-management') }}" class="btn btn-secondary" style="height: 32px; padding: 0.35rem 0.6rem; font-size: 0.8125rem;"><i class="fas fa-rotate"></i> {{ __('admin::cms.reset') }}</a>
            <button type="button" id="openCreateProductModal" class="btn btn-primary" style="height: 32px; padding: 0.35rem 0.6rem; font-size: 0.8125rem;" data-bs-toggle="modal" data-bs-target="#createProductModal"><i class="fas fa-plus"></i> {{ __('admin::cms.add_new') }}</button>
        </form>

        <div style="margin-bottom: 0.5rem; color: var(--gray-600); font-size: 0.875rem;">{{ __('admin::cms.total') }}: {{ ($products ?? null) ? $products->total() : 0 }}</div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center" style="width:48px;">#</th>
                        <th style="width:150px;" class="text-left">{{ __('admin::cms.image') }}</th>
                        <th class="text-left">{{ __('admin::cms.product_name') }}</th>
                        <th class="text-left">{{ __('admin::cms.price') }}</th>
                        <th class="text-left">{{ __('admin::cms.commission') }}</th>
                        <th class="text-left">{{ __('admin::cms.vip_level') }}</th>
                        <th class="text-left">{{ __('admin::cms.vip') }}</th>
                        <th class="text-left">{{ __('admin::cms.created_at') }}</th>
                        <th class="text-left" style="width:140px;">{{ __('admin::cms.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($products ?? []) as $index => $product)
                        <tr>
                            <td class="text-center">{{ $products->firstItem() + $index }}</td>
                            <td>
                                @php 
                                    $img = $product->hinh_anh ?: 'https://via.placeholder.com/60x60?text=IMG';
                                    $isUrl = filter_var($img, FILTER_VALIDATE_URL) !== false;
                                    $src = $isUrl ? $img : asset($img);
                                @endphp
                                <img src="{{ $src }}" alt="img" style="width:100px; height:100px; object-fit:cover; border-radius:6px;">
                            </td>
                            <td>
                                <div style="font-weight:600;">{{ $product->ten }}</div>
                                <div style="font-size:12px; color: var(--gray-600); max-width:380px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $product->mo_ta }}</div>
                            </td>
                            <td>
                                {{ is_numeric($product->gia) ? number_format($product->gia, 0, ',', '.') . '₫' : ($product->gia ?? '') }}
                            </td>
                            <td>{{ $product->hoa_hong }}</td>
                            <td>{{ $product->cap_do }}</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <button 
                                        type="button" 
                                        class="btn btn-sm {{ ($product->cap_do && $product->cap_do > 0) ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                        style="padding: 2px 8px; font-size: 11px;"
                                        onclick="toggleVipStatus({{ $product->id }}, {{ ($product->cap_do && $product->cap_do > 0) ? 0 : 1 }})"
                                        title="{{ ($product->cap_do && $product->cap_do > 0) ? __('admin::cms.set_as_no_vip') : __('admin::cms.set_as_vip') }}"
                                    >
                                        <i class="fas {{ ($product->cap_do && $product->cap_do > 0) ? 'fa-times' : 'fa-check' }}"></i>
                                    </button>
                                    @if($product->cap_do && $product->cap_do > 0)
                                        <span class="badge bg-success">{{ __('admin::cms.yes') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ __('admin::cms.no') }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                {{ $product->created_at ? $product->created_at->locale(app()->getLocale())->translatedFormat('d M Y H:i') : '' }}
                            </td>
                            <td class="text-center">
                                <button 
                                    type="button" 
                                    class="btn btn-secondary btn-sm" 
                                    title="{{ __('admin::cms.edit') }}"
                                    onclick='onEditProduct(@json($product))'
                                >
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button 
                                    type="button" 
                                    class="btn btn-danger btn-sm" 
                                    title="{{ __('admin::cms.delete') }}"
                                    onclick="onRequestDeleteProduct({{ $product }})"
                                ><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align:center; color: var(--gray-600);">{{ __('admin::cms.no_data') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(!empty($products))
            <x-pagination :paginator="$products" />
        @endif
    </div>
</div>

<!-- Create Product Modal (Bootstrap) -->
<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="createProductModalLabel">{{ __('admin::cms.create_product') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="createProductError" class="alert alert-danger" style="display:none;"></div>
                <form id="createProductForm" enctype="multipart/form-data">
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
                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="cp_ten" class="form-label">{{ __('admin::cms.product_name') }}</label>
                            <input id="cp_ten" name="ten" type="text" placeholder="{{ __('admin::cms.placeholder_product_name') }}" class="form-control">
                            <div class="field-error" id="error_cp_ten" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: #dc2626;"></div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="cp_gia" class="form-label">{{ __('admin::cms.price') }}</label>
                            <input id="cp_gia" name="gia" type="number" step="0.01" min="0" placeholder="{{ __('admin::cms.placeholder_price') }}" class="form-control">
                            <div class="field-error" id="error_cp_gia" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: #dc2626;"></div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="cp_hoa_hong" class="form-label">{{ __('admin::cms.commission') }}</label>
                            <input id="cp_hoa_hong" name="hoa_hong" type="number" step="0.01" min="0" placeholder="{{ __('admin::cms.placeholder_commission') }}" class="form-control">
                            <div class="field-error" id="error_cp_hoa_hong" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: #dc2626;"></div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="cp_cap_do" class="form-label">{{ __('admin::cms.vip_level') }}</label>
                            <select id="cp_cap_do" name="cap_do" class="form-control">
                                <option value="">{{ __('admin::cms.placeholder_vip_level') }}</option>
                                @for($i = 1; $i <= 15; $i++)
                                    <option value="{{ $i }}">VIP{{ $i }}</option>
                                @endfor
                            </select>
                            <div class="field-error" id="error_cp_cap_do" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: #dc2626;"></div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="cp_vip" class="form-label">{{ __('admin::cms.vip') }}</label>
                            <select id="cp_vip" name="vip" class="form-control">
                                <option value="0">{{ __('admin::cms.no') }}</option>
                                <option value="1">{{ __('admin::cms.yes') }}</option>
                            </select>
                            <div class="field-error" id="error_cp_vip" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: #dc2626;"></div>
                        </div>
                    </div>
                    <div class="mb-3 mt-2">
                        <label for="cp_mo_ta" class="form-label">{{ __('admin::cms.description') }}</label>
                        <textarea id="cp_mo_ta" name="mo_ta" rows="3" class="form-control" placeholder="{{ __('admin::cms.placeholder_description_product') }}"></textarea>
                        <div class="field-error" id="error_cp_mo_ta" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: #dc2626;"></div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin::cms.cancel') }}</button>
                <button type="button" id="submitCreateProduct" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('admin::cms.save') }}</button>
            </div>
        </div>
    </div>
    
</div>

<!-- Edit Product Modal (Bootstrap) -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="editProductModalLabel">{{ __('admin::cms.edit_product') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="editProductError" class="alert alert-danger" style="display:none;"></div>
                <form id="editProductForm" enctype="multipart/form-data">
                    <input type="hidden" id="ep_id" name="id" />
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
                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="ep_ten" class="form-label">{{ __('admin::cms.product_name') }}</label>
                            <input id="ep_ten" name="ten" type="text" class="form-control">
                            <div class="field-error" id="error_ep_ten" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: #dc2626;"></div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="ep_gia" class="form-label">{{ __('admin::cms.price') }}</label>
                            <input id="ep_gia" name="gia" type="number" step="0.01" min="0" class="form-control">
                            <div class="field-error" id="error_ep_gia" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: #dc2626;"></div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="ep_hoa_hong" class="form-label">{{ __('admin::cms.commission') }}</label>
                            <input id="ep_hoa_hong" name="hoa_hong" type="number" step="0.01" min="0" class="form-control">
                            <div class="field-error" id="error_ep_hoa_hong" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: #dc2626;"></div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="ep_cap_do" class="form-label">{{ __('admin::cms.vip_level') }}</label>
                            <select id="ep_cap_do" name="cap_do" class="form-control">
                                <option value="">{{ __('admin::cms.placeholder_vip_level') }}</option>
                                @for($i = 1; $i <= 15; $i++)
                                    <option value="{{ $i }}">VIP{{ $i }}</option>
                                @endfor
                            </select>
                            <div class="field-error" id="error_ep_cap_do" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: #dc2626;"></div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label for="ep_vip" class="form-label">{{ __('admin::cms.vip') }}</label>
                            <select id="ep_vip" name="vip" class="form-control">
                                <option value="0">{{ __('admin::cms.no') }}</option>
                                <option value="1">{{ __('admin::cms.yes') }}</option>
                            </select>
                            <div class="field-error" id="error_ep_vip" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: #dc2626;"></div>
                        </div>
                    </div>
                    <div class="mb-3 mt-2">
                        <label for="ep_mo_ta" class="form-label">{{ __('admin::cms.description') }}</label>
                        <textarea id="ep_mo_ta" name="mo_ta" rows="3" class="form-control"></textarea>
                        <div class="field-error" id="error_ep_mo_ta" style="display:none; margin-top: 0.25rem; font-size: 0.8125rem; color: #dc2626;"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin::cms.cancel') }}</button>
                <button type="button" id="submitEditProduct" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('admin::cms.save') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirm Modal -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="deleteProductModalLabel">{{ __('admin::cms.delete_product') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="deleteProductMessage" class="text-dark" style="font-size:0.95rem;">
                    {{ __('admin::cms.confirm_delete_product') }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin::cms.cancel') }}</button>
                <button type="button" id="confirmDeleteProductBtn" class="btn btn-danger">
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
        const modalEl = document.getElementById('createProductModal');
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
        const submitBtn = document.getElementById('submitCreateProduct');
        const form = document.getElementById('createProductForm');
        const errorBox = document.getElementById('createProductError');

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
                }
            });
            // Do not manually trigger input click here because the input already overlays the dropzone
        }

        function clearErrors(){
            document.querySelectorAll('#createProductForm .field-error').forEach(el=>{ el.style.display='none'; el.textContent=''; });
            ['cp_ten','cp_gia','cp_hoa_hong','cp_mo_ta','cp_hinh_anh','cp_vip'].forEach(id=>{
                const input = document.getElementById(id);
                if (input) input.style.borderColor = 'var(--gray-400)';
            });
        }

        function setFieldError(fieldId, message){
            const input = document.getElementById(fieldId);
            const error = document.getElementById('error_' + fieldId);
            if (input) input.style.borderColor = 'var(--danger-color)';
            if (error) { error.textContent = message; error.style.display = 'block'; }
        }

        submitBtn && submitBtn.addEventListener('click', function(){
            clearErrors();
            console.log('[Submit] Start building FormData');
            const fd = new FormData();
            fd.append('ten', document.getElementById('cp_ten').value.trim());
            fd.append('gia', document.getElementById('cp_gia').value.trim());
            fd.append('hoa_hong', document.getElementById('cp_hoa_hong').value.trim());
            fd.append('mo_ta', document.getElementById('cp_mo_ta').value.trim());
            const inp = document.getElementById('cp_hinh_anh');
            if (droppedFile) {
                console.log('[Submit] using droppedFile');
                fd.append('hinh_anh', droppedFile);
            } else if (inp && inp.files && inp.files[0]) {
                console.log('[Submit] using input file');
                fd.append('hinh_anh', inp.files[0]);
            }
            // Xử lý logic VIP: nếu VIP = 1 thì cap_do = 1, nếu VIP = 0 thì cap_do = 0
            const vipValue = document.getElementById('cp_vip').value;
            const capDoValue = vipValue == '1' ? '1' : '0';
            fd.append('cap_do', capDoValue);

            const clientErrors = [];
            const vTen = fd.get('ten');
            const vGia = fd.get('gia');
            const vHoaHong = fd.get('hoa_hong');
            const vVip = document.getElementById('cp_vip').value;
            const hasImage = !!(droppedFile || (document.getElementById('cp_hinh_anh') && document.getElementById('cp_hinh_anh').files && document.getElementById('cp_hinh_anh').files[0]));
            if (!vTen) clientErrors.push({ f:'cp_ten', m:'{{ __('admin::cms.validation_enter_name') }}' });
            if (vGia === '' || isNaN(vGia) || Number(vGia) < 0) clientErrors.push({ f:'cp_gia', m:'{{ __('admin::cms.validation_enter_price') }}' });
            if (vHoaHong !== '' && (isNaN(vHoaHong) || Number(vHoaHong) < 0)) clientErrors.push({ f:'cp_hoa_hong', m:'{{ __('admin::cms.validation_enter_commission') }}' });
            if (!vVip) clientErrors.push({ f:'cp_vip', m:'{{ __('admin::cms.validation_vip_required') }}' });
            if (!hasImage) clientErrors.push({ f:'cp_hinh_anh', m:'{{ __('admin::cms.validation_enter_image') }}' });

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
            axios.post("{{ route('admin.product-management.store') }}", fd, {
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Accept': 'application/json', 'Content-Type': 'multipart/form-data' }
            }).then(function(res){
                console.log('[Submit] response:', res.status, res.data);
                if (res.data && res.data.success){
                    if (bsModal) bsModal.hide();
                    if (window.showToast) window.showToast('{{ __('admin::cms.product_created_success') }}', { type: 'success' });
                    setTimeout(()=>{ location.reload(); }, 600);
                } else {
                    const msg = res.data && (res.data.message || res.data.errors) || '{{ __('admin::cms.error_generic') }}';
                    if (window.showToast) window.showToast(Array.isArray(msg) ? msg[0] : String(msg), { type: 'error' });
                }
            }).catch(function(err){
                console.error('[Submit] error:', err);
                if (err.response && err.response.status === 422 && err.response.data && err.response.data.errors){
                    const errors = err.response.data.errors;
                    const map = { ten:'cp_ten', gia:'cp_gia', hoa_hong:'cp_hoa_hong', mo_ta:'cp_mo_ta', hinh_anh:'cp_hinh_anh', cap_do:'cp_vip' };
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
        const editModalEl = document.getElementById('editProductModal');
        const editBsModal = editModalEl ? new bootstrap.Modal(editModalEl) : null;
        const editForm = document.getElementById('editProductForm');
        const editErrorBox = document.getElementById('editProductError');
        const btnSaveEdit = document.getElementById('submitEditProduct');

        // Inputs
        const epId = document.getElementById('ep_id');
        const epTen = document.getElementById('ep_ten');
        const epGia = document.getElementById('ep_gia');
        const epHoaHong = document.getElementById('ep_hoa_hong');
        const epMoTa = document.getElementById('ep_mo_ta');
        const epCapDo = document.getElementById('ep_cap_do');
        const epInputImage = document.getElementById('ep_hinh_anh');
        const epPreviewImage = document.getElementById('ep_preview');
        const epDropzone = document.getElementById('ep_dropzone');
        const epPlaceholder = document.getElementById('ep_placeholder');
        let epDroppedFile = null;

        function epClearErrors(){
            if (!editForm) return;
            editForm.querySelectorAll('.field-error').forEach(el=>{ el.style.display='none'; el.textContent=''; });
            ['ep_ten','ep_gia','ep_hoa_hong','ep_mo_ta','ep_hinh_anh','ep_vip'].forEach(id=>{
                const input = document.getElementById(id);
                if (input) input.style.borderColor = 'var(--gray-400)';
            });
            if (editErrorBox) { editErrorBox.style.display='none'; editErrorBox.textContent=''; }
        }

        function epSetFieldError(fieldId, message){
            const input = document.getElementById(fieldId);
            const error = document.getElementById('error_' + fieldId);
            if (input) input.style.borderColor = 'var(--danger-color)';
            if (error) { error.textContent = message; error.style.display = 'block'; }
        }

        function epShowPreview(file){
            if (!epPreviewImage || !epPlaceholder) return;
            if (!file) { 
                epPreviewImage.classList.add('d-none');
                epPlaceholder.style.display = 'block';
                epPreviewImage.src='';
                return; 
            }
            const reader = new FileReader();
            reader.onload = function(e){
                epPreviewImage.src = e.target.result;
                epPreviewImage.classList.remove('d-none');
                epPlaceholder.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }

        // Setup input behaviors
        if (epInputImage && epPreviewImage) {
            epInputImage.addEventListener('click', function(){ this.value=''; epDroppedFile=null; });
            epInputImage.addEventListener('change', function(){
                const file = this.files && this.files[0];
                epShowPreview(file);
                epDroppedFile = null;
            });
        }
        if (epDropzone) {
            ['dragenter','dragover','dragleave','drop'].forEach(evt => {
                epDropzone.addEventListener(evt, function(e){ e.preventDefault(); e.stopPropagation(); });
            });
            epDropzone.addEventListener('dragover', function(){
                epDropzone.style.borderColor = '#0d6efd';
                epDropzone.style.background = '#eef6ff';
            });
            epDropzone.addEventListener('dragleave', function(){
                epDropzone.style.borderColor = '#cbd5e0';
                epDropzone.style.background = '#f9fafb';
            });
            epDropzone.addEventListener('drop', function(e){
                epDropzone.style.borderColor = '#cbd5e0';
                epDropzone.style.background = '#f9fafb';
                const files = e.dataTransfer.files;
                if (files && files[0]) { epDroppedFile = files[0]; epShowPreview(epDroppedFile); }
            });
        }

        // Open and populate modal on Edit button click
        window.onEditProduct = function(p){
            epClearErrors();
            if (!p || !p.id) {
                if (window.showToast) window.showToast('Product not found', { type: 'error' });
                return;
            }

            if (epId) epId.value = p.id;
            if (epTen) epTen.value = p.ten || '';
            if (epGia) epGia.value = p.gia || '';
            if (epHoaHong) epHoaHong.value = p.hoa_hong || '';
            if (epMoTa) epMoTa.value = p.mo_ta || '';
            if (epCapDo) epCapDo.value = p.cap_do || '';
            // Set VIP based on cap_do: if cap_do > 0 then VIP = 1, else VIP = 0
            const epVip = document.getElementById('ep_vip');
            if (epVip) epVip.value = (p.cap_do && p.cap_do > 0) ? '1' : '0';
            const hinh_anh = p.hinh_anh || '';
            const isUrl = /^https?:\/\//i.test(hinh_anh);
            const resolvedUrl = isUrl ? hinh_anh : (hinh_anh ? `${window.location.origin}/${hinh_anh}` : '');
            // Also show current image directly in the dropzone preview
            if (epPreviewImage && epPlaceholder) {
                if (resolvedUrl) {
                    epPreviewImage.src = resolvedUrl;
                    epPreviewImage.classList.remove('d-none');
                    epPlaceholder.style.display = 'none';
                } else {
                    epPreviewImage.src = '';
                    epPreviewImage.classList.add('d-none');
                    epPlaceholder.style.display = 'block';
                }
            }
            // reset optional new image selection
            if (epInputImage) epInputImage.value = '';
            epDroppedFile = null;

            if (editBsModal) editBsModal.show();
        };

        // Submit edit
        btnSaveEdit && btnSaveEdit.addEventListener('click', function(){
            epClearErrors();
            if (!epId) return;
            const id = epId.value;
            const fd = new FormData();
            fd.append('ten', (epTen && epTen.value.trim()) || '');
            fd.append('gia', (epGia && epGia.value.trim()) || '');
            fd.append('hoa_hong', (epHoaHong && epHoaHong.value.trim()) || '');
            fd.append('mo_ta', (epMoTa && epMoTa.value.trim()) || '');
            // Xử lý logic VIP: nếu VIP = 1 thì cap_do = 1, nếu VIP = 0 thì cap_do = 0
            const epVipValue = document.getElementById('ep_vip').value;
            const epCapDoValue = epVipValue == '1' ? '1' : '0';
            fd.append('cap_do', epCapDoValue);
            // Optional image
            if (epDroppedFile) {
                fd.append('hinh_anh', epDroppedFile);
            } else if (epInputImage && epInputImage.files && epInputImage.files[0]) {
                fd.append('hinh_anh', epInputImage.files[0]);
            }
            fd.append('_method', 'PUT'); // spoofing PUT for form-data

            // simple client-side validation
            const errs = [];
            const vTen = fd.get('ten');
            const vGia = fd.get('gia');
            const vHoaHong = fd.get('hoa_hong');
            const vVip = document.getElementById('ep_vip').value;
            if (!vTen) errs.push({ f:'ep_ten', m:'{{ __('admin::cms.validation_enter_name') }}' });
            if (vGia === '' || isNaN(vGia) || Number(vGia) < 0) errs.push({ f:'ep_gia', m:'{{ __('admin::cms.validation_enter_price') }}' });
            if (vHoaHong !== '' && (isNaN(vHoaHong) || Number(vHoaHong) < 0)) errs.push({ f:'ep_hoa_hong', m:'{{ __('admin::cms.validation_enter_commission') }}' });
            if (!vVip) errs.push({ f:'ep_vip', m:'{{ __('admin::cms.validation_vip_required') }}' });

            if (errs.length){
                epSetFieldError(errs[0].f, errs[0].m);
                if (window.showToast) window.showToast(errs[0].m, { type: 'error' });
                return;
            }

            btnSaveEdit.disabled = true;
            const originalHtml = btnSaveEdit.innerHTML;
            btnSaveEdit.innerHTML = '<span class="loading" style="width:16px; height:16px; border-width:2px; margin-right:6px;"></span> {{ __('admin::cms.saving') }}';

            axios.post(`{{ url('/admin/product-management') }}/${id}`, fd, {
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Accept': 'application/json' }
            }).then(function(res){
                if (res.data && res.data.success){
                    if (editBsModal) editBsModal.hide();
                    if (window.showToast) window.showToast('{{ __('admin::cms.product_updated_success') ?? 'Updated successfully' }}', { type: 'success' });
                    setTimeout(()=>{ location.reload(); }, 1500);
                } else {
                    const msg = res.data && (res.data.message || res.data.errors) || '{{ __('admin::cms.error_generic') }}';
                    if (window.showToast) window.showToast(Array.isArray(msg) ? msg[0] : String(msg), { type: 'error' });
                }
            }).catch(function(err){
                if (err.response && err.response.status === 422 && err.response.data && err.response.data.errors){
                    const errors = err.response.data.errors;
                    const map = { ten:'ep_ten', gia:'ep_gia', hoa_hong:'ep_hoa_hong', mo_ta:'ep_mo_ta', hinh_anh:'ep_hinh_anh', cap_do:'ep_vip' };
                    const firstKey = Object.keys(errors)[0];
                    const firstMsg = Array.isArray(errors[firstKey]) ? errors[firstKey][0] : String(errors[firstKey]);
                    Object.keys(errors).forEach(k=> epSetFieldError(map[k] || k, Array.isArray(errors[k]) ? errors[k][0] : String(errors[k])));
                    if (window.showToast) window.showToast(firstMsg, { type: 'error' });
                } else {
                    if (window.showToast) window.showToast('{{ __('admin::cms.error_network') }}', { type: 'error' });
                }
            }).finally(function(){
                btnSaveEdit.disabled = false;
                btnSaveEdit.innerHTML = originalHtml;
            });
        });

        // ========================= DELETE PRODUCT LOGIC =========================
        const deleteModalEl = document.getElementById('deleteProductModal');
        let deleteBsModal = deleteModalEl ? new bootstrap.Modal(deleteModalEl) : null;
        const deleteMsgEl = document.getElementById('deleteProductMessage');
        const confirmDeleteBtn = document.getElementById('confirmDeleteProductBtn');
        let deleteTargetId = null;

        window.onRequestDeleteProduct = function(p){
            const id = p.id;
            const name = p.ten;
            deleteTargetId = id;
            if (deleteMsgEl) {
                deleteMsgEl.textContent = name 
                    ? `{{ __('admin::cms.confirm_delete_product') }} (${name})`
                    : `{{ __('admin::cms.confirm_delete_product') }}`;
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

            axios.post(`{{ url('/admin/product-management') }}/${deleteTargetId}`, {
                _method: 'DELETE'
            }, {
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Accept': 'application/json' }
            }).then(function(res){
                if (res.data && res.data.success){
                    if (deleteBsModal) deleteBsModal.hide();
                    if (window.showToast) window.showToast('{{ __('admin::cms.deleted_success') }}', { type: 'success' });
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

        // Toggle VIP status function
        window.toggleVipStatus = function(productId, newVipStatus) {
            if (!confirm(newVipStatus == 1 ? '{{ __('admin::cms.confirm_set_as_vip') }}' : '{{ __('admin::cms.confirm_set_as_no_vip') }}')) {
                return;
            }

            const button = event.target.closest('button');
            const originalHtml = button.innerHTML;
            button.disabled = true;
            button.innerHTML = '<span class="loading" style="width:12px; height:12px; border-width:1px; margin-right:4px;"></span>';

            axios.post(`{{ url('/admin/product-management') }}/${productId}/toggle-vip`, {
                vip_status: newVipStatus
            }, {
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 
                    'Accept': 'application/json' 
                }
            }).then(function(res) {
                if (res.data && res.data.success) {
                    if (window.showToast) window.showToast(res.data.message, { type: 'success' });
                    setTimeout(() => { location.reload(); }, 500);
                } else {
                    const msg = res.data && res.data.message || '{{ __('admin::cms.error_generic') }}';
                    if (window.showToast) window.showToast(msg, { type: 'error' });
                }
            }).catch(function(err) {
                console.error('Toggle VIP error:', err);
                if (window.showToast) window.showToast('{{ __('admin::cms.error_network') }}', { type: 'error' });
            }).finally(function() {
                button.disabled = false;
                button.innerHTML = originalHtml;
            });
        };
    })();
</script>
@endpush