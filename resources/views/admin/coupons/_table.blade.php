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
    <tbody>
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
                </div>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

