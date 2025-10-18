<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('admin.name') }}</th>
                <th>{{ __('admin.price') }}</th>
                <th>{{ __('admin.sale_price') }}</th>
                <th>{{ __('admin.category') }}</th>
                <th>{{ __('admin.stock') }}</th>
                <th>{{ __('admin.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td class="pname">
                        <div class="image">
                            <img src="{{ $product->images && count($product->images) > 0 ? asset($product->images[0]) : asset('uploads/products/default.png') }}" alt="{{ $product->display_name }}" class="image">
                        </div>
                        <div class="name">
                            <a href="{{ route('admin.products.show', $product) }}" class="body-title-2">{{ $product->display_name }}</a>
                            <div class="text-tiny mt-3">{{ Str::limit($product->display_description, 50) }}</div>
                        </div>
                    </td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>${{ number_format($product->sale_price ?? $product->price, 2) }}</td>
                    <td>{{ $product->category->display_name ?? __('admin.no_data') }}</td>
                    <td>{{ $product->stock ?? 0 }}</td>
                    <td>
                        <div class="list-icon-function">
                            <a href="{{ route('admin.products.show', $product) }}">
                                <div class="item eye">
                                    <i class="icon-eye"></i>
                                </div>
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}">
                                <div class="item edit">
                                    <i class="icon-edit"></i>
                                </div>
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" style="display: inline;" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="item delete">
                                    <i class="icon-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-20">
                        <div class="text-center">
                            <i class="icon-shopping-bag" style="font-size: 48px; color: #ccc;"></i>
                            <p class="mt-10">{{ __('admin.no_data') }}</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($products->hasPages())
    <div class="pagination-wrapper">
        <div class="pagination-info">
            {{ __('admin.showing_results') }} {{ $products->firstItem() }} {{ __('admin.to') }} {{ $products->lastItem() }} {{ __('admin.of') }} {{ $products->total() }} {{ __('admin.product') }}
        </div>
        {{ $products->links() }}
    </div>
@endif
