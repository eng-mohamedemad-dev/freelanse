<div class="table-responsive">
    <table class="table table-striped table-bordered wg-table">
        <thead>
            <tr>
                <th>{{ __('admin.rank') }}</th>
                <th>{{ __('admin.user') }}</th>
                <th>{{ __('admin.email') }}</th>
                <th>{{ __('admin.purchases') }}</th>
                <th>{{ __('admin.top_product') }}</th>
                <th>{{ __('admin.last_order') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $index => $u)
            @php
                $user = \App\Models\User::find($u->user_id);
                $lastOrder = \App\Models\Order::where('user_id', $u->user_id)->latest()->first();
            @endphp
            <tr>
                <td>
                    <span class="badge badge-primary" style="background-color: #000 !important; color: #fff !important;">{{ $users->firstItem() + $index }}</span>
                </td>
                <td>
                    @if($user)
                        <div class="d-flex align-items-center">
                            @if($user->avatar)
                                <img src="{{ asset('uploads/avatars/' . $user->avatar) }}" 
                                     alt="{{ $user->name }}" 
                                     class="rounded-circle me-2" 
                                     style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                     style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <div class="fw-bold">{{ $user->name }}</div>
                                @if($user->phone)
                                    <small class="text-muted">{{ $user->phone }}</small>
                                @endif
                            </div>
                        </div>
                    @else
                        <span class="text-muted">#{{ $u->user_id }}</span>
                    @endif
                </td>
                <td>
                    @if($user)
                        <span class="text-muted">{{ $user->email }}</span>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>
                    <span class="fw-bold text-primary">{{ number_format($u->purchases) }}</span>
                    <small class="text-muted d-block">{{ __('admin.items') }}</small>
                </td>
                <td>
                    @if($u->top_product)
                        <div class="d-flex align-items-center">
                            @if($u->top_product->image && !empty($u->top_product->image))
                                @php
                                    $imagePath = is_array($u->top_product->image) ? $u->top_product->image[0] : $u->top_product->image;
                                    // Check if image file exists
                                    $imageExists = file_exists(public_path('uploads/products/' . $imagePath));
                                @endphp
                                @if($imageExists)
                                    <img src="{{ asset('uploads/products/' . $imagePath) }}" 
                                         alt="{{ $u->top_product->display_name }}" 
                                         class="rounded me-2" 
                                         style="width: 30px; height: 30px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                         style="width: 30px; height: 30px; font-size: 10px; color: #6c757d;">
                                        <i class="icon-package"></i>
                                    </div>
                                @endif
                            @else
                                <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                     style="width: 30px; height: 30px; font-size: 10px; color: #6c757d;">
                                    <i class="icon-package"></i>
                                </div>
                            @endif
                            <div>
                                <a href="{{ route('admin.products.show', $u->top_product) }}" 
                                   data-product-show 
                                   class="body-title-2 text-decoration-none">
                                    {{ $u->top_product->display_name ?? $u->top_product->name_ar ?? $u->top_product->name_en }}
                                </a>
                                <small class="text-muted d-block">${{ number_format($u->top_product->final_price, 2) }}</small>
                            </div>
                        </div>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>
                    @if($lastOrder)
                        <div>
                            <span class="fw-bold">{{ $lastOrder->created_at->format('Y-m-d') }}</span>
                            <small class="text-muted d-block">{{ $lastOrder->created_at->diffForHumans() }}</small>
                            <span class="badge badge-{{ $lastOrder->status === 'delivered' ? 'success' : ($lastOrder->status === 'pending' ? 'warning' : 'danger') }}">
                                {{ __('admin.' . $lastOrder->status) }}
                            </span>
                        </div>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@if(method_exists($users,'links'))
    <div class="mt-3 d-flex justify-content-between align-items-center">
        <div class="text-muted">
            {{ __('admin.showing') }} {{ $users->firstItem() }} {{ __('admin.to') }} {{ $users->lastItem() }} 
            {{ __('admin.of') }} {{ $users->total() }} {{ __('admin.results') }}
        </div>
        <div>{{ $users->links() }}</div>
    </div>
@endif

