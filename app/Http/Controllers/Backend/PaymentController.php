<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ClientProfile;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('clientProfile.user:id,name')
            ->select('id', 'client_profile_id', 'amount', 'status', 'method', 'paid_at', 'created_at')
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('backend.payments.index', compact('payments'));
    }
    
    public function create()
    {
        $clients = ClientProfile::with('user:id,name')
            ->select('id', 'user_id')
            ->orderBy('id')
            ->get();

        return view('backend.payments.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_profile_id' => ['required', 'exists:client_profiles,id'],
            'status' => ['required', Rule::in(['pending', 'paid', 'failed'])],
            'method' => ['required', Rule::in(['card', 'cash', 'bank_transfer'])],
            'paid_at' => ['nullable', 'date'],
        ]);

        $amount = DB::table('client_profile_addons as cpa')
            ->join('addons as a', 'a.id', '=', 'cpa.addon_id')
            ->where('cpa.client_profile_id', $data['client_profile_id'])
            ->when(
                DB::getSchemaBuilder()->hasColumn('client_profile_addons', 'is_active'),
                fn($q) => $q->where('cpa.is_active', 1)
            )
            ->sum('a.price');

        $payment = DB::transaction(function () use ($data, $amount) {
            return Payment::create([
                'client_profile_id' => $data['client_profile_id'],
                'amount'            => $amount,
                'status'            => $data['status'],
                'method'            => $data['method'],
                'paid_at'           => $data['paid_at'] ?? null,
            ]);
        });

        return redirect()->route('payments.index')->with('success', "Payment #{$payment->id} created.");
    }

    public function amount(ClientProfile $client_profile)
    {
        $client_profile->loadMissing('user:id,name');

        $total = DB::table('client_profile_addons as cpa')
            ->join('addons as a', 'a.id', '=', 'cpa.addon_id')
            ->where('cpa.client_profile_id', $client_profile->id)
            ->when(DB::getSchemaBuilder()->hasColumn('client_profile_addons', 'is_active'), function ($q) {
                $q->where('cpa.is_active', 1);
            })
            ->sum('a.price');

        return response()->json([
            'client_profile_id' => $client_profile->id,
            'user_id'           => $client_profile->user_id,
            'user_name'         => optional($client_profile->user)->name,
            'addons_total'      => number_format($total, 2, '.', ''),
        ]);
    }
}
