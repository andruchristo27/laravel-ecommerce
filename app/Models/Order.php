<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'total_price', 
        'status',
        'transaction_id',
        'payment_type',
        'payment_code',
        'va_number',
        'bank',
        'acquirer',
        'issuer',
        'reference_no',
        'qris_data'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
