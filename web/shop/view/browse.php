<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
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
        <h3 id='shop-message'>
            <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
        ?>
        </h3>
        <div class="products-container">
            <h2>PRODUCTS</h2>
            <?php 
                if (isset($categoriesDisplay)) {
                    echo $categoriesDisplay;
                }
            ?>
            <hr id="products-hr">
            <?php 
                if (isset($productsDisplay)) {
                    echo $productsDisplay;
                }
            ?>
        </div>
    </main>

    <footer>
        <p>&#169; Homey. All rights reserved.</p>
        <p>Olea Yaona | BYU-Idaho | CSE-341</p>
    </footer>
    <?php echo "<pre>" . print_r($json, true) . "</pre>"; ?>
<script>
    
    var jsonData = <?= $json; ?>;
    var prodData = JSON.parse(jsonData.slice(1, -1));
    console.log(prodData);



    
    // function buildProductsDisplay() {
    //     var display = '<ul class="products">';
    //     for (i in $json) {
    //     $display .= "<li><a href='./index.php?action=product-info&id=" . urlencode($product['prod_id']) . "'>";
    //     $display .= "<img class='product-img' src='./images/$product[prod_img]' alt='$product[prod_name]'></a>";
    //     $display .= "<a href='./index.php?action=product-info&id=" . urlencode($product['prod_id']) . "'><h2>" . strtoupper($product['prod_name']) . "</h2></a>";
    //     $display .= "<h4>&#8369;". number_format($product['prod_price'], 2) ."</h4>";
    //     $display .= "<a href='./index.php?action=add-to-cart&id=" . urlencode($product['prod_id']) . "'><h5 class='add-cart'>ADD TO CART</h3></a>";
    //     $display .= '</li>';
    //     }
    //     $display .= '</ul>';
    // }

    // function showProducts() {

    // };
    // /*---Loads a text file given the url and function------*/
    // function loadDoc(url, cFunction) {
    //     var xhttp;
    //     xhttp = new XMLHttpRequest();
    //     xhttp.onreadystatechange = function () {
    //         if (this.readyState == 4 && this.status == 200) {
    //             cFunction(this);
    //         }
    //     };
    //     xhttp.open("GET", url, true);
    //     xhttp.send();
    // }

    // function myFunction(xhttp) {
    //     document.getElementById("data").innerHTML =
    //         xhttp.responseText;
    // }

    // function readJSON() {
    //     const input = document.getElementById("input").value;

    //     var xmlhttp = new XMLHttpRequest();
    //     xmlhttp.onreadystatechange = function () {
    //         if (this.readyState == 4 && this.status == 200) {
    //             var myArr = JSON.parse(this.responseText);
    //             formatJSON(myArr);
    //         }
    //     };
    //     xmlhttp.open("GET", input, true);
    //     xmlhttp.send();
    // }

    // function formatJSON(json) {
    //     var i;
    //     var table = "<tr><th>First name</th><th>Last name</th><th>Address</th><th>Major</th><th>GPA</th></tr>";
    //     for (i in json.students) {
    //         table += "<tr><td>" +
    //             json.students[i].first +
    //             "</td><td>" +
    //             json.students[i].last +
    //             "</td><td>" +
    //             json.students[i].address.city + ", " + json.students[i].address.state + " " + json.students[i].address.zip +
    //             "</td><td>" +
    //             json.students[i].major +
    //             "</td><td>" +
    //             json.students[i].gpa +
    //             "</td></tr>";
    //     }
    //     document.getElementById("json_data").innerHTML = table;
    // }
</script>
</body>

</html><?php unset($_SESSION['message']) ?>