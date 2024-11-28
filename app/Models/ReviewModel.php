<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table = 'product_reviews';
    protected $primaryKey = 'id';
    protected $allowedFields = ['product_id', 'name', 'email', 'phone', 'review', 'rating', 'approved'];
    protected $returnType = 'array';
    
    public function getReviews($productId)
    {
        return $this->where('product_id', $productId)->where('approved', 1)->findAll();
    }
    
    public function addReview($data)
    {
        return $this->insert($data);
    }
}
