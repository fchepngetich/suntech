<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SubcategoryModel;
use App\Models\CategoryModel;
use App\Models\ProductModel;

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
        $full_name ='Faith';
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
    
        // Generate slug from the name
        $newSlug = url_title($this->request->getPost('name'), '-', true);
        
        // Fetch the existing subcategory
        $subcategory = $subcategoryModel->where('slug', $slug)->first();
    
        if (!$subcategory) {
            return redirect()->to(base_url('admin/subcategories'))->with('error', 'Subcategory not found.');
        }
    
        // Check if the new slug is unique
        if ($newSlug !== $slug && $subcategoryModel->where('slug', $newSlug)->first()) {
            return redirect()->back()->withInput()->with('errors', ['slug' => 'The slug must be unique.']);
        }
    
        $data = [
            'name' => $this->request->getPost('name'),
            'category_id' => $this->request->getPost('category_id'),
            'slug' => $newSlug,
        ];
        
        // Update the subcategory using the ID of the found subcategory
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
    $subcategoryModel = new SubcategoryModel();
    $itemModel = new ProductModel();
    $categoryModel = new CategoryModel();

$categories = $categoryModel->findAll();
    $subcategory = $subcategoryModel->where('slug', $slug)->first();

    if (!$subcategory) {
        log_message('error', 'Subcategory not found: ' . $slug);
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $products = $itemModel->where('subcategory_id', $subcategory['id'])->findAll();

    return view('backend/pages/subcategories/subcategory-details', ['subcategory' => $subcategory,'categories'=>$categories, 'products' => $products]);
}

}
