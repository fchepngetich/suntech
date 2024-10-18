<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\WishlistModel;
use App\Models\ProductModel;
use App\Libraries\CIAuth;


class WishlistController extends BaseController
   
{
    protected $wishlistModel;
    protected $productModel;

    public function __construct()
    {
        $this->wishlistModel = new WishlistModel();
        $this->productModel = new ProductModel(); // Assuming you have a product model
        helper('session'); // Load the session helper
    }

  
    public function addToWishlist()
    {
        if ($this->request->isAJAX()) {
            $productId = $this->request->getPost('product_id');
            $userId = session()->get('user_id');

            if (!$userId) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Please log in to add items to your wishlist.']);
            }

            $wishlistModel = new WishlistModel();
            
            // Check if the product is already in the wishlist
            $existingItem = $wishlistModel->where(['user_id' => $userId, 'product_id' => $productId])->first();

            if (!$existingItem) {
                // Add to wishlist
                $wishlistModel->save([
                    'user_id' => $userId,
                    'product_id' => $productId,
                ]);

                return $this->response->setJSON(['status' => 'success', 'message' => 'Product added to wishlist.']);
            } else {
                return $this->response->setJSON(['status' => 'info', 'message' => 'Product is already in your wishlist.']);
            }
        }
    }

    
    public function viewWishlist()
    {
        if (session()->has('logged_in') && session()->get('logged_in')) {
            $userId = session()->get('user_id');
        }
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Please log in to view your wishlist.');
        }

        $wishlistModel = new WishlistModel();
        $productModel = new ProductModel();

        $wishlistItems = $wishlistModel->where('user_id', $userId)->findAll();
        $products = [];

        foreach ($wishlistItems as $item) {
            $products[] = $productModel->find($item['product_id']);
        }

        $data['wishlistProducts'] = $products;

        return view('backend/pages/wishlist/wishlist.php', $data);
    }

    // Remove product from wishlist
    public function removeFromWishlist($productId)
    {
        $userId = CIAuth::id();
        $wishlistModel = new WishlistModel(); 
        
        $result = $wishlistModel->removeFromWishlist($userId, $productId); 
    
    if ($result) {
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Item removed from wishlist successfully.'
        ]);
    } else {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Could not remove the item. Please try again.'
        ]);
    }
}

    public function moveToCart($productId)
    {
        $userId = CIAuth::id();

        if ($this->wishlistModel->isInWishlist($userId, $productId)) {

            $product = $this->productModel->find($productId);

            if (!$product) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Product not found.']);
            }

            $cart = \Config\Services::cart();

            $data = [
                'id'      => $product['id'],
                'qty'     => 1,
                'price'   => $product['price'],
                'name'    => $product['name'],
                'options' => ['image' => $product['image']]
            ];

            if (!$cart->insert($data)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Could not add to cart.']);
            }

            $this->wishlistModel->removeFromWishlist($userId, $productId);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Product moved to cart from wishlist.',
                'totalItems' => $cart->totalItems()
            ]);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Product not in wishlist.']);
    }
}

        
    
    