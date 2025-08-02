<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Auto Spare Parts Shop</title>
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
        .product {
    background: white;
    border: 1px solid #ddd;
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 5px;
        }
        .product h3 {
    margin-top: 0;
        }
        .btn {
    display: inline-block;
    padding: 0.4rem 0.8rem;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 4px;
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
    </style>
</head>
<body>
<script src="../js/tracker.js"></script>
<header>
    <h1>Auto Spare Parts Shop</h1>
    <p>Buy high-quality car parts at affordable prices.</p>
    <nav>
        <ul style="list-style: none; display: flex; gap: 1rem; padding: 0; margin-top: 1rem;">
            <li><a href="spare-part.php" style="color: white; text-decoration: none;">Spare Parts</a></li>
            <li><a href="cart.php" style="color: white; text-decoration: none;">Cart</a></li>
            <li><a href="about.php" style="color: white; text-decoration: none;">About</a></li>
        </ul>
    </nav>
</header>

<main>
    <div class="product">
        <h3>Brake Pads - Front (Set of 4)</h3>
        <p>Compatible with: Toyota, Honda, Nissan</p>
        <strong>Price: $49.99</strong><br>
        <a href="#" class="btn">Add to Cart</a>
    </div>

    <div class="product">
        <h3>Oil Filter - Bosch Premium</h3>
        <p>Compatible with: BMW, Mercedes, Audi</p>
        <strong>Price: $14.99</strong><br>
        <a href="#" class="btn">Add to Cart</a>
    </div>

    <div class="product">
        <h3>Spark Plugs - NGK Iridium (Set of 4)</h3>
        <p>Compatible with: Ford, Mazda, Hyundai</p>
        <strong>Price: $32.50</strong><br>
        <a href="#" class="btn">Add to Cart</a>
    </div>
</main>
</body>
</html>
