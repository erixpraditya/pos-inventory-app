<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transactiondetail extends Model
{
    protected $guarded = ['id'];


    public function transaction(): BelongsTo
    {
        return $this->belongsto(Transaction::class, 'transaction_invoice_code', 'invoice_code');
    }

    public function product(): BelongsTo
    {
        return $this->belongsto(Product::class, 'product_code', 'code');
    }
}
