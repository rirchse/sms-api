<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;
    protected $fillable = [
      'school_id',
      'admission_id',
      'payment_type',
      'transaction_id',
      'account_no',
      'paid_amount'
    ];
}
