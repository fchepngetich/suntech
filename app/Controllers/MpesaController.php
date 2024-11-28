<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use Exception;
use Config\Mpesa;
use App\Models\TransactionModel;
use App\Models\OrderModel;
class MpesaController extends BaseController
{
    protected $mpesa;
    protected $db;

    public function __construct()
    {
        $this->mpesa = new Mpesa();
         $this->db = \Config\Database::connect(); 
    }

    private function generateAccessToken()
    {
        $credentials = base64_encode($this->mpesa->consumerKey . ':' . $this->mpesa->consumerSecret);

        $ch = curl_init('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $credentials]);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response);
        return $data->access_token ?? null;
    }
    public function initiatePayment()
    {
        try {
            // Get form data (phone number and amount)
            $phone = $this->request->getPost('phone');
            $amount = $this->request->getPost('amount');
            $userId = session()->get('user_id');
    
            // Format phone number to international format (e.g., 2547XXXXXXXX)
            $phone = preg_replace('/[^0-9]/', '', $phone);
            if (strlen($phone) == 10 && substr($phone, 0, 1) == '0') {
                $phone = '254' . substr($phone, 1);
            }
    
            if (!preg_match('/^254[7-9][0-9]{8}$/', $phone)) {
                throw new Exception('Invalid phone number format.');
            }
    
            // Prepare M-Pesa request data
            $timestamp = date('YmdHis');
            $password = base64_encode($this->mpesa->businessShortCode . $this->mpesa->passkey . $timestamp);
    
            $accessToken = $this->generateAccessToken();
            if (!$accessToken) {
                throw new Exception('Unable to generate access token.');
            }
    
            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $accessToken
            ];
    
            $callbackUrl = "https://demo.zetech.ac.ke/suntech/payments/callback?user_id=" . urlencode($userId);
    
            // M-Pesa payment request
            $requestData = [
                'BusinessShortCode' => $this->mpesa->businessShortCode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => $amount,
                'PartyA' => $phone,
                'PartyB' => $this->mpesa->businessShortCode,
                'PhoneNumber' => $phone,
                'CallBackURL' => $callbackUrl,
                'AccountReference' => 'Order Payment', // This could be anything meaningful
                'TransactionDesc' => 'Payment for Order',
            ];
    
            // Send request to M-Pesa
            $curl = curl_init($this->mpesa->stkPushUrl);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($requestData));
    
            $response = curl_exec($curl);
            curl_close($curl);
    
            $responseData = json_decode($response);
            if (isset($responseData->ResponseCode) && $responseData->ResponseCode === '0') {
                // Extract CheckoutRequestID from the response
                $checkoutRequestID = $responseData->CheckoutRequestID;
    
                // Save the transaction details in the database (optional)
                $this->db->table('transactions')->insert([
                    'CheckoutRequestID' => $checkoutRequestID,
                    'MerchantRequestID' => $responseData->MerchantRequestID,
                    'Amount' => $amount,
                    'PhoneNumber' => $phone,
                    'status' => 'PENDING',
                    'user_id' => $userId,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
    
                // Redirect to confirm payment page with the Safaricom-generated CheckoutRequestID
                return redirect()->to(base_url("payments/confirm-payment") . '?checkoutRequestID=' . urlencode($checkoutRequestID) . '&user_id=' . urlencode($userId));
            } else {
                // Handle error response from M-Pesa
                return redirect()->to(base_url("payments/error"))->with('error', 'Payment initiation failed: ' . ($responseData->errorMessage ?? 'Unknown error'));
            }
        } catch (Exception $e) {
            // Handle exceptions
            return redirect()->to(base_url("payments/error"))->with('error', $e->getMessage());
        }
    }
    
    

    public function callback()
{
    try {
        $callbackData = $this->request->getJSON();
        log_message('info', 'M-Pesa Callback Data: ' . json_encode($callbackData));

        if (!isset($callbackData->Body->stkCallback)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid M-Pesa callback data.'
            ])->setStatusCode(400);
        }

        $stkCallback = $callbackData->Body->stkCallback;
        $resultCode = $stkCallback->ResultCode;
        $resultDesc = $stkCallback->ResultDesc ?? 'Unknown error';
        $checkoutRequestID = $stkCallback->CheckoutRequestID;
        $merchantRequestID = $stkCallback->MerchantRequestID ?? null;

        // Process successful transactions
        if ($resultCode == 0) {
            $meta = $stkCallback->CallbackMetadata->Item ?? [];
            $transactionId = $this->getMetadataValue($meta, 'MpesaReceiptNumber');
            $amount = $this->getMetadataValue($meta, 'Amount');
            $phone = $this->getMetadataValue($meta, 'PhoneNumber');

            // Prepare data for the transaction
            $transactionData = [
                'MerchantRequestID' => $merchantRequestID,
                'CheckoutRequestID' => $checkoutRequestID,
                'ResultCode'        => $resultCode,
                'ResultDesc'        => $resultDesc,
                'Amount'            => $amount,
                'MpesaReceiptNumber'=> $transactionId,
                'PhoneNumber'       => $phone,
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => null,
            ];

            // Save the transaction to the database
            $this->db->table('transactions')->insert($transactionData);

            // Prepare order data based on transaction data (you might need to customize this)
            $orderData = [
                'transaction_id'    => $transactionId,
                'amount'            => $amount,
                'status'            => 'paid',  // assuming the payment is successful
                'checkout_request_id' => $checkoutRequestID,
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => null,
            ];

            // Save the order to the orders table
            $this->db->table('orders')->insert($orderData);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Transaction successful and order created.',
            ])->setStatusCode(200);
        }

        // Log failed transactions
        log_message('error', "M-Pesa Transaction Failed: ResultCode {$resultCode}, Description: {$resultDesc}");

        // Save failed transaction data
        $failedTransactionData = [
            'MerchantRequestID' => $merchantRequestID,
            'CheckoutRequestID' => $checkoutRequestID,
            'ResultCode'        => $resultCode,
            'ResultDesc'        => $resultDesc,
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => null,
        ];

        $this->db->table('transactions')->insert($failedTransactionData);

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Transaction failed.',
        ])->setStatusCode(400);
    } catch (Exception $e) {
        log_message('error', 'M-Pesa Callback Error: ' . $e->getMessage());

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'An error occurred while processing the callback.',
        ])->setStatusCode(500);
    }
}

    
  private function getOrderId($transactionId) {
    // Simulate fetching or generating an order ID based on the transaction ID
    $order = $this->orderModel->where('transaction_id', $transactionId)->first();
    return $order ? $order['id'] : null;
}

