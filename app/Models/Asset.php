<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'location_id',
        'name',
        'asset_code',
        'serial_number',
        'status',
        'purchase_date',
        'purchase_cost',
        'notes',
    ];

    // Relasi ke Model Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke Model Location
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    // Relasi ke Maintenance Logs
    public function maintenanceLogs()
    {
        return $this->hasMany(MaintenanceLog::class);
    }
}