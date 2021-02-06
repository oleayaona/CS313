<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&family=Open+Sans:wght@300;400&family=Playfair+Display&display=swap"
        rel="stylesheet">
        <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital@0;1&display=swap" rel="stylesheet">
    <link href="./shopping_cart.css" rel="stylesheet">
</head>

<body>
    <header>
        <div class="logo">
            <h1>HOMEY</h1>
            <p>Lifestyle and Home Decor</p>
        </div>
        <nav>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/week_03/shopping_cart/modules/nav.php'; ?>
        </nav>
    </header>

    <div class="spread">
        <div class="spread_text">
            <h1>2021 Winter Collection</h1>
            <p>Gorgeous minimal decor bathed in beige that is sure to give your home a soothing atmosphere.</p>
            <a href="./index.php?action=shop"><h3>SHOP NOW</h3></a>
        </div>
    </div>
    
    <footer>
        <p>&#169; Homey. All rights reserved.</p>
        <p>Olea Yaona | BYU-Idaho | CSE-341</p>
    </footer>
</body>

</html>