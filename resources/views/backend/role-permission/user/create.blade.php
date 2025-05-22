<x-app-layout>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create User
                            <a href="{{ route('backend.users.index') }}" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('backend.users.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label for="">Name</label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}" />
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label for=""> Email</label>
                                        <input type="email" name=" email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}" />
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label for="">Password</label>
                                        <input type="text" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            value="{{ old('password') }}" />
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label for="">Age</label>
                                        <input type="number" name="age"
                                            class="form-control @error('age') is-invalid @enderror"
                                            value="{{ old('age') }}" />
                                        @error('age')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label for="">Gender</label>
                                        <select name="gender"
                                            class="form-control @error('gender') is-invalid @enderror">
                                            <option value="" disabled {{ old('gender') ? '' : 'selected' }}>
                                                Select Gender</option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                                                Male</option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                                Female</option>
                                        </select>
                                        @error('gender')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label for="shift_id">Shift</label>
                                        <select name="shift_id"
                                            class="form-control @error('shift_id') is-invalid @enderror">
                                            <option value="" disabled {{ old('shift_id') ? '' : 'selected' }}>
                                                Select Shift</option>
                                            @foreach ($shifts as $shift)
                                                <option value="{{ $shift->id }}"
                                                    {{ old('shift_id') == $shift->id ? 'selected' : '' }}>
                                                    {{ $shift->name }} ({{ $shift->start_time }} -
                                                    {{ $shift->end_time }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('shift_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label for="">Roles</label>
                                        <select name="roles[]" class="form-control @error('roles') is-invalid @enderror"
                                            multiple>
                                            <option value="">Select Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role }}">{{ $role }}</option>
                                            @endforeach
                                        </select>
                                        @error('roles')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <input type="hidden" name="type" id="userType" value="client">
                                    <div class="nav-align-top">
                                        <ul class="nav nav-pills mt-5 mb-4 justify-content-center" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button type="button" class="nav-link active" role="tab"
                                                    id="client-tab" data-bs-toggle="tab"
                                                    data-bs-target="#navs-pills-top-client"
                                                    aria-controls="navs-pills-top-client" aria-selected="true">
                                                    Client
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button type="button" class="nav-link" role="tab" id="trainer-tab"
                                                    data-bs-toggle="tab" data-bs-target="#navs-pills-top-trainer"
                                                    aria-controls="navs-pills-top-trainer" aria-selected="false"
                                                    tabindex="-1">
                                                    Trainer
                                                </button>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="navs-pills-top-client"
                                                role="tabpanel">
                                                <div class="row">
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Package</label>
                                                            <select name="package_id"
                                                                class="form-control @error('package_id') is-invalid @enderror">
                                                                <option value="" disabled
                                                                    {{ old('package_id') ? '' : 'selected' }}>
                                                                    Select Package</option>
                                                                @foreach ($packages as $package)
                                                                    <option value="{{ $package->id }}"
                                                                        {{ old('package_id') == $package->id ? 'selected' : '' }}>
                                                                        {{ $package->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('package_id')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="mb-3">
                                                            <label>Height</label>
                                                            <input type="text" name="height"
                                                                class="form-control @error('height') is-invalid @enderror"
                                                                value="{{ old('height') }}" />
                                                            @error('height')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="mb-3">
                                                            <label>Weight</label>
                                                            <input type="text" name="weight"
                                                                class="form-control @error('weight') is-invalid @enderror"
                                                                value="{{ old('weight') }}" />
                                                            @error('weight')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="mb-3">
                                                            <label>Goal</label>
                                                            <input type="text" name="goal"
                                                                class="form-control @error('goal') is-invalid @enderror"
                                                                value="{{ old('goal') }}" />
                                                            @error('goal')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="navs-pills-top-trainer" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="mb-3">
                                                            <label>Specialization</label>
                                                            <input type="text" name="specialization"
                                                                class="form-control @error('specialization') is-invalid @enderror"
                                                                value="{{ old('specialization') }}" />
                                                            @error('specialization')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="mb-3">
                                                            <label>Experience</label>
                                                            <input type="number" name="experience"
                                                                class="form-control @error('experience') is-invalid @enderror"
                                                                value="{{ old('experience') }}" />
                                                            @error('experience')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="mb-3">
                                                            <label>Salary</label>
                                                            <input type="text" name="salary"
                                                                class="form-control @error('salary') is-invalid @enderror"
                                                                value="{{ old('salary') }}" />
                                                            @error('salary')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            $(document).ready(function() {
                $('#client-tab').on('click', function() {
                    $('#userType').val('client');
                });

                $('#trainer-tab').on('click', function() {
                    $('#userType').val('trainer');
                });
            });
        </script>
    @endpush
</x-app-layout>
