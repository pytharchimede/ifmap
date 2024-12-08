<?php
// Récupérer les données de la notification
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if ($data && isset($data['transaction_id'])) {
    $transactionId = $data['transaction_id'];
    $status = $data['status'];

    // Logique pour mettre à jour la base de données en fonction du statut
    if ($status == 'ACCEPTED') {
        // Mettre à jour la commande comme "payée"
        file_put_contents('logs/payment.log', "Transaction $transactionId acceptée\n", FILE_APPEND);
    } else {
        // Mettre à jour la commande comme "échouée"
        file_put_contents('logs/payment.log', "Transaction $transactionId refusée\n", FILE_APPEND);
    }

    echo json_encode(['message' => 'Notification reçue avec succès']);
} else {
    echo json_encode(['error' => 'Données invalides']);
}
