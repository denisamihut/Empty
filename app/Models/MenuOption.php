<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class MenuOption extends Model
{
    use SoftDeletes;

    protected $table = 'menu_options';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'icon',
        'link',
        'order',
        'menugroup_id',
    ];

    public function menugroup()
    {
        return $this->belongsTo(MenuGroup::class, 'menugroup_id');
    }

    public function usertype()
    {
        return $this->belongsToMany(UserType::class, 'access', 'menuoption_id', 'usertype_id');
    }

    public static function getMenu()
    {
        $option = new MenuOption();
        $usertype_option = $option->getMenusOptions();
        return $usertype_option;
    }

    public function getMenusOptions()
    {
        $groupWithOptions = MenuGroup::with([
            'menuoption' => function ($query) {
                $query->whereHas('usertype', function ($q) {
                    $q->where('usertype_id', Auth::user()->usertype_id);
                });
            }
        ])->orderBy('order')->get()->toArray();
        return $groupWithOptions;
    }

    public function getMenuGroups()
    {
        $group = MenuGroup::orderBy('order')->get()->toArray();
        return $group;
    }

    public function scopesearch($query, $name, $menugroup)
    {
        return $query
            ->where(function ($subquery) use ($name) {
                if (!is_null($name) && strlen($name) > 0) {
                    $subquery->where('name', 'LIKE', '%' . $name . '%');
                }
            })
            ->where(function ($subquery) use ($menugroup) {
                if (!is_null($menugroup) && strlen($menugroup) > 0) {
                    $subquery->where('menugroup_id', $menugroup);
                }
            })
            ->orderBy('name', 'DESC');
    }
}