@extends('admin.layouts.app')

@section('title', __('admin::cms.lich_su_management'))
@section('breadcrumb', __('admin::cms.lich_su_management'))

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">{{ __('admin::cms.history_list') }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.lich-su-management') }}" method="GET" role="search" style="margin-bottom: 0.75rem; display: flex; gap: 0.4rem; align-items: center; flex-wrap: nowrap;">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ __('admin::auth.search_placeholder') }}" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" style="flex: 4 1 0; min-width: 320px; padding: 0.35rem 0.5rem; font-size: 0.875rem; height: 32px;">
                <select name="hanh_dong" class="form-select" aria-label="{{ __('admin::cms.history_action') }}" style="flex: 0 0 220px; width: 220px; height: 32px; padding: 0.2rem 1.6rem 0.2rem 0.5rem; font-size: 0.8125rem;">
                    <option value="">{{ __('admin::cms.history_action') }}</option>
                    <option value="1" {{ request('hanh_dong') == '1' ? 'selected' : '' }}>{{ __('admin::cms.history_action_topup') }}</option>
                    <option value="2" {{ request('hanh_dong') == '2' ? 'selected' : '' }}>{{ __('admin::cms.history_action_withdraw') }}</option>
                    <option value="3" {{ request('hanh_dong') == '3' ? 'selected' : '' }}>{{ __('admin::cms.history_action_system') }}</option>
                    <option value="4" {{ request('hanh_dong') == '4' ? 'selected' : '' }}>{{ __('admin::cms.history_action_commission') }}</option>
                </select>
                <select name="trang_thai" class="form-select" aria-label="{{ __('admin::cms.status') }}" style="flex: 0 0 180px; width: 180px; height: 32px; padding: 0.2rem 1.6rem 0.2rem 0.5rem; font-size: 0.8125rem;">
                    <option value="">{{ __('admin::cms.status') }}</option>
                    <option value="0" {{ request('trang_thai') == '0' ? 'selected' : '' }}>{{ __('admin::cms.pending') }}</option>
                    <option value="1" {{ request('trang_thai') == '1' ? 'selected' : '' }}>{{ __('admin::cms.completed') }}</option>
                    <option value="2" {{ request('trang_thai') == '2' ? 'selected' : '' }}>{{ __('admin::cms.cancelled') }}</option>
                </select>
                <button type="submit" class="btn btn-primary" style="height: 32px; padding: 0.35rem 0.8rem; font-size: 0.8125rem; min-width: 110px; white-space: nowrap;"><i class="fas fa-filter"></i> {{ __('admin::auth.filter') }}</button>
                @if(request()->hasAny(['search','hanh_dong','trang_thai']))
                    <a href="{{ route('admin.lich-su-management') }}" class="btn btn-secondary" style="height: 32px; padding: 0.35rem 0.8rem; font-size: 0.8125rem; min-width: 110px; white-space: nowrap;">{{ __('admin::auth.reset') }}</a>
                @endif
            </form>
            <div class="table-responsive">
                <table class="table" style="margin-bottom: 0;">
                    <thead>
                        <tr>
                            <th style="width: 60px">#</th>
                            <th>{{ __('admin::cms.account') }}</th>
                            <th>{{ __('admin::cms.history_action') }}</th>
                            <th class="text-end">{{ __('admin::cms.amount') }}</th>
                            <th>{{ __('admin::cms.note') }}</th>
                            <th>{{ __('admin::auth.status') }}</th>
                            <th>{{ __('admin::cms.created_at') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lichSu as $index => $item)
                            <tr>
                                <td>{{ ($lichSu->currentPage() - 1) * $lichSu->perPage() + $index + 1 }}</td>
                                <td>
                                    {{ $item->user?->name ?? $item->user?->email.' '.$item->user?->phone ?? ('#'.$item->user_id) }}
                                    
                                    - [{{ $item->user?->phone ?? $item->user?->phone ?? ('#'.$item->user_id) }}]

                                </td>
                                <td>
                                   
                                    <span class="badge bg-info">{{ $actionMap[$item->hanh_dong] ?? '—' }}</span>
                                </td>
                                <td class="text-end">{{ number_format((float) $item->so_tien, 0, '.', '.') }}</td>
                                <td class="text-left">{{ $item->ghi_chu }}</td>
                                <td>
                                    @php
                                        $statusMap = [
                                            0 => ['text' => __('admin::cms.pending'), 'class' => 'bg-warning'],
                                            1 => ['text' => __('admin::cms.completed'), 'class' => 'bg-success'],
                                            2 => ['text' => __('admin::cms.cancelled'), 'class' => 'bg-danger'],
                                        ];
                                        $status = $statusMap[$item->trang_thai] ?? ['text' => __('admin::cms.status'), 'class' => 'bg-secondary'];
                                    @endphp
                                    <span class="badge {{ $status['class'] }}">{{ $status['text'] }}</span>
                                </td>
                                <td>{{ optional($item->created_at)->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">{{ __('admin::cms.no_data') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($lichSu->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        @php($from = ($lichSu->currentPage() - 1) * $lichSu->perPage() + 1)
                        @php($to = min($lichSu->currentPage() * $lichSu->perPage(), $lichSu->total()))
                        {{ __('admin::cms.showing') }} {{ $from }} {{ __('admin::cms.to') }} {{ $to }} {{ __('admin::cms.of') }} {{ $lichSu->total() }} {{ __('admin::cms.results') }}
                    </div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            {{ $lichSu->withQueryString()->links() }}
                        </ul>
                    </nav>
                </div>
            @endif
        </div>
    </div>
@endsection


