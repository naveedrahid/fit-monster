<?php

namespace App\Http\Controllers;

use App\Models\ClientProfile;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalClients = ClientProfile::count();

        $paidThisMonthClients = ClientProfile::query()
            ->whereHas('latestPaidThisMonth')
            ->with([
                'user:id,name',
                'latestPaidThisMonth' => function ($q) {
                    $q->select(
                        'payments.id',
                        'payments.client_profile_id',
                        'payments.amount',
                        'payments.paid_at'
                    );
                },
            ])
            ->orderBy('id')
            ->get();

        $remainingThisMonthClients = ClientProfile::query()
            ->whereDoesntHave('latestPaidThisMonth')
            ->with('user:id,name')
            ->orderBy('id')
            ->get();

        return view('home', compact(
            'totalClients',
            'paidThisMonthClients',
            'remainingThisMonthClients'
        ));
    }
}
