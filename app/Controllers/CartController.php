<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CartController extends BaseController
{
    public function __construct()
    {
        session();
    }
   
    public function addToCart($productId)
    {
        try {
            $productModel = new ProductModel();
            $product = $productModel->find($productId);
    
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
    
            $totalItems = $cart->totalItems();
    
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Product added to cart.',
                'totalItems' => $totalItems
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in addToCart: ' . $e->getMessage());
            return $this->response->setJSON(['status' => 'error', 'message' => 'An error occurred.']);
        }
    }
    
    public function viewCart()
    {
        $cart = \Config\Services::cart();
        $cartContents = $cart->contents();

        return view('backend/pages/cart/cart.php', [
            'cart' => $cartContents,
            'total' => $cart->total(),
            'totalItems' => $cart->totalItems()
        ]);
    }

    public function removeFromCart($rowid)
{
    $cart = \Config\Services::cart();
    if ($rowid) {
        $cart->remove($rowid);
    }

    return redirect()->to('/cart')->with('success', 'Item removed from cart');
}

    public function clearCart()
    {
        try {
            $cart = \Config\Services::cart();
            $cart->destroy();
    
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Cart cleared successfully.'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error in clearCart: ' . $e->getMessage());
            return $this->response->setJSON(['status' => 'error', 'message' => 'An error occurred while clearing the cart.']);
        }
    }

//     public function update()
// {
//     $cart = \Config\Services::cart();

//     $rowid = $this->request->getPost('rowid');
//     $qty = $this->request->getPost('qty');

//     if ($cart->update(['rowid' => $rowid, 'qty' => $qty])) {
//         return $this->response->setJSON(['status' => 'success', 'message' => 'Cart updated successfully.']);
//     } else {
//         return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to update cart.']);
//     }
// }

public function update()
{
    $cart = \Config\Services::cart();

    $rowid = $this->request->getPost('rowid');  // Ensure this is the correct row ID from the cart
    $qty = $this->request->getPost('qty');

    // Log to check the rowid and quantity
    log_message('debug', 'Updating cart. Row ID: ' . $rowid . ', Quantity: ' . $qty);

    // Validate the inputs
    if (!$rowid || !$qty || $qty < 1) {
        log_message('error', 'Invalid row ID or quantity. Row ID: ' . $rowid . ', Quantity: ' . $qty);
        return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request.']);
    }

    // Update the cart
    $updateStatus = $cart->update(['rowid' => $rowid, 'qty' => $qty]);

    if ($updateStatus) {
        log_message('debug', 'Cart updated successfully for Row ID: ' . $rowid);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Cart updated successfully.']);
    } else {
        log_message('error', 'Failed to update cart for Row ID: ' . $rowid);
        return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to update cart.']);
    }
}

public function getCartItems()
{
    $cart = \Config\Services::cart();
    
    // Fetch the cart items
    $cartContents = $cart->contents();

    // If cart is empty, return empty cart response
    if (empty($cartContents)) {
        return $this->response->setJSON([
            'status' => 'success',
            'cart' => [],
            'message' => 'Your cart is empty!'
        ]);
    }

    // Return the cart contents
    return $this->response->setJSON([
        'status' => 'success',
        'cart' => $cartContents,
        'totalItems' => $cart->totalItems(),
        'totalAmount' => $cart->total()
    ]);
}



    

}

    