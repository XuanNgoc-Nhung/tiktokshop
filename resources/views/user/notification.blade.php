@php
use App\Helpers\LanguageHelper;
$__ = [LanguageHelper::class, 'getUserTranslation'];
$__home = [LanguageHelper::class, 'getHomeTranslation'];
@endphp
@extends('user.layouts.app')

@section('title', $__home('notification') . ' - ' . $__('tiktok_shop'))

@section('content')

<style>
    .accordion-button:focus,
    .accordion-button:focus-visible {
        box-shadow: none !important;
        outline: none !important;
    }
</style>

<!-- Navigation Header -->
<div class="nav-header">
    <button class="nav-button" onclick="goBack()">
        <i class="fas fa-chevron-left"></i>
    </button>
    <div class="nav-title">{{ $__home('notification') }}</div>
    <x-user.language-switcher />
</div>
<div class="container">
    @if ($notifications->isEmpty())
    <!-- Empty state -->
    <div id="emptyState" class="text-center text-muted py-5">
        <i class="fas fa-bell-slash" style="font-size:48px;color:#d1d1d6"></i>
        <div class="mt-3">Chưa có thông báo</div>
    </div>
    @else
    <!-- FAQ-style notifications -->
    <div class="accordion" id="notificationAccordion">
        @foreach ($notifications as $notification)
        <div class="accordion-item">
            <h2 class="accordion-header" id="{{'heading' . $notification->id }}">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#{{'collapse' . $notification->id }}" aria-expanded="true" aria-controls="collapseOne">
                    
                    <span style="margin-right:8px; font-weight:600; color:#8b4513;">{{ $loop->iteration }}.</span>
                    <i class="fas fa-volume-up" style="margin-right:8px"></i>
                    {{ $notification->tieu_de }}
                </button>
            </h2>
            <div id="{{'collapse' . $notification->id }}" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="{{ '#heading' . $notification->id }}">
                <div class="accordion-body" style="padding: 1.25rem 1.5rem;">
                    {{ $notification->noi_dung }}
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

@endsection
