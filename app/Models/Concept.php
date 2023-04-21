<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Concept extends Model
{
    use SoftDeletes;

    protected $table = 'concepts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'type',
        'branch_id',
        'business_id',
    ];

    public function getIsGeneralConceptAttribute()
    {
        return in_array($this->id, config('constants.generalConcepts'));
    }

    public function scopesearch(Builder $query, string $param = null, int $branch_id = null, int $business_id = null)
    {
        $generalConcepts = DB::table('concepts')->whereIn('id', config('constants.generalConcepts'));
        return $query->when($param, function ($query, $param) {
            return $query->where('name', 'like', "%$param%");
        })->when($branch_id, function ($query, $branch_id) {
            return $query->where('branch_id', $branch_id);
        })->when($business_id, function ($query, $business_id) {
            return $query->where('business_id', $business_id);
        })->union($generalConcepts)->orderBy('name', 'asc');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function getTypeAttribute($value)
    {
        return $value == 'I' ? 'Ingreso' : 'Egreso';
    }
}