<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CinetPayPayment extends CI_Model
{
    private $apikey;
    private $site_id;
    private $notify_url;
    private $mode;

    // Constructeur de la classe
    public function __construct($apikey = null, $site_id = null, $notify_url = null, $mode = 'PRODUCTION')
    {
        parent::__construct();

        // Initialisation avec les paramètres ou valeurs par défaut
        $this->apikey = $apikey ?: '76102700367505632e52a84.44877120';  // Remplacez par votre clé API
        $this->site_id = $site_id ?: '5883702';  // Remplacez par votre site ID
        $this->notify_url = $notify_url ?: 'https://ifmap.ci/notify/';  // Remplacez par votre URL de notification
        $this->mode = $mode;
    }

    // Génère un ID de transaction unique
    public function generateTransactionId()
    {
        return (string) mt_rand(100000000, 999999999);
    }

    // Récupère les données pour le paiement
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
