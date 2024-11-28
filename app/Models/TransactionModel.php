<?php


namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['MerchantRequestID', 'CheckoutRequestID', 'ResultCode', 'ResultDesc', 'Amount', 'MpesaReceiptNumber', 'PhoneNumber', 'created_at', 'order_id']; // Ensure 'phone' is included

    protected $useTimestamps    = true;
}
