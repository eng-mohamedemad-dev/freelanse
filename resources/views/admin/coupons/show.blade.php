@extends('admin.layouts.app')

@section('title', __('admin.coupons'))

@section('content')
<div class="flex items-center flex-wrap justify-between gap20 mb-27">
    <h3>{{ app()->getLocale() === 'ar' ? ($coupon->name_ar ?? $coupon->name) : ($coupon->name_en ?? $coupon->name) }}</h3>
    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <div class="text-tiny">{{ __('admin.dashboard') }}</div>
            </a>
        </li>
        <li>
            <i class="icon-chevron-right"></i>
        </li>
        <li>
            <a href="{{ route('admin.coupons.index') }}">
                <div class="text-tiny">{{ __('admin.coupons') }}</div>
            </a>
        </li>
        <li>
            <i class="icon-chevron-right"></i>
        </li>
        <li>
            <div class="text-tiny">{{ app()->getLocale() === 'ar' ? ($coupon->name_ar ?? $coupon->name) : ($coupon->name_en ?? $coupon->name) }}</div>
        </li>
    </ul>
    </div>

    <div class="coupon-show">
        <div class="coupon-grid">
            <section class="coupon-left">
                <header class="coupon-header">
                    <span class="chip {{ $coupon->status === 'active' ? 'chip-success' : 'chip-muted' }}">{{ $coupon->status_label }}</span>
                    <span class="chip {{ $coupon->type === 'fixed' ? 'chip-success' : 'chip-warning' }}">{{ $coupon->type_label }}</span>
                    <span class="chip chip-info">{{ __('admin.coupon_code') }}: {{ $coupon->code }}</span>
                </header>

                <div class="stats">
                    <div class="stat">
                        <div class="stat-label">{{ __('admin.coupon_value') }}</div>
                        <div class="stat-value">
                            @if($coupon->type === 'fixed')
                                {{ number_format($coupon->value, 2) }} 
                            @else
                                {{ $coupon->value }}%
                            @endif
                        </div>
                    </div>
                    <div class="stat">
                        <div class="stat-label">{{ __('admin.expires_at') }}</div>
                        <div class="stat-value">
                            @if($coupon->expires_at)
                                <span class="{{ $coupon->is_expired ? 'txt-danger' : ($coupon->expires_at->diffInDays(now()) <= 7 ? 'txt-warning' : 'txt-success') }}">{{ $coupon->expires_at->format('Y-m-d') }}</span>
                            @else
                                <span class="txt-muted">{{ __('admin.no_expiry') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="stat">
                        <div class="stat-label">{{ __('admin.usage_limit') }}</div>
                        <div class="stat-value">
                            @if($coupon->usage_limit)
                                @php 
                                    $percent = $coupon->usage_limit ? min(100, round(($coupon->used_count/$coupon->usage_limit)*100)) : 0; 
                                    $remain = $coupon->usage_limit - $coupon->used_count;
                                    $barClass = $percent < 50 ? 'bar-success' : ($percent < 100 ? 'bar-warning' : 'bar-danger');
                                    if ($remain <= 5) { $barClass = 'bar-danger'; }
                                @endphp
                                {{ $coupon->used_count }} / {{ $coupon->usage_limit }}
                                <div class="progress">
                                    <div class="progress-bar {{ $barClass }}" style="width: {{ $percent }}%"></div>
                                </div>
                            @else
                                <span class="txt-muted">{{ __('admin.no_limit') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="stat">
                        <div class="stat-label">{{ __('admin.coupon_status') }}</div>
                        <div class="stat-value"><span class="chip {{ $coupon->status === 'active' ? 'chip-success' : 'chip-muted' }}">{{ $coupon->status_label }}</span></div>
                    </div>
                </div>

                @php
                    $desc = app()->getLocale()==='ar' ? ($coupon->description_ar ?? $coupon->description) : ($coupon->description_en ?? $coupon->description);
                @endphp
                @if($desc)
                    <div class="desc">
                        <div class="desc-title">{{ __('admin.description') }}</div>
                        <p class="desc-text">{{ $desc }}</p>
                    </div>
                @endif

                <div class="actions">
                    <a class="tf-button" href="{{ route('admin.coupons.edit', $coupon) }}">{{ __('admin.edit') }}</a>
                    <a class="tf-button style-1" href="{{ route('admin.coupons.index') }}">{{ __('admin.back') }}</a>
                </div>
            </section>

            <aside class="coupon-right">
                @if($coupon->image)
                    <img src="{{ asset($coupon->image) }}" alt="{{ app()->getLocale() === 'ar' ? ($coupon->name_ar ?? $coupon->name) : ($coupon->name_en ?? $coupon->name) }}" class="coupon-image">
                @else
                    <div class="no-image">{{ __('admin.no_image') }}</div>
                @endif
            </aside>
        </div>
    </div>
@push('styles')
<style>
    .coupon-show { padding: 10px 0; }
    .coupon-grid { display: grid; grid-template-columns: 1.6fr .8fr; gap: 18px; }
    @media (max-width: 992px){ .coupon-grid { grid-template-columns: 1fr; } }
    .coupon-left { background: #fff; border: 2px solid #e9ecef; border-radius: 14px; padding: 18px; }
    .coupon-right { background: #fff; border: 2px solid #e9ecef; border-radius: 14px; padding: 14px; display:flex; align-items:center; justify-content:center; }
    .coupon-image { max-width: 100%; border-radius: 10px; box-shadow: 0 6px 16px rgba(0,0,0,.08); }
    .coupon-header { display:flex; gap:8px; flex-wrap:wrap; margin-bottom: 14px; }
    .chip { display:inline-flex; align-items:center; gap:6px; padding:6px 10px; border-radius: 999px; font-size: 12px; font-weight:600; background:#eef2f7; color:#334155; }
    .chip-success { background:#e7f7ee; color:#0f9d58; }
    .chip-warning { background:#fff4e5; color:#f59e0b; }
    .chip-info { background:#e6f1ff; color:#2563eb; }
    .chip-muted { background:#f1f5f9; color:#64748b; }
    .stats { display:grid; grid-template-columns: repeat(2,1fr); gap:16px; }
    @media (max-width: 576px){ .stats { grid-template-columns: 1fr; } }
    .stat { border:1px dashed #e5e7eb; border-radius:12px; padding:12px; }
    .stat-label { font-size:12px; color:#64748b; margin-bottom:6px; }
    .stat-value { font-weight:700; color:#111827; }
    .progress { margin-top:8px; width:100%; height:8px; border-radius:6px; background:#f1f5f9; overflow:hidden; }
    .progress-bar { height:100%; border-radius:6px; }
    .progress-bar.bar-success{ background: linear-gradient(90deg,#22c55e,#16a34a); }
    .progress-bar.bar-warning{ background: linear-gradient(90deg,#f59e0b,#f97316); }
    .progress-bar.bar-danger{ background: linear-gradient(90deg,#ef4444,#dc2626); }
    .desc { margin-top:16px; }
    .desc-title { font-weight:600; margin-bottom:6px; }
    .desc-text { color:#475569; line-height:1.7; }
    .actions { margin-top:18px; display:flex; gap:10px; flex-wrap:wrap; }
    .txt-danger{ color:#dc2626; } .txt-warning{ color:#f59e0b; } .txt-success{ color:#16a34a; } .txt-muted{ color:#64748b; }
    .no-image { padding: 40px 0; color:#94a3b8; }
    .dark-theme .coupon-left, .dark-theme .coupon-right{ background:#1f2937; border-color:#374151; }
    .dark-theme .stat { border-color:#374151; }
    .dark-theme .stat-value, .dark-theme .desc-title { color:#e5e7eb; }
    .dark-theme .desc-text { color:#cbd5e1; }
</style>
@endpush
@endsection


