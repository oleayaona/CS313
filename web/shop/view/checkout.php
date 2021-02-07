<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&family=Open+Sans:wght@300;400&family=Playfair+Display&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital@0;1&display=swap" rel="stylesheet">
    <link href="./shop.css" rel="stylesheet">
</head>

<body>
    <main>
        <form class="checkout" action="./index.php?action=complete" method="POST">
        <fieldset>
            <h1>Checkout</h1>
            <p>Contact Information</p>
            <div class="two-child">
                <div>
                    <input type="text" id="first_name" name="first_name" placeholder="First name"
                        oninput="capitalize('first_name');" required><br>
                    <label for="first_name">First name</label>
                </div>
                <div>
                    <input type="text" id="last_name" name="last_name" placeholder="Last name"
                        oninput="capitalize('last_name');" required><br>
                    <label for="last_name">Last name</label>
                </div>
            </div>
            <div class="full">
                <input type="text" id="phone" name="phone" placeholder="Phone" oninput="numberOnly('phone');"  required><br>
                <label for="phone">Phone</label>
            </div>
            <p>Shipping Address</p>
            <div class="full">
                <textarea id="address" name="address" rows="1" placeholder="Address required"></textarea><br>
                <label for="address">Address</label>
            </div>
            <div class="two-child">
                <div>
                    <input type="text" id="postal_code" name="postal_code" placeholder="Postal Code" oninput="numberOnly('postal_code');" required><br>
                    <label for="postal_code">Postal Code</label>
                </div>
                <div>
                    <input type="text" id="city" name="city" placeholder="City"
                        oninput="capitalize('city');" required><br>
                    <label for="city">City</label>
                </div>
            </div>
            <div class="full">
                <input type="text" id="country" name="country" placeholder="Country" required><br>
                <label for="country">Country</label>
            </div>
            <div class="form-btns">
                <a href="./index.php?action=cart"><p>< Return to cart</p></a>
                <button id="pay-now-btn" type="submit">PAY NOW</button>
            </div>
        </fieldset>
        </form>
    </main>

    <footer>
        <p>&#169; Homey. All rights reserved.</p>
        <p>Olea Yaona | BYU-Idaho | CSE-341</p>
    </footer>

<script>
    // Capitalize names
    function capitalize(id) {
            let name = document.getElementById(id).value.replace(/[^a-zA-Z ]/g, '');
            let formatted = name.charAt(0).toUpperCase() + name.slice(1);
            document.getElementById(id).value = formatted;
    }
    // Number only input
    function numberOnly(id){
        var input = document.getElementById(id).value.replace(/\D/g, '');
        document.getElementById(id).value = input;
    }
</script>
</body>

</html>