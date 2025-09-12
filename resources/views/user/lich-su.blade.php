@extends('user.layouts.app')

@section('title', __('user::cms.lich_su'))
@section('breadcrumb', __('user::cms.lich_su'))

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">{{ __('user::cms.lich_su_cua_toi') }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('user.lich-su') }}" method="GET" role="search" style="margin-bottom: 0.75rem; display: flex; gap: 0.4rem; align-items: center; flex-wrap: nowrap;">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ __('user::cms.tim_kiem_lich_su') }}" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" style="flex: 4 1 0; min-width: 320px; padding: 0.35rem 0.5rem; font-size: 0.875rem; height: 32px;">
                <select name="hanh_dong" class="form-select" aria-label="{{ __('user::cms.loai_giao_dich') }}" style="flex: 0 0 220px; width: 220px; height: 32px; padding: 0.2rem 1.6rem 0.2rem 0.5rem; font-size: 0.8125rem;">
                    <option value="">{{ __('user::cms.tat_ca_giao_dich') }}</option>
                    <option value="1" {{ request('hanh_dong') == '1' ? 'selected' : '' }}>{{ __('user::cms.nap_tien') }}</option>
                    <option value="2" {{ request('hanh_dong') == '2' ? 'selected' : '' }}>{{ __('user::cms.rut_tien') }}</option>
                    <option value="3" {{ request('hanh_dong') == '3' ? 'selected' : '' }}>{{ __('user::cms.he_thong') }}</option>
                    <option value="4" {{ request('hanh_dong') == '4' ? 'selected' : '' }}>{{ __('user::cms.hoa_hong') }}</option>
                </select>
                <select name="trang_thai" class="form-select" aria-label="{{ __('user::cms.trang_thai') }}" style="flex: 0 0 180px; width: 180px; height: 32px; padding: 0.2rem 1.6rem 0.2rem 0.5rem; font-size: 0.8125rem;">
                    <option value="">{{ __('user::cms.tat_ca_trang_thai') }}</option>
                    <option value="0" {{ request('trang_thai') == '0' ? 'selected' : '' }}>{{ __('user::cms.cho_xu_ly') }}</option>
                    <option value="1" {{ request('trang_thai') == '1' ? 'selected' : '' }}>{{ __('user::cms.thanh_cong') }}</option>
                    <option value="2" {{ request('trang_thai') == '2' ? 'selected' : '' }}>{{ __('user::cms.da_huy') }}</option>
                </select>
                <button type="submit" class="btn btn-primary" style="height: 32px; padding: 0.35rem 0.8rem; font-size: 0.8125rem; min-width: 110px; white-space: nowrap;"><i class="fas fa-filter"></i> {{ __('user::cms.loc') }}</button>
                @if(request()->hasAny(['search','hanh_dong','trang_thai']))
                    <a href="{{ route('user.lich-su') }}" class="btn btn-secondary" style="height: 32px; padding: 0.35rem 0.8rem; font-size: 0.8125rem; min-width: 110px; white-space: nowrap;">{{ __('user::cms.reset') }}</a>
                @endif
            </form>
            <div class="table-responsive">
                <table class="table" style="margin-bottom: 0;">
                    <thead>
                        <tr>
                            <th style="width: 60px">#</th>
                            <th>{{ __('user::cms.loai_giao_dich') }}</th>
                            <th class="text-end">{{ __('user::cms.so_tien') }}</th>
                            <th>{{ __('user::cms.ghi_chu') }}</th>
                            <th>{{ __('user::cms.trang_thai') }}</th>
                            <th>{{ __('user::cms.thoi_gian') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lichSu as $index => $item)
                            <tr>
                                <td>{{ ($lichSu->currentPage() - 1) * $lichSu->perPage() + $index + 1 }}</td>
                                <td>
                                    @php
                                        $actionMap = [
                                            1 => ['text' => __('user::cms.nap_tien'), 'class' => 'bg-success'],
                                            2 => ['text' => __('user::cms.rut_tien'), 'class' => 'bg-warning'],
                                            3 => ['text' => __('user::cms.he_thong'), 'class' => 'bg-info'],
                                            4 => ['text' => __('user::cms.hoa_hong'), 'class' => 'bg-primary'],
                                        ];
                                        $action = $actionMap[$item->hanh_dong] ?? ['text' => '—', 'class' => 'bg-secondary'];
                                    @endphp
                                    <span class="badge {{ $action['class'] }}">{{ $action['text'] }}</span>
                                </td>
                                <td class="text-end">
                                    @if($item->hanh_dong == 1 || $item->hanh_dong == 4)
                                        <span class="text-success">+{{ number_format((float) $item->so_tien, 0, '.', '.') }} VNĐ</span>
                                    @elseif($item->hanh_dong == 2)
                                        <span class="text-danger">-{{ number_format((float) $item->so_tien, 0, '.', '.') }} VNĐ</span>
                                    @else
                                        <span class="text-muted">{{ number_format((float) $item->so_tien, 0, '.', '.') }} VNĐ</span>
                                    @endif
                                </td>
                                <td class="text-left">{{ $item->ghi_chu }}</td>
                                <td>
                                    @php
                                        $statusMap = [
                                            0 => ['text' => __('user::cms.cho_xu_ly'), 'class' => 'bg-warning'],
                                            1 => ['text' => __('user::cms.thanh_cong'), 'class' => 'bg-success'],
                                            2 => ['text' => __('user::cms.da_huy'), 'class' => 'bg-danger'],
                                        ];
                                        $status = $statusMap[$item->trang_thai] ?? ['text' => __('user::cms.trang_thai'), 'class' => 'bg-secondary'];
                                    @endphp
                                    <span class="badge {{ $status['class'] }}">{{ $status['text'] }}</span>
                                </td>
                                <td>{{ optional($item->created_at)->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">{{ __('user::cms.khong_co_du_lieu') }}</td>
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
                        {{ __('user::cms.hien_thi') }} {{ $from }} {{ __('user::cms.den') }} {{ $to }} {{ __('user::cms.trong_tong') }} {{ $lichSu->total() }} {{ __('user::cms.ket_qua') }}
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
