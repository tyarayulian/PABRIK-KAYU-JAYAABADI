<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    protected $fillable = ['kas_keluar_id', 'wood_type', 'total_cost', 'date', 'notes'];

    public function kasKeluar()
    {
        return $this->belongsTo(KasKeluar::class, 'kas_keluar_id');
    }

    public function items()
    {
        return $this->hasMany(ProductionItem::class);
    }
}
