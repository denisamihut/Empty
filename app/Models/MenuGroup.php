<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuGroup extends Model
{
    use SoftDeletes;

    protected $table = 'menu_groups';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'icon',
        'order',
    ];

    public function menuoption()
    {
        return $this->hasMany(MenuOption::class, 'menugroup_id');
    }

    public function scopesearch(Builder $query, string $param = null)
    {
        return $query->when($param, function ($query, $param) {
            return $query->where('name', 'like', "%$param%");
        })->orderBy('order', 'asc');
    }
}