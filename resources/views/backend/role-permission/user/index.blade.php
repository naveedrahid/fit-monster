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
                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th> Email</th>
                                    <th>Roles</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if (!empty($user->getRoleNames()))
                                                @foreach ($user->getRoleNames() as $rolename)
                                                    <label class="badge bg-primary mx-1">{{ $rolename }}</label>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @can('update user')
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success">Edit</a>
                                            @endcan

                                            @can('delete user')
                                                <a href="{{ route('users.destroy', $user->id) }}"
                                                    class="btn btn-danger mx-2">Delete</a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>