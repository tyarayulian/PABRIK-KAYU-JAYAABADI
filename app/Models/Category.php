<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['code', 'name', 'type', 'transaction_type', 'is_product', 'account_id', 'is_active'];

    protected $table = 'categories';

    public function account()
    {
        return $this->belongsTo(ChartOfAccount::class, 'account_id');
    }
}
