@php
    use App\Helpers\LanguageHelper;
    $__ = [LanguageHelper::class, 'getUserTranslation'];
    $__home = [LanguageHelper::class, 'getHomeTranslation'];
    $__account = fn($key) => LanguageHelper::getTranslationFromFile('account', $key, 'user');
@endphp

@extends('user.layouts.app')

@section('title', ($__account('account_history') ?? 'Lịch sử tài khoản') . ' - ' . ($__('tiktok_shop') ?? 'TikTok Shop'))

@section('content')
<div class="nav-header">
    <button class="nav-button" onclick="goBack()">
        <i class="fas fa-chevron-left"></i>
    </button>
    <div class="nav-title">{{ $__account('account_history') ?? 'Lịch sử tài khoản' }}</div>
    <x-user.language-switcher />
</div>

<div class="container">
    <x-user-info-card />

    <div class="account-card px-3">
        <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
            <h5 class="mb-0">{{ $__account('account_history') ?? 'Lịch sử tài khoản' }}</h5>
        </div>

        <div class="table-responsive mt-3 mb-3">
            <table class="table table-sm table-bordered hover table-striped align-middle mb-0" style="font-size: 12px;">
                <thead>
                    <tr>
                        <th class="text-center">{{ $__home('serial') ?? 'STT' }}</th>
                        <th>{{ $__home('amount') ?? 'Số tiền' }}</th>
                        <th>{{ $__account('type') ?? 'Loại' }}</th>
                        <th>{{ $__home('status') ?? 'Trạng thái' }}</th>
                        <th>{{ $__home('time') ?? 'Thời gian' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($accountHistory)
                        @forelse ($accountHistory as $index => $item)
                            <tr>
                                <td class="text-center">{{ ($accountHistory->currentPage() - 1) * $accountHistory->perPage() + $index + 1 }}</td>
                                <td class="{{ isset($item->hanh_dong) && (int)$item->hanh_dong === 1 ? 'text-success' : 'text-danger' }} fw-semibold">
                                    {{ number_format($item->so_tien ?? 0, 0, ',', '.') }}
                                </td>
                                <td>
                                    @switch($item->hanh_dong)
                                        @case(1)
                                            {{ $__account('deposit') ?? 'Nạp tiền' }}
                                            @break
                                        @case(2)
                                            {{ $__account('withdraw') ?? 'Rút tiền' }}
                                            @break
                                        @default
                                            {{ $__account('other') ?? 'Khác' }}
                                    @endswitch
                                </td>
                                <td>
                                    @php
                                        $status = $item->trang_thai ?? null;
                                    @endphp
                                    @if($status === 1 || $status === '1')
                                        <span class="badge bg-success">{{ $__home('success') ?? 'Thành công' }}</span>
                                    @elseif($status === 0 || $status === '0' || is_null($status))
                                        <span class="badge bg-warning text-dark">{{ $__home('pending') ?? 'Đang xử lý' }}</span>
                                    @elseif($status === 2 || $status === '2')
                                        <span class="badge bg-danger">{{ $__home('failed') ?? 'Thất bại' }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ (string)$status }}</span>
                                    @endif
                                </td>
                                <td>{{ optional($item->created_at)->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">{{ $__home('no_data') }}</td>
                            </tr>
                        @endforelse
                    @else
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">{{ $__home('no_data') }}</td>
                        </tr>
                    @endisset
                </tbody>
            </table>
        </div>

        @isset($histories)
            <div class="mt-3">
                {{ $histories->links() }}
            </div>
        @endisset
    </div>
</div>

<script>
    function goBack() {
        if (window.history.length > 1) {
            window.history.back();
        } else {
            window.location.href = '/account';
        }
    }
</script>
@endsection

