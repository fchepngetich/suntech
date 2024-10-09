<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'id';
    protected $allowedFields = [
        'user_id',
        'phone',
        'additional_phone',
        'address1',
        'address2',
        'region_id',
        'city_id',
        'delivery_method',
        'payment_method',
        'created_at', 
        'updated_at'
    ];

}
