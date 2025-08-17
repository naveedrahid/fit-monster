<x-app-layout>
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                <div class="card mt-3">
                    <div class="card-header">
                        <h4>User Details
                            <a href="{{ route('users.index') }}" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card mt-5 h-100">
                    <div class="card-body">
                        <h4>{{ __('Shift') }}</h4>
                        <ul class="list-group">
                            <li class="list-group-item"><strong>{{ __('Name') }}</strong>: {{ $user?->shift?->name }}
                            </li>
                            <li class="list-group-item"><strong>{{ __('Gender') }}</strong>:
                                {{ $user?->shift?->gender }}</li>
                            <li class="list-group-item"><strong>{{ __('Start Time') }}</strong>:
                                {{ date('h:ia', strtotime($user?->shift?->start_time)) }}</li>
                            <li class="list-group-item"><strong>{{ __('End Time') }}</strong>:
                                {{ date('h:ia', strtotime($user?->shift?->end_time)) }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mt-5 h-100">
                    <div class="card-body">
                        <h4>{{ __('Personal Details') }}</h4>
                        <ul class="list-group">
                            <li class="list-group-item"><strong>{{ __('Name') }}</strong>: {{ $user?->name }}</li>
                            <li class="list-group-item"><strong>{{ __('Email') }}</strong>: {{ $user?->email }}</li>
                            <li class="list-group-item"><strong>{{ __('Gender') }}</strong>: {{ $user?->gender }}
                            </li>
                            <li class="list-group-item"><strong>{{ __('Phone') }}</strong>: {{ $user?->phone }}</li>
                            <li class="list-group-item"><strong>{{ __('Emergency Contact') }}</strong>:
                                {{ $user?->emergency_contact }}</li>
                            <li class="list-group-item"><strong>{{ __('Height') }}</strong>:
                                {{ $user?->clientProfile?->height }} ft</li>
                            <li class="list-group-item"><strong>{{ __('Weight') }}</strong>:
                                {{ $user?->clientProfile?->weight }} kg</li>
                            <li class="list-group-item"><strong>{{ __('Goal') }}</strong>:
                                {{ $user?->clientProfile?->goal }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-5">
                <div class="card mt-5 h-100">
                    <div class="card-body">
                        <h4>{{ __('Package Details') }}</h4>
                        @if ($user?->clientProfile?->package)
                            <ul class="list-group">
                                <li class="list-group-item"><strong>{{ __('Package Name') }}</strong>:
                                    {{ $user?->clientProfile?->package?->name }}</li>
                                <li class="list-group-item"><strong>{{ __('Price') }}</strong>:
                                    {{ $user?->clientProfile?->package?->price }}</li>
                                <li class="list-group-item"><strong>{{ __('Duration') }}</strong>:
                                    {{ $user?->clientProfile?->package?->duration_days }} days</li>
                            </ul>
                        @else
                            <p class="m-0">No package found!.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-5">
                <div class="card mt-5 h-100">
                    <div class="card-body">
                        <h4>{{ __('Client Addons') }}</h4>
                        @if ($user?->clientProfile?->addons)
                            @foreach ($user->clientProfile->addons as $addon)
                                <ul class="list-group mb-4">
                                    <li class="list-group-item"><strong>{{ __('Name') }}</strong>:
                                        {{ $addon->name }}</li>
                                    <li class="list-group-item"><strong>{{ __('Price') }}</strong>:
                                        {{ $addon->price }}</li>
                                    <li class="list-group-item">
                                        <strong>{{ __('Status') }}</strong>:
                                        @if ($addon->pivot->is_active == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </li>
                                </ul>
                            @endforeach
                            <ul class="list-group mt-4">
                                <li class="list-group-item d-flex align-items-center justify-content-between">
                                    <strong>{{ __('Total') }}:</strong>
                                    Rs:{{ $user->clientProfile->addons->sum('price') }}
                                </li>
                            </ul>
                        @else
                            <p class="m-0">No addons found!.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-5">
                <div class="card mt-5 h-100">
                    <div class="card-body">
                        <h4>{{ __('Client Payments') }}</h4>
                        @if ($user?->clientProfile?->payments)
                            <ul class="list-group mb-4">
                                <li class="list-group-item"><strong>{{ __('Payment Type') }}</strong>:
                                    {{ $user?->clientProfile?->payments?->first()?->method }}</li>
                                @if ($user?->clientProfile?->payments?->first()?->status == 'paid')
                                    <li class="list-group-item"><strong>{{ __('Payment Status') }}</strong>:
                                        <span
                                            class="badge bg-success">{{ $user?->clientProfile?->payments?->first()?->status }}</span>
                                    </li>
                                @elseif ($user?->clientProfile?->payments?->first()?->status == 'pending')
                                    <li class="list-group-item"><strong>{{ __('Payment Status') }}</strong>:
                                        <span class="badge bg-warning">{{ $user?->clientProfile?->payments?->first()?->status }}</span>
                                    </li>
                                @else
                                    <li class="list-group-item"><strong>{{ __('Payment Status') }}</strong>:
                                        <span class="badge bg-danger">{{ $user?->clientProfile?->payments?->first()?->status }}</span>
                                    </li>
                                @endif
                                <li class="list-group-item"><strong>{{ __('Amount') }}</strong>:
                                    {{ $user?->clientProfile?->payments?->first()?->amount }}
                                </li>
                                <li class="list-group-item"><strong>{{ __('Paid At') }}</strong>:
                                    {{ $user?->clientProfile?->payments?->first()?->paid_at }}
                                </li>
                            </ul>
                        @else
                            <p class="m-0">No payments found!.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
