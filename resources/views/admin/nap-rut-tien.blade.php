@extends('admin.layouts.app')

@section('title', __('admin::cms.nap_rut_management'))
@section('breadcrumb', __('admin::cms.nap_rut_management'))

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('admin::cms.nap_rut_list') }}</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.nap-rut-tien') }}" style="margin-bottom: 0.75rem; display: flex; gap: 0.4rem; align-items: center;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('admin::cms.search_placeholder_phone') }}" style="flex: 1; padding: 0.35rem 0.5rem; font-size: 0.875rem; border: 1px solid var(--gray-400); border-radius: var(--border-radius); background: var(--gray-100); color: var(--gray-800); height: 32px;">
                <select name="loai_giao_dich" class="form-select" style="width: 150px; height: 32px; padding: 0.2rem 1.6rem 0.2rem 0.5rem; font-size: 0.8125rem;">
                    <option value="">{{ __('admin::cms.transaction_type') }}</option>
                    <option value="nap" {{ request('loai_giao_dich') == 'nap' ? 'selected' : '' }}>{{ __('admin::cms.deposit') }}</option>
                    <option value="rut" {{ request('loai_giao_dich') == 'rut' ? 'selected' : '' }}>{{ __('admin::cms.withdraw') }}</option>
                </select>
                <select name="trang_thai" class="form-select" style="width: 150px; height: 32px; padding: 0.2rem 1.6rem 0.2rem 0.5rem; font-size: 0.8125rem;">
                    <option value="">{{ __('admin::cms.status') }}</option>
                    <option value="0" {{ request('trang_thai') == '0' ? 'selected' : '' }}>{{ __('admin::cms.pending') }}</option>
                    <option value="1" {{ request('trang_thai') == '1' ? 'selected' : '' }}>{{ __('admin::cms.approved') }}</option>
                    <option value="2" {{ request('trang_thai') == '2' ? 'selected' : '' }}>{{ __('admin::cms.rejected') }}</option>
                </select>
                <button type="submit" class="btn btn-primary" style="height: 32px; padding: 0.35rem 0.6rem; font-size: 0.8125rem;"><i class="fas fa-search"></i> {{ __('admin::cms.search') }}</button>
                <a href="{{ route('admin.nap-rut-tien') }}" class="btn btn-secondary" style="height: 32px; padding: 0.35rem 0.6rem; font-size: 0.8125rem;"><i class="fas fa-rotate"></i> {{ __('admin::cms.reset') }}</a>
            </form>

            <div style="margin-bottom: 0.5rem; color: var(--white); font-size: 0.875rem;">{{ __('admin::cms.total') }}: {{ $napRut->total() }}</div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 60px; color: var(--white);">{{ __('admin::cms.stt') }}</th>
                            <th style="width: 200px; color: var(--white);">{{ __('admin::cms.user') }}</th>
                            <th style="width: 150px; color: var(--white);">{{ __('admin::cms.phone') }}</th>
                            <th style="width: 150px; color: var(--white);">{{ __('admin::cms.transaction_type') }}</th>
                            <th class="text-end" style="width: 120px; color: var(--white);">{{ __('admin::cms.amount') }}</th>
                            <th style="width: 120px; color: var(--white);">{{ __('admin::cms.status') }}</th>
                            <th style="color: var(--white);">{{ __('admin::cms.note') }}</th>
                            <th class="text-center" style="width: 140px; color: var(--white);">{{ __('admin::cms.time') }}</th>
                            <th style="width: 150px; color: var(--white);">{{ __('admin::cms.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($napRut as $index => $item)
                            <tr>
                                <td class="text-center" style="color: var(--white);">{{ $napRut->firstItem() + $index }}</td>
                                <td>
                                    <div class="fw-bold" style="color: var(--white);">{{ $item->user?->name ?? 'N/A' }}</div>
                                </td>
                                <td>
                                    <span style="color: var(--white);">
                                        {{ $item->user?->phone ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    @if($item->loai_giao_dich == 'nap')
                                        <span class="badge bg-success">
                                            <i class="fas fa-arrow-down me-1"></i>{{ __('admin::cms.deposit') }}
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="fas fa-arrow-up me-1"></i>{{ __('admin::cms.withdraw') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <span class="fw-bold" style="color: var(--success-color);">
                                        {{ number_format((float) $item->so_tien, 0, '.', '.') }} VNĐ
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $statusMap = [
                                            0 => ['text' => __('admin::cms.pending'), 'class' => 'bg-warning'],
                                            1 => ['text' => __('admin::cms.approved'), 'class' => 'bg-success'],
                                            2 => ['text' => __('admin::cms.rejected'), 'class' => 'bg-danger'],
                                        ];
                                        $status = $statusMap[$item->trang_thai] ?? ['text' => __('admin::cms.unknown'), 'class' => 'bg-secondary'];
                                    @endphp
                                    <span class="badge {{ $status['class'] }}">{{ $status['text'] }}</span>
                                </td>
                                <td>
                                    <div class="text-truncate" title="{{ $item->ghi_chu }}" style="max-width: 200px;">
                                        {{ $item->ghi_chu ?? '—' }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div style="color: var(--white);">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ optional($item->created_at)->format('d/m/Y') }}
                                    </div>
                                    <small style="color: var(--gray-500);">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ optional($item->created_at)->format('H:i:s') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @if($item->trang_thai == 0)
                                            <button class="btn btn-success btn-sm" onclick="updateStatus({{ $item->id }}, 1)" title="{{ __('admin::cms.approve') }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm" onclick="updateStatus({{ $item->id }}, 2)" title="{{ __('admin::cms.reject') }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                        <button class="btn btn-info btn-sm" onclick="viewDetails({{ $item->id }})" title="{{ __('admin::cms.view_details') }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-warning btn-sm" onclick="editNapRut({{ $item->id }})" title="{{ __('admin::cms.edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <div class="mb-3">
                                        <i class="fas fa-exchange-alt fa-3x" style="color: var(--gray-500);"></i>
                                    </div>
                                    <h5 style="color: var(--white);">{{ __('admin::cms.no_transactions_found') }}</h5>
                                    <p style="color: var(--gray-500);">{{ __('admin::cms.no_transactions_description') }}</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <x-pagination :paginator="$napRut" :show-info-text="true" :show-info="__('admin::cms.showing') . ' ' . $napRut->firstItem() . ' - ' . $napRut->lastItem() . ' ' . __('admin::cms.of') . ' ' . $napRut->total() . ' ' . __('admin::cms.results')" />
        </div>
    </div>

    <!-- Add Nap Rut Modal -->
    <div class="modal fade" id="addNapRutModal" tabindex="-1" aria-labelledby="addNapRutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNapRutModalLabel">{{ __('admin::cms.add_nap_rut') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.nap-rut-tien.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">{{ __('admin::cms.user') }}</label>
                            <select class="form-select" id="user_id" name="user_id" required>
                                <option value="">{{ __('admin::cms.select_user') }}</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->phone }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="loai_giao_dich" class="form-label">{{ __('admin::cms.transaction_type') }}</label>
                            <select class="form-select" id="loai_giao_dich" name="loai_giao_dich" required>
                                <option value="">{{ __('admin::cms.select_transaction_type') }}</option>
                                <option value="nap">{{ __('admin::cms.deposit') }}</option>
                                <option value="rut">{{ __('admin::cms.withdraw') }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="so_tien" class="form-label">{{ __('admin::cms.amount') }}</label>
                            <input type="number" class="form-control" id="so_tien" name="so_tien" required min="0" step="1000">
                        </div>
                        <div class="mb-3">
                            <label for="ghi_chu" class="form-label">{{ __('admin::cms.note') }}</label>
                            <textarea class="form-control" id="ghi_chu" name="ghi_chu" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="trang_thai" class="form-label">{{ __('admin::cms.status') }}</label>
                            <select class="form-select" id="trang_thai" name="trang_thai">
                                <option value="0">{{ __('admin::cms.pending') }}</option>
                                <option value="1">{{ __('admin::cms.approved') }}</option>
                                <option value="2">{{ __('admin::cms.rejected') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin::cms.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('admin::cms.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Details Modal -->
    <div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewDetailsModalLabel">{{ __('admin::cms.transaction_details') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="transactionDetails">
                    <!-- Details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin::cms.close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Include pagination styles --}}
@include('components.pagination-styles')

@section('scripts')
<script>
function updateStatus(id, status) {
    if (confirm('{{ __("admin::cms.confirm_status_update") }}')) {
        fetch(`/admin/nap-rut-tien/${id}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('{{ __("admin::cms.error_occurred") }}');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('{{ __("admin::cms.error_occurred") }}');
        });
    }
}

function viewDetails(id) {
    fetch(`/admin/nap-rut-tien/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('transactionDetails').innerHTML = data.html;
            new bootstrap.Modal(document.getElementById('viewDetailsModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('{{ __("admin::cms.error_occurred") }}');
        });
}

function editNapRut(id) {
    // Implement edit functionality
    console.log('Edit nap rut:', id);
}
</script>
@endsection
