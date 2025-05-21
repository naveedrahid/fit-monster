@section('title', 'Client Package')
<x-app-layout>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card position-relative">
            <div id="loadingSpinner" style="display: none; text-align: center;">
                <i class="fas fa-spinner fa-spin fa-3x"></i>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-header">{{ __('Manage Client Package') }}</h5>
                <div class="card-header">
                    <a href="" class="btn btn-secondary">{{ __('Add Client Package') }}</a>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Client Package Name') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        {{-- @forelse ($assets as $asset)
                            <tr>
                                <td>
                                    <img src="{{ $asset->image ? asset($asset->image) : asset('admin/img/placeholder.jpg') }}"
                                        width="70" height="70" alt="" style="background-size: cover">
                                </td>
                                <td>
                                    <p class="m-0">{{ $asset->employee->user->name }}</p>
                                    <hr class="m-0">
                                    <p class="m-0"><small><strong>{{ __('Client Package Code') }}</strong>:
                                            {{ $asset->asset_code }}</small></p>
                                    <p class="m-0"><small><strong>{{ __('Assigned Date') }}</strong>:
                                            {{ $asset->assigned_date }}</small></p>
                                    <p class="m-0"><small><strong>{{ __('Return Date') }}</strong>:
                                            {{ $asset->return_date }}</small></p>
                                    <p class="m-0"><small><strong>{{ __('Serial Number') }}</strong>:
                                            {{ $asset->serial_number }}</small></p>
                                    <p class="m-0"><small><strong>{{ __('Model') }}</strong>:
                                            {{ $asset->model }}</small></p>
                                    <p class="m-0"><small><strong>{{ __('Brand') }}</strong>:
                                            {{ $asset->brand }}</small></p>
                                </td>
                                <td>
                                    <p>{{ $asset->asset_name }}</p>
                                    <div class="demo-inline-spacing">
                                        <small><strong>Condition</strong></small>
                                        <span
                                            class="badge text-bg-{{ $asset->condition == 'new' ? 'success' : ($asset->condition == 'used' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($asset->condition) }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="demo-inline-spacing">
                                        <span
                                            class="badge bg-label-{{ $asset->status == 'assigned' ? 'warning' : ($asset->status == 'not assigned' ? 'success' : 'secondary') }}">
                                            {{ ucfirst($asset->status) }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <a class="btn btn-icon btn-primary"
                                        href="{{ route('backend.asset.edit', $asset->id) }}">
                                        <i class="icon-base bx bx-edit-alt text-white"></i>
                                    </a>
                                    <a class="btn btn-icon btn-danger deleteAsset"
                                        href="{{ route('backend.asset.destroy', $asset->id) }}">
                                        <i class="icon-base bx bx-trash text-white"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="9">{{ __('No Client Package Found') }}</td>
                            </tr>
                        @endforelse --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('js')
        {{-- <script>
            $(document).ready(function() {
                
                $(document).on('click', '.deleteAsset', function (e) {
                    e.preventDefault();

                    self = $(this);
                    const url = self.attr('href');
                    const token = $('meta[name="csrf-token"]').attr('content');
                    
                    if (confirm('Are you sure you want to delete this asset?')) {
                        $('#loadingSpinner').show();
                        self.prop('disabled', true);
                        
                        $.ajax({
                            method: 'DELETE',
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': token
                            },
                        })
                        .done(function(response){
                            $('#loadingSpinner').hide();
                            self.prop('disabled', false);
                            toastr.success(response.message);
                            self.closest('tr').fadeOut('slow', function() {
                                $(this).remove();
                            });
                        })
                        .fail(function(xhr){
                            handleAjaxError(xhr);
                        })
                        .always(function(){
                            $('#loadingSpinner').hide();
                            self.prop('disabled', false);
                        })
                    }
                });
            });
        </script> --}}
    @endpush
</x-app-layout>
