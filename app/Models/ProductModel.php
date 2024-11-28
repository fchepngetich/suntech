<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';

    protected $allowedFields = ['name', 'description','specifications','discounted_price', 
    'price', 'stock', 'category_id','subcategory_id', 'subsubcategory_id', 'image',
    'sideview_images', 'is_top_deal', 'is_recommended','slug'];

 // Validation rules
 protected $validationRules = [
    'name' => [
        'label' => 'Product Name',
        'rules' => 'required', 
        'errors' => [
            'regex_match' => 'The {field} can only contain alpha-numeric characters, dashes, underscores, colons, spaces, and parentheses.'
        ]
    ],
    'description' => [
        'label' => 'Description',
        'rules' => 'required',
        'errors' => [
            'required' => 'The {field} is required.'
        ]
    ],
    'price' => [
        'label' => 'Price',
        'rules' => 'required|numeric|greater_than[0]',
        'errors' => [
            'required' => 'The {field} is required.',
            'numeric' => 'The {field} must be a number.',
            'greater_than' => 'The {field} must be greater than 0.'
        ]
    ],
    'stock' => [
        'label' => 'Stock',
        'rules' => 'required|integer|greater_than_equal_to[0]',
        'errors' => [
            'required' => 'The {field} is required.',
            'integer' => 'The {field} must be an integer.',
            'greater_than_equal_to' => 'The {field} must be greater than or equal to 0.'
        ]
    ],
    'category_id' => [
        'label' => 'Category ID',
        'rules' => 'required|integer',
        'errors' => [
            'required' => 'The {field} is required.',
            'integer' => 'The {field} must be an integer.'
        ]
    ]
];


public function generateSlug($name)
{
  $slug = url_title($name, '-', true);
  $count = 1;
  while ($this->where('slug', $slug)->first()) {
      $slug = url_title($name, '-', true) . '-' . $count;
      $count++;
  }

  return $slug;
}

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
    return $this->where('is_top_deal', 1)
                ->orderBy('created_at', 'DESC') // Order by latest first
                ->limit(6)
                ->findAll();
}

public function getRecommendedProducts()
{
    return $this->where('is_recommended', 1)
                ->orderBy('created_at', 'DESC') // Order by latest first
                ->limit(6)
                ->findAll();
}


    
   
}
