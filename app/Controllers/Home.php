<?php

namespace App\Controllers;
use App\Models\ProductModel;
use App\Models\SubcategoryModel;
use App\Models\CategoryModel;
use App\Models\SubsubcategoryModel;
use App\Models\BlogModel; // Add this line
class Home extends BaseController
{
    public function index()
    {
        // $categories = $this->getCategories();
        $productModel = new ProductModel();
        $data['topDeals'] = $productModel->getTopDeals();
        $data['recommendedProducts'] = $productModel->getRecommendedProducts();
        // $data['categories'] = $categories;
        $blogModel = new BlogModel();
        
        $data['blogs'] = $blogModel->orderBy('created_at', 'DESC')->findAll(3);
        

        return view('backend/pages/home/home',$data);
    }
    
    
    public function getCategories()
{
    $categoryModel = new CategoryModel();
    $subcategoryModel = new SubcategoryModel();
    $subsubcategoryModel = new SubsubcategoryModel(); // Add this line
    $productModel = new ProductModel();
    
    // Retrieve all categories
    $categories = $categoryModel->findAll();

    foreach ($categories as &$category) {
        // Retrieve subcategories for the current category
        $subcategories = $subcategoryModel->where('category_id', $category['id'])->findAll();

        if ($subcategories) {
            // If there are subcategories, get their products and subsubcategories
            foreach ($subcategories as &$subcategory) {
                // Retrieve products for the current subcategory
                $subcategory['products'] = $productModel->where('subcategory_id', $subcategory['id'])->findAll();
                
                // Retrieve subsubcategories for the current subcategory
                $subsubcategories = $subsubcategoryModel->where('subcategory_id', $subcategory['id'])->findAll();
                $subcategory['subsubcategories'] = $subsubcategories;
                // Assign subsubcategories to the subcategory
            }
            $category['subcategories'] = $subcategories; // Assign subcategories to the category
        } else {
            // If no subcategories, get products directly under the category
            $category['products'] = $productModel->where('category_id', $category['id'])->findAll();
        }
    }

    // Log the entire structure for debugging purposes
    log_message('debug', 'Categories Data: ' . print_r($categories, true)); 

         return view('backend/layout/inc/header', ['categories' => $categories]);

}


//     public function getCategories()
// {
//     $categoryModel = new CategoryModel();
//     $subcategoryModel = new SubcategoryModel();
//     $productModel = new ProductModel();
    
//     $categories = $categoryModel->findAll();

//     foreach ($categories as &$category) {
//         $subcategories = $subcategoryModel->where('category_id', $category['id'])->findAll();

//         if ($subcategories) {
//             // If there are subcategories, get their products
//             foreach ($subcategories as &$subcategory) {
//                 $subcategory['products'] = $productModel->where('subcategory_id', $subcategory['id'])->findAll();
//             }
//             $category['subcategories'] = $subcategories;
//         } else {
//             // If no subcategories, get products directly under the category
//             $category['products'] = $productModel->where('category_id', $category['id'])->findAll();
//         }
//     }

//     return view('backend/layout/inc/header', ['categories' => $categories]);
// }

}
