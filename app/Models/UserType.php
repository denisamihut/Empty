<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserType extends Model
{
    use SoftDeletes;

    protected $table = 'usertypes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'usertype_id');
    }

    public function menuoption()
    {
        return $this->belongsToMany(MenuOption::class, 'access', 'usertype_id', 'menuoption_id');
    }

    public function scopesearch(Builder $query, $name = null)
    {
        return $query
            ->when($name, function ($query, $name) {
                return $query->where('name', 'like', "%$name%");
            })->orderBy('name');
    }
}