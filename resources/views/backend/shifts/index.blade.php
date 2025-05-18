@section('title', 'Shift')
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
                <h5 class="card-header">{{ __('Manage Shift') }}</h5>
                <div class="card-header">
                    <a href="{{ route('backend.shifts.create') }}" class="btn btn-secondary">{{ __('Add Shift') }}</a>
                </div>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Gender') }}</th>
                            <th>{{ __('Start Time') }}</th>
                            <th>{{ __('End Time') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($shifts as $shift)
                            <tr>
                                <td>{{ $shift->name ?? '' }}</td>
                                <td>{{ $shift->gender ?? '' }}</td>
                                <td>{{ date('h:i A', strtotime($shift->start_time)) ?? '' }}</td>
                                <td>{{ date('h:i A', strtotime($shift->end_time)) ?? '' }}</td>
                                <td>
                                    <a class="btn btn-icon btn-primary"
                                        href="{{ route('backend.shifts.edit', $shift->id) }}">
                                        <i class="icon-base bx bx-edit-alt text-white"></i>
                                    </a>
                                    <form action="{{ route('backend.shifts.destroy', $shift->id) }}" method="POST"
                                        style="display:inline-block;" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-danger">
                                            <i class="icon-base bx bx-trash text-white"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="9">{{ __('No Shift Found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
