<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    protected $table = 'akun_coa';

    protected $fillable = [
        'code',
        'name',
        'type',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function journals()
    {
        return $this->hasMany(GeneralJournal::class, 'account_id');
    }

    public function ledger()
    {
        return $this->hasOne(GeneralLedger::class, 'account_id');
    }
}
