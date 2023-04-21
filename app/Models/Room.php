<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Termwind\Components\Dd;

class Room extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'rooms';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'number',
        'status',
        'branch_id',
        'business_id',
        'floor_id',
        'room_type_id',
    ];

    public function getHasBookingTodayAttribute()
    {
        $today = date('Y-m-d');
        $booking = Booking::where('room_id', $this->id)
            ->where('status', 'P')
            ->where('datefrom', '<=', $today)
            ->where('dateto', '>=', $today)
            ->whereHas('room', function (Builder $query) {
                $query->where('status', 'D');
            })
            ->first();
        return $booking ? true : false;
    }

    public function scopeAvailable(Builder $query, string $datefrom, string $dateto, int $branch_id, int $business_id)
    {
        return $query->whereDoesntHave('bookings', function ($query) use ($datefrom, $dateto, $branch_id, $business_id) {
            $query->where('datefrom', '<=', $datefrom)
                ->where('dateto', '>=', $dateto)
                ->where('branch_id', $branch_id)
                ->where('business_id', $business_id)
                ->whereNotIn('status', ['C', 'P']);
        });
    }

    public function getCheckoutDateAttribute()
    {
        $today = date('Y-m-d');
        $process = Process::where('room_id', $this->id)
            ->where('start_date', '>', $today)
            ->whereHas('room', function (Builder $query) {
                $query->where('status', 'O');
            })
            ->orderBy('id', 'desc')->first();

        if ($process) {
            return 'Checkout en: ' . Carbon::parse(Carbon::now())->diffInDays($process->end_date) . ' día(s)';
        } else {
            return "";
        }
    }

    public function getNextBookingDateAttribute()
    {
        $today = date('Y-m-d');
        $booking = Booking::where('room_id', $this->id)
            ->where('status', 'P')
            ->where('datefrom', '>', $today)
            ->whereHas('room', function (Builder $query) {
                $query->whereIn('status', ['D', 'M']);
            })
            ->orderBy('datefrom', 'asc')->first();
        if ($booking) {
            return Carbon::parse(Carbon::now())->diffInDays($booking->datefrom);
        } else {
            return "";
        }
    }


    public function getStatusAttribute($status)
    {
        $values = config('constants.roomStatus');
        return $values[$status];
    }

    public function getColorAttribute()
    {
        $values = config('constants.roomStatusColor');
        return $values[$this->status];
    }

    public function getIconActionButtonAttribute()
    {
        $values = config('constants.roomStatusIcon');
        return $values[$this->status];
    }

    public function getTextActionButtonAttribute()
    {
        $values = config('constants.roomTextStatus');
        return $values[$this->status];
    }

    public function getLastProcessAttribute()
    {
        return $this->processes()->orderBy('id', 'desc')?->first()->start_date ?? '';
    }

    public function scopesearch(Builder $query, string $param = null, int $branch_id = null, int $business_id = null, array $status = null)
    {
        return $query->when($param, function ($query, $param) {
            return $query->where('name', 'like', "%$param%");
        })->when($branch_id, function ($query, $branch_id) {
            return $query->where('branch_id', $branch_id);
        })->when($business_id, function ($query, $business_id) {
            return $query->where('business_id', $business_id);
        })->when($status, function ($query, $status) {
            return $query->whereIn('status', $status);
        });
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function floor()
    {
        return $this->belongsTo(Floor::class, 'floor_id');
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function processes()
    {
        return $this->hasMany(Process::class, 'room_id');
    }
}