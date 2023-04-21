<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class People extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'people';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'dni',
        'email',
        'phone',
        'age',
        'birthday',
        'social_reason',
        'ruc',
        'address',
        'district_id',
        'province_id',
        'department_id',
        'country_id',
        'notes',
    ];

    public function getFullNameAttribute()
    {
        if (!is_null($this->dni)) {
            return $this->name;
        } else {
            return $this->social_reason;
        }
    }

    public function scopeCompanies(Builder $builder)
    {
        return $builder->where('ruc', '!=', null)->where('social_reason', '!=', null);
    }

    public function scopePeopleClient(Builder $builder)
    {
        return $builder->where('dni', '!=', null)->where('name', '!=', null);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function scopeSearch(Builder $builder, string $name = null)
    {
        $clients = DB::table('people')
            ->when($name, function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%')
                    ->orWhere('dni', 'like', '%' . $name . '%');
            });

        $companies = DB::table('people')
            ->when($name, function ($query, $name) {
                return $query->where('social_reason', 'like', '%' . $name . '%')
                    ->orWhere('ruc', 'like', '%' . $name . '%');
            });

        return $clients->union($companies)->orderBy('name', 'asc');
    }
}