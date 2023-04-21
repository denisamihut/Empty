<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use SoftDeletes;

    protected $table = 'settings';
    protected $primaryKey = 'id';

    protected $fillable = [
        'razon_social',
        'ruc',
        'nombre_comercial',
        'direccion',
        'telefono',
        'email',
        'logo',
        'business_id',
        'branch_id',
        'serie'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}