<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var mixed
     */
    protected $fillable = [
        'transaction_id',
        'product_id',
        'qty',
        'price',
    ];

    /**
     * transactions
     *
     * @return void
     */
    public function transaction()
    {

        return $this->belongsTo(Transaction::class);
    }

    /**
     * product
     *
     * @return void
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
