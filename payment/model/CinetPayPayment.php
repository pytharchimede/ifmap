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
            'customer_name' => isset($customerData['name']) ? $customerData['name'] : '',
            'customer_surname' => isset($customerData['surname']) ? $customerData['surname'] : '',
            'customer_email' => isset($customerData['email']) ? $customerData['email'] : '',
            'customer_phone_number' => isset($customerData['phone']) ? $customerData['phone'] : '',
            'customer_address' => isset($customerData['address']) ? $customerData['address'] : '',
            'customer_city' => isset($customerData['city']) ? $customerData['city'] : '',
            'customer_country' => isset($customerData['country']) ? $customerData['country'] : '',
            'customer_state' => isset($customerData['state']) ? $customerData['state'] : '',
            'customer_zip_code' => isset($customerData['zip']) ? $customerData['zip'] : ''
        ];
    }
}
