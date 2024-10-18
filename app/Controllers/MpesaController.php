<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;


class MpesaController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

        public function generateAccessToken()
        {
            $cacheKey = 'mpesa_access_token';
            $cachedToken = cache($cacheKey);
    
            if ($cachedToken) {
                return $cachedToken;
            }
    
            $consumer_key = getenv('MPESA_CONSUMER_KEY');
            $consumer_secret = getenv('MPESA_CONSUMER_SECRET');
            $credentials = base64_encode($consumer_key . ':' . $consumer_secret);
    
            $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
            $headers = ['Authorization: Basic ' . $credentials];
    
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    
            $response = curl_exec($curl);
            curl_close($curl);
    
            $result = json_decode($response);
            print_r($result);
    
            if (isset($result->access_token)) {
                cache()->save($cacheKey, $result->access_token, 3600); // Cache token for 1 hour
                return $result->access_token;
            } else {
                throw new Exception('Failed to generate access token.');
            }
        }

        function initiateMpesaPayment($phone, $amount, $orderId) {
            $accessToken = $this->generateAccessToken();
            $shortCode = '174379';
            $passKey = getenv('MPESA_PASSKEY');
            $accountReference = 'ORDER-' . $orderId;
            $transactionDesc = 'Payment for Order #' . $orderId;
            $timestamp = date('YmdHis');
            $password = 'MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMTYwMjE2MTY1NjI3';
            
            // Generate the callback URL and log it
            $callbackUrl = base_url('payments/callback');
            log_message('info', 'Callback URL: ' . $callbackUrl);
        
            // // Ensure callback URL is valid (you may want to enforce HTTPS)
            // if (strpos($callbackUrl, 'https://') === false) {
            //     log_message('error', 'Invalid Callback URL: ' . $callbackUrl);
            //     return (object) ['ResponseCode' => '1', 'errorMessage' => 'Invalid Callback URL'];
            // }
        
            $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        
            $data = [
                'BusinessShortCode' => $shortCode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => $amount,
                'PartyA' => $phone,
                'PartyB' => $shortCode,
                'PhoneNumber' => $phone,
                'CallBackURL' => $callbackUrl, // Use the logged callback URL
                'AccountReference' => $accountReference,
                'TransactionDesc' => $transactionDesc
            ];
        
            $headers = [
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json'
            ];
        
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
            $response = curl_exec($curl);
            curl_close($curl);
        
            return json_decode($response);
        }
        

        public function callback() {
            $jsonData = file_get_contents('php://input');
            $response = json_decode($jsonData, true);
        
            $resultCode = $response['Body']['stkCallback']['ResultCode'];
            $resultDesc = $response['Body']['stkCallback']['ResultDesc'];
            $merchantRequestID = $response['Body']['stkCallback']['MerchantRequestID'];
            $checkoutRequestID = $response['Body']['stkCallback']['CheckoutRequestID'];
        
            if ($resultCode == 0) {
                $mpesaReference = $response['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
                $amount = $response['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
                $phoneNumber = $response['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];
        
                // Save to DB and update status to 'paid'
                $this->db->table('payments')->where('checkout_request_id', $checkoutRequestID)
                    ->update([
                        'mpesa_reference' => $mpesaReference,
                        'amount' => $amount,
                        'phone_number' => $phoneNumber,
                        'status' => 'paid',
                        'transaction_time' => date('Y-m-d H:i:s')
                    ]);
        
                return json_encode(['status' => 'success']);
            } else {
                // Handle failed transaction
                return json_encode(['status' => 'failed', 'message' => $resultDesc]);
            }
        }
        public function initiate() {
            $phone = 254705952719;
            $amount =1;
            $orderId = $this->request->getPost('order_id');

             $phone = preg_replace("/[^0-9]/", "", $phone); 
    
            if (strlen($phone) == 10 && substr($phone, 0, 1) == '0') {
                $phone = '254' . substr($phone, 1); 
            }
    
             if (!preg_match('/^254[7-9][0-9]{8}$/', $phone)) {
                throw new Exception('Invalid phone number format.');
            }
        
            $response = $this->initiateMpesaPayment($phone, $amount, $orderId);
        
            if (isset($response->ResponseCode) && $response->ResponseCode == '0') {
                // Save initial payment data to DB
                $this->db->table('payments')->insert([
                    'user_id' => session('user_id'),
                    'order_id' => $orderId,
                    'amount' => $amount,
                    'phone_number' => $phone,
                    'status' => 'pending'
                ]);
        
                return $this->response->setJSON(['status' => 'success']);
            } else {
                return $this->response->setJSON(['status' => 'failed', 'message' => $response->errorMessage]);
            }
        }
        
        
    
        // public function initiatePayment()
        // {
        //     try {
        // $phone = trim($this->request->getPost('phone_number'));
        // $phone = preg_replace("/[^0-9]/", "", $phone); 

        // if (strlen($phone) == 10 && substr($phone, 0, 1) == '0') {
        //     $phone = '254' . substr($phone, 1); 
        // }

        // if (!preg_match('/^254[7-9][0-9]{8}$/', $phone)) {
        //     throw new Exception('Invalid phone number format.');
        // }

        // $amount = filter_var($this->request->getPost('amount'), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        // if ($amount <= 0) {
        //     throw new Exception('Invalid amount provided.');
        // }
        
        //         $accessToken = $this->getAccessToken();
    
        //         $shortcode = '174379';
        //         $passkey = getenv('MPESA_PASSKEY');
        //         $timestamp = date('YmdHis');
        //         $password = base64_encode($shortcode . $passkey . $timestamp);
        //         $phone = preg_replace("/[^0-9]/", "", $this->request->getPost('phone_number'));
        //         $amount = filter_var($this->request->getPost('amount'), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        //         $callbackUrl = base_url('mpesa/callback');
    
        //         $stkPushData = [
        //             'BusinessShortCode' => $shortcode,
        //             'Password' => $password,
        //             'Timestamp' => $timestamp,
        //             'TransactionType' => 'CustomerPayBillOnline',
        //             'Amount' => $amount,
        //             'PartyA' => $phone,
        //             'PartyB' => $shortcode,
        //             'PhoneNumber' => $phone,
        //             'CallBackURL' => $callbackUrl,
        //             'AccountReference' => 'Payment for Order',
        //             'TransactionDesc' => 'Order Payment'
        //         ];
    
        //         $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        //         $headers = [
        //             'Authorization: Bearer ' . $accessToken,
        //             'Content-Type: application/json'
        //         ];
    
        //         $curl = curl_init();
        //         curl_setopt($curl, CURLOPT_URL, $url);
        //         curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //         curl_setopt($curl, CURLOPT_POST, true);
        //         curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($stkPushData));
        //         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    
        //         $response = curl_exec($curl);
        //         curl_close($curl);
    
        //         $result = json_decode($response, true);
    
        //         if (isset($result['ResponseCode']) && $result['ResponseCode'] == '0') {
        //             $this->db->table('transactions')->insert([
        //                 'checkout_request_id' => $result['CheckoutRequestID'],
        //                 'amount' => $amount,
        //                 'phone' => $phone,
        //                 'status' => 'pending',
        //                 'created_at' => date('Y-m-d H:i:s')
        //             ]);
    
        //             return $this->response->setJSON(['status' => 'success', 'message' => 'Payment request initiated successfully.']);
        //         } else {
        //             throw new Exception('Failed to initiate payment: ' . $result['errorMessage']);
        //         }
        //     } catch (Exception $e) {
        //         log_message('error', 'Payment initiation failed: ' . $e->getMessage());
        //         log_message('error', 'Response from MPESA: ' . $response);  // Log MPESA API response for debugging
        //         return $this->response->setJSON(['status' => 'error', 'message' => 'Payment request failed.']);
        //     }
            
        // }
        
    
        // public function handleMpesaCallback()
        // {
        //     $callbackData = json_decode(file_get_contents('php://input'), true);
    
        //     log_message('info', 'MPESA Callback Data: ' . json_encode($callbackData));
    
        //     if (isset($callbackData['Body']['stkCallback'])) {
        //         $callback = $callbackData['Body']['stkCallback'];
        //         $resultCode = $callback['ResultCode'];
    
        //         if ($resultCode == 0) {
        //             $transactionData = [
        //                 'mpesa_receipt_number' => $callback['CallbackMetadata']['Item'][1]['Value'],
        //                 'result_code' => $resultCode,
        //                 'status' => 'successful',
        //                 'updated_at' => date('Y-m-d H:i:s'),
        //             ];
        //             $this->db->table('transactions')->where('checkout_request_id', $callback['CheckoutRequestID'])->update($transactionData);
        //         } else {
        //             log_message('error', 'MPESA Transaction failed: ' . $callback['ResultDesc']);
        //         }
        //     } else {
        //         log_message('error', 'Invalid MPESA Callback received.');
        //     }
        // }
    }
    

