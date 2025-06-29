@section('title', 'Addon')
<x-app-layout>
    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card position-relative">
            <div id="loadingSpinner" style="display: none; text-align: center;">
                <i class="fas fa-spinner fa-spin fa-3x"></i>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-header">{{ __('Manage Addon') }}</h5>
                <div class="card-header">
                    <a href="{{ route('addons.create') }}" class="btn btn-secondary">{{ __('Add Addon') }}</a>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Addon Name') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Price') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($addons as $addon)
                            <tr>
                                <td>{{ $addon->name }}</td>
                                <td>{{ $addon->description }}</td>
                                <td>{{ $addon->price }}</td>
                                <td>
                                    <a class="btn btn-icon btn-primary" href="{{ route('addons.edit', $addon->id) }}">
                                        <i class="icon-base bx bx-edit-alt text-white"></i>
                                    </a>
                                    <form action="{{ route('addons.destroy', $addon) }}" method="POST"
                                        style="display:inline-block;"
                                        onsubmit="return confirm('Are you sure you want to delete this addon?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-danger deleteAsset">
                                            <i class="icon-base bx bx-trash text-white"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="9">{{ __('No Addon Found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-2">
                    {{ $addons->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
