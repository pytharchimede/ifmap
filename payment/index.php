<?php
// session_start();
// var_dump($_POST);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Détails de votre achat - IFMAP</title>
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
            padding: 3rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            width: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .container:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.3);
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: #fabd02;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            font-weight: 300;
        }

        .price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #fabd02;
            margin-bottom: 2rem;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.2);
            margin: 1rem 0;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .cart-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .cart-item img {
            width: 80px;
            height: 120px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .cart-item-details {
            flex-grow: 1;
            margin-left: 1rem;
            text-align: left;
        }

        .cart-item-name {
            font-weight: bold;
            font-size: 1.1rem;
        }

        .cart-item-description {
            font-size: 0.9rem;
            color: #ccc;
            margin-top: 0.5rem;
        }

        .cart-item-price {
            font-size: 1.2rem;
            color: #fabd02;
            font-weight: bold;
        }

        .checkout-btn {
            display: inline-block;
            padding: 1rem 2rem;
            font-size: 1.2rem;
            font-weight: bold;
            color: #1d2b57;
            background: #fabd02;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
            margin-top: 2rem;
        }

        .checkout-btn:hover {
            background: #ffd659;
            transform: translateY(-5px);
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Récapitulatif de votre commande</h1>
        <p>Voici les détails des articles que vous avez choisis. Merci pour votre achat !</p>

        <?php
        if (!empty($_POST['cart_items'])) {
            $total_price = 0;
            for ($i = 0; $i < count($_POST['cart_items']); $i++) {
                echo '<div class="cart-item">';
                echo '<img src="' . $_POST['cart_items_images'][$i] . '" alt="Image">';
                echo '<div class="cart-item-details">';
                echo '<div class="cart-item-name">' . $_POST['cart_items_names'][$i] . '</div>';
                echo '<div class="cart-item-description">' . $_POST['cart_items_descriptions'][$i] . '</div>';
                echo '<div class="cart-item-price">' . $_POST['cart_items_price'][$i] . ' FCFA</div>';
                echo '</div>';
                echo '</div>';

                // Add item price to total
                $total_price += $_POST['cart_items_price'][$i];
            }
        }
        ?>

        <div class="price">Total : <?= number_format($total_price, 0, ',', ' ') ?> FCFA</div>

        <button class="checkout-btn" onclick="checkout()">Procéder au paiement</button>
    </div>
    <?php
    // Process Payment - Inclusion of the payment logic.
    require_once 'process_payment.php';
    ?>
</body>

</html>