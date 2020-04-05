<?php

namespace App\Eloquents;

use App\Eloquents\Traits\AuthGuardTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements Auditable
{
    use AuthGuardTrait, AuditingAuditable, HasApiTokens, HasRoles, Notifiable;

    /**
     * @var string
     */
    protected $guardName = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Set Password Attribute
     *
     * @param string $pass
     */
    public function setPasswordAttribute($pass)
    {
        if (!empty($pass)) {
            $this->attributes['password'] = Hash::make($pass);
        }
    }
}
