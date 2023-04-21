<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Billing extends Model
{
    use SoftDeletes;

    protected $table = 'billings';
    protected $primaryKey = 'id';

    protected $fillable = [
        'date',
        'number',
        'type',
        'status',
        'motivo_anulacion',
        'total',
        'subtotal',
        'igv',
        'notes',
        'client_id',
        'process_id',
        'user_id',
        'branch_id',
        'business_id',
        'billing_id',
    ];


    public function client()
    {
        return $this->belongsTo(People::class, 'client_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function process()
    {
        return $this->belongsTo(Process::class, 'process_id');
    }

    public function billing()
    {
        return $this->belongsTo(Billing::class, 'billing_id');
    }

    public function details()
    {
        return $this->hasMany(BillingDetails::class, 'billing_id');
    }

    public function scopeSearch(Builder $query, string $param = null, string $type = null, $date_start = null, $date_end = null, int $business_id, int $branch_id)
    {
        return $query->when($param, function ($query, $param) {
            return $query->where('number', 'like', '%' . $param . '%');
        })
            ->when($type, function ($query, $type) {
                return $query->where('type', $type);
            })
            ->when($date_start, function ($query, $date_start) {
                return $query->where('date', '>=', $date_start);
            })
            ->when($date_end, function ($query, $date_end) {
                return $query->where('date', '<=', $date_end);
            })
            ->where('business_id', $business_id)
            ->where('branch_id', $branch_id)
            ->orderBy('id', 'desc');
    }

    public function scopeGetBillingAmounts(Builder $query, int $business_id, int $branch_id, float $amount): array
    {
        $settings = Setting::where('business_id', $business_id)->where('branch_id', $branch_id)->first();
        $igv = $settings->igv;
        $subtotal = $amount / (1 + ($igv / 100));
        $igv_amount = $amount - $subtotal;
        return [
            'subtotal' => $subtotal,
            'igv' => $igv_amount,
            'total' => $amount,
        ];
    }

    public function scopeNextNumberDocument(Builder $query, string $type, string $serie, int $branch_id = null, int $business_id = null)
    {
        $rs = $query->where('number', 'like', '%' . $serie . '-%')
            ->where('branch_id', $branch_id)
            ->where('business_id', $business_id)
            ->where('type', $type)
            ->select(DB::raw("max((CASE WHEN number is NULL THEN 0 ELSE convert(substr(number,6,11),SIGNED integer) END)*1) AS maximum"))->first();

        switch ($type) {
            case 'BOLETA':
                $serie = 'B0' . $serie;
                break;
            case 'FACTURA':
                $serie = 'F0' . $serie;
                break;
            case 'NOTA DE CREDITO FACTURA':
                $serie = 'FC' . $serie;
                break;
            case 'NOTA DE CREDITO BOLETA':
                $serie = 'BC' . $serie;
                break;
            default:
                $serie = 'T0' . $serie;
                break;
        }
        return $serie . '-' . str_pad($rs->maximum + 1, 6, '0', STR_PAD_LEFT);
    }
}