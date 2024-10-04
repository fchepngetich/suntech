<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';

    protected $allowedFields = ['name', 'description','features','discounted-price', 'price', 'stock', 'category_id','subcategory_id', 'image','sideview_images', 'is_top_deal', 'is_recommended','slug'];

 // Validation rules
 protected $validationRules = [
    'name'        => 'required|min_length[3]|max_length[255]',
    'description' => 'required',
    'price'       => 'required|numeric|greater_than[0]',
    'stock'       => 'required|integer|greater_than_equal_to[0]',
    'category_id' => 'required|integer',
    'image'       => 'permit_empty|valid_url',
];

// Generate slug from product name
public function generateSlug($name)
{
    return url_title($name, '-', true);
}

// Before insert or update, generate the slug
protected $beforeInsert = ['createSlug'];
protected $beforeUpdate = ['createSlug'];

protected function createSlug(array $data)
{
    if (isset($data['data']['name'])) {
        $data['data']['slug'] = $this->generateSlug($data['data']['name']);
    }
    return $data;
}

    public function getTopDeals()
    {
        return $this->where('is_top_deal', 1)->limit(6)->findAll();
    }
    
    public function getRecommendedProducts()
    {
        return $this->where('is_recommended', 1)->limit(6)->findAll();
    }
    
   
}
