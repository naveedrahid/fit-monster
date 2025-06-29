@section('title', 'Package')
<x-app-layout>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card position-relative">
            <div id="loadingSpinner" style="display: none; text-align: center;">
                <i class="fas fa-spinner fa-spin fa-3x"></i>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-header">{{ __('Create New Package') }}</h5>
                <div class="card-header">
                    <a href="" class="btn btn-secondary">Back</a>
                </div>
            </div>
            <div class="card-body">
                <form method="POST"
                    action="{{ $package->exists ? route('packages.update', $package->id) : route('packages.store') }}">
                    @csrf
                    @if ($package->exists)
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Package Name') }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $package->name ?? '') }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label for="price" class="form-label">{{ __('Price') }}</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    id="price" name="price" value="{{ old('price', $package->price ?? '') }}">
                                @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label for="duration_days" class="form-label">{{ __('Duration') }}</label>
                                <input type="number" class="form-control @error('duration_days') is-invalid @enderror"
                                    id="duration_days" name="duration_days"
                                    value="{{ old('duration_days', $package->duration_days ?? '') }}">
                                @error('duration_days')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('Description') }}</label>
                                <textarea class="form-control" id="description" name="description">{{ old('description', $package->description ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ $package->exists ? 'Update' : 'Create' }}</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
