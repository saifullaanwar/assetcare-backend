<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'title',
        'maintenance_date',
        'next_service_date',
        'cost',
        'status',
        'performed_by',
        'notes',
    ];

    // Relasi ke Model Asset
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}