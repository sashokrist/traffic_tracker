<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart - Auto Spare Parts Shop</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 1rem;
            background-color: #f5f5f5;
        }
        header {
            background-color: #003366;
            color: white;
            padding: 1rem;
        }
        nav ul {
            list-style: none;
            display: flex;
            gap: 1rem;
            padding: 0;
            margin-top: 1rem;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
        }
        .cart-container {
            background: white;
            padding: 2rem;
            border-radius: 5px;
            max-width: 800px;
            margin: 2rem auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            border-bottom: 1px solid #ddd;
            padding-bottom: 0.5rem;
        }
        .cart-total {
            font-weight: bold;
            font-size: 1.2rem;
            text-align: right;
            margin-top: 1rem;
        }
        .btn-checkout {
            background-color: #28a745;
            color: white;
            padding: 0.6rem 1rem;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            float: right;
        }
    </style>
</head>
<body>
<script src="../js/tracker.js"></script>
<header>
    <h1>Your Cart</h1>
    <p>Review the items you’ve selected.</p>
    <nav>
        <ul>
            <li><a href="spare-part.php">Spare Parts</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="about.php">About</a></li>
        </ul>
    </nav>
</header>

<main>
    <div class="cart-container">
        <div class="cart-item">
            <span>Brake Pads - Front (Set of 4)</span>
            <span>$49.99</span>
        </div>
        <div class="cart-item">
            <span>Oil Filter - Bosch Premium</span>
            <span>$14.99</span>
        </div>
        <div class="cart-total">
            Total: $64.98
        </div>
        <a href="#" class="btn-checkout">Proceed to Checkout</a>
    </div>
</main>
</body>
</html>
