<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'amount'  => 'decimal:2',
        'paid_at' => 'date',
    ];

    public function clientProfile()
    {
        return $this->belongsTo(ClientProfile::class);
    }

    public function scopeLatestFirst($q)
    {
        return $q->orderByDesc('id');
    }

    public function latestPaidThisMonth()
    {
        $start = now()->startOfMonth();
        $end   = now()->endOfMonth();

        return $this->hasOne(Payment::class)
            ->ofMany(
                [DB::raw('COALESCE(paid_at, created_at)') => 'max'],
                function ($q) use ($start, $end) {
                    $q->where('status', 'paid')
                        ->whereBetween(DB::raw('COALESCE(paid_at, created_at)'), [$start, $end]);
                }
            );
    }
}
