@extends('admin.layouts.app')

@section('title', __('admin::cms.order_management'))

@section('breadcrumb', __('admin::cms.order_management'))

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('admin::cms.order_history') }}</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.order-management') }}" style="margin-bottom: 0.75rem; display: flex; gap: 0.4rem; align-items: center;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('admin::cms.search_placeholder_phone') }}" style="flex: 1; padding: 0.35rem 0.5rem; font-size: 0.875rem; border: 1px solid var(--gray-400); border-radius: var(--border-radius); background: var(--gray-100); color: var(--gray-800); height: 32px;">
                <button type="submit" class="btn btn-primary" style="height: 32px; padding: 0.35rem 0.6rem; font-size: 0.8125rem;"><i class="fas fa-search"></i> {{ __('admin::cms.search') }}</button>
                <a href="{{ route('admin.order-management') }}" class="btn btn-secondary" style="height: 32px; padding: 0.35rem 0.6rem; font-size: 0.8125rem;"><i class="fas fa-rotate"></i> {{ __('admin::cms.reset') }}</a>
            </form>

            <div style="margin-bottom: 0.5rem; color: var(--white); font-size: 0.875rem;">{{ __('admin::cms.total') }}: {{ $orders->total() }}</div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 60px; color: var(--white);">{{ __('admin::cms.stt') }}</th>
                            <th style="width: 200px; color: var(--white);">{{ __('admin::cms.user') }}</th>
                            <th style="width: 150px; color: var(--white);">{{ __('admin::cms.phone') }}</th>
                            <th style="color: var(--white);">{{ __('admin::cms.product') }}</th>
                            <th class="text-end" style="width: 120px; color: var(--white);">{{ __('admin::cms.value') }}</th>
                            <th class="text-end" style="width: 120px; color: var(--white);">{{ __('admin::cms.commission') }}</th>
                            <th class="text-center" style="width: 140px; color: var(--white);">{{ __('admin::cms.time') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $index => $order)
                            <tr>
                                <td class="text-center" style="color: var(--white);">{{ $orders->firstItem() + $index }}</td>
                                <td>
                                    <div class="fw-bold" style="color: var(--white);">{{ $order->user->name ?? 'N/A' }}</div>
                                </td>
                                <td>
                                    <span style="color: var(--white);">
                                        {{ $order->user->phone ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold" style="color: var(--accent-color);">{{ $order->ten_san_pham }}</div>
                                    @if($order->sanPham)
                                        <small style="color: var(--gray-500);">{{ $order->sanPham->mo_ta ?? '' }}</small>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <span class="fw-bold" style="color: var(--success-color);">
                                        ${{ number_format($order->gia_tri, 2, '.', ',') }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <span class="fw-bold" style="color: var(--warning-color);">
                                        ${{ number_format($order->hoa_hong, 2, '.', ',') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div style="color: var(--white);">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $order->created_at->format('d/m/Y') }}
                                    </div>
                                    <small style="color: var(--gray-500);">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $order->created_at->format('H:i:s') }}
                                    </small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="mb-3">
                                        <i class="fas fa-shopping-cart fa-3x" style="color: var(--gray-500);"></i>
                                    </div>
                                    <h5 style="color: var(--white);">{{ __('admin::cms.no_orders_found') }}</h5>
                                    <p style="color: var(--gray-500);">{{ __('admin::cms.no_orders_description') }}</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <x-pagination :paginator="$orders" :show-info-text="true" :show-info="__('admin::cms.showing') . ' ' . $orders->firstItem() . ' - ' . $orders->lastItem() . ' ' . __('admin::cms.of') . ' ' . $orders->total() . ' ' . __('admin::cms.results')" />
        </div>
    </div>

@endsection

{{-- Include pagination styles --}}
@include('components.pagination-styles')
