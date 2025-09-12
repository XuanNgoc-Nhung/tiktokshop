<div class="row">
    <div class="col-md-6">
        <h6 class="fw-bold mb-3">{{ __('admin::cms.user_information') }}</h6>
        <div class="mb-3">
            <label class="form-label fw-bold">{{ __('admin::cms.name') }}:</label>
            <p class="mb-0">{{ $napRut->user->name ?? 'N/A' }}</p>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">{{ __('admin::cms.phone') }}:</label>
            <p class="mb-0">{{ $napRut->user->phone ?? 'N/A' }}</p>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">{{ __('admin::cms.email') }}:</label>
            <p class="mb-0">{{ $napRut->user->email ?? 'N/A' }}</p>
        </div>
    </div>
    
    <div class="col-md-6">
        <h6 class="fw-bold mb-3">{{ __('admin::cms.transaction_information') }}</h6>
        <div class="mb-3">
            <label class="form-label fw-bold">{{ __('admin::cms.transaction_type') }}:</label>
            <p class="mb-0">
                @if($napRut->loai_giao_dich == 'nap')
                    <span class="badge bg-success">
                        <i class="fas fa-arrow-down me-1"></i>{{ __('admin::cms.deposit') }}
                    </span>
                @else
                    <span class="badge bg-warning">
                        <i class="fas fa-arrow-up me-1"></i>{{ __('admin::cms.withdraw') }}
                    </span>
                @endif
            </p>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">{{ __('admin::cms.amount') }}:</label>
            <p class="mb-0 fw-bold text-primary">{{ number_format((float) $napRut->so_tien, 0, '.', '.') }} VNĐ</p>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">{{ __('admin::cms.status') }}:</label>
            <p class="mb-0">
                @php
                    $statusMap = [
                        0 => ['text' => __('admin::cms.pending'), 'class' => 'bg-warning'],
                        1 => ['text' => __('admin::cms.approved'), 'class' => 'bg-success'],
                        2 => ['text' => __('admin::cms.rejected'), 'class' => 'bg-danger'],
                    ];
                    $status = $statusMap[$napRut->trang_thai] ?? ['text' => __('admin::cms.unknown'), 'class' => 'bg-secondary'];
                @endphp
                <span class="badge {{ $status['class'] }}">{{ $status['text'] }}</span>
            </p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h6 class="fw-bold mb-3">{{ __('admin::cms.note') }}</h6>
        <div class="mb-3">
            <p class="mb-0">{{ $napRut->ghi_chu ?? '—' }}</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <h6 class="fw-bold mb-3">{{ __('admin::cms.created_at') }}</h6>
        <div class="mb-3">
            <p class="mb-0">
                <i class="fas fa-calendar me-1"></i>
                {{ optional($napRut->created_at)->format('d/m/Y H:i:s') }}
            </p>
        </div>
    </div>
    
    <div class="col-md-6">
        <h6 class="fw-bold mb-3">{{ __('admin::cms.updated_at') }}</h6>
        <div class="mb-3">
            <p class="mb-0">
                <i class="fas fa-calendar me-1"></i>
                {{ optional($napRut->updated_at)->format('d/m/Y H:i:s') }}
            </p>
        </div>
    </div>
</div>
