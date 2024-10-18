<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\SubcategoryModel;
use App\Models\SubsubcategoryModel;
use App\Models\BlogModel;

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

        $products = $productsModel->findAll();
        foreach ($products as &$product) {
            $category = $categoryModel->find($product['category_id']);
            $product['category_name'] = $category ? $category['name'] : 'N/A'; // Assign category name or default to N/A
        }

        $data['products'] = $products;

        return view('admin/pages/products/products.php', $data);
    }

    public function recommended()
    {
        $categoryModel = new CategoryModel();
        $subcategoryModel = new SubcategoryModel();
        $blogModel = new BlogModel();
        
        // Fetch the latest blogs
        $blogs = $blogModel->orderBy('created_at', 'DESC')->limit(3)->find(); 
        $subcategories = $subcategoryModel->findAll();
        $currency = getenv('CURRENCY') ?? 'Ksh';
    
        $productModel = new ProductModel();
        $data['recommendedProducts'] = $productModel->getRecommendedProducts();
        $data['currency'] = $currency; 
        $data['subcategories'] = $subcategories;
        $data['blogs'] = $blogs;
    
        // Set up breadcrumbs
        $data['breadcrumbs'] = [
            ['url' => base_url(), 'name' => 'Home'], // Home link
            ['url' => '', 'name' => 'Recommended'], // Current page without a link
        ];
    
        return view('backend/pages/products/recommended', $data);
    }
    

    
    public function TopDeals()
{
    $categoryModel = new CategoryModel();
    $subcategoryModel = new SubcategoryModel();
    $blogModel = new BlogModel();
    
    // Fetch the latest blogs
    $blogs = $blogModel->orderBy('created_at', 'DESC')->limit(3)->find(); 
    $subcategories = $subcategoryModel->findAll();
    $currency = getenv('CURRENCY') ?? 'Ksh';

    $productModel = new ProductModel();
    $data['topDeals'] = $productModel->getTopDeals();
    $data['currency'] = $currency; 
    $data['subcategories'] = $subcategories;
    $data['blogs'] = $blogs;

    // Set up breadcrumbs
    $data['breadcrumbs'] = [
        ['url' => base_url(), 'name' => 'Home'], // Home link
        ['url' => '', 'name' => 'Top Deals'], // Current page without a link
    ];

    return view('backend/pages/products/top-deals', $data);
}

