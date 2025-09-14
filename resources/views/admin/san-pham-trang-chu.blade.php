@extends('admin.layouts.app')

@section('title', __('admin::cms.products_homepage'))

@section('breadcrumb', __('admin::cms.products_homepage'))

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('admin::cms.products_homepage') }}</h3>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.san-pham-trang-chu.index') }}" style="margin-bottom: 0.75rem; display: flex; gap: 0.4rem; align-items: center;">
            <input type="text" name="q" value="{{ $keyword ?? '' }}" placeholder="{{ __('admin::cms.search') }}" style="flex: 1; padding: 0.35rem 0.5rem; font-size: 0.875rem; border: 1px solid var(--gray-400); border-radius: var(--border-radius); background: var(--gray-100); color: var(--gray-800); height: 32px;">
            <button type="submit" class="btn btn-primary" style="height: 32px; padding: 0.35rem 0.6rem; font-size: 0.8125rem;"><i class="fas fa-search"></i> {{ __('admin::cms.search') }}</button>
            <a href="{{ route('admin.san-pham-trang-chu.index') }}" class="btn btn-secondary" style="height: 32px; padding: 0.35rem 0.6rem; font-size: 0.8125rem;"><i class="fas fa-rotate"></i> {{ __('admin::cms.reset') }}</a>
            <button type="button" class="btn btn-primary" style="height: 32px; padding: 0.35rem 0.6rem; font-size: 0.8125rem;" onclick="openAddProductModal()"><i class="fas fa-plus"></i> {{ __('admin::cms.add_new') }}</button>
        </form>

        <div style="margin-bottom: 0.5rem; color: var(--gray-600); font-size: 0.875rem;">{{ __('admin::cms.total') }}: {{ ($sanPhamTrangChu ?? null) ? $sanPhamTrangChu->total() : 0 }}</div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center" style="width:48px;">#</th>
                        <th style="width:150px;" class="text-left">{{ __('admin::cms.image') }}</th>
                        <th class="text-left">{{ __('admin::cms.product_name') }}</th>
                        <th class="text-left">{{ __('admin::cms.price') }}</th>
                        <th class="text-left">{{ __('admin::cms.commission') }}</th>
                        <th class="text-left">{{ __('admin::cms.rating') }}</th>
                        <th class="text-left">{{ __('admin::cms.sold') }}</th>
                        <th class="text-left">{{ __('admin::cms.status') }}</th>
                        <th class="text-left">{{ __('admin::cms.created_at') }}</th>
                        <th class="text-left" style="width:180px;">{{ __('admin::cms.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($sanPhamTrangChu ?? []) as $index => $product)
                        <tr>
                            <td class="text-center">{{ $sanPhamTrangChu->firstItem() + $index }}</td>
                            <td>
                                @php 
                                    $img = $product->hinh_anh ?: 'https://via.placeholder.com/60x60?text=IMG';
                                    $isUrl = filter_var($img, FILTER_VALIDATE_URL) !== false;
                                    $src = $isUrl ? $img : asset($img);
                                @endphp
                                <img src="{{ $src }}" alt="img" style="width:100px; height:100px; object-fit:cover; border-radius:6px;">
                            </td>
                            <td>
                                <div style="font-weight:600;">{{ $product->ten_san_pham }}</div>
                                <div style="font-size:12px; color: var(--gray-600); max-width:380px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">ID: #{{ $product->id }}</div>
                            </td>
                            <td>
                                {{ is_numeric($product->gia_san_pham) ? number_format($product->gia_san_pham, 0, ',', '.') . '₫' : ($product->gia_san_pham ?? '') }}
                            </td>
                            <td>{{ number_format($product->hoa_hong, 0, ',', '.') }}₫</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="text-warning me-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $product->sao_vote)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </span>
                                    <small class="text-muted ms-1">{{ $product->sao_vote }}</small>
                                </div>
                            </td>
                            <td>{{ number_format($product->da_ban) }}</td>
                            <td>
                                <span class="badge {{ $product->trang_thai == 1 ? 'bg-success' : 'bg-secondary' }}" id="status-badge-{{ $product->id }}">
                                    {{ $product->trang_thai == 1 ? __('admin::cms.active') : __('admin::cms.inactive') }}
                                </span>
                            </td>
                            <td>
                                {{ $product->created_at ? $product->created_at->locale(app()->getLocale())->translatedFormat('d M Y H:i') : '' }}
                            </td>
                            <td class="text-center">
                                <button 
                                    type="button" 
                                    class="btn {{ $product->trang_thai == 1 ? 'btn-warning' : 'btn-success' }} btn-sm me-1" 
                                    title="{{ $product->trang_thai == 1 ? __('admin::cms.deactivate') : __('admin::cms.activate') }}"
                                    onclick="toggleProductStatus({{ $product->id }}, {{ $product->trang_thai }})"
                                    id="toggle-btn-{{ $product->id }}"
                                >
                                    <i class="fas {{ $product->trang_thai == 1 ? 'fa-pause' : 'fa-play' }}"></i>
                                </button>
                                <button 
                                    type="button" 
                                    class="btn btn-secondary btn-sm me-1" 
                                    title="{{ __('admin::cms.edit') }}"
                                    onclick="openEditProductModal({{ $product->id }}, '{{ addslashes($product->ten_san_pham) }}', {{ $product->gia_san_pham }}, {{ $product->hoa_hong }}, {{ $product->sao_vote }}, {{ $product->da_ban }}, {{ $product->trang_thai }}, '{{ $product->hinh_anh }}')"
                                >
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button 
                                    type="button" 
                                    class="btn btn-danger btn-sm" 
                                    title="{{ __('admin::cms.delete') }}"
                                    onclick="onRequestDeleteProduct({{ $product->id }}, '{{ $product->ten_san_pham }}')"
                                ><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="text-align:center; color: var(--gray-600);">{{ __('admin::cms.no_data') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(!empty($sanPhamTrangChu))
            <x-pagination :paginator="$sanPhamTrangChu" />
        @endif
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="addProductModalLabel">{{ __('admin::cms.add_new') }} {{ __('admin::cms.product') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="addProductForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ten_san_pham" class="form-label">{{ __('admin::cms.product_name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="ten_san_pham" name="ten_san_pham" placeholder="{{ __('admin::cms.placeholder_product_name') }}" maxlength="255">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="gia_san_pham" class="form-label">{{ __('admin::cms.price') }} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="gia_san_pham" name="gia_san_pham" min="0" step="0.01" placeholder="0">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="hoa_hong" class="form-label">{{ __('admin::cms.commission') }} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="hoa_hong" name="hoa_hong" min="0" step="0.01" placeholder="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sao_vote" class="form-label">{{ __('admin::cms.rating') }} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="sao_vote" name="sao_vote" step="0.1" placeholder="5.0">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="da_ban" class="form-label">{{ __('admin::cms.sold') }} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="da_ban" name="da_ban" min="0" placeholder="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="trang_thai" class="form-label">{{ __('admin::cms.status') }} <span class="text-danger">*</span></label>
                                <select class="form-select" id="trang_thai" name="trang_thai">
                                    <option value="">{{ __('admin::cms.select_status') }}</option>
                                    <option value="1">{{ __('admin::cms.active') }}</option>
                                    <option value="0">{{ __('admin::cms.inactive') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="hinh_anh" class="form-label">{{ __('admin::cms.image') }} <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="hinh_anh" name="hinh_anh" accept="image/*" onchange="previewImage(this)">
                        <div class="form-text">{{ __('admin::cms.image_upload_help') }}</div>
                        <!-- Image Preview -->
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <div class="text-center">
                                <img id="previewImg" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid #dee2e6;">
                                <div class="mt-2">
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeImagePreview()">
                                        <i class="fas fa-times"></i> {{ __('admin::cms.remove_image') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin::cms.cancel') }}</button>
                    <button type="button" id="submitAddProductBtn" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ __('admin::cms.save') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="editProductModalLabel">{{ __('admin::cms.edit') }} {{ __('admin::cms.product') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="editProductForm">
                <input type="hidden" id="edit_product_id" name="product_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_ten_san_pham" class="form-label">{{ __('admin::cms.product_name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_ten_san_pham" name="ten_san_pham" placeholder="{{ __('admin::cms.placeholder_product_name') }}" maxlength="255">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_gia_san_pham" class="form-label">{{ __('admin::cms.price') }} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_gia_san_pham" name="gia_san_pham" min="0" step="0.01" placeholder="0">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_hoa_hong" class="form-label">{{ __('admin::cms.commission') }} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_hoa_hong" name="hoa_hong" min="0" step="0.01" placeholder="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_sao_vote" class="form-label">{{ __('admin::cms.rating') }} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_sao_vote" name="sao_vote" step="0.1" placeholder="5.0">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_da_ban" class="form-label">{{ __('admin::cms.sold') }} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_da_ban" name="da_ban" min="0" placeholder="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_trang_thai" class="form-label">{{ __('admin::cms.status') }} <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_trang_thai" name="trang_thai">
                                    <option value="">{{ __('admin::cms.select_status') }}</option>
                                    <option value="1">{{ __('admin::cms.active') }}</option>
                                    <option value="0">{{ __('admin::cms.inactive') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_hinh_anh" class="form-label">{{ __('admin::cms.image') }}</label>
                        <input type="file" class="form-control" id="edit_hinh_anh" name="hinh_anh" accept="image/*" onchange="previewEditImage(this)">
                        <div class="form-text">{{ __('admin::cms.image_upload_help') }} {{ __('admin::cms.image_optional') }}</div>
                        <!-- Current Image Display -->
                        <div id="currentImageDisplay" class="mt-3" style="display: none;">
                            <div class="text-center">
                                <div class="mb-2">
                                    <small class="text-muted">{{ __('admin::cms.current_image') }}:</small>
                                </div>
                                <img id="currentImg" src="" alt="Current" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid #dee2e6;">
                            </div>
                        </div>
                        <!-- New Image Preview -->
                        <div id="editImagePreview" class="mt-3" style="display: none;">
                            <div class="text-center">
                                <div class="mb-2">
                                    <small class="text-muted">{{ __('admin::cms.new_image') }}:</small>
                                </div>
                                <img id="editPreviewImg" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid #dee2e6;">
                                <div class="mt-2">
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeEditImagePreview()">
                                        <i class="fas fa-times"></i> {{ __('admin::cms.remove_image') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin::cms.cancel') }}</button>
                    <button type="button" id="submitEditProductBtn" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ __('admin::cms.update') }}
                    </button>
                </div>
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
<style>
    #imagePreview {
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
    }
    
    #previewImg {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
    }
    
    #previewImg:hover {
        transform: scale(1.05);
    }
    
    .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    
    .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    
</style>
@endpush
@include('components.pagination-styles')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    (function(){
        // ========================= ADD PRODUCT LOGIC =========================
        const addModalEl = document.getElementById('addProductModal');
        let addBsModal = addModalEl ? new bootstrap.Modal(addModalEl) : null;
        const addFormContainer = document.getElementById('addProductForm');
        const submitAddBtn = document.getElementById('submitAddProductBtn');

        window.openAddProductModal = function(){
            if (!addBsModal && addModalEl) {
                addBsModal = new bootstrap.Modal(addModalEl);
            }
            if (addBsModal) {
                // Reset form fields manually
                document.getElementById('ten_san_pham').value = '';
                document.getElementById('gia_san_pham').value = '';
                document.getElementById('hoa_hong').value = '';
                document.getElementById('sao_vote').value = '';
                document.getElementById('da_ban').value = '';
                document.getElementById('trang_thai').value = '';
                document.getElementById('hinh_anh').value = '';
                
                // Hide image preview
                const imagePreview = document.getElementById('imagePreview');
                if (imagePreview) imagePreview.style.display = 'none';
                addBsModal.show();
            }
        };

        // Image preview functions
        window.previewImage = function(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImg = document.getElementById('previewImg');
                    const imagePreview = document.getElementById('imagePreview');
                    if (previewImg && imagePreview) {
                        previewImg.src = e.target.result;
                        imagePreview.style.display = 'block';
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        };

        window.removeImagePreview = function() {
            const fileInput = document.getElementById('hinh_anh');
            const imagePreview = document.getElementById('imagePreview');
            if (fileInput && imagePreview) {
                fileInput.value = '';
                imagePreview.style.display = 'none';
            }
        };

        // Validation functions
        function validateForm() {
            let isValid = true;
            const errors = [];
            let firstErrorField = null;

            // Validate product name
            const tenSanPham = document.getElementById('ten_san_pham').value.trim();
            if (!tenSanPham) {
                errors.push('{{ __('admin::cms.product_name_required') }}');
                if (!firstErrorField) firstErrorField = 'ten_san_pham';
                isValid = false;
            } else if (tenSanPham.length > 255) {
                errors.push('{{ __('admin::cms.product_name_max_length') }}');
                if (!firstErrorField) firstErrorField = 'ten_san_pham';
                isValid = false;
            }

            // Validate price
            const giaSanPham = document.getElementById('gia_san_pham').value;
            if (!giaSanPham || giaSanPham === '') {
                errors.push('{{ __('admin::cms.price_required') }}');
                if (!firstErrorField) firstErrorField = 'gia_san_pham';
                isValid = false;
            } else if (parseFloat(giaSanPham) < 0) {
                errors.push('{{ __('admin::cms.price_min_value') }}');
                if (!firstErrorField) firstErrorField = 'gia_san_pham';
                isValid = false;
            }

            // Validate commission
            const hoaHong = document.getElementById('hoa_hong').value;
            if (!hoaHong || hoaHong === '') {
                errors.push('{{ __('admin::cms.commission_required') }}');
                if (!firstErrorField) firstErrorField = 'hoa_hong';
                isValid = false;
            } else if (parseFloat(hoaHong) < 0) {
                errors.push('{{ __('admin::cms.commission_min_value') }}');
                if (!firstErrorField) firstErrorField = 'hoa_hong';
                isValid = false;
            }

            // Validate rating
            const saoVote = document.getElementById('sao_vote').value;
            if (!saoVote || saoVote === '') {
                errors.push('{{ __('admin::cms.rating_required') }}');
                if (!firstErrorField) firstErrorField = 'sao_vote';
                isValid = false;
            } else {
                const rating = parseFloat(saoVote);
                if (isNaN(rating)) {
                    errors.push('{{ __('admin::cms.rating_invalid_number') }}');
                    if (!firstErrorField) firstErrorField = 'sao_vote';
                    isValid = false;
                } else if (rating < 0) {
                    errors.push('{{ __('admin::cms.rating_min_value') }}');
                    if (!firstErrorField) firstErrorField = 'sao_vote';
                    isValid = false;
                } else if (rating > 5) {
                    errors.push('{{ __('admin::cms.rating_max_value') }}');
                    if (!firstErrorField) firstErrorField = 'sao_vote';
                    isValid = false;
                }
            }

            // Validate sold quantity
            const daBan = document.getElementById('da_ban').value;
            if (!daBan || daBan === '') {
                errors.push('{{ __('admin::cms.sold_required') }}');
                if (!firstErrorField) firstErrorField = 'da_ban';
                isValid = false;
            } else if (parseInt(daBan) < 0) {
                errors.push('{{ __('admin::cms.sold_min_value') }}');
                if (!firstErrorField) firstErrorField = 'da_ban';
                isValid = false;
            }

            // Validate status
            const trangThai = document.getElementById('trang_thai').value;
            if (!trangThai || trangThai === '') {
                errors.push('{{ __('admin::cms.status_required') }}');
                if (!firstErrorField) firstErrorField = 'trang_thai';
                isValid = false;
            }

            // Validate image
            const hinhAnh = document.getElementById('hinh_anh').files[0];
            if (!hinhAnh) {
                errors.push('{{ __('admin::cms.image_required') }}');
                if (!firstErrorField) firstErrorField = 'hinh_anh';
                isValid = false;
            } else {
                // Check file type
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!allowedTypes.includes(hinhAnh.type)) {
                    errors.push('{{ __('admin::cms.image_invalid_type') }}');
                    if (!firstErrorField) firstErrorField = 'hinh_anh';
                    isValid = false;
                }
                // Check file size (2MB = 2 * 1024 * 1024 bytes)
                if (hinhAnh.size > 2 * 1024 * 1024) {
                    errors.push('{{ __('admin::cms.image_size_limit') }}');
                    if (!firstErrorField) firstErrorField = 'hinh_anh';
                    isValid = false;
                }
            }

            // Display errors using toast and focus
            if (!isValid) {
                showValidationErrors(errors, firstErrorField);
            }

            return isValid;
        }

        function showValidationErrors(errors, firstErrorField) {
            if (errors.length > 0) {
                // Show only the first error
                if (window.showToast) {
                    window.showToast(errors[0], { type: 'error' });
                }
                
                // Focus on the first error field
                if (firstErrorField) {
                    const errorField = document.getElementById(firstErrorField);
                    if (errorField) {
                        // Small delay to ensure toast is shown first
                        setTimeout(() => {
                            errorField.focus();
                            // Scroll to the field if needed
                            errorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }, 100);
                    }
                }
            }
        }

        // Handle add product button click
        submitAddBtn && submitAddBtn.addEventListener('click', function(e){
            e.preventDefault();
            if (!submitAddBtn) return;
            
            // Validate form before submission
            if (!validateForm()) {
                return;
            }
            
            submitAddBtn.disabled = true;
            const originalHtml = submitAddBtn.innerHTML;
            submitAddBtn.innerHTML = '<span class="loading" style="width:16px; height:16px; border-width:2px; margin-right:6px;"></span> {{ __('admin::cms.saving') }}';

            // Create FormData for file upload
            const formData = new FormData();
            formData.append('ten_san_pham', document.getElementById('ten_san_pham').value);
            formData.append('gia_san_pham', document.getElementById('gia_san_pham').value);
            formData.append('hoa_hong', document.getElementById('hoa_hong').value);
            formData.append('sao_vote', document.getElementById('sao_vote').value);
            formData.append('da_ban', document.getElementById('da_ban').value);
            formData.append('trang_thai', document.getElementById('trang_thai').value);
            
            const hinhAnhFile = document.getElementById('hinh_anh').files[0];
            if (hinhAnhFile) {
                formData.append('hinh_anh', hinhAnhFile);
            }

            axios.post('{{ route("admin.san-pham-trang-chu.store") }}', formData, {
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 
                    'Accept': 'application/json',
                    'Content-Type': 'multipart/form-data'
                }
            }).then(function(res){
                if (res.data && res.data.success !== false){
                    if (addBsModal) addBsModal.hide();
                    if (window.showToast) window.showToast('{{ __('admin::cms.saved_success') }}', { type: 'success' });
                    location.reload();
                } else {
                    const msg = res.data && (res.data.message || res.data.errors) || '{{ __('admin::cms.error_generic') }}';
                    if (window.showToast) window.showToast(Array.isArray(msg) ? msg[0] : String(msg), { type: 'error' });
                }
            }).catch(function(error){
                let errorMsg = '{{ __('admin::cms.error_network') }}';
                if (error.response && error.response.data) {
                    const data = error.response.data;
                    if (data.errors) {
                        const firstError = Object.values(data.errors)[0];
                        errorMsg = Array.isArray(firstError) ? firstError[0] : firstError;
                    } else if (data.message) {
                        errorMsg = data.message;
                    }
                }
                if (window.showToast) window.showToast(errorMsg, { type: 'error' });
            }).finally(function(){
                submitAddBtn.disabled = false;
                submitAddBtn.innerHTML = originalHtml;
            });
        });

        // ========================= EDIT PRODUCT LOGIC =========================
        const editModalEl = document.getElementById('editProductModal');
        let editBsModal = editModalEl ? new bootstrap.Modal(editModalEl) : null;
        const editFormContainer = document.getElementById('editProductForm');
        const submitEditBtn = document.getElementById('submitEditProductBtn');

        window.openEditProductModal = function(productId, productName, price, commission, rating, sold, status, image) {
            if (!editBsModal && editModalEl) {
                editBsModal = new bootstrap.Modal(editModalEl);
            }
            if (editBsModal) {
                // Set product ID
                document.getElementById('edit_product_id').value = productId;
                
                // Fill form fields
                document.getElementById('edit_ten_san_pham').value = productName || '';
                document.getElementById('edit_gia_san_pham').value = price || '';
                document.getElementById('edit_hoa_hong').value = commission || '';
                document.getElementById('edit_sao_vote').value = rating || '';
                document.getElementById('edit_da_ban').value = sold || '';
                document.getElementById('edit_trang_thai').value = status || '';
                
                // Handle image display
                const currentImageDisplay = document.getElementById('currentImageDisplay');
                const currentImg = document.getElementById('currentImg');
                const editImagePreview = document.getElementById('editImagePreview');
                const fileInput = document.getElementById('edit_hinh_anh');
                
                // Reset file input
                fileInput.value = '';
                
                // Hide new image preview
                if (editImagePreview) editImagePreview.style.display = 'none';
                
                // Show current image if exists
                if (image && image.trim() !== '') {
                    const isUrl = image.startsWith('http');
                    const imageSrc = isUrl ? image : `{{ asset('') }}${image}`;
                    if (currentImg) {
                        currentImg.src = imageSrc;
                        currentImageDisplay.style.display = 'block';
                    }
                } else {
                    if (currentImageDisplay) currentImageDisplay.style.display = 'none';
                }
                
                editBsModal.show();
            }
        };

        // Image preview functions for edit modal
        window.previewEditImage = function(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const editPreviewImg = document.getElementById('editPreviewImg');
                    const editImagePreview = document.getElementById('editImagePreview');
                    if (editPreviewImg && editImagePreview) {
                        editPreviewImg.src = e.target.result;
                        editImagePreview.style.display = 'block';
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        };

        window.removeEditImagePreview = function() {
            const fileInput = document.getElementById('edit_hinh_anh');
            const editImagePreview = document.getElementById('editImagePreview');
            if (fileInput && editImagePreview) {
                fileInput.value = '';
                editImagePreview.style.display = 'none';
            }
        };

        // Validation functions for edit form
        function validateEditForm() {
            let isValid = true;
            const errors = [];
            let firstErrorField = null;

            // Validate product name
            const tenSanPham = document.getElementById('edit_ten_san_pham').value.trim();
            if (!tenSanPham) {
                errors.push('{{ __('admin::cms.product_name_required') }}');
                if (!firstErrorField) firstErrorField = 'edit_ten_san_pham';
                isValid = false;
            } else if (tenSanPham.length > 255) {
                errors.push('{{ __('admin::cms.product_name_max_length') }}');
                if (!firstErrorField) firstErrorField = 'edit_ten_san_pham';
                isValid = false;
            }

            // Validate price
            const giaSanPham = document.getElementById('edit_gia_san_pham').value;
            if (!giaSanPham || giaSanPham === '') {
                errors.push('{{ __('admin::cms.price_required') }}');
                if (!firstErrorField) firstErrorField = 'edit_gia_san_pham';
                isValid = false;
            } else if (parseFloat(giaSanPham) < 0) {
                errors.push('{{ __('admin::cms.price_min_value') }}');
                if (!firstErrorField) firstErrorField = 'edit_gia_san_pham';
                isValid = false;
            }

            // Validate commission
            const hoaHong = document.getElementById('edit_hoa_hong').value;
            if (!hoaHong || hoaHong === '') {
                errors.push('{{ __('admin::cms.commission_required') }}');
                if (!firstErrorField) firstErrorField = 'edit_hoa_hong';
                isValid = false;
            } else if (parseFloat(hoaHong) < 0) {
                errors.push('{{ __('admin::cms.commission_min_value') }}');
                if (!firstErrorField) firstErrorField = 'edit_hoa_hong';
                isValid = false;
            }

            // Validate rating
            const saoVote = document.getElementById('edit_sao_vote').value;
            if (!saoVote || saoVote === '') {
                errors.push('{{ __('admin::cms.rating_required') }}');
                if (!firstErrorField) firstErrorField = 'edit_sao_vote';
                isValid = false;
            } else {
                const rating = parseFloat(saoVote);
                if (isNaN(rating)) {
                    errors.push('{{ __('admin::cms.rating_invalid_number') }}');
                    if (!firstErrorField) firstErrorField = 'edit_sao_vote';
                    isValid = false;
                } else if (rating < 0) {
                    errors.push('{{ __('admin::cms.rating_min_value') }}');
                    if (!firstErrorField) firstErrorField = 'edit_sao_vote';
                    isValid = false;
                } else if (rating > 5) {
                    errors.push('{{ __('admin::cms.rating_max_value') }}');
                    if (!firstErrorField) firstErrorField = 'edit_sao_vote';
                    isValid = false;
                }
            }

            // Validate sold quantity
            const daBan = document.getElementById('edit_da_ban').value;
            if (!daBan || daBan === '') {
                errors.push('{{ __('admin::cms.sold_required') }}');
                if (!firstErrorField) firstErrorField = 'edit_da_ban';
                isValid = false;
            } else if (parseInt(daBan) < 0) {
                errors.push('{{ __('admin::cms.sold_min_value') }}');
                if (!firstErrorField) firstErrorField = 'edit_da_ban';
                isValid = false;
            }

            // Validate status
            const trangThai = document.getElementById('edit_trang_thai').value;
            if (!trangThai || trangThai === '') {
                errors.push('{{ __('admin::cms.status_required') }}');
                if (!firstErrorField) firstErrorField = 'edit_trang_thai';
                isValid = false;
            }

            // Validate image (optional for edit)
            const hinhAnh = document.getElementById('edit_hinh_anh').files[0];
            if (hinhAnh) {
                // Check file type
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!allowedTypes.includes(hinhAnh.type)) {
                    errors.push('{{ __('admin::cms.image_invalid_type') }}');
                    if (!firstErrorField) firstErrorField = 'edit_hinh_anh';
                    isValid = false;
                }
                // Check file size (2MB = 2 * 1024 * 1024 bytes)
                if (hinhAnh.size > 2 * 1024 * 1024) {
                    errors.push('{{ __('admin::cms.image_size_limit') }}');
                    if (!firstErrorField) firstErrorField = 'edit_hinh_anh';
                    isValid = false;
                }
            }

            // Display errors using toast and focus
            if (!isValid) {
                showValidationErrors(errors, firstErrorField);
            }

            return isValid;
        }

        // Handle edit product button click
        submitEditBtn && submitEditBtn.addEventListener('click', function(e){
            e.preventDefault();
            if (!submitEditBtn) return;
            
            // Validate form before submission
            if (!validateEditForm()) {
                return;
            }
            
            submitEditBtn.disabled = true;
            const originalHtml = submitEditBtn.innerHTML;
            submitEditBtn.innerHTML = '<span class="loading" style="width:16px; height:16px; border-width:2px; margin-right:6px;"></span> {{ __('admin::cms.updating') }}';

            // Create FormData for file upload
            const formData = new FormData();
            formData.append('ten_san_pham', document.getElementById('edit_ten_san_pham').value);
            formData.append('gia_san_pham', document.getElementById('edit_gia_san_pham').value);
            formData.append('hoa_hong', document.getElementById('edit_hoa_hong').value);
            formData.append('sao_vote', document.getElementById('edit_sao_vote').value);
            formData.append('da_ban', document.getElementById('edit_da_ban').value);
            formData.append('trang_thai', document.getElementById('edit_trang_thai').value);
            
            const hinhAnhFile = document.getElementById('edit_hinh_anh').files[0];
            if (hinhAnhFile) {
                formData.append('hinh_anh', hinhAnhFile);
            }
            
            const productId = document.getElementById('edit_product_id').value;

            axios.post(`{{ url('/admin/san-pham-trang-chu') }}/${productId}`, formData, {
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 
                    'Accept': 'application/json',
                    'Content-Type': 'multipart/form-data'
                }
            }).then(function(res){
                if (res.data && res.data.success !== false){
                    if (editBsModal) editBsModal.hide();
                    if (window.showToast) window.showToast('{{ __('admin::cms.updated_success') }}', { type: 'success' });
                    location.reload();
                } else {
                    const msg = res.data && (res.data.message || res.data.errors) || '{{ __('admin::cms.error_generic') }}';
                    if (window.showToast) window.showToast(Array.isArray(msg) ? msg[0] : String(msg), { type: 'error' });
                }
            }).catch(function(error){
                let errorMsg = '{{ __('admin::cms.error_network') }}';
                if (error.response && error.response.data) {
                    const data = error.response.data;
                    if (data.errors) {
                        const firstError = Object.values(data.errors)[0];
                        errorMsg = Array.isArray(firstError) ? firstError[0] : firstError;
                    } else if (data.message) {
                        errorMsg = data.message;
                    }
                }
                if (window.showToast) window.showToast(errorMsg, { type: 'error' });
            }).finally(function(){
                submitEditBtn.disabled = false;
                submitEditBtn.innerHTML = originalHtml;
            });
        });

        // ========================= TOGGLE STATUS LOGIC =========================
        window.toggleProductStatus = function(productId, currentStatus) {
            const toggleBtn = document.getElementById(`toggle-btn-${productId}`);
            const statusBadge = document.getElementById(`status-badge-${productId}`);
            
            if (!toggleBtn || !statusBadge) return;
            
            // Disable button during request
            toggleBtn.disabled = true;
            const originalHtml = toggleBtn.innerHTML;
            toggleBtn.innerHTML = '<span class="loading" style="width:12px; height:12px; border-width:1px; margin-right:4px;"></span>';
            
            axios.post(`{{ url('/admin/san-pham-trang-chu') }}/${productId}/toggle-status`, {}, {
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 
                    'Accept': 'application/json' 
                }
            }).then(function(res){
                if (res.data && res.data.success){
                    const newStatus = res.data.trang_thai;
                    
                    // Update status badge
                    if (newStatus == 1) {
                        statusBadge.className = 'badge bg-success';
                        statusBadge.textContent = '{{ __('admin::cms.active') }}';
                    } else {
                        statusBadge.className = 'badge bg-secondary';
                        statusBadge.textContent = '{{ __('admin::cms.inactive') }}';
                    }
                    
                    // Update toggle button
                    if (newStatus == 1) {
                        toggleBtn.className = 'btn btn-warning btn-sm me-1';
                        toggleBtn.title = '{{ __('admin::cms.deactivate') }}';
                        toggleBtn.innerHTML = '<i class="fas fa-pause"></i>';
                    } else {
                        toggleBtn.className = 'btn btn-success btn-sm me-1';
                        toggleBtn.title = '{{ __('admin::cms.activate') }}';
                        toggleBtn.innerHTML = '<i class="fas fa-play"></i>';
                    }
                    
                    if (window.showToast) {
                        const message = newStatus == 1 ? '{{ __('admin::cms.activated_success') }}' : '{{ __('admin::cms.deactivated_success') }}';
                        window.showToast(message, { type: 'success' });
                    }
                } else {
                    if (window.showToast) window.showToast('{{ __('admin::cms.error_generic') }}', { type: 'error' });
                }
            }).catch(function(error){
                let errorMsg = '{{ __('admin::cms.error_network') }}';
                if (error.response && error.response.data) {
                    const data = error.response.data;
                    if (data.message) {
                        errorMsg = data.message;
                    }
                }
                if (window.showToast) window.showToast(errorMsg, { type: 'error' });
            }).finally(function(){
                toggleBtn.disabled = false;
                if (toggleBtn.innerHTML.includes('loading')) {
                    toggleBtn.innerHTML = originalHtml;
                }
            });
        };

        // ========================= DELETE PRODUCT LOGIC =========================
        const deleteModalEl = document.getElementById('deleteProductModal');
        let deleteBsModal = deleteModalEl ? new bootstrap.Modal(deleteModalEl) : null;
        const deleteMsgEl = document.getElementById('deleteProductMessage');
        const confirmDeleteBtn = document.getElementById('confirmDeleteProductBtn');
        let deleteTargetId = null;

        window.onRequestDeleteProduct = function(productId, productName){
            console.log('🗑️ [DELETE] Request to delete product:', { productId, productName });
            deleteTargetId = productId;
            if (deleteMsgEl) {
                deleteMsgEl.textContent = productName 
                    ? `{{ __('admin::cms.confirm_delete_product') }} (${productName})`
                    : `{{ __('admin::cms.confirm_delete_product') }}`;
            }
            if (!deleteBsModal && deleteModalEl) {
                deleteBsModal = new bootstrap.Modal(deleteModalEl);
            }
            if (deleteBsModal) deleteBsModal.show();
        };

        confirmDeleteBtn && confirmDeleteBtn.addEventListener('click', function(){
            if (!deleteTargetId) {
                console.error('❌ [DELETE] No target ID set for deletion');
                return;
            }
            
            console.log('🚀 [DELETE] Starting deletion process for product ID:', deleteTargetId);
            confirmDeleteBtn.disabled = true;
            const originalHtml = confirmDeleteBtn.innerHTML;
            confirmDeleteBtn.innerHTML = '<span class="loading" style="width:16px; height:16px; border-width:2px; margin-right:6px;"></span> {{ __('admin::cms.deleting') }}';

            const deleteUrl = `{{ url('/admin/xoa-san-pham-trang-chu') }}/${deleteTargetId}`;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            console.log('📡 [DELETE] Sending POST request to:', deleteUrl);
            console.log('🔐 [DELETE] CSRF Token:', csrfToken ? 'Present' : 'Missing');

            axios.post(deleteUrl, {}, {
                headers: { 
                    'X-CSRF-TOKEN': csrfToken, 
                    'Accept': 'application/json' 
                }
            }).then(function(res){
                console.log('✅ [DELETE] Response received:', res.data);
                
                if (res.data && res.data.success){
                    console.log('🎉 [DELETE] Deletion successful');
                    if (deleteBsModal) deleteBsModal.hide();
                    if (window.showToast) window.showToast(res.data.message || '{{ __('admin::cms.product_deleted_successfully') }}', { type: 'success' });
                    console.log('🔄 [DELETE] Reloading page in 2 seconds...');
                    setTimeout(function(){
                        location.reload();
                    }, 2000);
                } else {
                    console.warn('⚠️ [DELETE] Deletion failed - success flag is false:', res.data);
                    const msg = res.data && (res.data.message || res.data.errors) || '{{ __('admin::cms.error_generic') }}';
                    if (window.showToast) window.showToast(Array.isArray(msg) ? msg[0] : String(msg), { type: 'error' });
                }
            }).catch(function(error){
                console.error('❌ [DELETE] Request failed:', error);
                console.error('❌ [DELETE] Error details:', {
                    message: error.message,
                    status: error.response?.status,
                    statusText: error.response?.statusText,
                    data: error.response?.data
                });
                
                let errorMsg = '{{ __('admin::cms.error_network') }}';
                if (error.response && error.response.data) {
                    const data = error.response.data;
                    if (data.errors) {
                        const firstError = Object.values(data.errors)[0];
                        errorMsg = Array.isArray(firstError) ? firstError[0] : firstError;
                    } else if (data.message) {
                        errorMsg = data.message;
                    }
                }
                if (window.showToast) window.showToast(errorMsg, { type: 'error' });
            }).finally(function(){
                console.log('🏁 [DELETE] Request completed, resetting button');
                confirmDeleteBtn.disabled = false;
                confirmDeleteBtn.innerHTML = originalHtml;
            });
        });
    })();
</script>
@endpush
