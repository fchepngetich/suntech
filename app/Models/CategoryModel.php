<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['name', 'description','slug'];
 
    public function getCategoriesWithSubcategoriesAndProducts()
    {
        $categories = $this->db->table('categories')
                               ->select('id, name,slug')
                               ->get()
                               ->getResultArray();

        foreach ($categories as &$category) {
            $subcategories = $this->db->table('subcategories')
                                      ->select('id, ,slug,name')
                                      ->where('category_id', $category['id'])
                                      ->get()
                                      ->getResultArray();

            if (!empty($subcategories)) {
                foreach ($subcategories as &$subcategory) {
                    $subcategory['products'] = $this->db->table('products')
                                                        ->select('name,slug',)
                                                        ->where('subcategory_id', $subcategory['id'])
                                                        ->get()
                                                        ->getResultArray();
                }
                $category['subcategories'] = $subcategories;
            } else {
                $category['products'] = $this->db->table('products')
                                                 ->select('name,slug',)
                                                 ->where('category_id', $category['id'])
                                                 ->get()
                                                 ->getResultArray();
            }
        }

        return $categories;
    }
}


