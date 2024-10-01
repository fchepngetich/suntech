<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SubcategoryController extends BaseController
{
    public function subcategoryItems($slug)
{
    $subcategoryModel = new \App\Models\SubcategoryModel();
    $itemModel = new \App\Models\ProductModel();
    $categoryModel = new \App\Models\CategoryModel();

$categories = $categoryModel->findAll();
    $subcategory = $subcategoryModel->where('slug', $slug)->first();

    if (!$subcategory) {
        log_message('error', 'Subcategory not found: ' . $slug);
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    // Fetch items that belong to this subcategory
    $products = $itemModel->where('subcategory_id', $subcategory['id'])->findAll();

    // Load the view and pass the items and subcategory
    return view('backend/pages/subcategories/subcategory-details', ['subcategory' => $subcategory,'categories'=>$categories, 'products' => $products]);
}

}
