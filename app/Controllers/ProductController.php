<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\SubcategoryModel;
use App\Models\SubsubcategoryModel;

class ProductController extends BaseController
{
    
        protected $productModel;
    
        public function __construct()
        {
            $this->productModel = new ProductModel();
        }
    
        public function index()
        {
            $full_name = 'Faith';
            $data['full_name'] = $full_name;
        
            $productsModel = new ProductModel();
            $categoryModel = new CategoryModel();
        
            // Fetch all products
            $products = $productsModel->findAll();
        
            // Loop through products to get category names
            foreach ($products as &$product) {
                $category = $categoryModel->find($product['category_id']);
                $product['category_name'] = $category ? $category['name'] : 'N/A'; // Assign category name or default to N/A
            }
        
            $data['products'] = $products;
        
            return view('admin/pages/products/products.php', $data);
        }
        

        public function getSubcategories($categoryId)
{
    $subcategoryModel = new SubcategoryModel();
    $subcategories = $subcategoryModel->where('category_id', $categoryId)->findAll();
    return $this->response->setJSON($subcategories);
}

        

        public function details($slug)
{
    $product = $this->productModel->where('slug', $slug)->first(); 
    if (!$product) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Product not found');
    }

    $data['product'] = $product;

    return view('backend/pages/products/product-detail', $data); 
}
public function create()
{
    $full_name = 'Faith';
    $data['full_name'] = $full_name;

    // Fetch categories for form dropdown
    $categoryModel = new CategoryModel();
    $categories = $categoryModel->findAll();

    // Pass only categories to the view (subcategories will be loaded via AJAX)
    return view('admin/pages/products/create', [
        'categories' => $categories,
        'full_name' => $full_name,
    ]);
}

// Add a method to handle the AJAX request
public function getSubcategoriesByCategory($categoryId)
{
    $subcategoryModel = new SubcategoryModel();
    $subcategories = $subcategoryModel->where('category_id', $categoryId)->findAll();
    return $this->response->setJSON($subcategories);
}
public function getSubsubcategoriesBysubCategory($subcategoryId)
{
    $subsubcategoryModel = new SubsubcategoryModel();
    $subsubcategories = $subsubcategoryModel->where('subcategory_id', $subcategoryId)->findAll();

    return $this->response->setJSON($subsubcategories);
}


public function store()
{
    $validation = $this->validate([
        'name' => 'required|min_length[3]|max_length[255]',
        'description' => 'required',
        'price' => 'required|decimal',
        'discounted_price' => 'permit_empty|decimal',
        'stock' => 'required|integer',
        'category_id' => 'required|integer',
        'subcategory_id' => 'required|integer',
        'image' => 'uploaded[image]|max_size[image,2048]|is_image[image]|ext_in[image,jpg,jpeg,png]', // Modified validation rule
        'sideview_images' => 'permit_empty',
    ]);

    if (!$validation) {
        log_message('error', 'Validation errors: ' . json_encode($this->validator->getErrors()));
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }
 $uploadPath = 'backend/images'; 

 $imageFile = $this->request->getFile('image');
 if ($imageFile->isValid() && !$imageFile->hasMoved()) {
     $imageName = $imageFile->getClientName(); 
     $imageFile->move($uploadPath, $imageName); 
 } else {
     log_message('error', 'Image upload failed: ' . json_encode($imageFile->getErrors()));
 }

 $sideviewImages = [];
 $sideviewFiles = $this->request->getFiles();
 if (!empty($sideviewFiles['sideview_images'])) {
     foreach ($sideviewFiles['sideview_images'] as $file) {
         if ($file->isValid() && !$file->hasMoved()) {
             $sideImageName = $file->getClientName(); 
             $file->move($uploadPath, $sideImageName); 
             $sideviewImages[] = $sideImageName;
         }
     }
 }


    $slug = url_title($this->request->getPost('name'), '-', true);
    $slug = $this->generateUniqueSlug($slug); 

    $productData = [
        'name' => $this->request->getPost('name'),
        'description' => $this->request->getPost('description'),
        'features' => $this->request->getPost('features'),
        'price' => $this->request->getPost('price'),
        'discounted_price' => $this->request->getPost('discounted_price'),
        'stock' => $this->request->getPost('stock'),
        'category_id' => $this->request->getPost('category_id'),
        'subcategory_id' => $this->request->getPost('subcategory_id'),
        'subsubcategory_id' => $this->request->getPost('subsubcategory_id'),
        'image' => $imageName,
        'sideview_images' => json_encode($sideviewImages),
        'is_top_deal' => $this->request->getPost('is_top_deal') == '1',
        'is_recommended' => $this->request->getPost('is_recommended') == '1',
        'slug' => $slug,  
    ];

    log_message('info', 'Product Data: ' . json_encode($productData));

    $productsModel = new ProductModel();
    
    if (!$productsModel->save($productData)) {
        log_message('error', 'Database error: ' . json_encode($productsModel->errors()));
    }

    return redirect()->to(base_url('admin/products'))->with('message', 'Product created successfully.');
}



