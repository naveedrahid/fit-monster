@section('title', 'Addon')
<x-app-layout>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card position-relative">
            <div id="loadingSpinner" style="display: none; text-align: center;">
                <i class="fas fa-spinner fa-spin fa-3x"></i>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-header">{{ __('Create New Addon') }}</h5>
                <div class="card-header">
                    <a href="" class="btn btn-secondary">Back</a>
                </div>
            </div>
            <div class="card-body"> 
                <form
                    action="{{ $addon->exists ? route('addons.update', $addon) : route('addons.store') }}"
                    method="POST">
                    @csrf
                    @if ($addon->exists)
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label>{{ __('Addon Name') }}</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $addon->name) }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label>{{ __('Addon Description') }}</label>
                                <input name="description" class="form-control" value="{{ old('description', $addon->description) }}">
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label>{{ __('Addon Price') }}</label>
                                <input type="text" name="price"
                                    class="form-control @error('price') is-invalid @enderror"
                                    value="{{ old('price', $addon->price) }}">
                                @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="my-3">
                                <button type="submit"
                                    class="btn btn-primary">{{ $addon->exists ? 'Update' : 'Create' }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
