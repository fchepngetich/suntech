<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\SubsubcategoryModel;
use App\Models\SubcategoryModel;
use App\Models\CategoryModel;
use App\Models\ProductModel;

class SubsubcategoryController extends BaseController
{
    protected $subsubcategoryModel;

    public function __construct()
    {
        $this->subsubcategoryModel = new SubsubcategoryModel();
    }

    // List all subsubcategories
    public function index()
{
    $full_name = 'Faith';

    // Models
    $subsubcategoryModel = new SubsubcategoryModel();
    $subcategoryModel = new SubcategoryModel();
    $categoryModel = new CategoryModel();

    // Fetch all subsubcategories
    $subsubcategories = $subsubcategoryModel->findAll();

    // Iterate through each subsubcategory to fetch the related subcategory and category
    foreach ($subsubcategories as &$subsubcategory) {
        // Fetch subcategory
        $subcategory = $subcategoryModel->find($subsubcategory['subcategory_id']);
        if ($subcategory) {
            $subsubcategory['subcategory_name'] = $subcategory['name']; // Assign subcategory name
            // Fetch category
            $category = $categoryModel->find($subcategory['category_id']);
            $subsubcategory['category_name'] = $category ? $category['name'] : 'N/A'; // Assign category name
        } else {
            $subsubcategory['subcategory_name'] = 'N/A';
            $subsubcategory['category_name'] = 'N/A'; // Default values if not found
        }
    }

    // Pass the subsubcategories and full name to the view
    return view('admin/pages/subsubcategories/view', [
        'subsubcategories' => $subsubcategories,
        'full_name' => $full_name,
    ]);
}


 // Display form to create subsubcategory
 public function create()
 {
     $full_name = 'Faith';
     $subcategoryModel = new SubcategoryModel();
     $data['subcategories'] = $subcategoryModel->findAll();
     $data['full_name'] = $full_name;

     return view('admin/pages/subsubcategories/add', $data);
 }

 // Store a new subsubcategory
 public function store()
 {
     $validation = $this->validate([
         'name' => 'required',
         'subcategory_id' => 'required|integer',
     ]);

     if (!$validation) {
         return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
     }

     $slug = url_title($this->request->getPost('name'), '-', true);

     $data = [
         'name' => $this->request->getPost('name'),
         'subcategory_id' => $this->request->getPost('subcategory_id'),
         'slug' => $slug,
     ];

     if ($this->subsubcategoryModel->where('slug', $slug)->first()) {
         return redirect()->back()->withInput()->with('errors', ['slug' => 'The slug must be unique.']);
     }

     $this->subsubcategoryModel->save($data);

     return redirect()->to(base_url('admin/subsubcategories'))->with('message', 'Subsubcategory created successfully.');
 }

 // Display edit form for a subsubcategory
 public function edit($slug)
 {
     $full_name = 'Faith';

     $subcategoryModel = new SubcategoryModel();
     $subsubcategory = $this->subsubcategoryModel->where('slug', $slug)->first();

     if (!$subsubcategory) {
         return redirect()->to(base_url('admin/subsubcategories'))->with('error', 'Subsubcategory not found.');
     }

     $data['subsubcategory'] = $subsubcategory;
     $data['subcategories'] = $subcategoryModel->findAll();
     $data['full_name'] = $full_name;

     return view('admin/pages/subsubcategories/edit', $data);
 }

 // Update a subsubcategory
 public function update($slug)
 {
     $validation = $this->validate([
         'name' => 'required|min_length[3]|max_length[255]',
         'subcategory_id' => 'required|integer',
     ]);

     if (!$validation) {
         return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
     }

     $newSlug = url_title($this->request->getPost('name'), '-', true);

     $subsubcategory = $this->subsubcategoryModel->where('slug', $slug)->first();

     if (!$subsubcategory) {
         return redirect()->to(base_url('admin/subsubcategories'))->with('error', 'Subsubcategory not found.');
     }

     if ($newSlug !== $slug && $this->subsubcategoryModel->where('slug', $newSlug)->first()) {
         return redirect()->back()->withInput()->with('errors', ['slug' => 'The slug must be unique.']);
     }

     $data = [
         'name' => $this->request->getPost('name'),
         'subcategory_id' => $this->request->getPost('subcategory_id'),
         'slug' => $newSlug,
     ];

     $this->subsubcategoryModel->update($subsubcategory['id'], $data);

     return redirect()->to(base_url('admin/subsubcategories'))->with('message', 'Subsubcategory updated successfully.');
 }

 // Delete a subsubcategory
 public function delete($slug)
 {
     $this->subsubcategoryModel->where('slug', $slug)->delete();
     return redirect()->to(base_url('admin/subsubcategories'))->with('message', 'Subsubcategory deleted successfully.');
 }


 public function subsubcategoryItems($slug)
{
    $subsubcategoryModel = new SubsubcategoryModel();
    $itemModel = new ProductModel();
    $categoryModel = new CategoryModel();

    $categories = $categoryModel->findAll();
    $subsubcategory = $subsubcategoryModel->where('slug', $slug)->first();

    if (!$subsubcategory) {
        log_message('error', 'Subsubcategory not found: ' . $slug);
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $products = $itemModel->where('subsubcategory_id', $subsubcategory['id'])->findAll();

    return view('backend/pages/subsubcategories/subsubcategory-details', [
        'subsubcategory' => $subsubcategory,
        'categories' => $categories,
        'products' => $products
    ]);
}





}
