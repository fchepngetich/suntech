<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Mpesa;
use Exception;
use App\Models\OrderModel;
use CodeIgniter\Database\Config;

class PaymentController extends BaseController
{
    private $consumerKey;
    private $consumerSecret;
    private $shortCode;
    private $passkey;
    private $callbackUrl;

    public function __construct()
    {
        // parent::__construct();

        // Initialize dynamic values in the constructor
        $this->consumerKey = getenv('MPESA_CONSUMER_KEY');
        $this->consumerSecret = getenv('MPESA_CONSUMER_SECRET');
        $this->shortCode = getenv('MPESA_BUSINESS_SHORT_CODE');
        $this->passkey = getenv('MPESA_PASSKEY');
        $this->callbackUrl = getenv('MPESA_CALLBACK_URL');
    }
    private function formatPhoneNumber($phone)
{
    $phone = preg_replace('/\D/', '', $phone);

    if (substr($phone, 0, 1) === '0') {
        $phone = '254' . substr($phone, 1);
    }

    if (substr($phone, 0, 3) !== '254') {
        throw new Exception('Invalid phone number format.');
    }

    return $phone;
}


// public function processPayment()
// {
//     $amount = $this->request->getPost('amount');
//     $phone = $this->request->getPost('phone');

//     try {
//         log_message('debug', "Starting payment process for phone: {$phone}, amount: {$amount}");

//         // Format phone number
//         $formattedPhone = $this->formatPhoneNumber($phone);
//         log_message('debug', "Formatted phone number: {$formattedPhone}");

//         $accessToken = $this->getAccessToken();
//         log_message('debug', "Access token retrieved: {$accessToken}");

//         $maxRetries = 3;
//         $retryCount = 0;
//         $response = null;

//         // Retry logic for handling the "transaction already in process" error
//         while ($retryCount < $maxRetries) {
//             $response = $this->initiateSTKPush($accessToken, $amount, $formattedPhone);
            
//             // Check if the error is the "transaction already in progress" error
//             if (isset($response['errorCode']) && $response['errorCode'] === '500.001.1001') {
//                 $retryCount++;
//                 log_message('warning', "Retrying payment for phone {$formattedPhone}, attempt {$retryCount}.");
//                 sleep(10); // Wait for 10 seconds before retrying
//             } else {
//                 break; // Stop retrying if the transaction succeeds or encounters another error
//             }
//         }

//         // If the retry count exceeds the max retries, throw an exception
//         if ($retryCount >= $maxRetries) {
//             throw new Exception("Payment failed after {$maxRetries} attempts. Please try again later.");
//         }

//         // If response code is '0', it means the payment was successful
//         if ($response['ResponseCode'] == '0') {
//             $orderData = [
//                 'transaction_id' => $response['CheckoutRequestID'],
//                 'amount' => $amount,
//                 'phone' => $formattedPhone,
//             ];
//             log_message('debug', 'Payment successful. Redirecting to success page.');

//             return view('success', ['order' => $orderData]);
//         } else {
//             log_message('error', 'Payment failed: ' . $response['ResponseDescription']);
//             throw new Exception($response['ResponseDescription']);
//         }
//     } catch (Exception $e) {
//         log_message('critical', 'Exception during payment process: ' . $e->getMessage());
//         return view('error', ['error' => $e->getMessage()]);
//     }
// }


public function processPayment()
{
    $amount = $this->request->getPost('amount');
    $phone = $this->request->getPost('phone');

    // Format phone number to E.164 (Safaricom format)
    if (preg_match('/^0[7-9][0-9]{8}$/', $phone)) {
        $phone = '254' . substr($phone, 1); // Convert 0701234567 to 254701234567
    }

    log_message('debug', "Formatted phone number: $phone");

    try {
        $accessToken = $this->getAccessToken();
        $response = $this->initiateSTKPush($accessToken, $amount, $phone);

        if ($response['ResponseCode'] == '0') {
            log_message('debug', 'STK Push initiated successfully. CheckoutRequestID: ' . $response['CheckoutRequestID']);
            
            // Save CheckoutRequestID to session
            session()->set('CheckoutRequestID', $response['CheckoutRequestID']);

            // Redirect to success page without undefined variables
            return view('success'); 
        } else {
            throw new Exception($response['ResponseDescription']);
        }
    } catch (Exception $e) {
        log_message('critical', 'Payment initiation failed: ' . $e->getMessage());
        return view('error', ['error' => $e->getMessage()]);
    }
}



    

    private function getAccessToken()
    {
        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);

        $client = \Config\Services::curlrequest();
        $response = $client->request('GET', $url, [
            'headers' => ['Authorization' => 'Basic ' . $credentials],
        ]);

