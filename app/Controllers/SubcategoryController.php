<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SubcategoryModel;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\BlogModel;

class SubcategoryController extends BaseController
{
    //administrator methods starts here



    public function index()
    {
        $full_name = 'Faith';

        $subcategoryModel = new SubcategoryModel();
        $categoryModel = new CategoryModel();

        $subcategories = $subcategoryModel->findAll();

        foreach ($subcategories as &$subcategory) {
            $category = $categoryModel->find($subcategory['category_id']);
            $subcategory['category_name'] = $category ? $category['name'] : 'N/A'; // Assign category name or default to N/A
        }

        return view('admin/pages/subcategories/view', [
            'subcategories' => $subcategories,
            'full_name' => $full_name, // Include full name in the data passed to the view
        ]);
    }



    public function create()
    {
        $full_name = 'Faith';
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll();
        $data['full_name'] = $full_name;

        return view('admin/pages/subcategories/add', $data);
    }

    public function store()
    {
        $validation = $this->validate([
            'name' => 'required|min_length[3]|max_length[255]',
            'category_id' => 'required|integer',
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $subcategoryModel = new SubcategoryModel();

        $slug = url_title($this->request->getPost('name'), '-', true);

        $data = [
            'name' => $this->request->getPost('name'),
            'category_id' => $this->request->getPost('category_id'),
            'slug' => $slug,
        ];

        if ($subcategoryModel->where('slug', $slug)->first()) {
            return redirect()->back()->withInput()->with('errors', ['slug' => 'The slug must be unique.']);
        }

        $subcategoryModel->save($data);

        return redirect()->to(base_url('admin/subcategories'))->with('message', 'Subcategory created successfully.');
    }



    public function edit($slug)
    {
        $full_name = 'Faith';

        $subcategoryModel = new SubcategoryModel();
        $categoryModel = new CategoryModel();

        $subcategory = $subcategoryModel->where('slug', $slug)->first();

        if (!$subcategory) {
            return redirect()->to(base_url('admin/subcategories'))->with('error', 'Subcategory not found.');
        }

        $data['subcategory'] = $subcategory;
        $data['categories'] = $categoryModel->findAll();
        $data['full_name'] = $full_name;

        return view('admin/pages/subcategories/edit', $data);
    }

    public function update($slug)
    {
        $subcategoryModel = new SubcategoryModel();

        $validation = $this->validate([
            'name' => 'required|min_length[3]|max_length[255]',
            'category_id' => 'required|integer',
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $newSlug = url_title($this->request->getPost('name'), '-', true);

        $subcategory = $subcategoryModel->where('slug', $slug)->first();

        if (!$subcategory) {
            return redirect()->to(base_url('admin/subcategories'))->with('error', 'Subcategory not found.');
        }

        if ($newSlug !== $slug && $subcategoryModel->where('slug', $newSlug)->first()) {
            return redirect()->back()->withInput()->with('errors', ['slug' => 'The slug must be unique.']);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'category_id' => $this->request->getPost('category_id'),
            'slug' => $newSlug,
        ];

        $subcategoryModel->update($subcategory['id'], $data);

        return redirect()->to(base_url('admin/subcategories'))->with('message', 'Subcategory updated successfully.');
    }


    public function delete($slug)
    {
        $subcategoryModel = new SubcategoryModel();
        $subcategoryModel->where('slug', $slug)->delete();
        return redirect()->to('admin/subcategories')->with('message', 'Subcategory deleted successfully.');
    }

    //admin methods ends here

    public function subcategoryItems($slug)
    {
        // Initialize models
        $subcategoryModel = new SubcategoryModel();
        $itemModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $blogModel = new BlogModel();
    
        // Fetch the latest blogs
        $blogs = $blogModel->orderBy('created_at', 'DESC')->limit(3)->find();
    
        // Fetch the subcategory based on the slug
        $subcategory = $subcategoryModel->where('slug', $slug)->first();
    
        // Check if the subcategory exists
        if (!$subcategory) {
            log_message('error', 'Subcategory not found: ' . $slug);
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    
        // Fetch the associated category
        $category = $categoryModel->find($subcategory['category_id']);
    
        // Breadcrumbs setup
        $breadcrumbs = [
            ['url' => base_url(), 'name' => 'Home'], // Corrected URL to base URL
            ['url' => base_url('categories/category/' . $category['slug']), 'name' => $category['name']], // Corrected category link
            ['url' => '', 'name' => $subcategory['name']], // Last item as non-clickable
        ];
    
        // Fetch products in the selected subcategory
        $products = $itemModel->where('subcategory_id', $subcategory['id'])->findAll();
    
        // Pass data to the view
        return view('backend/pages/subcategories/subcategory-details', [
            'subcategory' => $subcategory,
            'blogs' => $blogs,
            'breadcrumbs' => $breadcrumbs,
            'subcategories' => $subcategoryModel->findAll(), // If you want to display all subcategories
            'products' => $products
        ]);
    }
    

}
