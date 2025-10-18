<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ __('admin.user') }}</th>
            <th>{{ __('admin.product') }}</th>
            <th>{{ __('admin.rating') }}</th>
            <th>{{ __('admin.comment') }}</th>
            <th>{{ __('admin.review_status') }}</th>
            <th>{{ __('admin.date') }}</th>
            <th>{{ __('admin.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reviews as $review)
        <tr>
            <td>{{ $review->id }}</td>
            <td>
                <div class="flex items-center gap10">
                    @if($review->user)
                        @if($review->user->avatar)
                            <img src="{{ asset('storage/' . $review->user->avatar) }}" alt="{{ $review->user->name }}" class="avatar-small">
                        @else
                            <div class="avatar-small avatar-placeholder">
                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <div class="name">{{ $review->user->name }}</div>
                            <div class="text-tiny text-muted">{{ $review->user->email }}</div>
                        </div>
                    @else
                        <div class="avatar-small avatar-placeholder">
                            A
                        </div>
                        <div>
                            <div class="name">{{ __('admin.unknown_user') }}</div>
                            <div class="text-tiny text-muted">-</div>
                        </div>
                    @endif
                </div>
            </td>
            <td>
                <div class="name">
                    <a href="{{ route('admin.products.show', $review->product->id) }}" class="body-title-2">
                        {{ $review->product->display_name }}
                    </a>
                </div>
            </td>
            <td>
                <div class="rating-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="icon-star{{ $i <= $review->rating ? '' : '-o' }} {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                    @endfor
                    <span class="text-tiny text-muted ml-2">({{ $review->rating }}/5)</span>
                </div>
            </td>
            <td>
                <div class="comment-preview">
                    @if($review->comment)
                        <div class="text-tiny">
                            {{ Str::limit($review->comment, 100) }}
                            @if(strlen($review->comment) > 100)
                                <a href="#" class="text-primary" onclick="showFullComment('{{ $review->id }}', '{{ addslashes($review->comment) }}')">
                                    {{ __('admin.read_more') }}
                                </a>
                            @endif
                        </div>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </div>
            </td>
            <td>
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
            </td>
            <td>
                <div class="text-tiny">{{ $review->created_at->format('Y-m-d H:i') }}</div>
            </td>
            <td>
                <div class="list-icon-function">
                    <a href="{{ route('admin.reviews.show', $review->id) }}">
                        <div class="item eye">
                            <i class="icon-eye"></i>
                        </div>
                    </a>
                    @if($review->status !== 'approved')
                        <a href="#" onclick="handleApprove({{ $review->id }})" title="{{ __('admin.approve_review') }}">
                            <div class="item approve">
                                <i class="icon-check"></i>
                            </div>
                        </a>
                    @endif
                    @if($review->status !== 'rejected')
                        <a href="#" onclick="handleReject({{ $review->id }})" title="{{ __('admin.reject_review') }}">
                            <div class="item reject">
                                <i class="icon-x"></i>
                            </div>
                        </a>
                    @endif
                    <a href="#" onclick="handleDelete({{ $review->id }})" title="{{ __('admin.delete') }}">
                        <div class="item delete">
                            <i class="icon-trash"></i>
                        </div>
                    </a>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center py-4">
                <div class="text-muted">
                    <i class="icon-star mb-3" style="font-size: 48px;"></i>
                    <h5>{{ __('admin.no_reviews_found') }}</h5>
                </div>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>


<!-- Full Comment Modal -->
<div class="modal fade" id="commentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('admin.full_comment') }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="fullCommentText"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('admin.close') }}</button>
            </div>
        </div>
    </div>
</div>

<script>
// Show full comment modal
function showFullComment(reviewId, comment) {
    document.getElementById('fullCommentText').textContent = comment;
    $('#commentModal').modal('show');
}
</script>

<style>
.avatar-small {
    width: 32px;
    height: 32px;
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
    font-size: 14px;
}

.rating-stars {
    display: flex;
    align-items: center;
    gap: 2px;
}

.rating-stars i {
    font-size: 14px;
}

.comment-preview {
    max-width: 200px;
}

.badge {
    padding: 4px 8px;
    border-radius: 4px;
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

.list-icon-function {
    display: flex;
    align-items: center;
    gap: 5px;
}

.list-icon-function .item {
    width: 32px;
    height: 32px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
}

.list-icon-function .item.eye {
    background-color: #17a2b8;
    color: white;
}

.list-icon-function .item.eye:hover {
    background-color: #138496;
    color: white;
}

.list-icon-function .item.approve {
    background-color: #28a745;
    color: white;
}

.list-icon-function .item.approve:hover {
    background-color: #218838;
    color: white;
}

.list-icon-function .item.reject {
    background-color: #ffc107;
    color: #212529;
}

.list-icon-function .item.reject:hover {
    background-color: #e0a800;
    color: #212529;
}

.list-icon-function .item.delete {
    background-color: #dc3545;
    color: white;
}

.list-icon-function .item.delete:hover {
    background-color: #c82333;
    color: white;
}
</style>
