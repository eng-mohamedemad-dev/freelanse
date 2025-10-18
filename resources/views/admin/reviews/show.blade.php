@extends('admin.layouts.app')

@section('title', __('admin.review') . ' #' . $review->id)
@section('page-title', __('admin.review') . ' #' . $review->id)

@section('content')
<div class="flex items-center flex-wrap justify-between gap20 mb-27">
    <h3>{{ __('admin.review') }} #{{ $review->id }}</h3>
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
            <a href="{{ route('admin.reviews.index') }}">
                <div class="text-tiny">{{ __('admin.reviews') }}</div>
            </a>
        </li>
        <li>
            <i class="icon-chevron-right"></i>
        </li>
        <li>
            <div class="text-tiny">{{ __('admin.review') }} #{{ $review->id }}</div>
        </li>
    </ul>
</div>

<div class="wg-box">
    <div class="flex items-center justify-between gap10 mb-20">
        <h4>{{ __('admin.review_details') }}</h4>
        <div class="review-actions">
            @if($review->status !== 'approved')
                <a href="#" class="action-btn approve" onclick="handleApprove({{ $review->id }})" title="{{ __('admin.approve_review') }}">
                    <i class="icon-check"></i>
                </a>
            @endif
            @if($review->status !== 'rejected')
                <a href="#" class="action-btn reject" onclick="handleReject({{ $review->id }})" title="{{ __('admin.reject_review') }}">
                    <i class="icon-x"></i>
                </a>
            @endif
            <a href="#" class="action-btn delete" onclick="handleDelete({{ $review->id }})" title="{{ __('admin.delete_review') }}">
                <i class="icon-trash"></i>
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="review-details">
                <div class="review-item mb-20">
                    <h5>{{ __('admin.user_information') }}</h5>
                    <div class="flex items-center gap15">
                        @if($review->user)
                            @if($review->user->avatar)
                                <img src="{{ asset('storage/' . $review->user->avatar) }}" alt="{{ $review->user->name }}" class="avatar-large">
                            @else
                                <div class="avatar-large avatar-placeholder">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <div class="name">{{ $review->user->name }}</div>
                                <div class="text-tiny text-muted">{{ $review->user->email }}</div>
                                <div class="text-tiny text-muted">{{ __('admin.member_since') }}: {{ $review->user->created_at->format('Y-m-d') }}</div>
                            </div>
                        @else
                            <div class="avatar-large avatar-placeholder">
                                A
                            </div>
                            <div>
                                <div class="name">{{ __('admin.unknown_user') }}</div>
                                <div class="text-tiny text-muted">-</div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="review-item mb-20">
                    <h5>{{ __('admin.product_information') }}</h5>
                    <div class="flex items-center gap15">
                        @if($review->product->images && count($review->product->images) > 0)
                            <img src="{{ asset('uploads/products/' . $review->product->images[0]) }}" alt="{{ $review->product->display_name }}" class="product-thumb">
                        @else
                            <div class="product-thumb product-placeholder">
                                <i class="icon-box"></i>
                            </div>
                        @endif
                        <div>
                            <div class="name">
                                <a href="{{ route('admin.products.show', $review->product->id) }}" class="body-title-2">
                                    {{ $review->product->display_name }}
                                </a>
                            </div>
                            <div class="text-tiny text-muted">{{ __('admin.price') }}: {{ number_format($review->product->price, 2) }} {{ __('admin.currency') }}</div>
                            @if($review->product->sale_price)
                                <div class="text-tiny text-muted">{{ __('admin.sale_price') }}: {{ number_format($review->product->sale_price, 2) }} {{ __('admin.currency') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="review-item mb-20">
                    <h5>{{ __('admin.rating') }}</h5>
                    <div class="rating-display">
                        <div class="rating-stars-large">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="icon-star{{ $i <= $review->rating ? '' : '-o' }} {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </div>
                        <div class="rating-text">
                            <span class="rating-number">{{ $review->rating }}/5</span>
                            <span class="text-muted">{{ __('admin.stars') }}</span>
                        </div>
                    </div>
                </div>

                @if($review->comment)
                <div class="review-item mb-20">
                    <h5>{{ __('admin.comment') }}</h5>
                    <div class="comment-content">
                        <p>{{ $review->comment }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="review-meta">
                <div class="meta-item">
                    <h6>{{ __('admin.review_status') }}</h6>
                    @switch($review->status)
                        @case('pending')
                            <span class="badge badge-warning">{{ __('admin.pending_review') }}</span>
                            @break
                        @case('approved')
                            <span class="badge badge-success">{{ __('admin.approved_review') }}</span>
                            @break
                        @case('rejected')
                            <span class="badge badge-danger">{{ __('admin.rejected_review') }}</span>
                            @break
                    @endswitch
                </div>

                <div class="meta-item">
                    <h6>{{ __('admin.created_at') }}</h6>
                    <div class="text-tiny">{{ $review->created_at->format('Y-m-d H:i:s') }}</div>
                </div>

                <div class="meta-item">
                    <h6>{{ __('admin.updated_at') }}</h6>
                    <div class="text-tiny">{{ $review->updated_at->format('Y-m-d H:i:s') }}</div>
                </div>

                <div class="meta-item">
                    <h6>{{ __('admin.review_id') }}</h6>
                    <div class="text-tiny">#{{ $review->id }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Handle approve action
function handleApprove(reviewId) {
    Swal.fire({
        title: '{{ __('admin.confirm_action') }}',
        text: '{{ __('admin.are_you_sure_you_want_to_approve_this_review') }}?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '{{ __('admin.yes') }}',
        cancelButtonText: '{{ __('admin.cancel') }}',
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/reviews/${reviewId}/approve`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '{{ __('admin.success') }}!',
                        text: data.message,
                        confirmButtonText: '{{ __('admin.confirm') }}'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __('admin.error') }}!',
                        text: data.message,
                        confirmButtonText: '{{ __('admin.confirm') }}'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: '{{ __('admin.error') }}!',
                    text: '{{ __('admin.something_went_wrong') }}',
                    confirmButtonText: '{{ __('admin.confirm') }}'
                });
            });
        }
    });
}

// Handle reject action
function handleReject(reviewId) {
    Swal.fire({
        title: '{{ __('admin.confirm_action') }}',
        text: '{{ __('admin.are_you_sure_you_want_to_reject_this_review') }}?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '{{ __('admin.yes') }}',
        cancelButtonText: '{{ __('admin.cancel') }}',
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/reviews/${reviewId}/reject`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '{{ __('admin.success') }}!',
                        text: data.message,
                        confirmButtonText: '{{ __('admin.confirm') }}'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __('admin.error') }}!',
                        text: data.message,
                        confirmButtonText: '{{ __('admin.confirm') }}'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: '{{ __('admin.error') }}!',
                    text: '{{ __('admin.something_went_wrong') }}',
                    confirmButtonText: '{{ __('admin.confirm') }}'
                });
            });
        }
    });
}

