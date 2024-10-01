<?php

namespace App\Models;

use CodeIgniter\Model;

class WishlistModel extends Model
{
    protected $table = 'wishlist'; // Ensure this matches your actual table name
    protected $primaryKey = 'id'; // Assuming 'id' is your primary key
    protected $allowedFields = ['user_id', 'product_id']; // Adjust based on your database schema

    public function getUserWishlist($userId)
    {
        return $this->where('user_id', $userId)->findAll();
    }

    // Check if the product is in the wishlist
    public function isInWishlist($userId, $productId)
    {
        return $this->where('user_id', $userId)->where('product_id', $productId)->countAllResults() > 0;
    }

    // Remove product from wishlist
    public function removeFromWishlist($userId, $productId)
{
    // Check if the record exists before attempting to delete it
    $wishlistItem = $this->where('user_id', $userId)
                         ->where('product_id', $productId)
                         ->first();

    // If the item exists, proceed to delete it
    if ($wishlistItem) {
        return $this->where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->delete();
    }

    // Return false if no item was found to delete
    return false;
}




    
}
