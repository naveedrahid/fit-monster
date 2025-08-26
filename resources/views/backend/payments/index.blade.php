@section('title', 'Payment')
<x-app-layout>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card position-relative">
            <div id="loadingSpinner" style="display: none; text-align: center;">
                <i class="fas fa-spinner fa-spin fa-3x"></i>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-header">{{ __('Manage Payment') }}</h5>
                <div class="card-header">
                    <a href="{{route('payments.create')}}" class="btn btn-secondary">{{ __('Add Payment') }}</a>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Payment Method') }}</th>
                            <th>{{ __('Total') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($payments as $payment)
                            <tr>
                                <td>{{ $payment?->clientProfile?->user?->name }}</td>
                                <td>
                                    @if ($payment->method == 'cash')
                                        <span class="badge text-capitalize bg-success"><i
                                                class="fas fa-money-bill-wave"></i>
                                            {{ $payment->method }}</span>
                                    @elseif ($payment->method == 'card')
                                        <span class="badge text-capitalize bg-warning"><i
                                                class="fas fa-credit-card"></i>
                                            {{ $payment->method }}</span>
                                    @elseif ($payment->method == 'bank_transfer')
                                        <span class="badge text-capitalize bg-info"><i class="fas fa-university"></i>
                                            bank
                                            transfer</span>
                                    @endif
                                </td>
                                <td>{{ $payment?->amount }}</td>
                                <td>{{ $payment?->paid_at }}</td>
                                <td>
                                    @if ($payment->status == 'paid')
                                        <span class="badge text-capitalize bg-success">
                                            {{ $payment->status }}</span>
                                    @elseif ($payment->status == 'pending')
                                        <span class="badge text-capitalize bg-warning">
                                            {{ $payment->status }}</span>
                                    @elseif ($payment->status == 'failed')
                                        <span class="badge text-capitalize bg-danger">{{ $payment->status }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="9">{{ __('No Payment Found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
