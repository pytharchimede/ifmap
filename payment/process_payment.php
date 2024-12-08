<?php
require_once 'model/CinetPayPayment.php';

use Model\CinetPayPayment;

$payment = new CinetPayPayment(
    '76102700367505632e52a84.44877120', // API Key
    '5883702',                          // Site ID
    'https://ifmap.ci/notify/',    // Notify URL
    'PRODUCTION'                        // Mode
);

$customerData = [
    'name' => 'Amani',
    'surname' => 'Ulrich',
    'email' => 'amani_ulrih@outlook.fr',
    'phone' => '0748367710',
    'address' => 'BP 23',
    'city' => 'Abidjan',
    'country' => 'Côte d\'Ivoire',
    'state' => 'CI',
    'zip' => '225'
];

$checkoutData = $payment->getCheckoutData(10000, 'XOF', 'Test de paiement', $customerData);

echo "<script>const checkoutData = " . json_encode($checkoutData) . ";</script>";
?>
<script>
    function checkout() {
        CinetPay.setConfig({
            apikey: checkoutData.apikey,
            site_id: checkoutData.site_id,
            notify_url: checkoutData.notify_url,
            mode: checkoutData.mode
        });

        CinetPay.getCheckout({
            ...checkoutData
        });

        CinetPay.waitResponse(function(data) {
            if (data.status === "REFUSED") {
                alert("Votre paiement a échoué");
                window.location.reload();
            } else if (data.status === "ACCEPTED") {
                alert("Votre paiement a été effectué avec succès");
                window.location.reload();
            }
        });

        CinetPay.onError(function(data) {
            console.log(data);
        });
    }
</script>