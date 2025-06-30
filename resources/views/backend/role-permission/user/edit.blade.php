<x-app-layout>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit User
                            <a href="{{ url('users') }}" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.update', $user->id) }}" method="POST" autocomplete="off">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label>Name</label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $user->name) }}" />
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label> Email</label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $user->email) }}" />
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label>Password</label>
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            value="{{ old('password') }}" />
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label>Age</label>
                                        <input type="number" name="age"
                                            class="form-control @error('age') is-invalid @enderror"
                                            value="{{ old('age', $user->age) }}" />
                                        @error('age')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label>Gender</label>
                                        <select name="gender"
                                            class="form-control @error('gender') is-invalid @enderror">
                                            <option value="" disabled {{ old('gender') ? '' : 'selected' }}>
                                                Select Gender</option>
                                            <option value="male"
                                                {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>
                                                Male</option>
                                            <option value="female"
                                                {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>
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
                                            @foreach ($shifts as $shift)
                                                <option value="{{ $shift->id }}"
                                                    {{ old('shift_id', $user->shift_id) == $shift->id ? 'selected' : '' }}>
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
                                        <label>Roles</label>
                                        <select name="roles[]" class="form-control @error('roles') is-invalid @enderror"
                                            multiple>
                                            <option value="">Select Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role }}"
                                                    {{ in_array($role, old('roles', $user->getRoleNames()->toArray())) ? 'selected' : '' }}>
                                                    {{ $role }}</option>
                                            @endforeach
                                        </select>
                                        @error('roles')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label>Phone</label>
                                        <input type="tel" name="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone', $user->phone) }}" />
                                        @error('phone')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label>Emergency Contact (Optional)</label>
                                        <input type="tel" name="emergency_contact"
                                            class="form-control @error('emergency_contact') is-invalid @enderror"
                                            value="{{ old('emergency_contact', $user->emergency_contact) }}" />
                                        @error('emergency_contact')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    {{-- <input type="hidden" name="type" id="userType" value="{{ $user->type }}"> --}}
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
                                                            <label>Choose Plan Type</label><br>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="plan_type" value="default"
                                                                    id="plan_default" checked>
                                                                <label class="form-check-label"
                                                                    for="plan_default">Default Package</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="plan_type" value="custom" id="plan_custom">
                                                                <label class="form-check-label"
                                                                    for="plan_custom">Custom Package</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="plan_type" value="addon_only"
                                                                    id="plan_addon_only">
                                                                <label class="form-check-label"
                                                                    for="plan_addon_only">Only Addons</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group package-select">
                                                            <label>Package</label>
                                                            <select name="package_id" id="package_id"
                                                                class="form-control">
                                                                <option value="">Select Package</option>
                                                                @foreach ($packages as $package)
                                                                    <option value="{{ $package->id }}"
                                                                        {{ old('package_id', $client?->package_id) == $package->id ? 'selected' : '' }}>
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
                                                        <div class="form-group addon-checkboxes mt-3"
                                                            style="display: none;">
                                                            <label>Select Addons</label>
                                                            <div class="d-flex flex-wrap gap-2">
                                                                @php
                                                                    $selectedAddons = old(
                                                                        'addons',
                                                                        $client?->addons?->pluck('id')->toArray() ?? [],
                                                                    );
                                                                @endphp
                                                                @foreach ($addons as $addon)
                                                                    <label class="btn btn-outline-primary">
                                                                        <input type="checkbox" name="addons[]"
                                                                            value="{{ $addon->id }}"
                                                                            {{ in_array($addon->id, $selectedAddons) ? 'checked' : '' }}>
                                                                        {{ $addon->name }}
                                                                    </label>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="mb-3">
                                                            <label>Height</label>
                                                            <input type="text" name="height" class="form-control"
                                                                value="{{ old('height', $client?->height) }}" />
                                                            @error('height')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="mb-3">
                                                            <label>Weight</label>
                                                            <input type="text" name="weight" class="form-control"
                                                                value="{{ old('weight', $client?->weight) }}" />
                                                            @error('weight')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="mb-3">
                                                            <label>Goal</label>
                                                            <input type="text" name="goal" class="form-control"
                                                                value="{{ old('goal', $client?->goal) }}" />
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
                                                                class="form-control"
                                                                value="{{ old('specialization', $trainer?->specialization) }}" />
                                                            @error('specialization')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="mb-3">
                                                            <label>Experience</label>
                                                            <input type="number" name="experience"
                                                                class="form-control"
                                                                value="{{ old('experience', $trainer?->experience) }}" />
                                                            @error('experience')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="mb-3">
                                                            <label>Salary</label>
                                                            <input type="text" name="salary" class="form-control"
                                                                value="{{ old('salary', $trainer?->salary) }}" />
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
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
