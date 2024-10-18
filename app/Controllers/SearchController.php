<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CategoryModel;
use App\Models\ProductModel;

class SearchController extends BaseController
{
    protected $db;

    public function __construct()
    {
        // Load the database service
        $this->db = \Config\Database::connect();
    }
    public function suggestions()
    {
        // Load the Category model
        $categoryModel = new CategoryModel();
    
        // Fetch all categories from the database
        $categories = $categoryModel->findAll();
    
        // Get the search and category inputs safely
        $search = $this->request->getPost('search');
        $category = $this->request->getPost('category');
    
        // Debug: Check the incoming search parameters
        log_message('info', 'Search Query: ' . $search);
        log_message('info', 'Category: ' . $category);
    
        // Initialize query builder for products
        $builder = $this->db->table('products');
        $builder->select('products.*, categories.name AS category_name');
        $builder->join('categories', 'categories.id = products.category_id');
    
        // Apply search filter
        if (!empty($search)) {
            $builder->like('products.name', $search);
        }
    
        // Apply category filter if selected
        if (!empty($category)) {
            $builder->where('categories.slug', $category);
        }
        $categorySlug = $this->request->getPost('category');

            // Get category name from slug
    $categoryName = '';
    if (!empty($categorySlug)) {
        $categoryDetails = $categoryModel->where('slug', $categorySlug)->first();
        $categoryName = $categoryDetails['name'] ?? '';
    }

    
        // Get search results
        $results = $builder->get()->getResultArray();
    
        // Debug: Log search results
        log_message('info', 'Search Results: ' . json_encode($results));
    
        // Load the view to display the search results, passing categories and results
        return view('backend/pages/search-results', [
            'results' => $results,
            'search' => $search,
            'category' => $category,
            'categoryName' => $categoryName,
            'categories' => $categories // Pass the categories to the view
        ]);
    }
    
}