private function getMetadataValue($meta, $key)
{
    foreach ($meta as $item) {
        if ($item->Name === $key) {
            return $item->Value ?? null;
        }
    }
    return null;
}

private function saveOrder($orderData)
{
    $orderModel = new \App\Models\OrderModel();
    $orderModel->insert($orderData);
}

public function confirmPayment()
{
    $checkoutRequestID = $this->request->getGet('checkoutRequestID');
    
    $paymentStatus = $this->checkPaymentStatus($checkoutRequestID);

    if ($paymentStatus['status'] === 'SUCCESS') {
        // Step 1: Update transaction status
        $this->updateTransactionStatus($checkoutRequestID, $paymentStatus);

        // Step 2: Update order status
        $this->updateOrderStatus($checkoutRequestID, 'paid');
        
        // Step 3: Capture cart items before destroying the cart
        $cart = \Config\Services::cart();
        $cartItems = $cart->contents(); // Get cart items
        
        // Step 4: Format the cart items as a comma-separated string
        $orderItems = [];
        foreach ($cartItems as $item) {
            $orderItems[] = $item['id'] . ':' . $item['qty']; // Format as product_id:quantity
        }
        $orderItemsString = implode(',', $orderItems); // Convert array to comma-separated string

        // Step 5: Save cart items to the cart_items table
        $orderModel = new OrderModel();
        $order = $orderModel->where('checkout_request_id', $checkoutRequestID)->first();
        
        if ($order) {
            $cartItemsData = [
                'order_id'    => $order['id'],   // Use the order ID that was created earlier
                'cart_items'  => $orderItemsString,  // Comma-separated string of cart items
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ];
            // Insert cart items into the cart_items table
            $this->db->table('cart_items')->insert($cartItemsData);
        }

        // Step 6: Destroy the cart after saving the items
        $cart->destroy();

        // Step 7: Redirect to the order view page
        return redirect()->to('/orders/view/' . esc($checkoutRequestID));
    }

    // If payment is not successful, show the confirmation page with the payment status
    return view('backend/pages/checkout/confirm', ['paymentStatus' => $paymentStatus]);
}


// public function confirmPayment()
// {
//     $checkoutRequestID = $this->request->getGet('checkoutRequestID');
    
  
//     $paymentStatus = $this->checkPaymentStatus($checkoutRequestID);

//     if ($paymentStatus['status'] === 'SUCCESS') {
//         $this->updateTransactionStatus($checkoutRequestID, $paymentStatus);

//         $this->updateOrderStatus($checkoutRequestID, 'paid');
        
//         return redirect()->to('/orders/view/' . esc($checkoutRequestID));
//     }

//     return view('backend/pages/checkout/confirm', ['paymentStatus' => $paymentStatus]);
// }

public function checkPaymentStatus($checkoutRequestID)
{
    $transaction = $this->db->table('transactions')->where('CheckoutRequestID', $checkoutRequestID)->get()->getRow();

    if (!$transaction) {
        log_message('error', 'Transaction not found for CheckoutRequestID: ' . $checkoutRequestID);
        return [
            'status' => 'FAILED',
            'error' => 'Transaction not found'
        ];
    }

    if ($transaction->ResultCode == 0) {
        return [
            'status' => 'SUCCESS',
            'receipt' => $transaction->MpesaReceiptNumber, 
            'amount' => $transaction->Amount 
        ];
    } else {
        return [
            'status' => 'FAILED',
            'error' => $transaction->ResultDesc 
        ];
    }
}

public function updateTransactionStatus($checkoutRequestID, $paymentStatus)
{
    $this->db->table('transactions')->where('CheckoutRequestID', $checkoutRequestID)->update([
        'status' => 'SUCCESS',
        'receipt_number' => $paymentStatus['receipt'],
        'amount' => $paymentStatus['amount']
    ]);
}

public function updateOrderStatus($checkoutRequestID, $status)
{
    $orderModel = new \App\Models\OrderModel();
    $orderModel->updateOrderStatus($checkoutRequestID, $status);
}









    
    
    
}
