<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\CIAuth;


class CheckoutController extends BaseController
{
    public function startCheckout()
    {
        $cart = \Config\Services::cart();

        if ($cart->totalItems() == 0) {
            return redirect()->to('/cart')->with('error', 'Your cart is empty.');
        }
        $cartItems = $cart->contents();
        $user = CIAuth::id();
        if (!$user) {
            return redirect()->to('/login')->with('error', 'Please log in to proceed.');
        }
        $data = [
            'cartItems' => $cartItems,
            'total' => $cart->total(),
            'user' => $user
        ];
        return view('backend/pages/checkout/checkout', $data);
    }
}
