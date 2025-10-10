<table class="table table-striped">
    <thead>
        <tr>
            <th>{{ __('admin.name') }}</th>
            <th>{{ __('admin.email') }}</th>
            <th>{{ __('admin.registration_date') }}</th>
            <th>{{ __('admin.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
            <tr>
                <td class="text-center">{{ $user->name }}</td>
                <td class="text-center">{{ $user->email }}</td>
                <td class="text-center">{{ $user->created_at->format('Y-m-d H:i') }}</td>
                <td class="text-center">
                    <div class="list-icon-function">
                        <a href="{{ route('admin.users.show', $user) }}" class="item eye" title="{{ __('admin.view') }}">
                            <i class="icon-eye"></i>
                        </a>
                        <a href="#" class="item delete delete-user" 
                           data-id="{{ $user->id }}" 
                           data-name="{{ $user->name }}"
                           title="{{ __('admin.delete') }}">
                            <i class="icon-trash-2"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">{{ __('admin.no_users_found') }}</td>
            </tr>
        @endforelse
    </tbody>
</table>

@if($users->hasPages())
    <div class="pagination-wrapper">
        <div class="pagination-info">
            {{ __('admin.showing_results') }} {{ $users->firstItem() }} {{ __('admin.to') }} {{ $users->lastItem() }} {{ __('admin.of') }} {{ $users->total() }} {{ __('admin.user') }}
        </div>
        {{ $users->links() }}
    </div>
@endif
