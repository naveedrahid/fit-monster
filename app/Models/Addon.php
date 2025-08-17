<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'addon_package');
    }

    public function clients()
    {
        return $this->belongsToMany(
            ClientProfile::class,
            'client_profile_addons',
            'addon_id',
            'client_profile_id'
        )
            ->withPivot('package_id', 'is_active')
            ->withTimestamps();
    }
}
