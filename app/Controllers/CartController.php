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

    public function cartInfo() {
        $cart = \Config\Services::cart();
    
        log_message('debug', 'Cart service initiated.');
        
        $totalItems = $cart->totalItems();
        log_message('debug', 'Total items in cart: ' . $totalItems);
    
        $cartContents = $cart->contents();
        log_message('debug', 'Cart contents: ' . json_encode($cartContents));
        
        $totalAmount = $cart->total();
        log_message('debug', 'Cart total amount: ' . $totalAmount);
    
        $response = [
            'totalItems'  => $totalItems,
            'cartItems'   => view('backend/pages/cart/cart_items_partial', ['cartItems' => $cartContents]),
            'totalAmount' => number_format($totalAmount, 2)
        ];
    
        log_message('debug', 'Cart response: ' . json_encode($response));
    
        return $this->response->setJSON($response);
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

    public function update()
{
    $cart = \Config\Services::cart();

    $rowid = $this->request->getPost('rowid');  
    $qty = $this->request->getPost('qty');

    log_message('debug', 'Updating cart. Row ID: ' . $rowid . ', Quantity: ' . $qty);

    // Check if row ID and quantity are valid
    if (!$rowid || !$qty || $qty < 1) {
        log_message('error', 'Invalid row ID or quantity. Row ID: ' . $rowid . ', Quantity: ' . $qty);
        return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request.']);
    }

    // Log cart contents for debugging
    $cartContents = $cart->contents();
    log_message('debug', 'Cart Contents: ' . json_encode($cartContents));

    // Check if the row ID exists in the cart
    $cartItem = $cart->getItem($rowid); 
    if (!$cartItem) {
        log_message('error', 'No cart item found for Row ID: ' . $rowid);
        return $this->response->setJSON(['status' => 'error', 'message' => 'Cart item not found.']);
    }

    // Attempt to update the cart
    $updateStatus = $cart->update(['rowid' => $rowid, 'qty' => $qty]);

    // Log the update status
    log_message('debug', 'Cart update status: ' . json_encode($updateStatus));

    // Check the result of the update
    if ($updateStatus) {
        log_message('debug', 'Cart updated successfully for Row ID: ' . $rowid);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Cart updated successfully.']);
    } else {
        log_message('error', 'Failed to update cart for Row ID: ' . $rowid);
        return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to update cart.']);
    }
}


// public function update()
// {
//     $cart = \Config\Services::cart();

//     $rowid = $this->request->getPost('rowid');  
//     $qty = $this->request->getPost('qty');

//     log_message('debug', 'Updating cart. Row ID: ' . $rowid . ', Quantity: ' . $qty);

//     if (!$rowid || !$qty || $qty < 1) {
//         log_message('error', 'Invalid row ID or quantity. Row ID: ' . $rowid . ', Quantity: ' . $qty);
//         return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request.']);
//     }

//     $updateStatus = $cart->update(['rowid' => $rowid, 'qty' => $qty]);

//     if ($updateStatus) {
//         log_message('debug', 'Cart updated successfully for Row ID: ' . $rowid);
//         return $this->response->setJSON(['status' => 'success', 'message' => 'Cart updated successfully.']);
//     } else {
//         log_message('error', 'Failed to update cart for Row ID: ' . $rowid);
//         return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to update cart.']);
//     }
// }

public function getCartItems()
{
    $cart = \Config\Services::cart();
    
    $cartContents = $cart->contents();

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

    