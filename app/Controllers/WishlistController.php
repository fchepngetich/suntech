<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\WishlistModel;

class WishlistController extends BaseController
{
        protected $wishlistModel;
    
        public function __construct()
        {
            $this->wishlistModel = new WishlistModel();
        }
    
        public function add()
        {
            $productId = $this->request->getPost('product_id');
            $userId = session()->get('user_id'); 
    
            if (!$userId || !$productId) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request.']);
            }
    
            if ($this->wishlistModel->isInWishlist($userId, $productId)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Product is already in your wishlist.']);
            }
    
            $data = [
                'user_id' => $userId,
                'product_id' => $productId,
            ];
    
            if ($this->wishlistModel->save($data)) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Product added to wishlist.']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to add product to wishlist.']);
            }
        }
    
    }
    
    