public function getCategoryAndSubcategory($subcategoryId)
{
    $subsubcategoryModel = new SubsubcategoryModel();

    // Fetch category and subcategory based on the subsubcategory ID
    $subsubcategory = $subsubcategoryModel->find($subcategoryId);

    return $this->response->setJSON([
        'category_id' => $subsubcategory['category_id'],
        'subcategory_id' => $subsubcategory['subcategory_id'],
    ]);
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
    
        $category = null;
        $subcategory = null;
        $subsubcategory = null;
        if (!empty($product['subsubcategory_id'])) {
            $subsubcategoryModel = new SubsubcategoryModel();
            $subsubcategory = $subsubcategoryModel->find($product['subsubcategory_id']);

            if ($subsubcategory && !empty($subsubcategory['subcategory_id'])) {
                $subcategoryModel = new SubcategoryModel();
                $subcategory = $subcategoryModel->find($subsubcategory['subcategory_id']);
            }
        }

        if ($subcategory && !empty($subcategory['category_id'])) {
            $categoryModel = new CategoryModel();
            $category = $categoryModel->find($subcategory['category_id']);
        }
    
        $breadcrumbs = [
            ['url' => base_url(), 'name' => 'Home'], 
        ];
    
        if ($category) {
            $breadcrumbs[] = ['url' => base_url('categories/category/' . $category['slug']), 'name' => $category['name']];
        }
        
        if ($subcategory) {
            $breadcrumbs[] = ['url' => base_url('subcategories/subcategory/' . $subcategory['slug']), 'name' => $subcategory['name']];
        }
        
        if ($subsubcategory) {
            $breadcrumbs[] = ['url' => base_url('subsubcategories/details/' . $subsubcategory['slug']), 'name' => $subsubcategory['name']];
        }
    
        $breadcrumbs[] = ['url' => '', 'name' => $product['name']];
    
        $data['breadcrumbs'] = $breadcrumbs;
  
        $cart = \Config\Services::cart();
        $productInCart = false;
        foreach ($cart->contents() as $item) {
            if ($item['id'] == $product['id']) {
                $productInCart = $item;
                break;
            }
        }
    
        $data['product'] = $product;
        $data['productInCart'] = $productInCart;
    
        return view('backend/pages/products/product-detail', $data);
    }
    

    
    

    // public function details($slug)
    // {
    //     $product = $this->productModel->where('slug', $slug)->first();
    //     if (!$product) {
    //         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Product not found');
    //     }

    //     $productModel = new ProductModel();
    //     $product = $productModel->where('slug', $slug)->first();

    //     $subsubcategoryModel = new SubsubcategoryModel();
    //     $subsubcategory = $subsubcategoryModel->find($product['subsubcategory_id']);
        
    //     $subcategoryModel = new SubcategoryModel();
    //     $subcategory = $subcategoryModel->find($subsubcategory['subcategory_id']);
        
    //     $categoryModel = new CategoryModel();
    //     $category = $categoryModel->find($subcategory['category_id']);
    
    //     // Breadcrumb for Home > Category > Subcategory > Subsubcategory > Product
    //     $breadcrumbs = [
    //         ['url' => base_url(), 'name' => 'Home'],
    //         ['url' => base_url('category/' . $category['slug']), 'name' => $category['name']],
    //         ['url' => base_url('subcategory/' . $subcategory['slug']), 'name' => $subcategory['name']],
    //         ['url' => base_url('subsubcategory/' . $subsubcategory['slug']), 'name' => $subsubcategory['name']],
    //         ['url' => base_url('products/details/' . $product['slug']), 'name' => $product['name']],
    //     ];
    
    //     // Pass the breadcrumbs to the view
    //     $data['breadcrumbs'] = $breadcrumbs;

    //     $cart = \Config\Services::cart();
    //     $productInCart = false;
    //     foreach ($cart->contents() as $item) {
    //         if ($item['id'] == $product['id']) {
    //             $productInCart = $item;
    //             break;
    //         }
    //     }

    //     $data['product'] = $product;
    //     $data['productInCart'] = $productInCart; 
    //     return view('backend/pages/products/product-detail', $data);
    // }
    public function create()
    {
        $full_name = 'Faith';
        $data['full_name'] = $full_name;
    
        // Fetch categories with subcategories and subsubcategories
        $categoryModel = new CategoryModel();
        $subcategoryModel = new SubcategoryModel(); // Assume you have this model
        $subsubcategoryModel = new SubsubcategoryModel(); // Assume you have this model
    
        // Fetch all categories
        $categories = $categoryModel->findAll();
        $structuredCategories = [];
    
        foreach ($categories as $category) {
            // Get subcategories for the current category
            $subcategories = $subcategoryModel->where('category_id', $category['id'])->findAll();
            
            $subcategoryList = [];
            foreach ($subcategories as $subcategory) {
                // Get subsubcategories for the current subcategory
                $subsubcategories = $subsubcategoryModel->where('subcategory_id', $subcategory['id'])->findAll();
    
                $subcategoryList[] = [
                    'id' => $subcategory['id'],
                    'name' => $subcategory['name'],
                    'subsubcategories' => $subsubcategories, // Assuming this is an array of subsubcategories
                ];
            }
    
            $structuredCategories[] = [
                'id' => $category['id'],
                'name' => $category['name'],
                'subcategories' => $subcategoryList,
            ];
        }
    
        // Pass structured categories to the view
        return view('admin/pages/products/create', [
            'categories' => $structuredCategories,
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
            'subsubcategory_id' => 'required|integer', 
            'image' => 'uploaded[image]|max_size[image,2048]|is_image[image]|ext_in[image,jpg,jpeg,png]', 
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
            'category_id' => $this->request->getPost('category_id'), // Get category ID from hidden field
            'subcategory_id' => $this->request->getPost('subcategory_id'), // Get subcategory ID from hidden field
            'subsubcategory_id' => $this->request->getPost('subsubcategory_id'), // Get subsubcategory ID from select
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
        $categories = $categoriesModel->getCategoriesWithSubcategories();
        log_message('info', 'Categories Data: ' . json_encode($categories));

        return view('admin/pages/products/edit', [
            'product' => $product,
            'categories' => $categories,
            'full_name' => $full_name
        ]);
    }
    


    public function update($slug)
    {
        // Validate incoming data
        $validation = $this->validate([
            'name' => 'required|min_length[3]|max_length[255]',
            'description' => 'required',
            'price' => 'required|decimal',
            'discounted_price' => 'permit_empty|decimal',
            'stock' => 'required|integer',
            'category_id' => 'required|integer',
            'subcategory_id' => 'required|integer',
            'subsubcategory_id' => 'required|integer', // Ensure this is included for the dropdown
            'image' => 'permit_empty|uploaded[image]|max_size[image,2048]|is_image[image]|ext_in[image,jpg,jpeg,png]',
            'sideview_images' => 'permit_empty',
        ]);
    
        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        // Get the existing product
        $productsModel = new ProductModel();
        $product = $productsModel->where('slug', $slug)->first();
    
        if (!$product) {
            return redirect()->to(base_url('admin/products'))->with('error', 'Product not found.');
        }
    
        $uploadPath = 'backend/images';
        $imageName = $product['image'];
    
        // Handle main image removal
        if ($this->request->getPost('remove_main_image')) {
            if (file_exists($uploadPath . '/' . $product['image'])) {
                unlink($uploadPath . '/' . $product['image']);
            }
            $imageName = null;  // Or set a default image if necessary
        }
    
        // Handle side view images removal
        $sideviewImages = json_decode($product['sideview_images'], true);
        $removeSideviewImages = $this->request->getPost('remove_sideview_images');
        if ($removeSideviewImages) {
            foreach ($removeSideviewImages as $index) {
                if (isset($sideviewImages[$index])) {
                    if (file_exists($uploadPath . '/' . $sideviewImages[$index])) {
                        unlink($uploadPath . '/' . $sideviewImages[$index]);
                    }
                    unset($sideviewImages[$index]);
                }
            }
            $product['sideview_images'] = json_encode(array_values($sideviewImages)); 
        }
    
        // Process main image upload
        $imageFile = $this->request->getFile('image');
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $imageName = $imageFile->getClientName();
            $imageFile->move($uploadPath, $imageName);
        }
    
        // Process sideview images
        if ($this->request->getFiles('sideview_images')) {
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
            'subsubcategory_id' => $this->request->getPost('subsubcategory_id'),
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

