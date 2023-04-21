<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use SoftDeletes;

    protected $table = 'business';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'address',
        'city',
        'phone',
        'email',
        'status',
    ];

    public function getStatusBusinessAttribute()
    {
        return $this->status == 'A' ? 'Activo' : 'Inactivo';
    }

    public function scopesearch(Builder $query, string $param = null, string $status = null)
    {
        return $query->when($param, function ($query, $param) {
            return $query->where('name', 'like', '%' . $param . '%')
                ->orWhere('address', 'like', '%' . $param . '%')
                ->orWhere('city', 'like', '%' . $param . '%')
                ->orWhere('phone', 'like', '%' . $param . '%')
                ->orWhere('email', 'like', '%' . $param . '%');
        })->when($status, function ($query, $status) {
            return $query->where('status', $status);
        })->orderBy('name', 'asc');
    }

    public function settings()
    {
        return $this->hasOne(Setting::class, 'business_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
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

    public function branches()
    {
        return $this->hasMany(Branch::class);
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
}