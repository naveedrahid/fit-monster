<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ClientProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'client_profile_id');
    }

    public function addons()
    {
        return $this->belongsToMany(
            Addon::class,
            'client_profile_addons',
            'client_profile_id',
            'addon_id'
        )
            ->withPivot('package_id', 'is_active')
            ->withTimestamps();
    }

    public function latestPaidThisMonth()
    {
        $start = now()->startOfMonth();
        $end   = now()->endOfMonth();

        return $this->hasOne(Payment::class)
            ->where('status', 'paid')
            ->whereBetween('paid_at', [$start, $end])
            ->latestOfMany('paid_at');
    }
}
