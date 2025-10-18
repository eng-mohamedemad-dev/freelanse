@extends('admin.layouts.app')

@section('title', __('admin.coupons'))

@section('content')
<div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>{{ __('admin.coupons') }}</h3>
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
                        <div class="text-tiny">{{ __('admin.coupons') }}</div>
                    </li>
                </ul>
            </div>
            
            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search" method="GET" action="{{ route('admin.coupons.index') }}" id="coupon-search-form">
                            <fieldset class="name">
                                <input type="text" placeholder="{{ __('admin.search_here') }}" class="" name="search" value="{{ request('search') }}" id="coupon-search-input" autocomplete="off">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.coupons.create') }}">
                        <i class="icon-plus"></i>{{ __('admin.add_coupon') }}
                    </a>
                </div>
                
                <div class="table-responsive" id="coupon-table-wrapper">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('admin.coupon_name') }}</th>
                                <th>{{ __('admin.coupon_code') }}</th>
                                <th>{{ __('admin.coupon_type') }}</th>
                                <th>{{ __('admin.coupon_value') }}</th>
                                <th>{{ __('admin.usage_count') }}</th>
                                <th>{{ __('admin.expires_at') }}</th>
                                <th>{{ __('admin.coupon_status') }}</th>
                                <th>{{ __('admin.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody id="coupon-table-body">
                            @forelse($coupons as $coupon)
                            <tr>
                                <td>{{ $coupon->id }}</td>
                                <td class="pname">
                                    @if($coupon->image)
                                        <div class="image">
                                            <img src="{{ asset($coupon->image) }}" alt="{{ $coupon->name }}" class="image">
                                        </div>
                                    @else
                                        <div class="image">
                                            <div class="bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="icon-image text-muted"></i>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="name">
                                        <a href="{{ route('admin.coupons.show', $coupon) }}" class="body-title-2">{{ $coupon->name }}</a>
                                        @if($coupon->description)
                                            <div class="text-tiny mt-3">{{ Str::limit($coupon->description, 50) }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $coupon->code }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $coupon->type === 'fixed' ? 'success' : 'warning' }}">
                                        {{ $coupon->type_label }}
                                    </span>
                                </td>
                                <td>
                                    @if($coupon->type === 'fixed')
                                        {{ number_format($coupon->value, 2) }} 
                                    @else
                                        {{ $coupon->value }}%
                                    @endif
                                </td>
                                <td>
                                    @if($coupon->usage_limit)
                                        @php
                                            $percent = $coupon->usage_limit ? min(100, round(($coupon->used_count/$coupon->usage_limit)*100)) : 0;
                                            $remain = $coupon->usage_limit - $coupon->used_count;
                                            $barClass = $percent < 50 ? 'bg-success' : ($percent < 100 ? 'bg-warning' : 'bg-danger');
                                            if ($remain <= 5) { $barClass = 'bg-danger'; }
                                        @endphp
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar {{ $barClass }}" role="progressbar" style="width: {{ $percent }}%">
                                                {{ $coupon->used_count }}/{{ $coupon->usage_limit }}
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ $percent }}% {{ __('admin.used') }}</small>
                                    @else
                                        <span class="text-muted">{{ $coupon->used_count }} {{ __('admin.used') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($coupon->expires_at)
                                        <span class="{{ $coupon->is_expired ? 'text-danger' : ($coupon->expires_at->diffInDays(now()) <= 7 ? 'text-warning' : 'text-success') }}">
                                            {{ $coupon->expires_at->format('Y-m-d') }}
                                        </span>
                                        @if($coupon->is_expired)
                                            <br><small class="text-danger">{{ __('admin.expired') }}</small>
                                        @elseif($coupon->expires_at->diffInDays(now()) <= 7)
                                            <br><small class="text-warning">{{ __('admin.expires_soon') }}</small>
                                        @endif
                                    @else
                                        <span class="text-muted">{{ __('admin.no_expiry') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $coupon->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ $coupon->status_label }}
                                    </span>
                                </td>
                                <td>
                                    <div class="list-icon-function">
                                        <a href="{{ route('admin.coupons.show', $coupon) }}">
                                            <div class="item eye">
                                                <i class="icon-eye"></i>
                                            </div>
                                        </a>
                                        <a href="{{ route('admin.coupons.edit', $coupon) }}">
                                            <div class="item edit">
                                                <i class="icon-edit-3"></i>
                                            </div>
                                        </a>
                                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="item text-danger delete" onclick="confirmDelete(this)">
                                                <i class="icon-trash-2"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="icon-box-open mb-3" style="font-size: 48px;"></i>
                                        <h5>{{ __('admin.no_coupons_found') }}</h5>
                                        <p>{{ __('admin.no_coupons_found_message') }}</p>
                                        {{-- <a href="{{ route('admin.coupons.create') }}" class="tf-button">
                                            <i class="icon-plus"></i> {{ __('admin.add_first_coupon') }}
                                        </a> --}}
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination" id="coupon-pagination">
                    {{ $coupons->appends(request()->query())->links() }}
                </div>
            </div>

<script>
function confirmDelete(button) {
    if (confirm('{{ __("admin.confirm_delete_coupon") }}')) {
        button.closest('form').submit();
    }
}

// بحث فوري عبر AJAX
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('coupon-search-input');
    const tableWrapper = document.getElementById('coupon-table-wrapper');
    const paginationWrapper = document.getElementById('coupon-pagination');
    let timer = null;

    input.addEventListener('input', function() {
        clearTimeout(timer);
        timer = setTimeout(() => {
            const params = new URLSearchParams({ search: input.value, ajax: 1 });
            fetch(`{{ route('admin.coupons.index') }}?${params.toString()}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(({ html }) => {
                // نتوقع أن يعيد السيرفر HTML لجزء الجدول كاملًا
                tableWrapper.innerHTML = html;
                // إخفاء ترقيم الصفحات أثناء البحث
                if (input.value.trim().length > 0) {
                    paginationWrapper.style.display = 'none';
                } else {
                    paginationWrapper.style.display = '';
                }
            })
            .catch(() => {
                // تجاهل الأخطاء البسيطة
            });
        }, 300);
    });
});
</script>
@endsection