<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Mpesa extends BaseConfig
{
    public string $consumerKey;
    public string $consumerSecret;
    public string $businessShortCode;
    public string $passkey;
    public string $callbackUrl;
    public string $stkPushUrl;

    public function __construct()
    {
        $this->consumerKey = getenv('MPESA_CONSUMER_KEY');
        $this->consumerSecret = getenv('MPESA_CONSUMER_SECRET');
        $this->businessShortCode = getenv('MPESA_BUSINESS_SHORT_CODE');
        $this->passkey = getenv('MPESA_PASSKEY');
        $this->callbackUrl = getenv('MPESA_CALLBACK_URL');
        $this->stkPushUrl = getenv('MPESA_STK_PUSH_URL');
    }
}