private function generateUniqueSlug($slug)
{
    $productsModel = new ProductModel();
    $originalSlug = $slug;
    $count = 1;

    // Check if slug exists
    while ($productsModel->where('slug', $slug)->first()) {
        $slug = $originalSlug . '-' . $count;
        $count++;
    }

    return $slug;
}

public function edit($slug)
{
    $full_name = 'Faith';
    $productsModel = new ProductModel();
    $product = $productsModel->where('slug', $slug)->first();

    if (!$product) {
        return redirect()->to(base_url('admin/products'))->with('error', 'Product not found.');
    }

    $categoriesModel = new CategoryModel();
    $categories = $categoriesModel->findAll();

    return view('admin/pages/products/edit', [
        'product' => $product,
        'categories' => $categories,
        'full_name' => $full_name
    ]);
}


    public function update($slug)
    {
        $validation = $this->validate([
            'name' => 'required|min_length[3]|max_length[255]',
            'description' => 'required',
            'price' => 'required|decimal',
            'discounted_price' => 'permit_empty|decimal',
            'stock' => 'required|integer',
            'category_id' => 'required|integer',
            'subcategory_id' => 'required|integer',
            'image' => 'permit_empty|uploaded[image]|max_size[image,2048]|is_image[image]|ext_in[image,jpg,jpeg,png]',
            'sideview_images' => 'permit_empty',
        ]);
    
        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        $productsModel = new ProductModel();
        $product = $productsModel->where('slug', $slug)->first();
    
        if (!$product) {
            return redirect()->to(base_url('admin/products'))->with('error', 'Product not found.');
        }
    
        $uploadPath = 'backend/images'; 
        $imageName = $product['image'];

            // Handle main image removal
    if ($this->request->getPost('remove_main_image')) {
        if (file_exists('backend/images/' . $product['image'])) {
            unlink('backend/images/' . $product['image']);
        }
        $product['image'] = null;  // Or set a default image
    }

    // Handle side view images removal
    $sideviewImages = json_decode($product['sideview_images'], true);
    $removeSideviewImages = $this->request->getPost('remove_sideview_images');
    if ($removeSideviewImages) {
        foreach ($removeSideviewImages as $index) {
            if (isset($sideviewImages[$index])) {
                if (file_exists('backend/images/' . $sideviewImages[$index])) {
                    unlink('backend/images/' . $sideviewImages[$index]);
                }
                unset($sideviewImages[$index]);
            }
        }
        $product['sideview_images'] = json_encode(array_values($sideviewImages)); // Reindex the array and save
    }


    
        // Process image upload if new image is provided
        $imageFile = $this->request->getFile('image');
        if ($imageFile->isValid() && !$imageFile->hasMoved()) {
            $imageName = $imageFile->getClientName(); 
            $imageFile->move($uploadPath, $imageName);
        }
    
        // Process sideview images
        $sideviewImages = json_decode($product['sideview_images'], true) ?? [];
        $sideviewFiles = $this->request->getFiles();
    
        if (!empty($sideviewFiles['sideview_images'])) {
            foreach ($sideviewFiles['sideview_images'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $sideImageName = $file->getClientName(); 
                    $file->move($uploadPath, $sideImageName); 
                    $sideviewImages[] = $sideImageName;
                }
            }
        }
    
        // Update slug if the name changes
        $newSlug = url_title($this->request->getPost('name'), '-', true);
        if ($this->request->getPost('name') !== $product['name']) {
            $newSlug = $this->generateUniqueSlug($newSlug);
        }
    
        // Prepare updated product data
        $productData = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'features' => $this->request->getPost('features'),
            'price' => $this->request->getPost('price'),
            'discounted_price' => $this->request->getPost('discounted_price'),
            'stock' => $this->request->getPost('stock'),
            'category_id' => $this->request->getPost('category_id'),
            'subcategory_id' => $this->request->getPost('subcategory_id'),
            'image' => $imageName,
            'sideview_images' => json_encode($sideviewImages),
            'is_top_deal' => $this->request->getPost('is_top_deal') == '1',
            'is_recommended' => $this->request->getPost('is_recommended') == '1',
            'slug' => $newSlug,
        ];
    
        if (!$productsModel->update($product['id'], $productData)) {
            return redirect()->back()->with('error', 'Failed to update the product.');
        }
    
        return redirect()->to(base_url('admin/products'))->with('message', 'Product updated successfully.');
    }
    

    public function delete($slug)
    {
        $productModel = new ProductModel();
    
        $product = $productModel->where('slug', $slug)->first();
    
        if ($product) {
            $productModel->delete($product['id']);
    
            return redirect()->to('admin/products')->with('message', 'Product deleted successfully.');
        } else {
            return redirect()->back()->with('errors', ['Product not found']);
        }
    }
    
}

    