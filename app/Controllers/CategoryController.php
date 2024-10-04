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
    
       //administrator functions starts here

        public function index()
        {
            $full_name='Faith';
    
            $categoryModel = new CategoryModel();
            $categories = $categoryModel->findAll();
            $data['full_name'] = $full_name;
            $data['categories'] = $categories;


            return view('admin/pages/categories/view', $data);
        }
        public function create()
        {
            $full_name='Faith';
            $data['full_name'] = $full_name;

            return view('admin/pages/categories/add',$data);
        }
    
        public function store()
{
    $validation = $this->validate([
        'name' => 'required|min_length[3]|max_length[255]',
        'description' => 'permit_empty|max_length[1000]',
    ]);

    if (!$validation) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $categoryModel = new CategoryModel();

    // Generate slug from the name
    $slug = url_title($this->request->getPost('name'), '-', true);

    $categoryModel->save([
        'name' => $this->request->getPost('name'),
        'description' => $this->request->getPost('description'),
        'slug' => $slug, // Save the generated slug
    ]);

    return redirect()->to('/categories')->with('message', 'Category created successfully.');
}

    
public function edit($slug)
{
    $full_name = 'Faith';
    $data['full_name'] = $full_name;
    
    $categoryModel = new CategoryModel();
    // Find category by slug instead of ID
    $category = $categoryModel->where('slug', $slug)->first();

    if (!$category) {
        return redirect()->to(base_url( 'admin/categories'))->with('error', 'Category not found.');
    }

    // Combine category data with other data
    $data['category'] = $category;

    return view('admin/pages/categories/edit', $data);
}


    
public function update($id)
{
    $validation = $this->validate([
        'name' => 'required|min_length[3]|max_length[255]',
        'description' => 'permit_empty|max_length[1000]',
    ]);

    if (!$validation) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $categoryModel = new CategoryModel();

    // Generate slug from the updated name
    $slug = url_title($this->request->getPost('name'), '-', true);

    $categoryModel->update($id, [
        'name' => $this->request->getPost('name'),
        'description' => $this->request->getPost('description'),
        'slug' => $slug, // Save the generated slug
    ]);

    return redirect()->to(base_url('admin/categories'))->with('message', 'Category updated successfully.');
}

    
        public function delete($id)
        {
            $categoryModel = new CategoryModel();
            $categoryModel->delete($id);
    
            return redirect()->to(base_url('/categories'))->with('message', 'Category deleted successfully.');
        }


        //ends here


        //Front end methods start here
        public function view($slug)
    {
        $categoryModel = new CategoryModel();
        $productModel = new ProductModel();
        
        $category = $categoryModel->where('slug', $slug)->first();
        
        if (!$category) {
            return redirect()->to('/'); 
        }
        $categories = $categoryModel->findAll();
        $products = $productModel->where('category_id', $category['id'])->findAll();
        
        return view('backend/pages/categories/category-details', [
            'category' => $category,
            'categories' => $categories,
            'products' => $products

        ]);
    }
    
    
   
}

    