<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'usertype_id',
        'business_id',
        'people_id',
        'cashbox_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function people()
    {
        return $this->belongsTo(People::class);
    }

    public function usertype()
    {
        return $this->belongsTo(Usertype::class);
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'user_branches', 'user_id', 'branch_id');
    }

    public function cashbox()
    {
        return $this->belongsTo(Cashbox::class);
    }

    public function scopesearch(Builder $query, string $param = null, int $usertype_id = null, int $business_id = null, int $branch_id = null)
    {
        return $query->when($param, function ($query, $param) {
            return $query->where('name', 'like', '%' . $param . '%')
                ->orWhere('email', 'like', '%' . $param . '%');
        })
            ->when($usertype_id, function ($query, $usertype_id) {
                return $query->where('usertype_id', $usertype_id);
            })
            ->when($business_id, function ($query, $business_id) {
                return $query->where('business_id', $business_id);
            })
            ->when($branch_id, function ($query, $branch_id) {
                return $query->where('branch_id', $branch_id);
            });
    }
}