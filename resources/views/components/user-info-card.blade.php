@php
    use App\Helpers\LanguageHelper;
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
    $profile = $user->profile ?? null;
@endphp

<!-- User Info Card Component -->
<div class="account-card p-3 mb-3">
    <div class="d-flex align-items-center">
        <div class="avatar me-3">
            @if($profile && $profile->anh_chan_dung)
                <img class="avatar-img" src="{{ $profile->anh_chan_dung }}" alt="Avatar">
            @else
                {{ strtoupper(mb_substr($user->name ?? $user->phone ?? 'U', 0, 1)) }}
            @endif
        </div>
        <div class="flex-grow-1">
            <div class="fw-bold" style="font-size:16px; color:#111827;">
                {{ $user->name ?? 'User' }}
            </div>
            <div class="text-muted" style="font-size:13px;">
                <i class="fas fa-phone me-1"></i> {{ $user->phone ?? '—' }}
            </div>
            @php
                $balance = optional($profile)->so_du;
                $profit = optional($profile)->hoa_hong;
            @endphp
            <div class="mt-1" style="font-size:13px">
                <i class="fas fa-money-bill me-1"></i>
                <span>
                    {{ isset($balance) ? number_format((float)$balance, 0, '.', ',') : '0' }}$
                </span>
            </div>
            <div class="mt-1" style="font-size:13px">
                <i class="fas fa-chart-line me-1"></i>
                <span>
                    {{ isset($profit) ? number_format((float)$profit, 0, '.', ',') : '0' }}$
                </span>
            </div>
        </div>
        <div class="ms-auto">
            <span class="vip-badge">
                <i class="fas fa-crown"></i>VIP {{ (int)($profile->cap_do ?? 0) }}
            </span>
        </div>
    </div>
</div>
