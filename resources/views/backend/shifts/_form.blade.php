@section('title', 'Shift')
<x-app-layout>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card position-relative">
            <div id="loadingSpinner" style="display: none; text-align: center;">
                <i class="fas fa-spinner fa-spin fa-3x"></i>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-header">{{ __('Create New Shift') }}</h5>
                <div class="card-header">
                    <a href="" class="btn btn-secondary">Back</a>
                </div>
            </div>
            <div class="card-body">

            </div>
        </div>
    </div>

    {{-- @push('js')
        <script>
            $(document).ready(function() {
                $(document).on('submit', '#assetCreate , #assetUpdate', function(e) {
                    e.preventDefault();

                    const self = this;
                    const {
                        url,
                        token,
                        formData,
                        button,
                        loadingSpinner
                    } = getFormData(this);

                    let isValid = requestValidationHandler.call(self,
                        'input[required], select[required], textarea[required]'
                    );

                    if (!isValid) {
                        toastr.error('Please fill all required fields.');
                        return;
                    }

                    loadingSpinner.show();
                    button.prop('disabled', true).text('Processing...');

                    $.ajax({
                            method: "POST",
                            url: url,
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': token,
                            },
                        })
                        .done(function(response) {
                            loadingSpinner.hide();
                            button.prop('disabled', false).text('Submit');
                            if (self.id === 'assetCreate') {
                                $(self).trigger('reset');
                                $(self).find('select').each(function() {
                                    $(this).val($(this).find('option:first').val()).trigger(
                                        'change');
                                });
                            }
                            toastr.success(response.message || 'Form submitted successfully.');
                        })
                        .fail(function(xhr) {
                            handleAjaxError(xhr);
                        })
                        .always(function() {
                            loadingSpinner.hide();
                            button.prop('disabled', false).text('Submit');
                        });
                });
            });
        </script>
    @endpush --}}
</x-app-layout>
