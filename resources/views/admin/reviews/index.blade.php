@extends('admin.layouts.app')

@section('title', __('admin.reviews'))
@section('page-title', __('admin.reviews'))

@section('content')
<div class="flex items-center flex-wrap justify-between gap20 mb-27">
    <h3>{{ __('admin.reviews') }}</h3>
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
            <div class="text-tiny">{{ __('admin.reviews') }}</div>
        </li>
    </ul>
</div>

<div class="wg-box">
    <div class="flex items-center justify-between gap10 flex-wrap">
        <div class="wg-filter flex-grow">
            <form class="form-search" method="GET" action="{{ request()->fullUrl() }}" id="reviews-search-form">
                <fieldset class="name">
                    <input type="text" placeholder="{{ __('admin.search_here') }}" class="form-control-lg" name="search" value="{{ request('search') }}" id="reviews-search-input" autocomplete="off">
                </fieldset>
                <div class="button-submit">
                    <button class="" type="submit"><i class="icon-search"></i></button>
                </div>
            </form>
        </div>
        <div class="wg-filter">
            <select class="form-control-lg" name="status" id="status-filter">
                <option value="">{{ __('admin.all_statuses') }}</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('admin.pending_review') }}</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>{{ __('admin.approved_review') }}</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>{{ __('admin.rejected_review') }}</option>
            </select>
        </div>
        <div class="wg-filter">
            <select class="form-control-lg" name="rating" id="rating-filter">
                <option value="">{{ __('admin.all_ratings') }}</option>
                <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 {{ __('admin.stars') }}</option>
                <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 {{ __('admin.stars') }}</option>
                <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 {{ __('admin.stars') }}</option>
                <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 {{ __('admin.stars') }}</option>
                <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 {{ __('admin.stars') }}</option>
            </select>
        </div>
    </div>

    <div class="table-responsive" id="reviews-table-wrapper">
        @include('admin.reviews.partials.table', ['reviews' => $reviews])
    </div>

    <div class="divider"></div>
    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination" id="reviews-pagination">
        {{ $reviews->appends(request()->query())->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('reviews-search-input');
    const statusFilter = document.getElementById('status-filter');
    const ratingFilter = document.getElementById('rating-filter');
    const tableWrapper = document.getElementById('reviews-table-wrapper');
    const paginationWrapper = document.getElementById('reviews-pagination');

    function loadReviews() {
        const searchTerm = searchInput.value;
        const status = statusFilter.value;
        const rating = ratingFilter.value;
        
        const currentUrl = new URL(window.location.href);
        currentUrl.searchParams.set('search', searchTerm);
        currentUrl.searchParams.set('status', status);
        currentUrl.searchParams.set('rating', rating);
        currentUrl.searchParams.set('page', 1);
        currentUrl.searchParams.set('ajax', 1);

        fetch(currentUrl.toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            tableWrapper.innerHTML = data.html;
            if (data.paginationHtml) {
                paginationWrapper.innerHTML = data.paginationHtml;
            }
        })
        .catch(error => console.error('Error fetching reviews:', error));
    }

    // Search input handler
    searchInput.addEventListener('input', function() {
        clearTimeout(this.searchTimeout);
        this.searchTimeout = setTimeout(loadReviews, 500);
    });

    // Filter change handlers
    statusFilter.addEventListener('change', loadReviews);
    ratingFilter.addEventListener('change', loadReviews);


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
                            loadReviews();
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
                            loadReviews();
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
                            loadReviews();
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

    // Make functions globally available
    window.handleApprove = handleApprove;
    window.handleReject = handleReject;
    window.handleDelete = handleDelete;
});
</script>
@endpush
