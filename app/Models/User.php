<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'shift_id',
        'phone',
        'emergency_contact',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function trainerProfile()
    {
        return $this->hasOne(TrainerProfile::class);
    }

    public function clientProfile()
    {
        return $this->hasOne(ClientProfile::class);
    }

    public function payments()
    {
        return $this->hasManyThrough(
            Payment::class,
            ClientProfile::class,
            'user_id',
            'client_profile_id',
            'id',
            'id'
        );
    }

    public function package()
    {
        return $this->hasOneThrough(
            Package::class,
            ClientProfile::class,
            'user_id',
            'id',
            'id',
            'package_id'
        );
    }

    public function addons()
    {
        $clientId = optional($this->clientProfile)->id ?? 0;

        return $this->belongsToMany(
            Addon::class,
            'client_profile_addons',
            'client_profile_id',
            'addon_id'
        )
            ->withPivot('package_id', 'is_active')
            ->withTimestamps()
            ->where('client_profile_addons.client_profile_id', $clientId);
    }
}
