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
        'opening_balance',
        'opening_balance_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'opening_balance' => 'decimal:2',
        'opening_balance_date' => 'date',
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
