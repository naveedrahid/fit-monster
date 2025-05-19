@section('title', 'Trainer')
<x-app-layout>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card position-relative">
            <div id="loadingSpinner" style="display: none; text-align: center;">
                <i class="fas fa-spinner fa-spin fa-3x"></i>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-header">{{ __('Create New Trainer') }}</h5>
                <div class="card-header">
                    <a href="" class="btn btn-secondary">Back</a>
                </div>
            </div>
            <div class="card-body">
                <form
                    action="{{ $shift->exists ? route('backend.shifts.update', $shift) : route('backend.shifts.store') }}"
                    method="POST">
                    @csrf
                    @if ($shift->exists)
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3 col-xl-3">
                            <div class="form-group">
                                <label>{{ __('Name') }}</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $shift->name) }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3 col-xl-3">
                            <div class="form-group">
                                <label>{{ __('Gender') }}</label>
                                <select id="gender" name="gender"
                                    class="form-control @error('gender') is-invalid @enderror">
                                    <option value="" disabled
                                        {{ old('gender', $shift->gender) == '' ? 'selected' : '' }}>
                                        Select Gender
                                    </option>
                                    <option value="male"
                                        {{ old('gender', $shift->gender) == 'male' ? 'selected' : '' }}>
                                        Male
                                    </option>
                                    <option value="female"
                                        {{ old('gender', $shift->gender) == 'female' ? 'selected' : '' }}>
                                        Female
                                    </option>
                                </select>
                                @error('gender')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3 col-xl-3">
                            <div class="form-group">
                                <label>{{ __('Start Time') }}</label>
                                <input type="time" name="start_time"
                                    class="form-control @error('start_time') is-invalid @enderror"
                                    value="{{ old('start_time', $shift->start_time) }}">
                                @error('start_time')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3 col-xl-3">
                            <div class="form-group">
                                <label>{{ __('End Time') }}</label>
                                <input type="time" name="end_time"
                                    class="form-control @error('end_time') is-invalid @enderror"
                                    value="{{ old('end_time', $shift->end_time) }}">
                                @error('end_time')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="my-3">
                                <button type="submit"
                                    class="btn btn-primary">{{ $shift->exists ? 'Update' : 'Create' }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
