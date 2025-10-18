<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('admin.name') }}</th>
                <th>{{ __('admin.description') }}</th>
                <th>{{ __('admin.image') }}</th>
                <th>{{ __('admin.products_count') }}</th>
                <th>{{ __('admin.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td class="pname">
                        <div class="name">
                            <a href="{{ route('admin.categories.show', $category) }}" class="body-title-2">{{ $category->display_name }}</a>
                        </div>
                    </td>
                    <td>{{ Str::limit($category->display_description, 50) }}</td>
                    <td>
                        <div class="image">
                            <img src="{{ $category->image ? asset($category->image) : asset('uploads/categories/default.png') }}" alt="{{ $category->display_name }}" class="category-image">
                        </div>
                    </td>
                    <td>{{ $category->products_count ?? 0 }}</td>
                    <td>
                        <div class="list-icon-function">
                            <a href="{{ route('admin.categories.show', $category) }}">
                                <div class="item eye">
                                    <i class="icon-eye"></i>
                                </div>
                            </a>
                            <a href="{{ route('admin.categories.edit', $category) }}">
                                <div class="item edit">
                                    <i class="icon-edit"></i>
                                </div>
                            </a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" style="display: inline;" class="delete-form">
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
                    <td colspan="6" class="text-center py-20">
                        <div class="text-center">
                            <i class="icon-layers" style="font-size: 48px; color: #ccc;"></i>
                            <p class="mt-10">{{ __('admin.no_records_found') }}</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($categories->hasPages())
    <div class="pagination-wrapper">
        <div class="pagination-info">
            {{ __('admin.showing_results') }} {{ $categories->firstItem() }} {{ __('admin.to') }} {{ $categories->lastItem() }} {{ __('admin.of') }} {{ $categories->total() }} {{ __('admin.category') }}
        </div>
        {{ $categories->links() }}
    </div>
@endif
