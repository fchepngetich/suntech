<?php

namespace App\Services;

use CodeIgniter\HTTP\Client;
use CodeIgniter\Config\Services;

class MpesaService
{
    // Class properties
    private $shortcode;
    private $lipaPassword;
    private $lipaShortcode;
    private $apiKey;
    private $apiSecret;
    private $businessShortCode;
    private $passkey;
    private $callbackUrl;
    private $stkPushUrl;
    private $apiBaseUrl;

    // Constructor to initialize properties
    public function __construct()
    {
        $this->shortcode = getenv('MPESA_LIPA_SHORTCODE');
        $this->lipaPassword = getenv('MPESA_LIPA_PASSWORD');
        $this->lipaShortcode = getenv('MPESA_LIPA_SHORTCODE');
        $this->apiKey = getenv('MPESA_CONSUMER_KEY');
        $this->apiSecret = getenv('MPESA_CONSUMER_SECRET');
        $this->businessShortCode = getenv('MPESA_BUSINESS_SHORT_CODE');
        $this->passkey = getenv('MPESA_PASSKEY');
        $this->callbackUrl = getenv('MPESA_CALLBACK_URL');
        $this->stkPushUrl = '/mpesa/stkpush/v1/processrequest';
        $this->apiBaseUrl = 'https://sandbox.safaricom.co.ke';  // Use the live URL when you're ready for production
    }

    // Step 1: Get Access Token from M-Pesa API
    public function getAccessToken()
    {
        $url = $this->apiBaseUrl . '/oauth/v1/generate?grant_type=client_credentials';
        $authorization = base64_encode($this->apiKey . ':' . $this->apiSecret);

        $client = Services::curlrequest();
        $response = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => 'Basic ' . $authorization
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        return $data['access_token'] ?? null;
    }

    // Step 2: Make the STK Push payment request
    public function stkPush($amount, $phone, $orderReference)
    {
        // Get the access token
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return ['error' => 'Unable to retrieve access token.'];
        }

        // Prepare the STK Push URL
        $url = $this->apiBaseUrl . $this->stkPushUrl;

        // Prepare headers
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json'
        ];

        // Prepare the request body
        $body = [
            'BusinessShortCode' => $this->lipaShortcode,
            'Password' => base64_encode($this->lipaPassword),
            'LipaNaMpesaOnlineShortcode' => $this->lipaShortcode,
            'Amount' => $amount,
            'PhoneNumber' => $phone,
            'AccountReference' => $orderReference,
            'TransactionDesc' => 'Payment for Order: ' . $orderReference,
            'CallbackUrl' => $this->callbackUrl 
        ];

        $client = Services::curlrequest();
        $response = $client->request('POST', $url, [
            'headers' => $headers,
            'json' => $body
        ]);

        // Return the result from M-Pesa
        $result = json_decode($response->getBody(), true);
        return $result;
    }
}
