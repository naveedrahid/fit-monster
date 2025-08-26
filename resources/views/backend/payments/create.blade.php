@section('title', 'Payment')
<x-app-layout>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card position-relative">
            <div id="loadingSpinner" style="display: none; text-align: center;">
                <i class="fas fa-spinner fa-spin fa-3x"></i>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-header">{{ __('Create New Payment') }}</h5>
                <div class="card-header">
                    <a href="" class="btn btn-danger">Back</a>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('payments.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Client (ClientID — User Name)</label>
                                <select id="client_profile_id" name="client_profile_id" class="form-select" required
                                    data-amount-url="{{ route('payments.amount', ['client_profile' => ':id']) }}">
                                    <option value="" selected disabled>-- Select Client --</option>
                                    @foreach ($clients as $cp)
                                        <option value="{{ $cp->id }}">{{ $cp->user?->name ?? 'Unknown' }}</option>
                                    @endforeach
                                </select>
                                @error('client_profile_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Amount (auto from addons)</label>
                                <input type="text" id="amount" class="form-control mt-2" value="" readonly>
                                <small class="text-muted">This amount is auto-calculated and not editable.</small>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="paid" selected>Paid</option>
                                <option value="pending">Pending</option>
                                <option value="failed">Failed</option>
                            </select>
                            @error('status')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label">Method</label>
                            <select class="form-select" name="method" required>
                                <option value="cash" selected>Cash</option>
                                <option value="card">Card</option>
                                <option value="bank_transfer">Bank Transfer</option>
                            </select>
                            @error('method')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label">Paid At</label>
                            <input type="date" name="paid_at" class="form-control">
                            @error('paid_at')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <button class="btn btn-primary">
                            <i class="ti ti-device-floppy"></i> Save Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            (() => {
                const client = document.querySelector('#client_profile_id');
                const amount = document.querySelector('#amount');
                if (!client || !amount) return;

                let controller = null;

                const setLoading = (isLoading) => {
                    amount.value = isLoading ? 'Loading…' : amount.value;
                    amount.classList.toggle('opacity-50', isLoading);
                };

                const buildUrl = (id) => client.dataset.amountUrl.replace(':id', id);

                client.addEventListener('change', async (e) => {
                    const id = e.target.value;
                    if (!id) return;

                    if (controller) controller.abort();
                    controller = new AbortController();

                    setLoading(true);
                    try {
                        const res = await fetch(buildUrl(id), {
                            headers: {
                                'Accept': 'application/json'
                            },
                            signal: controller.signal,
                        });
                        if (!res.ok) throw new Error(`HTTP ${res.status}`);
                        const data = await res.json();

                        amount.value = data?.addons_total ?? '0.00';
                    } catch (err) {
                        if (err.name !== 'AbortError') {
                            console.error('payments.amount failed:', err);
                            amount.value = '';
                        }
                    } finally {
                        setLoading(false);
                    }
                }, {
                    passive: true
                });
            })();
        </script>
    @endpush

</x-app-layout>
