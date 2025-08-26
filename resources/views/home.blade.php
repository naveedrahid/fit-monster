@section('title', 'Dashboard')
<x-app-layout>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="mb-0">Paid — Current Month</h5>
                    <span class="badge bg-success">{{ $paidThisMonthClients->count() }}</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Client</th>
                                <th>Amount</th>
                                <th>Paid At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($paidThisMonthClients as $cp)
                                <tr>
                                    <td>#{{ $cp->id }}</td>
                                    <td>{{ $cp->user?->name ?? 'Unknown' }}</td>
                                    @php $p = $cp->latestPaidThisMonth; @endphp
                                    <td>{{ $p ? number_format($p->amount, 2) : '-' }}</td>
                                    <td>
                                        @if ($p)
                                            {{ \Carbon\Carbon::parse($p->paid_at)->format('d M Y, h:i A') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-muted">No paid clients in current month.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mb-4 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="mb-0">Remaining — This Month</h5>
                    <span class="badge bg-warning text-dark">{{ $remainingThisMonthClients->count() }}</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Client</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($remainingThisMonthClients as $cp)
                                <tr>
                                    <td>#{{ $cp->id }}</td>
                                    <td>{{ $cp->user?->name ?? 'Unknown' }}</td>
                                    <td><span class="badge bg-secondary">Unpaid this month</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-muted">Everyone paid this month 🎉</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
