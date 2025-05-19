<x-app-layout>
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Permissions
                            @can('create permission')
                                <a href="{{ url('backend/permissions/create') }}" class="btn btn-primary float-end">Add
                                    Permission</a>
                            @endcan
                        </h4>
                    </div>
                    <div class="card-body">

                        @php
                            $actions = ['view', 'create', 'update', 'delete'];
                        @endphp

                        @foreach ($actions as $action)
                            <h3 class="text-capitalize my-5">{{ $action }} Permissions</h3>
                            <div class="d-flex flex-wrap gap-2">
                                @if (isset($grouped[$action]))
                                    @foreach ($grouped[$action] as $module => $permission)
                                        <div class="permissionBox">
                                            @if (isset($grouped[$action][$module]))
                                               
                                               <h6 class="permissionName text-center">{{ $grouped[$action][$module]->name }}</h6> 
                                                @can($action . ' permission')
                                                <div class="permissionBtn">
                                                    <a href="{{ url('backend/permissions/' . $grouped[$action][$module]->id . '/edit') }}"
                                                        class="btn btn-sm btn-success">
                                                        <i class="icon-base bx bx-edit-alt text-white"></i></a>
                                                    <a href="{{ url('backend/permissions/' . $grouped[$action][$module]->id . '/delete') }}"
                                                        class="btn btn-sm btn-danger">
                                                        <i class="icon-base bx bx-trash text-white"></i></a>
                                                </div>
                                                @endcan
                                            @else
                                                -
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <span class="text-muted">No {{ $action }} permissions</span>
                                @endif
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('css')
        <style>
            .permissionBox {
                box-shadow: #0000003d 0px 0px 10px 0px;
                padding: 10px 20px;
                border-radius: 10px;
            }
        </style>
    @endpush
</x-app-layout>
