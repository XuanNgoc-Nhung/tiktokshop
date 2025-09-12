@php
    use App\Helpers\LanguageHelper;
    $__ = [LanguageHelper::class, 'getUserTranslation'];
    $__home = [LanguageHelper::class, 'getHomeTranslation'];
@endphp

@extends('user.layouts.app')

@section('title', $__home('orders') . ' - ' . $__('tiktok_shop'))

@section('content')
<div class="nav-header">
    <button class="nav-button" onclick="goBack()">
        <i class="fas fa-chevron-left"></i>
    </button>
    <div class="nav-title">{{ $__home('orders') }}</div>
    <x-user.language-switcher />
</div>

<div class="container">
    <!-- User Info Card -->
        <x-user-info-card />

    <div class="account-card px-3">
        <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
            <h5 class="mb-0">{{ $__home('orders') }}</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered hover table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th class="text-center">{{ $__home('serial') }}</th>
                        <th>{{ $__home('name') }}</th>
                        <th>{{ $__home('commission') }}</th>
                        <th>{{ $__home('time') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $index => $order)
                        <tr>
                            <td class="text-center">{{ ($orders->currentPage() - 1) * $orders->perPage() + $index + 1 }}</td>
                            <td>{{ $order->sanPham->ten }}</td>
                            <td class="text-success fw-semibold">+{{ number_format($order->hoa_hong, 0, ',', '.') }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">{{ $__home('no_data') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</div>

<script>
    function goBack() {
        if (window.history.length > 1) {
            window.history.back();
        } else {
            window.location.href = '/dashboard';
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        // noop for now
    });
</script>
@endsection


