<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CategoryModel;
use App\Models\ProductModel;

class CategoryController extends BaseController
{

        protected $categoryModel;
    
        public function __construct()
        {
            $this->categoryModel = new CategoryModel();
        }
    
        public function index()
        {
            $data['categories'] = $this->categoryModel->findAll();
            return view('categories/index', $data);
        }

        public function view($slug)
    {
        $categoryModel = new CategoryModel();
        $productModel = new ProductModel();
        
        // Find the category by slug
        $category = $categoryModel->where('slug', $slug)->first();
        
        if (!$category) {
            return redirect()->to('/'); // Redirect to homepage if category is not found
        }
        $categories = $categoryModel->findAll();
        // Fetch products that belong to the category
        $products = $productModel->where('category_id', $category['id'])->findAll();
        
        // Pass category and products to the view
        return view('backend/pages/categories/category-details', [
            'category' => $category,
            'categories' => $categories,
            'products' => $products

        ]);
    }
    
        public function create()
        {
            return view('categories/create');
        }
    
        public function store()
        {
            $this->categoryModel->save([
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
            ]);
    
            return redirect()->to(route_to('categories.index'))->with('success', 'Category added successfully.');
        }
    
        public function edit($id)
        {
            $data['category'] = $this->categoryModel->find($id);
            return view('categories/edit', $data);
        }
    
        public function update($id)
        {
            $this->categoryModel->update($id, [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
            ]);
    
            return redirect()->to(route_to('categories.index'))->with('success', 'Category updated successfully.');
        }
    
        public function delete($id)
        {
            $this->categoryModel->delete($id);
            return redirect()->to(route_to('categories.index'))->with('success', 'Category deleted successfully.');
        }
    }
    