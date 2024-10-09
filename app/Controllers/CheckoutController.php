<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\CIAuth;
use App\Models\UserModel;


class CheckoutController extends BaseController
{
    // public function startCheckout()
    // {
    //     $cart = \Config\Services::cart();

    //     if ($cart->totalItems() == 0) {
    //         return redirect()->to('/cart')->with('error', 'Your cart is empty.');
    //     }
    //     $cartItems = $cart->contents();
    //     $user = CIAuth::id();
    //     if (!$user) {
    //         return redirect()->to('/login')->with('error', 'Please log in to proceed.');
    //     }
    //     $data = [
    //         'cartItems' => $cartItems,
    //         'total' => $cart->total(),
    //         'user' => $user
    //     ];
    //     return view('backend/pages/checkout/checkout', $data);
    // }
    public function startCheckout()
{
    $cart = \Config\Services::cart();

    if ($cart->totalItems() == 0) {
        return redirect()->to('/cart')->with('error', 'Your cart is empty.');
    }

    $cartItems = $cart->contents();

    $userId = CIAuth::id();  
    if (!$userId) {
        return redirect()->to('/login')->with('error', 'Please log in to proceed.');
    }

    $userModel = new UserModel();
    $user = $userModel->find($userId);  

    if (!$user) {
        return redirect()->to('/login')->with('error', 'User not found. Please log in.');
    }

    $data = [
        'cartItems' => $cartItems,       
        'total' => $cart->total(),       
        'user' => $user                  
    ];

    return view('backend/pages/checkout/checkout', $data);
}


// public function submitCheckoutForm()
// {
//     $userModel = new UserModel();

//     $validation = \Config\Services::validation();
//     $validation->setRules([
//         'username' => 'required|min_length[3]|max_length[50]',
//         'email' => 'required|valid_email',
//         'phone' => 'required|min_length[10]|max_length[15]',
//         'address1' => 'required',
//         'regionId' => 'required',
//         'cityId' => 'required'
//     ]);

//     if (!$this->validate($validation->getRules())) {
//         return redirect()->to('/checkout')->withInput()->with('errors', $validation->getErrors());
//     }

//     $data = [
//         'username' => $this->request->getPost('username'),
//         'email' => $this->request->getPost('email'),
//         'phone' => $this->request->getPost('phone'),
//         'additionalPhone' => $this->request->getPost('additionalPhone'),
//         'address1' => $this->request->getPost('address1'),
//         'address2' => $this->request->getPost('address2'),
//         'regionId' => $this->request->getPost('regionId'),
//         'cityId' => $this->request->getPost('cityId'),
//     ];

//     $userId = CIAuth::id(); 

//     $userModel->update($userId, $data);

//     return redirect()->to('/checkout')->with('success', 'Checkout information saved successfully.');
// }



public function submitCheckoutForm()
{
    // Validate and get the form data
    $data = [
        'first_name' => $this->request->getPost('firstName'),
        'phone' => $this->request->getPost('phone'),
        'additional_phone' => $this->request->getPost('additionalPhone'),
        'address1' => $this->request->getPost('address1'),
        'address2' => $this->request->getPost('address2'),
        'region_id' => $this->request->getPost('regionId'),
        'city_id' => $this->request->getPost('cityId'),
    ];

    // Save to database (create order if first time)
    $orderModel = new \App\Models\OrderModel();
    $orderId = session()->get('order_id') ?? $orderModel->insert($data);
    session()->set('order_id', $orderId);

    return $this->response->setJSON(['status' => 'success']);
}


public function saveDeliveryMethod()
{
    $orderId = session()->get('order_id');
    $deliveryMethod = $this->request->getPost('deliveryMethod');

    // Update the delivery method in the order
    $orderModel = new \App\Models\OrderModel();
    $orderModel->update($orderId, ['delivery_method' => $deliveryMethod]);

    return $this->response->setJSON(['status' => 'success']);
}


public function savePaymentMethod()
{
    $orderId = session()->get('order_id');
    $paymentMethod = $this->request->getPost('paymentMethod');

    // Update the payment method in the order
    $orderModel = new \App\Models\OrderModel();
    $orderModel->update($orderId, ['payment_method' => $paymentMethod]);

    return $this->response->setJSON(['status' => 'success']);
}

public function confirmOrder()
{
    $orderId = session()->get('order_id');

    // Update the order status to confirmed
    $orderModel = new \App\Models\OrderModel();
    $orderModel->update($orderId, ['status' => 'confirmed']);

    return $this->response->setJSON(['status' => 'success']);
}



    // public function confirmOrder()
    // {
    //     // Retrieve all session data for the order
    //     $checkoutData = session()->get('checkout');
        
    //     // Insert the data into the orders table
    //     $orderModel = new OrderModel();
    //     $orderId = $orderModel->insert([
    //         'user_id' => session()->get('user_id'),
    //         'first_name' => $checkoutData['firstName'],
    //         'phone' => $checkoutData['phone'],
    //         'additional_phone' => $checkoutData['additionalPhone'],
    //         'address_1' => $checkoutData['address1'],
    //         'address_2' => $checkoutData['address2'],
    //         'region_id' => $checkoutData['regionId'],
    //         'city_id' => $checkoutData['cityId'],
    //         'delivery_method' => $checkoutData['deliveryMethod'],
    //         'payment_method' => $checkoutData['paymentMethod'],
    //         'status' => 'pending',
    //     ]);

    //     // Clear session data for checkout
    //     session()->remove('checkout');

    //     // Redirect to a success page
    //     return redirect()->to('/checkout/success');
    // }
}