// Handle delete action
function handleDelete(reviewId) {
    Swal.fire({
        title: '{{ __('admin.confirm_action') }}',
        text: '{{ __('admin.are_you_sure_you_want_to_delete_this_review') }}?',
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: '{{ __('admin.yes') }}',
        cancelButtonText: '{{ __('admin.cancel') }}',
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/reviews/${reviewId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '{{ __('admin.success') }}!',
                        text: data.message,
                        confirmButtonText: '{{ __('admin.confirm') }}'
                    }).then(() => {
                        window.location.href = '{{ route("admin.reviews.index") }}';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __('admin.error') }}!',
                        text: data.message,
                        confirmButtonText: '{{ __('admin.confirm') }}'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: '{{ __('admin.error') }}!',
                    text: '{{ __('admin.something_went_wrong') }}',
                    confirmButtonText: '{{ __('admin.confirm') }}'
                });
            });
        }
    });
}
</script>
@endpush

<style>
.avatar-large {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
}

.avatar-placeholder {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 24px;
}

.product-thumb {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    object-fit: cover;
}

.product-placeholder {
    background: #f8f9fa;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.rating-display {
    display: flex;
    align-items: center;
    gap: 15px;
}

.rating-stars-large {
    display: flex;
    align-items: center;
    gap: 5px;
}

.rating-stars-large i {
    font-size: 24px;
}

.rating-text {
    display: flex;
    align-items: center;
    gap: 5px;
}

.rating-number {
    font-size: 18px;
    font-weight: bold;
    color: #ffc107;
}

.comment-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 4px solid #007bff;
}

.comment-content p {
    margin: 0;
    line-height: 1.6;
}

.review-meta {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
}

.meta-item {
    margin-bottom: 20px;
}

.meta-item:last-child {
    margin-bottom: 0;
}

.meta-item h6 {
    margin-bottom: 5px;
    color: #495057;
    font-weight: 600;
}

.badge {
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
}

.badge-warning {
    background-color: #ffc107;
    color: #000;
}

.badge-success {
    background-color: #28a745;
    color: #fff;
}

.badge-danger {
    background-color: #dc3545;
    color: #fff;
}

.review-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.action-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
}

.action-btn.approve {
    background: #28a745;
    color: white;
}

.action-btn.reject {
    background: #dc3545;
    color: white;
}

.action-btn.delete {
    background: #6c757d;
    color: white;
}

.action-btn:hover {
    transform: scale(1.1);
    text-decoration: none;
    color: white;
}
</style>

