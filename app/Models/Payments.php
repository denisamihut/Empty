<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Payments extends Model
{
    use SoftDeletes;

    protected $table = 'payments';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'type',
        'notes',
        'branch_id',
        'business_id',
    ];

    public function getTypeListAttribute()
    {
        switch ($this->type) {
            case 'cash':
                return 'Efectivo';
            case 'card':
                return 'Tarjeta';
            case 'transfer':
                return 'Transferencia';
            case 'check':
                return 'Cheque';
            case 'deposit':
                return 'Depósito';
            case 'others':
                return 'Otros';
            default:
                return 'Desconocido';
        }
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function processes()
    {
        return $this->belongsToMany(Process::class, 'paymentprocesses', 'payment_id', 'process_id');
    }

    public function scopesearch(Builder $builder, string $param = null, $branch_id, $business_id)
    {
        $generalPaymetns = DB::table('payments')->whereIn('id', config('constants.generalPayments'));

        return $builder->when($param, function ($query, $param) {
            return $query->where('name', 'like', "%$param%");
        })->when($branch_id, function ($query, $branch_id) {
            return $query->where('branch_id', $branch_id);
        })->when($business_id, function ($query, $business_id) {
            return $query->where('business_id', $business_id);
        })->union($generalPaymetns)->orderBy('name', 'asc');
    }
}