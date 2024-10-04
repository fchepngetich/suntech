<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\SubcategoryModel;

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


// public function store()
// {
//     $validation = $this->validate([
//         'name' => 'required|min_length[3]|max_length[255]',
//         'description' => 'required|min_length[10]',
//         'price' => 'required|decimal',
//         'discounted_price' => 'permit_empty|decimal',
//         'stock' => 'required|integer',
//         'category_id' => 'required|integer',
//         'subcategory_id' => 'required|integer',
//         'image' => 'uploaded[image]|max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
//         'sideview_images.*' => 'uploaded[sideview_images.*]|max_size[sideview_images.*,1024]|is_image[sideview_images.*]|mime_in[sideview_images.*,image/jpg,image/jpeg,image/png]',
//     ]);

//     if (!$validation) {
//         return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
//     }

//     $productModel = new ProductModel();

//     // Handle main product image
//     $imageFile = $this->request->getFile('image');
//     $image = $imageFile->store(); // Store the image

//     // Handle multiple sideview images
//     $sideviewFiles = $this->request->getFiles()['sideview_images'];
//     $sideviewImages = [];
//     foreach ($sideviewFiles as $file) {
//         if ($file->isValid() && !$file->hasMoved()) {
//             $sideviewImages[] = $file->store(); // Store each image and add to array
//         }
//     }

//     // Generate slug
//     $slug = url_title($this->request->getPost('name'), '-', true);

//     // Prepare data for insertion
//     $data = [
//         'name' => $this->request->getPost('name'),
//         'description' => $this->request->getPost('description'),
//         'features' => $this->request->getPost('features'),
//         'price' => $this->request->getPost('price'),
//         'discounted_price' => $this->request->getPost('discounted_price'),
//         'stock' => $this->request->getPost('stock'),
//         'category_id' => $this->request->getPost('category_id'),
//         'subcategory_id' => $this->request->getPost('subcategory_id'),
//         'image' => $image, // Main image
//         'sideview_images' => json_encode($sideviewImages), // Store multiple images as JSON
//         'is_top_deal' => $this->request->getPost('is_top_deal'),
//         'is_recommended' => $this->request->getPost('is_recommended'),
//         'slug' => $slug
//     ];

//     // Save product
//     $productModel->save($data);

//     return redirect()->to(base_url('admin/products'))->with('message', 'Product created successfully.');
// }


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
        'image' => 'uploaded[image]|max_size[image,2048]|ext_in[image,jpg,jpeg,png]',
        'sideview_images' => 'permit_empty',
    ]);

    if (!$validation) {
        log_message('error', 'Validation errors: ' . json_encode($this->validator->getErrors()));
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // Upload the main product image
    $imageFile = $this->request->getFile('image');
    if ($imageFile->isValid() && !$imageFile->hasMoved()) {
        $imageName = $imageFile->getRandomName();
        $imageFile->move(WRITEPATH . 'uploads/products/', $imageName);
    } else {
        log_message('error', 'Image upload failed: ' . json_encode($imageFile->getErrors()));
    }

    // Upload sideview images
    $sideviewImages = [];
    $sideviewFiles = $this->request->getFiles();
    if (!empty($sideviewFiles['sideview_images'])) {
        foreach ($sideviewFiles['sideview_images'] as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $sideImageName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads/products/', $sideImageName);
                $sideviewImages[] = $sideImageName;
            }
        }
    }

    // Prepare data for the product model
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
        'slug' => url_title($this->request->getPost('name'), '-', true), // Auto-generate slug
    ];

    log_message('info', 'Product Data: ' . json_encode($productData));

    $productsModel = new ProductModel();
    $productsModel->save($productData);

    return redirect()->to(base_url('admin/products'))->with('message', 'Product created successfully.');
}


    public function edit($id)
    {
        $productModel = new ProductModel();
        $data['product'] = $productModel->find($id);

        return view('products/edit', $data);
    }

    public function update($id)
    {
        $validation = $this->validate([
            'name' => 'required|min_length[3]|max_length[255]',
            'description' => 'required|min_length[10]',
            'features' => 'permit_empty',
            'price' => 'required|decimal',
            'stock' => 'required|integer',
            'category_id' => 'required|integer',
            'subcategory_id' => 'required|integer',
            'image' => 'permit_empty|uploaded[image]|max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
            'is_top_deal' => 'permit_empty|in_list[0,1]',
            'is_recommended' => 'permit_empty|in_list[0,1]',
            'slug' => 'required|alpha_dash|is_unique[products.slug,id,{id}]'
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $productModel = new ProductModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'features' => $this->request->getPost('features'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'category_id' => $this->request->getPost('category_id'),
            'subcategory_id' => $this->request->getPost('subcategory_id'),
            'image' => $this->request->getFile('image') ? $this->request->getFile('image')->store() : null,
            'is_top_deal' => $this->request->getPost('is_top_deal'),
            'is_recommended' => $this->request->getPost('is_recommended'),
            'slug' => $this->request->getPost('slug')
        ];

        $productModel->update($id, $data);

        return redirect()->to('/products')->with('message', 'Product updated successfully.');
    }

    public function delete($id)
    {
        $productModel = new ProductModel();
        $productModel->delete($id);

        return redirect()->to('/products')->with('message', 'Product deleted successfully.');
    }
}

    