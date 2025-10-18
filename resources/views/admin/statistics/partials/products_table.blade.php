<div class="table-responsive">
    <table class="table table-striped table-bordered wg-table">
        <thead>
            <tr>
                <th>{{ __('admin.rank') }}</th>
                <th>{{ __('admin.product_name') }}</th>
                <th>{{ __('admin.category') }}</th>
                <th>{{ __('admin.price') }}</th>
                <th>{{ __('admin.total_sold') }}</th>
                <th>{{ __('admin.revenue') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($products as $index => $row)
            <tr>
                <td>
                    <span class="badge badge-primary" style="background-color: #000 !important; color: #fff !important;">{{ $products->firstItem() + $index }}</span>
                </td>
                <td>
                    @if($row->product)
                        <div class="d-flex align-items-center">
                            @if($row->product->image && !empty($row->product->image))
                                @php
                                    $imagePath = is_array($row->product->image) ? $row->product->image[0] : $row->product->image;
                                    // Check if image file exists
                                    $imageExists = file_exists(public_path('uploads/products/' . $imagePath));
                                @endphp
                                @if($imageExists)
                                    <img src="{{ asset('uploads/products/' . $imagePath) }}" 
                                         alt="{{ $row->product->display_name }}" 
                                         class="rounded me-2" 
                                         style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px; font-size: 12px; color: #6c757d;">
                                        <i class="icon-package"></i>
                                    </div>
                                @endif
                            @else
                                <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                     style="width: 40px; height: 40px; font-size: 12px; color: #6c757d;">
                                    <i class="icon-package"></i>
                                </div>
                            @endif
                            <div>
                                <a href="{{ route('admin.products.show', $row->product) }}" data-product-show class="body-title-2 text-decoration-none">
                                    {{ $row->product->display_name ?? $row->product->name_ar ?? $row->product->name_en }}
                                </a>
                                @if($row->product->description_ar || $row->product->description_en)
                                    <small class="text-muted d-block">
                                        {{ Str::limit($row->product->display_description ?? $row->product->description_ar ?? $row->product->description_en, 50) }}
                                    </small>
                                @endif
                            </div>
                        </div>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>
                    @if($row->product && $row->product->category)
                        <span class="badge badge-secondary">{{ $row->product->category->display_name ?? $row->product->category->name_ar ?? $row->product->category->name_en }}</span>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>
                    @if($row->product)
                        <span class="fw-bold text-success">${{ number_format($row->product->final_price, 2) }}</span>
                        @if($row->product->discount_percentage > 0)
                            <small class="text-muted d-block">
                                <s>${{ number_format($row->product->price, 2) }}</s>
                                <span class="badge badge-danger">{{ $row->product->discount_percentage }}%</span>
                            </small>
                        @endif
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>
                    <span class="fw-bold text-primary">{{ number_format($row->qty) }}</span>
                    <small class="text-muted d-block">{{ __('admin.units') }}</small>
                </td>
                <td>
                    @if($row->product)
                        <span class="fw-bold text-success">${{ number_format($row->qty * $row->product->final_price, 2) }}</span>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@if(method_exists($products,'links'))
    <div class="mt-3 d-flex justify-content-between align-items-center">
        <div class="text-muted">
            {{ __('admin.showing') }} {{ $products->firstItem() }} {{ __('admin.to') }} {{ $products->lastItem() }} 
            {{ __('admin.of') }} {{ $products->total() }} {{ __('admin.results') }}
        </div>
        <div>{{ $products->links() }}</div>
    </div>
@endif

