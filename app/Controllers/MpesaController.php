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

        public function getAccessToken()
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
    
        public function initiatePayment()
        {
            try {
        $phone = trim($this->request->getPost('phone_number'));
        $phone = preg_replace("/[^0-9]/", "", $phone); 

        if (strlen($phone) == 10 && substr($phone, 0, 1) == '0') {
            $phone = '254' . substr($phone, 1); 
        }

        if (!preg_match('/^254[7-9][0-9]{8}$/', $phone)) {
            throw new Exception('Invalid phone number format.');
        }

        $amount = filter_var($this->request->getPost('amount'), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        if ($amount <= 0) {
            throw new Exception('Invalid amount provided.');
        }
        
                $accessToken = $this->getAccessToken();
    
                $shortcode = '174379';
                $passkey = getenv('MPESA_PASSKEY');
                $timestamp = date('YmdHis');
                $password = base64_encode($shortcode . $passkey . $timestamp);
                $phone = preg_replace("/[^0-9]/", "", $this->request->getPost('phone_number'));
                $amount = filter_var($this->request->getPost('amount'), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $callbackUrl = base_url('mpesa/callback');
    
                $stkPushData = [
                    'BusinessShortCode' => $shortcode,
                    'Password' => $password,
                    'Timestamp' => $timestamp,
                    'TransactionType' => 'CustomerPayBillOnline',
                    'Amount' => $amount,
                    'PartyA' => $phone,
                    'PartyB' => $shortcode,
                    'PhoneNumber' => $phone,
                    'CallBackURL' => $callbackUrl,
                    'AccountReference' => 'Payment for Order',
                    'TransactionDesc' => 'Order Payment'
                ];
    
                $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
                $headers = [
                    'Authorization: Bearer ' . $accessToken,
                    'Content-Type: application/json'
                ];
    
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($stkPushData));
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    
                $response = curl_exec($curl);
                curl_close($curl);
    
                $result = json_decode($response, true);
    
                if (isset($result['ResponseCode']) && $result['ResponseCode'] == '0') {
                    $this->db->table('transactions')->insert([
                        'checkout_request_id' => $result['CheckoutRequestID'],
                        'amount' => $amount,
                        'phone' => $phone,
                        'status' => 'pending',
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
    
                    return $this->response->setJSON(['status' => 'success', 'message' => 'Payment request initiated successfully.']);
                } else {
                    throw new Exception('Failed to initiate payment: ' . $result['errorMessage']);
                }
            } catch (Exception $e) {
                log_message('error', 'Payment initiation failed: ' . $e->getMessage());
                log_message('error', 'Response from MPESA: ' . $response);  // Log MPESA API response for debugging
                return $this->response->setJSON(['status' => 'error', 'message' => 'Payment request failed.']);
            }
            
        }
        
    
        public function handleMpesaCallback()
        {
            $callbackData = json_decode(file_get_contents('php://input'), true);
    
            log_message('info', 'MPESA Callback Data: ' . json_encode($callbackData));
    
            if (isset($callbackData['Body']['stkCallback'])) {
                $callback = $callbackData['Body']['stkCallback'];
                $resultCode = $callback['ResultCode'];
    
                if ($resultCode == 0) {
                    $transactionData = [
                        'mpesa_receipt_number' => $callback['CallbackMetadata']['Item'][1]['Value'],
                        'result_code' => $resultCode,
                        'status' => 'successful',
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                    $this->db->table('transactions')->where('checkout_request_id', $callback['CheckoutRequestID'])->update($transactionData);
                } else {
                    log_message('error', 'MPESA Transaction failed: ' . $callback['ResultDesc']);
                }
            } else {
                log_message('error', 'Invalid MPESA Callback received.');
            }
        }
    }
    

