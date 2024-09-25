<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CartController extends BaseController
{
    public function __construct()
    {
        // Load session service
        session();
    }

    // Add product to the cart
   
    public function addToCart($productId)
    {
        try {
            $productModel = new ProductModel();
            $product = $productModel->find($productId);
    
            if (!$product) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Product not found.']);
            }
    
            // Call the cart service
            $cart = \Config\Services::cart();
    
            // Prepare data to be inserted into the cart
            $data = [
                'id'      => $product['id'],
                'qty'     => 1,
                'price'   => $product['price'],
                'name'    => $product['name'],
                'options' => ['image' => $product['image']]
            ];
    
            // Insert into cart
            if (!$cart->insert($data)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Could not add to cart.']);
            }
    
            // Get total items in the cart
            $totalItems = $cart->totalItems();
    
            // Return JSON response with updated cart count
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Product added to cart.',
                'totalItems' => $totalItems
            ]);
        } catch (\Exception $e) {
            // Log the error message
            log_message('error', 'Error in addToCart: ' . $e->getMessage());
            return $this->response->setJSON(['status' => 'error', 'message' => 'An error occurred.']);
        }
    }
    
    // View Cart
    public function viewCart()
    {
        // Call the cart service
        $cart = \Config\Services::cart();
        $cartContents = $cart->contents();

        return view('backend/pages/cart/cart.php', [
            'cart' => $cartContents,
            'total' => $cart->total(),
            'totalItems' => $cart->totalItems()
        ]);
    }

    // Remove from cart
    public function removeFromCart($rowId)
    {
        // Call the cart service
        $cart = \Config\Services::cart();

        // Remove the item using its `rowid`
        $cart->remove($rowId);

        // Recalculate totals after removing the item
        $this->getCartSummary();

        return $this->response->setJSON(['status' => 'success', 'message' => 'Item removed from cart.']);
    }

    public function getCartSummary()
    {
        $cart = \Config\Services::cart();
        $totalItems = $cart->totalItems();
        $totalCost = $cart->total();

        // Store these in the session to use in the cart preview
        session()->set('cart_total', $totalCost);
        session()->set('cart_total_items', $totalItems);
    }
}

    