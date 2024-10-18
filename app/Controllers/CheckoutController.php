<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\CIAuth;
use App\Models\UserModel;
use App\Models\OrderModel;


class CheckoutController extends BaseController
{

    public function startCheckout()
    {
        $cart = \Config\Services::cart();
    
        if ($cart->totalItems() == 0) {
            return redirect()->to('/cart')->with('error', 'Your cart is empty.');
        }
    
        $cartItems = $cart->contents();
    
        if (!session()->has('logged_in') || !session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please log in to proceed.');
        }
    
        $userId = session()->get('user_id');
    
        $userModel = new UserModel();
        $user = $userModel->find($userId);
    

        if (!$user) {
            return redirect()->to('/login')->with('error', 'User not found. Please log in.');
        }
    
        $orderModel = new OrderModel();
        $existingOrder = $orderModel->where('user_id', $userId)->first();
   
        $data = [
            'cartItems' => $cartItems,
            'total' => $cart->total(),
            'user' => $user,
            'orderData' => $existingOrder,
            'userData' => $user, 
            'counties' => $this->getCounties(), 
        ];
    
        return view('backend/pages/checkout/checkout', $data);
    }
    
  
    private function getCounties()
    {
        return [
            'BARINGO' => 'Baringo County',
            'BOMET' => 'Bomet County',
            'BUNGOMA' => 'Bungoma County',
            'BUSIA' => 'Busia County',
            'ELGEYO-MARAKWET' => 'Elgeyo-Marakwet County',
            // ... (other counties)
            'WEST POKOT' => 'West Pokot County',
        ];
    }
    
    public function submitCheckoutForm()
    {
        if (session()->has('logged_in') && session()->get('logged_in')) {
            $userId = session()->get('user_id');
        } else {
            return redirect()->to('/login')->with('error', 'You must be logged in to place an order.');
        }

        $orderModel = new OrderModel();

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'phone' => $this->request->getPost('phone'),
            'additional_phone' => $this->request->getPost('additional_phone'),
            'address1' => $this->request->getPost('address'),
            'address2' => $this->request->getPost('address2'),
            'region' => $this->request->getPost('region'),
            'delivery_method' => $this->request->getPost('delivery_method'),
            'payment_method' => $this->request->getPost('payment_method'),
            'user_id' => $userId,
        ];

        $existingOrder = $orderModel->where('user_id', $userId)->first();

        if ($existingOrder) {
            return $this->updateCheckoutForm($existingOrder['id'], $data);
        } else {
            if ($orderId = $orderModel->insert($data)) {
                session()->set('order_id', $orderId);
                session()->setFlashdata('success', 'Details saved successfully!,please proceed to payment processing');
                return redirect()->to(base_url('/checkout'));
            } else {
                session()->setFlashdata('error', 'There was an issue placing your order. Please try again.');
                return redirect()->back()->withInput();
            }
        }
    }

    public function updateCheckoutForm($orderId, $data)
    {
        if (session()->has('logged_in') && session()->get('logged_in')) {
            $userId = session()->get('user_id');
        } else {
            return redirect()->to('/login')->with('error', 'You must be logged in to update your order.');
        }

        $orderModel = new OrderModel();

        if ($orderModel->update($orderId, $data)) {
            session()->setFlashdata('success', 'Details updated successfully!,please proceed to payment processing!');
        } else {
            session()->setFlashdata('error', 'Failed to update the order. Please try again.');
            return redirect()->back()->withInput();
        }

        return redirect()->to(base_url('/checkout'));
    }


    public function saveDeliveryMethod()
    {
        $orderId = session()->get('order_id');
        $deliveryMethod = $this->request->getPost('deliveryMethod');

        $orderModel = new OrderModel();
        $orderModel->update($orderId, ['delivery_method' => $deliveryMethod]);

        return $this->response->setJSON(['status' => 'success']);
    }


    public function savePaymentMethod()
    {
        $orderId = session()->get('order_id');
        $paymentMethod = $this->request->getPost('paymentMethod');

        $orderModel = new OrderModel();
        $orderModel->update($orderId, ['payment_method' => $paymentMethod]);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function confirmOrder()
    {
        $orderId = session()->get('order_id');

        $orderModel = new OrderModel();
        $orderModel->update($orderId, ['status' => 'confirmed']);

        return $this->response->setJSON(['status' => 'success']);
    }

}

