<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';

    protected $allowedFields = ['name', 'description', 'price', 'stock', 'category_id','subcategory_id', 'image', 'is_top_deal', 'is_recommended','slug'];
    public function getTopDeals()
    {
        return $this->where('is_top_deal', 1)->limit(6)->findAll();
    }
    
    public function getRecommendedProducts()
    {
        return $this->where('is_recommended', 1)->limit(6)->findAll();
    }
    
   
}
