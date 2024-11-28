<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['transaction_id', 'amount', 'phone', 'status', 'created_at']; // Fields that can be inserted

    protected $useTimestamps = true;
}
