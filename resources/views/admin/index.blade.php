@extends('admin.layouts.app')

@section('title', __('admin::cms.dashboard'))

@section('breadcrumb', __('admin::cms.dashboard'))

@section('content')
<!-- Stats Overview -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-title">{{ __('admin::cms.total_users') }}</div>
            <div class="stat-icon primary">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['total_users'] ?? '0' }}</div>
        <div class="stat-change positive">
            <i class="fas fa-arrow-up"></i>
            <span>+12% {{ __('admin::cms.from_last_month') }}</span>
        </div>
    </div>

    <div class="stat-card success">
        <div class="stat-header">
            <div class="stat-title">{{ __('admin::cms.total_orders') }}</div>
            <div class="stat-icon success">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['total_orders'] ?? '0' }}</div>
        <div class="stat-change positive">
            <i class="fas fa-arrow-up"></i>
            <span>+8% {{ __('admin::cms.from_last_month') }}</span>
        </div>
    </div>

    <div class="stat-card warning">
        <div class="stat-header">
            <div class="stat-title">{{ __('admin::cms.total_products') }}</div>
            <div class="stat-icon warning">
                <i class="fas fa-box"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['total_products'] ?? '0' }}</div>
        <div class="stat-change positive">
            <i class="fas fa-arrow-up"></i>
            <span>+5% {{ __('admin::cms.from_last_month') }}</span>
        </div>
    </div>

    <div class="stat-card info">
        <div class="stat-header">
            <div class="stat-title">{{ __('admin::cms.total_revenue') }}</div>
            <div class="stat-icon info">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
        <div class="stat-value">${{ number_format($stats['total_revenue'] ?? 0, 2) }}</div>
        <div class="stat-change positive">
            <i class="fas fa-arrow-up"></i>
            <span>+15% {{ __('admin::cms.from_last_month') }}</span>
        </div>
    </div>
</div>

<!-- Charts and Analytics -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Revenue Chart -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('admin::cms.revenue_chart') }}</h3>
        </div>
        <div class="card-body">
            <canvas id="revenueChart" height="300"></canvas>
        </div>
    </div>

    <!-- Order Status -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('admin::cms.order_status') }}</h3>
        </div>
        <div class="card-body">
            <canvas id="orderStatusChart" height="300"></canvas>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
    <!-- Recent Orders -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('admin::cms.recent_orders') }}</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('admin::cms.order_id') }}</th>
                            <th>{{ __('admin::cms.customer') }}</th>
                            <th>{{ __('admin::cms.amount') }}</th>
                            <th>{{ __('admin::cms.status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_orders ?? [] as $order)
                        <tr>
                            <td>#{{ $order['id'] ?? 'N/A' }}</td>
                            <td>{{ $order['customer'] ?? 'N/A' }}</td>
                            <td>${{ number_format($order['amount'] ?? 0, 2) }}</td>
                            <td>
                                <span class="badge badge-{{ $order['status'] == 'completed' ? 'success' : ($order['status'] == 'pending' ? 'warning' : 'danger') }}">
                                    {{ __('admin::cms.' . ($order['status'] ?? 'pending')) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">{{ __('admin::cms.no_recent_orders') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('admin::cms.recent_users') }}</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('admin::cms.name') }}</th>
                            <th>{{ __('admin::cms.email') }}</th>
                            <th>{{ __('admin::cms.role') }}</th>
                            <th>{{ __('admin::cms.joined') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_users ?? [] as $user)
                        <tr>
                            <td>{{ $user['name'] ?? 'N/A' }}</td>
                            <td>{{ $user['email'] ?? 'N/A' }}</td>
                            <td>
                                <span class="badge badge-{{ $user['role'] == 'admin' ? 'primary' : 'secondary' }}">
                                    {{ __('admin::cms.' . ($user['role'] ?? 'user')) }}
                                </span>
                            </td>
                            <td>{{ $user['created_at'] ?? 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">{{ __('admin::cms.no_recent_users') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('admin::cms.quick_actions') }}</h3>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <a href="#" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                {{ __('admin::cms.add_product') }}
            </a>
            <a href="#" class="btn btn-secondary">
                <i class="fas fa-user-plus"></i>
                {{ __('admin::cms.add_user') }}
            </a>
            <a href="#" class="btn btn-primary">
                <i class="fas fa-chart-line"></i>
                {{ __('admin::cms.view_analytics') }}
            </a>
            <a href="#" class="btn btn-secondary">
                <i class="fas fa-cog"></i>
                {{ __('admin::cms.system_settings') }}
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
    .badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        font-weight: 500;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
    }

    .badge-primary {
        background-color: var(--primary-color);
        color: var(--white);
    }

    .badge-secondary {
        background-color: var(--gray-600);
        color: var(--white);
    }

    .badge-success {
        background-color: var(--success-color);
        color: var(--white);
    }

    .badge-warning {
        background-color: var(--warning-color);
        color: var(--white);
    }

    .badge-danger {
        background-color: var(--danger-color);
        color: var(--white);
    }

    .table-responsive {
        overflow-x: auto;
    }

    .text-center {
        text-align: center;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        div[style*="grid-template-columns: 2fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
        
        div[style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['{{ __('admin::cms.jan') }}', '{{ __('admin::cms.feb') }}', '{{ __('admin::cms.mar') }}', '{{ __('admin::cms.apr') }}', '{{ __('admin::cms.may') }}', '{{ __('admin::cms.jun') }}'],
            datasets: [{
                label: '{{ __('admin::cms.revenue') }}',
                data: [12000, 19000, 15000, 25000, 22000, 30000],
                borderColor: '#805AD5',
                backgroundColor: 'rgba(128, 90, 213, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#CBD5E0'
                    },
                    grid: {
                        color: '#4A5568'
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#CBD5E0',
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    },
                    grid: {
                        color: '#4A5568'
                    }
                }
            }
        }
    });

    // Order Status Chart
    const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
    new Chart(orderStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['{{ __('admin::cms.completed') }}', '{{ __('admin::cms.pending') }}', '{{ __('admin::cms.cancelled') }}'],
            datasets: [{
                data: [65, 25, 10],
                backgroundColor: ['#38A169', '#D69E2E', '#E53E3E'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#CBD5E0'
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection