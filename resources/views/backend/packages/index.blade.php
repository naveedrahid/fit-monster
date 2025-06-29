@section('title', 'Packages')
<x-app-layout>
    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible">
                {{ session('success') }}
            </div>
        @endif
        <div class="card position-relative">
            <div id="loadingSpinner" style="display: none; text-align: center;">
                <i class="fas fa-spinner fa-spin fa-3x"></i>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-header">{{ __('Manage Packages') }}</h5>
                <div class="card-header">
                    <a href="{{ route('packages.create') }}" class="btn btn-secondary">{{ __('Add Packages') }}</a>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Package Name') }}</th>
                            <th>{{ __('Price') }}</th>
                            <th>{{ __('Duration') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($packages as $package)
                            <tr>
                                <td>{{ $package->name ?? '' }}</td>
                                <td>{{ $package->price ?? '' }}</td>
                                <td>{{ $package->duration_days ?? '' }}</td>
                                <td>{{ $package->description ?? '' }}</td>
                                <td>
                                    <a class="btn btn-icon btn-primary"
                                        href="{{ route('packages.edit', $package->id) }}">
                                        <i class="icon-base bx bx-edit-alt text-white"></i>
                                    </a>
                                    <form action="{{ route('packages.destroy', $package->id) }}" method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this package?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-danger"><i class="icon-base bx bx-trash text-white"></i></button>
                                    </form>

                                    {{-- <a class=" deleteAsset"
                                        href="{{ route('packages.destroy', $package->id) }}">
                                        
                                    </a> --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="9">{{ __('No Packages Found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
