<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bookings';
    protected $primaryKey = 'id';

    protected $fillable = [
        'date',
        'datefrom',
        'dateto',
        'number',
        'status',
        'amount',
        'days',
        'notes',
        'client_id',
        'user_id',
        'room_id',
        'branch_id',
        'business_id',
    ];

    public function getStatusAttribute($status)
    {
        $values = config('constants.bookingStatus');
        return $values[$status];
    }

    public function client()
    {
        return $this->belongsTo(People::class, 'client_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function scopeNextNumber(Builder $query, $year = null, int $branch_id = null, int $business_id = null)
    {
        $year = $year ?? date('Y');
        $query->where('number', 'like', '%' . $year . '-%')
            ->where('branch_id', $branch_id)
            ->where('business_id', $business_id)
            ->select(DB::raw("max((CASE WHEN number is NULL THEN 0 ELSE convert(substr(number,6,11),SIGNED integer) END)*1) AS maximum"))->first();
        return str_pad($query->maximum + 1, 11, '0', STR_PAD_LEFT);
    }

    public function scopeSearch(Builder $query, string $param = null, string $date_from = null, string $date_to = null, string $client = null, int $branch_id = null, int $business_id = null, array $status = null)
    {
        return $query->when($param, function ($query, $param) {
            return $query->where('number', 'like', '%' . $param . '%');
        })->when($date_from, function ($query, $date_from) {
            return $query->where('datefrom', '>=', $date_from);
        })->when($date_to, function ($query, $date_to) {
            return $query->where('dateto', '<=', $date_to);
        })->when($client, function ($query, $client) {
            return $query->whereHas('client', function ($query) use ($client) {
                return $query->where('name', 'like', '%' . $client . '%')->orWhere('dni', 'like', '%' . $client . '%');
            });
        })->when($branch_id, function ($query, $branch_id) {
            return $query->where('branch_id', $branch_id);
        })->when($business_id, function ($query, $business_id) {
            return $query->where('business_id', $business_id);
        })->when($status, function ($query, $status) {
            return $query->whereIn('status', $status);
        });
    }
}