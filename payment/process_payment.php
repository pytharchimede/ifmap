<?php
require_once 'model/CinetPayPayment.php';

use Model\CinetPayPayment;

// Configuration de l'API CinetPay
$payment = new CinetPayPayment(
    '76102700367505632e52a84.44877120', // API Key
    '5883702',                           // Site ID
    'https://ifmap.ci/notify/',           // Notify URL
    'PRODUCTION'                         // Mode (peut être TEST en développement)
);

// Données client
$customerData = [
    'name' => 'Amani',
    'surname' => 'Ulrich',
    'email' => 'amani_ulrich@outlook.fr',
    'phone' => '0748367710',
    'address' => 'BP 23',
    'city' => 'Abidjan',
    'country' => 'Côte d\'Ivoire',
    'state' => 'CI',
    'zip' => '225'
];

// Données de la commande
$checkoutData = $payment->getCheckoutData(10000, 'XOF', 'Test de paiement', $customerData);

echo "<script>const checkoutData = " . json_encode($checkoutData) . ";</script>";
?>
<script>
    function checkout() {
        alert("Lancement du processus de paiement...");

        // Configuration de l'API CinetPay
        CinetPay.setConfig({
            apikey: checkoutData.apikey,
            site_id: checkoutData.site_id,
            notify_url: checkoutData.notify_url,
            mode: 'TEST' // Remplacer par 'LIVE' en production
        });

        // Lancer le processus de paiement
        CinetPay.getCheckout({
            apikey: checkoutData.apikey,
            site_id: checkoutData.site_id,
            transaction_id: checkoutData.transaction_id,
            amount: checkoutData.amount,
            currency: checkoutData.currency,
            description: checkoutData.description,
            notify_url: checkoutData.notify_url,
            channels: checkoutData.channels,
            customer_name: checkoutData.customer_name,
            customer_surname: checkoutData.customer_surname,
            customer_email: checkoutData.customer_email,
            customer_phone_number: checkoutData.customer_phone_number,
            customer_address: checkoutData.customer_address,
            customer_city: checkoutData.customer_city,
            customer_country: checkoutData.customer_country,
            customer_state: checkoutData.customer_state,
            customer_zip_code: checkoutData.customer_zip_code
        });

        // Attendre la réponse et rediriger en fonction de l'état du paiement
        CinetPay.waitResponse(function(data) {
            console.log(data); // Affichez la réponse de CinetPay pour déboguer
            if (data.status === "REFUSED") {
                alert("Votre paiement a échoué");
                window.location.reload(); // Recharge la page ou effectue une autre action
            } else if (data.status === "ACCEPTED") {
                alert("Votre paiement a été effectué avec succès");
                window.location.href = "page_de_succes.php"; // Redirection vers une page de succès
            } else {
                alert("Statut de paiement inconnu : " + data.status);
            }
        });

        // Gestion des erreurs
        CinetPay.onError(function(data) {
            console.log("Erreur CinetPay: ", data); // Log des erreurs
        });
    }
</script>