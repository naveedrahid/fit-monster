<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
