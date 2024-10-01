<?php

namespace App\Models;

use CodeIgniter\Model;

class WishlistModel extends Model
{
    protected $table = 'wishlist'; // Ensure this matches your actual table name
    protected $primaryKey = 'id'; // Assuming 'id' is your primary key
    protected $allowedFields = ['user_id', 'product_id']; // Adjust based on your database schema

    public function addToWishlist($userId, $productId) {
        return $this->insert(['user_id' => $userId, 'product_id' => $productId]);
    }

    public function isProductInWishlist($userId, $productId) {
        return $this->where(['user_id' => $userId, 'product_id' => $productId])->first() !== null;
    }
}
