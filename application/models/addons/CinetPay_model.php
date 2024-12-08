<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CinetPay_model extends CI_Model
{
    private $api_key;
    private $site_id;
    private $base_url;

    public function __construct()
    {
        parent::__construct();

        // Charger les clés API et le mode de test depuis la base de données
        $payment_gateway = $this->db->get_where('payment_gateways', ['identifier' => 'cinetpay'])->row_array();
        $keys = json_decode($payment_gateway['keys'], true);

        $this->api_key = $keys['api_key'];
        $this->site_id = $keys['site_id'];
        $this->base_url = $payment_gateway['enabled_test_mode'] ?
            'https://sandbox.cinetpay.com/api/v1/' :
            'https://api.cinetpay.com/api/v1/';
    }

    public function check_cinetpay_payment($payment_method, $payment_type)
    {
        // Exemple de vérification d'un paiement
        $transaction_id = $this->session->userdata('payment_details')['transaction_id'];

        $url = $this->base_url . 'payment/check';

        $post_data = [
            'apikey' => $this->api_key,
            'site_id' => $this->site_id,
            'transaction_id' => $transaction_id,
        ];

        $response = $this->make_curl_request($url, $post_data);

        if ($response && $response['code'] === '00') {
            return true; // Paiement validé
        }

        return false; // Paiement échoué
    }

    private function make_curl_request($url, $data)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response, true);
    }
}
