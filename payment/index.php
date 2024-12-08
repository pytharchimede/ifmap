<?php
var_dump($_POST);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Achetez votre Livre - IFMAP</title>
    <script src="https://cdn.cinetpay.com/seamless/main.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1d2b57, #fabd02);
            color: #fff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            text-align: center;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .container:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
        }

        .book-cover {
            width: 120px;
            height: 180px;
            object-fit: cover;
            margin-bottom: 1rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #fabd02;
            margin-bottom: 1.5rem;
        }

        .btn {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
            font-weight: bold;
            color: #1d2b57;
            background: #fabd02;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .btn:hover {
            background: #ffd659;
            transform: translateY(-5px);
        }

        .sdk {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="https://via.placeholder.com/120x180" alt="Couverture du Livre" class="book-cover">
        <h1>Le Guide des Métiers de l'Aval Pétrolier</h1>
        <p>Par IFMAP</p>
        <div class="price">Prix : 10 000 FCFA</div>
        <button class="btn" onclick="checkout()">Acheter Maintenant</button>
    </div>

    <?php
    // Process Payment - Inclusion of the payment logic.
    require_once 'process_payment.php';
    ?>
</body>

</html>