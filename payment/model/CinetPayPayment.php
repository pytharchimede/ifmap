<?php

namespace Model;

class CinetPayPayment
{
    private $apikey;
    private $site_id;
    private $notify_url;
    private $mode;

    public function __construct($apikey, $site_id, $notify_url, $mode = 'PRODUCTION')
    {
        $this->apikey = $apikey;
        $this->site_id = $site_id;
        $this->notify_url = $notify_url;
        $this->mode = $mode;
    }

    public function generateTransactionId()
    {
        return (string) mt_rand(100000000, 999999999);
    }


    public function getCheckoutData($amount, $currency, $description, $customerData)
    {
        return [
            'apikey' => $this->apikey,
            'site_id' => $this->site_id,
            'transaction_id' => $this->generateTransactionId(),
            'amount' => $amount,
            'currency' => $currency,
            'description' => $description,
            'notify_url' => $this->notify_url,
            'channels' => 'ALL',
            'customer_name' => $customerData['name'] ?? '',
            'customer_surname' => $customerData['surname'] ?? '',
            'customer_email' => $customerData['email'] ?? '',
            'customer_phone_number' => $customerData['phone'] ?? '',
            'customer_address' => $customerData['address'] ?? '',
            'customer_city' => $customerData['city'] ?? '',
            'customer_country' => $customerData['country'] ?? '',
            'customer_state' => $customerData['state'] ?? '',
            'customer_zip_code' => $customerData['zip'] ?? ''
        ];
    }
}
