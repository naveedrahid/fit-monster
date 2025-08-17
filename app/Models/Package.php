<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function addons()
    {
        return $this->belongsToMany(Addon::class, 'addon_package');
    }

    public function clients()
    {
        return $this->belongsTo(ClientProfile::class);
    }
}
