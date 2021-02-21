<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Complete!</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&family=Open+Sans:wght@300;400&family=Playfair+Display&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital@0;1&display=swap" rel="stylesheet">
    <link href="./shop.css" rel="stylesheet">
</head>

<body>
    <header>
        <div class="logo">
            <h1>HOMEY</h1>
            <p>Lifestyle and Home Decor</p>
        </div>
        <nav>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/shop/modules/nav.php'; ?>
        </nav>
    </header>

    <main>
        <div class="confirmation">
            <img id="confirmation-check" src="./images/checkmark-icon.png" alt="checkmark icon">
            <h3>Order complete!</h3>
            <p>Your invoice has been sent to <?php echo $email ?>. Your order is being processed and will be shipped within 3 business days. Thank you!</p>
            <a href="./index.php?action=shop"><h3>CONTINUE SHOPPING</h3></a>
        </div>
        
        <div class="summary">
            <h2>SUMMARY</h2>
            <h2>ORDER #<?php echo $order_id ?></h2>
                <h4><?php echo $name ?></h4>
                <p><?php echo $completeAddress ?></p>
                <p><?php echo $phone ?></p>
                <?php
                    if (isset($summaryDisplay)) {
                        echo $summaryDisplay;
                    }
                ?>
        </div>
    </main>

    <footer>
        <p>&#169; Homey. All rights reserved.</p>
        <p>Olea Yaona | BYU-Idaho | CSE-341</p>
    </footer>
<script>
    // make sure search bar is not empty
    var validate = function(event) {
        var input = document.querySelector('#search');
        if (input.value.length == 0) {
            event.preventDefault();
            input.focus();
        }
    };

    // get form
    var form = document.querySelector("#search-form");

    // attach event listener
    form.addEventListener("submit", validate, true);
</script>
</body>

</html>