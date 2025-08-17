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
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="mb-3">
                                        <label>User Type</label>
                                        <select name="user_type"
                                            class="form-control @error('user_type') is-invalid @enderror">
                                            <option value="" disabled {{ old('user_type') ? '' : 'selected' }}>
                                                Select User Type</option>
                                            <option value="client"
                                                {{ old('user_type', $user->user_type) == 'client' ? 'selected' : '' }}>
                                                Client</option>
                                            <option value="trainer"
                                                {{ old('user_type', $user->user_type) == 'trainer' ? 'selected' : '' }}>
                                                Trainer</option>
                                        </select>
                                        @error('type')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <input type="hidden" id="userType" value="{{ $user->user_type }}">
                                    <div class="nav-align-top">
                                        <ul class="nav nav-pills mt-5 mb-4 justify-content-center" role="tablist">
                                            @if ($isClient)
                                                <li class="nav-item" role="presentation">
                                                    <button type="button"
                                                        class="nav-link {{ $activeTab === 'client' ? 'active' : '' }}"
                                                        role="tab" id="client-tab" data-bs-toggle="tab"
                                                        data-bs-target="#navs-pills-top-client"
                                                        aria-controls="navs-pills-top-client"
                                                        aria-selected="{{ $activeTab === 'client' ? 'true' : 'false' }}">
                                                        Client
                                                    </button>
                                                </li>
                                            @endif

                                            @if ($isTrainer)
                                                <li class="nav-item" role="presentation">
                                                    <button type="button"
                                                        class="nav-link {{ $activeTab === 'trainer' ? 'active' : '' }}"
                                                        role="tab" id="trainer-tab" data-bs-toggle="tab"
                                                        data-bs-target="#navs-pills-top-trainer"
                                                        aria-controls="navs-pills-top-trainer"
                                                        aria-selected="{{ $activeTab === 'trainer' ? 'true' : 'false' }}">
                                                        Trainer
                                                    </button>
                                                </li>
                                            @endif
                                        </ul>

                                        <div class="tab-content">
                                            @if ($isClient)
                                                <div class="tab-pane fade {{ $activeTab === 'client' ? 'show active' : '' }}"
                                                    id="navs-pills-top-client" role="tabpanel">
                                                    <div class="row">
                                                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label>Choose Plan Type</label><br>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="plan_type" value="default"
                                                                        id="plan_default"
                                                                        {{ old('plan_type', $planType) === 'default' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="plan_default">Default Package</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="plan_type" value="custom"
                                                                        id="plan_custom"
                                                                        {{ old('plan_type', $planType) === 'custom' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="plan_custom">Custom Package</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="plan_type" value="addon_only"
                                                                        id="plan_addon_only"
                                                                        {{ old('plan_type', $planType) === 'addon_only' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="plan_addon_only">Only Addons</label>
                                                                </div>

                                                                <input type="hidden" name="plan_type" id="plan_type"
                                                                    value="{{ $planType }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                            <div class="form-group package-select">
                                                                <label>Package</label>
                                                                <select name="package_id" id="package_id"
                                                                    class="form-select">
                                                                    <option value="">-- No Package --</option>
                                                                    @foreach ($packages as $pkg)
                                                                        <option value="{{ $pkg->id }}"
                                                                            {{ (string) old('package_id', $user->clientProfile?->package_id) === (string) $pkg->id ? 'selected' : '' }}>
                                                                            {{ $pkg->name }}
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
                                                                    {{-- @php
                                                                    $selectedAddons = old(
                                                                        'addons',
                                                                        $user?->addons?->pluck('id')->toArray() ?? [],
                                                                    );
                                                                @endphp --}}
                                                                    @foreach ($addons as $ad)
                                                                        <div class="col-md-3">
                                                                            <label class="form-check">
                                                                                <input type="checkbox"
                                                                                    class="form-check-input"
                                                                                    name="addon_ids[]"
                                                                                    value="{{ $ad->id }}"
                                                                                    {{ in_array($ad->id, old('addon_ids', $selectedAddonIds)) ? 'checked' : '' }}>
                                                                                <span
                                                                                    class="form-check-label">{{ $ad->name }}
                                                                                    ({{ $ad->price }})
                                                                                </span>
                                                                            </label>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                {{-- <input type="hidden" name="plan_type" id="plan_type"
                                                                    value="{{ $planType }}"> --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                            <div class="mb-3">
                                                                <label>Height</label>
                                                                <input type="text" name="height"
                                                                    class="form-control"
                                                                    value="{{ old('height', $user?->clientProfile?->height) }}" />
                                                                @error('height')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                            <div class="mb-3">
                                                                <label>Weight</label>
                                                                <input type="text" name="weight"
                                                                    class="form-control"
                                                                    value="{{ old('weight', $user?->clientProfile?->weight) }}" />
                                                                @error('weight')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                            <div class="mb-3">
                                                                <label>Goal</label>
                                                                <input type="text" name="goal"
                                                                    class="form-control"
                                                                    value="{{ old('goal', $user?->clientProfile?->goal) }}" />
                                                                @error('goal')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($isTrainer)
                                                <div class="tab-pane fade {{ $activeTab === 'trainer' ? 'show active' : '' }}"
                                                    id="navs-pills-top-trainer" role="tabpanel">
                                                    <div class="row">
                                                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                            <div class="mb-3">
                                                                <label>Specialization</label>
                                                                <input type="text" name="specialization"
                                                                    class="form-control"
                                                                    value="{{ old('specialization', $user?->specialization) }}" />
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
                                                                    value="{{ old('experience', $user?->experience) }}" />
                                                                @error('experience')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                            <div class="mb-3">
                                                                <label>Salary</label>
                                                                <input type="text" name="salary"
                                                                    class="form-control"
                                                                    value="{{ old('salary', $user?->salary) }}" />
                                                                @error('salary')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
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
            <script>
                const packageAddons = @json($packageAddons);
                const preSelected = @json($selectedAddonIds);

                document.addEventListener('DOMContentLoaded', function() {
                    const planRadios = document.querySelectorAll('input[name="plan_type"]');
                    const packageSelectWrapper = document.querySelector('.package-select');
                    const addonCheckboxesBox = document.querySelector('.addon-checkboxes');
                    const packageSelect = document.getElementById('package_id');

                    const addonCbs = () =>
                        document.querySelectorAll('.addon-checkboxes input[type="checkbox"][name="addon_ids[]"]');

                    let initialized = false;

                    function unselectAllAddons() {
                        addonCbs().forEach(cb => cb.checked = false);
                    }

                    function selectIds(ids = []) {
                        const set = new Set(ids.map(String));
                        addonCbs().forEach(cb => {
                            if (set.has(cb.value)) cb.checked = true;
                        });
                    }

                    function autoSelectPackageAddons() {
                        const pkgId = packageSelect.value;
                        const ids = packageAddons[pkgId] || [];
                        selectIds(ids);
                    }

                    function toggleViews() {
                        const selectedPlan =
                            document.querySelector('input[name="plan_type"]:checked')?.value || 'addon_only';

                        if (selectedPlan === 'default') {
                            packageSelectWrapper.style.display = 'block';
                            addonCheckboxesBox.style.display = 'none';
                            packageSelect.removeAttribute('disabled');
                            if (initialized) unselectAllAddons();
                        } else if (selectedPlan === 'custom') {
                            packageSelectWrapper.style.display = 'block';
                            addonCheckboxesBox.style.display = 'block';
                            packageSelect.removeAttribute('disabled');
                            if (initialized) unselectAllAddons();
                            autoSelectPackageAddons();
                        } else {
                            packageSelectWrapper.style.display = 'none';
                            addonCheckboxesBox.style.display = 'block';
                            packageSelect.setAttribute('disabled', 'disabled');
                            packageSelect.value = '';
                        }
                    }

                    planRadios.forEach(r => r.addEventListener('change', () => {
                        toggleViews();
                        initialized = true;
                    }));

                    packageSelect.addEventListener('change', () => {
                        const plan = document.querySelector('input[name="plan_type"]:checked')?.value;
                        if (plan === 'custom') {
                            unselectAllAddons();
                            autoSelectPackageAddons();
                        }
                    });

                    if (preSelected?.length) selectIds(preSelected);
                    toggleViews();
                    initialized = true;
                });
            </script>
        @endpush
</x-app-layout>
