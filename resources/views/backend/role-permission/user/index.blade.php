<x-app-layout>
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Users
                            @can('create user')
                                <a href="{{ route('users.create') }}" class="btn btn-primary float-end">Add User</a>
                            @endcan
                        </h4>
                    </div>
                    <div class="card-body table-responsive p-0">

                        <table class="table table-bordered table-striped table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Fees</th>
                                    <th>Stats</th>
                                    <th>Paid At</th>
                                    <th>Roles</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @php($payment = $user->payments->first())
                                            @if ($payment && $payment->method == 'cash')
                                                <span class="badge bg-success"><i class="fas fa-money-bill-wave"></i>
                                                    {{ $payment->method }}</span>
                                            @elseif ($payment && $payment->method == 'card')
                                                <span class="badge bg-warning"><i class="fas fa-credit-card"></i>
                                                    {{ $payment->method }}</span>
                                            @elseif ($payment && $payment->method == 'bank_transfer')
                                                <span class="badge bg-info"><i class="fas fa-university"></i> bank
                                                    transfer</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($payment && $payment->status == 'pending')
                                                <span class="badge bg-warning">{{ $payment->status }}</span>
                                            @elseif ($payment && $payment->status == 'paid')
                                                <span class="badge bg-success">{{ $payment->status }}</span>
                                            @elseif ($payment && $payment->status == 'failed')
                                                <span class="badge bg-danger">{{ $payment->status }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $payment?->paid_at }}</td>
                                        <td>
                                            @if (!empty($user->getRoleNames()))
                                                @foreach ($user->getRoleNames() as $rolename)
                                                    <label class="badge bg-primary mx-1">{{ $rolename }}</label>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @can('update user')
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan

                                            @can('view user')
                                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endcan

                                            {{-- @can('delete user')
                                                <a href="{{ route('users.destroy', $user->id) }}"
                                                    class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                            @endcan --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No users found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $users->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
