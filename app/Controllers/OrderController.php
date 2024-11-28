<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\OrderModel;
class OrderController extends BaseController
{
    public function trackOrderForm()
    {
        // Load the view to enter the order number
        return view('backend/pages/order/track_order_form');
    }

    public function trackOrder()
    {
        $orderNumber = $this->request->getPost('order_number');

        // Validate order number input
        if (empty($orderNumber)) {
            return redirect()->back()->with('error', 'Please enter a valid order number.');
        }

        // Fetch the order details from the database
        $orderModel = new OrderModel();
        $order = $orderModel->where('order_number', $orderNumber)->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        // Pass order data to the view
        return view('backend/pages/order/order_status', ['order' => $order]);
    }
}
