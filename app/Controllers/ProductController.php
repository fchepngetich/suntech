<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductModel;

class ProductController extends BaseController
{
    
        protected $productModel;
    
        public function __construct()
        {
            $this->productModel = new ProductModel();
        }
    
        public function index()
        {
            $data['products'] = $this->productModel->findAll();
            return view('backend/pages/products/home/home.php', $data);
        }
    
        public function create()
        {
            return view('products/create');
        }
    
        public function store()
        {
            $this->productModel->save([
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'price' => $this->request->getPost('price'),
                'stock' => $this->request->getPost('stock'),
                'category_id' => $this->request->getPost('category_id'),
                'image' => $this->request->getPost('image'),
                'is_top_deal' => $this->request->getPost('is_top_deal'),
                'is_recommended' => $this->request->getPost('is_recommended'),
            ]);
    
            return redirect()->to(route_to('products.index'))->with('success', 'Product added successfully.');
        }
    
        public function edit($id)
        {
            $data['product'] = $this->productModel->find($id);
            return view('products/edit', $data);
        }
    
        public function update($id)
        {
            $this->productModel->update($id, [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'price' => $this->request->getPost('price'),
                'stock' => $this->request->getPost('stock'),
                'category_id' => $this->request->getPost('category_id'),
                'image' => $this->request->getPost('image'),
                'is_top_deal' => $this->request->getPost('is_top_deal'),
                'is_recommended' => $this->request->getPost('is_recommended'),
            ]);
    
            return redirect()->to(route_to('products.index'))->with('success', 'Product updated successfully.');
        }
    
        public function delete($id)
        {
            $this->productModel->delete($id);
            return redirect()->to(route_to('products.index'))->with('success', 'Product deleted successfully.');
        }

       

    }
    