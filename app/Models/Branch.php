<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;

    protected $table = 'branches';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'address',
        'city',
        'phone',
        'email',
        'status',
        'business_id',
        'is_main',
    ];

    public function getStatusBranchAttribute()
    {
        return $this->status == 'A' ? 'Activo' : 'Inactivo';
    }

    public function scopesearch(Builder $query, string $param = null, int $business_id = null)
    {
        return $query->when($param, function ($query, $param) {
            return $query->where('name', 'like', "%$param%")
                ->where('address', 'like', "%$param%")
                ->where('city', 'like', "%$param%")
                ->where('phone', 'like', "%$param%")
                ->where('email', 'like', "%$param%");
        })->when($business_id, function ($query, $business_id) {
            return $query->where('business_id', $business_id);
        })->orderBy('name', 'asc');
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function roomtypes()
    {
        return $this->hasMany(RoomType::class);
    }

    public function floors()
    {
        return $this->hasMany(Floor::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function concepts()
    {
        return $this->hasMany(Concept::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function cashboxes()
    {
        return $this->hasMany(Cashbox::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_branches', 'branch_id', 'user_id');
    }

    public function settings()
    {
        return $this->hasOne(Setting::class);
    }
}