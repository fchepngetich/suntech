<?php

namespace App\Controllers;
use App\Models\ProductModel;
use App\Models\SubcategoryModel;
use App\Models\CategoryModel;
class Home extends BaseController
{
    public function index()
    {
        $categories = $this->getCategories();
        $productModel = new ProductModel();
        $data['topDeals'] = $productModel->getTopDeals();
        $data['recommendedProducts'] = $productModel->getRecommendedProducts();
        $data['categories'] = $categories;

        return view('backend/pages/home/home',$data);
    }

    public function getCategories()
{
    $categoryModel = new CategoryModel();
    $subcategoryModel = new SubcategoryModel();
    $productModel = new ProductModel();
    
    $categories = $categoryModel->findAll();

    foreach ($categories as &$category) {
        $subcategories = $subcategoryModel->where('category_id', $category['id'])->findAll();

        if ($subcategories) {
            // If there are subcategories, get their products
            foreach ($subcategories as &$subcategory) {
                $subcategory['products'] = $productModel->where('subcategory_id', $subcategory['id'])->findAll();
            }
            $category['subcategories'] = $subcategories;
        } else {
            // If no subcategories, get products directly under the category
            $category['products'] = $productModel->where('category_id', $category['id'])->findAll();
        }
    }

    return view('backend/layout/inc/header', ['categories' => $categories]);
}

}
