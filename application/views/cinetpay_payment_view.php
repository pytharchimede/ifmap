<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement CinetPay</title>
    <!-- Lien vers Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .payment-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .payment-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .payment-header h2 {
            color: #1d2b57;
            /* Couleur bleue */
            font-size: 24px;
            margin-bottom: 10px;
        }

        .payment-header p {
            color: #6c757d;
        }

        .payment-details {
            margin-bottom: 20px;
        }

        .payment-details label {
            font-weight: bold;
            color: #1d2b57;
        }

        .payment-details p {
            font-size: 16px;
        }

        .btn-payment {
            background-color: #fabd02;
            /* Jaune */
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-size: 18px;
            width: 100%;
            cursor: pointer;
        }

        .btn-payment:hover {
            background-color: #e99f00;
            /* Teinte plus foncée de jaune */
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="payment-container">
        <div class="payment-header">
            <h2>Effectuer un Paiement</h2>
            <p>Veuillez vérifier les informations ci-dessous avant de procéder au paiement.</p>
            <p><?php var_dump($checkoutData); ?></p>
        </div>

        <div class="payment-details">
            <label for="amount">Montant :</label>
            <p id="amount">10000 XOF</p>

            <label for="description">Description :</label>
            <p id="description">Test de paiement pour CinetPay</p>

            <label for="customer_name">Nom du Client :</label>
            <p id="customer_name">Amani Ulrich</p>

            <label for="customer_email">Email :</label>
            <p id="customer_email">amani_ulrih@outlook.fr</p>

            <label for="customer_phone">Téléphone :</label>
            <p id="customer_phone">0748367710</p>
        </div>

        <!-- Bouton de paiement -->
        <button class="btn-payment" onclick="checkout()">Payer maintenant</button>
    </div>

    <div class="footer">
        <p>&copy; 2024 CinetPay - Tous droits réservés</p>
    </div>

    <!-- Scripts JavaScript -->
    <script>
        // Définir les données de paiement à partir de PHP
        const checkoutData = <?php echo $checkoutData; ?>;

        // Fonction de paiement CinetPay
        function checkout() {
            // Configurer CinetPay avec les données récupérées
            CinetPay.setConfig({
                apikey: checkoutData.apikey,
                site_id: checkoutData.site_id,
                notify_url: checkoutData.notify_url,
                mode: checkoutData.mode
            });

            // Lancer le processus de paiement
            CinetPay.getCheckout({
                ...checkoutData
            });

            // Gérer la réponse de paiement
            CinetPay.waitResponse(function(data) {
                if (data.status === "REFUSED") {
                    alert("Votre paiement a échoué. Veuillez réessayer.");
                    window.location.reload();
                } else if (data.status === "ACCEPTED") {
                    alert("Paiement effectué avec succès !");
                    window.location.reload();
                }
            });

            // Gestion des erreurs
            CinetPay.onError(function(data) {
                console.log("Erreur:", data);
            });
        }
    </script>

    <!-- Lien vers les scripts Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>