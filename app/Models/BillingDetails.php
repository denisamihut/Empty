<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillingDetails extends Model
{
    use SoftDeletes;

    protected $table = 'billingdetails';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'billing_id',
        'process_id',
        'product_id',
        'service_id',
        'amount',
        'purchase_price',
        'sale_price',
        'notes',
        'branch_id',
        'business_id',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function billing()
    {
        return $this->belongsTo(Billing::class, 'billing_id');
    }

    public function process()
    {
        return $this->belongsTo(Process::class, 'process_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }
}