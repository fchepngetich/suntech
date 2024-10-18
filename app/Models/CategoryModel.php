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
                           ->select('id, name, slug')
                           ->get()
                           ->getResultArray();

    foreach ($categories as &$category) {
        $subcategories = $this->db->table('subcategories')
                                  ->select('id, slug, name')
                                  ->where('category_id', $category['id'])
                                  ->get()
                                  ->getResultArray();

        if (!empty($subcategories)) {
            foreach ($subcategories as &$subcategory) {
                $subsubcategoryModel = $this->db->table('subsubcategories')
                                                ->select('name, slug')
                                                ->where('subcategory_id', $subcategory['id'])
                                                ->get()
                                                ->getResultArray();
                $subcategory['subsubcategories'] = $subsubcategoryModel;
            }
            $category['subcategories'] = $subcategories;
        } else {
            $category['products'] = $this->db->table('products')
                                             ->select('name, slug')
                                             ->where('category_id', $category['id'])
                                             ->get()
                                             ->getResultArray();
        }
    }

    return $categories;
}

// public function getCategoriesWithSubcategories()
// {
//     return $this->db->table('categories')
//         ->select('categories.*, subcategories.id as subcategory_id, subcategories.name as subcategory_name, subsubcategories.id as subsubcategory_id, subsubcategories.name as subsubcategory_name')
//         ->join('subcategories', 'subcategories.category_id = categories.id', 'left')
//         ->join('subsubcategories', 'subsubcategories.subcategory_id = subcategories.id', 'left')
//         ->get()
//         ->getResultArray();
// }

public function getCategoriesWithSubcategories()
{
    // Fetch the results from the database
    $results = $this->db->table('categories')
        ->select('categories.id as category_id, categories.name as category_name, 
                  subcategories.id as subcategory_id, subcategories.name as subcategory_name, 
                  subsubcategories.id as subsubcategory_id, subsubcategories.name as subsubcategory_name')
        ->join('subcategories', 'subcategories.category_id = categories.id', 'left')
        ->join('subsubcategories', 'subsubcategories.subcategory_id = subcategories.id', 'left')
        ->get()
        ->getResultArray();

    // Initialize an empty array to hold the nested structure
    $categories = [];

    // Loop through the results and organize them into a nested structure
    foreach ($results as $row) {
        // Check if the category already exists in the array
        if (!isset($categories[$row['category_id']])) {
            $categories[$row['category_id']] = [
                'id' => $row['category_id'],
                'name' => $row['category_name'],
                'subcategories' => []
            ];
        }

        // Check if the subcategory exists
        if (!empty($row['subcategory_id'])) {
            if (!isset($categories[$row['category_id']]['subcategories'][$row['subcategory_id']])) {
                $categories[$row['category_id']]['subcategories'][$row['subcategory_id']] = [
                    'id' => $row['subcategory_id'],
                    'name' => $row['subcategory_name'],
                    'subsubcategories' => []
                ];
            }

            // Check if subsubcategory exists and add it
            if (!empty($row['subsubcategory_id'])) {
                $categories[$row['category_id']]['subcategories'][$row['subcategory_id']]['subsubcategories'][$row['subsubcategory_id']] = [
                    'id' => $row['subsubcategory_id'],
                    'name' => $row['subsubcategory_name']
                ];
            }
        }
    }

    return array_values($categories); // return a numerically indexed array
}



}


