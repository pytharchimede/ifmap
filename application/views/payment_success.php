<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            margin-top: 50px;
        }

        .success-message {
            text-align: center;
            background-color: #28a745;
            color: white;
            padding: 20px;
            border-radius: 10px;
        }

        .button-back {
            margin-top: 20px;
            display: block;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="success-message">
            <h2>Payment Successful!</h2>
            <p>Your payment has been successfully processed. Thank you for your purchase.</p>
        </div>

        <div class="button-back">
            <a href="<?= base_url('home'); ?>" class="btn btn-primary">Go Back to Home</a>
        </div>
    </div>

</body>

</html>