        $data = json_decode($response->getBody(), true);

        if (!isset($data['access_token'])) {
            throw new Exception('Failed to generate access token');
        }

        return $data['access_token'];
    }

    public function initiateSTKPush($accessToken, $amount, $phone)
{
    $payload = [
        'BusinessShortCode' => getenv('MPESA_BUSINESS_SHORT_CODE'),
        'Password'          => base64_encode(getenv('MPESA_BUSINESS_SHORT_CODE') . getenv('MPESA_PASSKEY') . date('YmdHis')),
        'Timestamp'         => date('YmdHis'),
        'TransactionType'   => 'CustomerPayBillOnline',
        'Amount'            => $amount,
        'PartyA'            => $phone,
        'PartyB'            => getenv('MPESA_BUSINESS_SHORT_CODE'),
        'PhoneNumber'       => $phone,
        'CallBackURL'       => getenv('MPESA_CALLBACK_URL'),
        'AccountReference'  => 'Payment', // Customize as needed
        'TransactionDesc'   => 'Payment for Order', // Customize as needed
    ];

    log_message('debug', 'STK Push payload: ' . json_encode($payload));

    $ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        log_message('critical', 'CURL Error: ' . curl_error($ch));
        throw new Exception('CURL Error: ' . curl_error($ch));
    }

    curl_close($ch);

    log_message('debug', "HTTP Code: $httpCode, Response: $response");

    if ($httpCode != 200) {
        throw new Exception("$httpCode : " . $response);
    }

    return json_decode($response, true);
}


public function callback()
{
    $postData = file_get_contents('php://input');
    log_message('debug', 'Raw callback data: ' . $postData);

    $callbackData = json_decode($postData, true);

    if (isset($callbackData['Body']['stkCallback'])) {
        $callback = $callbackData['Body']['stkCallback'];
        $resultCode = $callback['ResultCode'];
        $checkoutRequestId = $callback['CheckoutRequestID'];
        $resultDesc = $callback['ResultDesc'];

        if ($resultCode == 0) {
            $metadata = $callback['CallbackMetadata']['Item'];
            $data = [];

            foreach ($metadata as $item) {
                $data[$item['Name']] = $item['Value'] ?? null;
            }

            // Save transaction
            $db = \Config\Database::connect();
            $transactionData = [
                'MerchantRequestID' => $callback['MerchantRequestID'],
                'CheckoutRequestID' => $checkoutRequestId,
                'ResultCode' => $resultCode,
                'ResultDesc' => $resultDesc,
                'Amount' => $data['Amount'] ?? null,
                'MpesaReceiptNumber' => $data['MpesaReceiptNumber'] ?? null,
                'PhoneNumber' => $data['PhoneNumber'] ?? null,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $db->table('transactions')->insert($transactionData);

            $orderData = [
                'transaction_id' => $db->insertID(),
                'amount' => $data['Amount'],
                'phone' => $data['PhoneNumber'],
                'status' => 'paid',
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $db->table('orders')->insert($orderData);

            log_message('debug', 'Order saved for transaction ID: ' . $db->insertID());
        } else {
            log_message('critical', "Payment failed for CheckoutRequestID: $checkoutRequestId, ResultDesc: $resultDesc");
        }
    }
}

    public function successPage()
    {
        
        session()->remove('cart');

    
        return view('success', [
            'message' => 'Payment successful! Your order has been placed.',
        ]);
    }

    public function confirmPayment()
    {
        $orderId = $this->request->getPost('order_id');
        $mpesaReceiptNumber = $this->request->getPost('mpesa_receipt_number');

        log_message('debug', "Attempt to confirm payment for Order ID: {$orderId}, M-Pesa Receipt Number: {$mpesaReceiptNumber}");

        $db = \Config\Database::connect();
        $builder = $db->table('transactions');
        
        $transaction = $builder->where('order_id', $orderId)
                               ->where('MpesaReceiptNumber', $mpesaReceiptNumber)
                               ->get()
                               ->getRow();
        
        if ($transaction) {
            $orderModel = new OrderModel();
            $order = $orderModel->find($orderId);

            if ($order) {
                $orderModel->update($orderId, ['status' => 'paid']);
                log_message('debug', "Order #{$orderId} status updated to paid.");

                return redirect()->to('/orders');
            } else {
                log_message('error', "Order not found: {$orderId}");
                return view('error', ['error' => 'Order not found.']);
            }
        } else {
            log_message('error', "M-Pesa receipt number does not match for Order ID: {$orderId}");
            return view('error', ['error' => 'M-Pesa receipt number does not match.']);
        }
    }
}
