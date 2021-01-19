<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>W03 | Team Assignment</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&family=Open+Sans:wght@300;400&family=Playfair+Display&display=swap"
        rel="stylesheet">
    <link href="index.css" rel="stylesheet">
</head>

<body>
    <main>
        <h1><?php echo "Hello, " . $_POST["name"] . "!\n" ?></h1>
        <h4><?php echo "This is your email: <a href='mailto:" . $_POST["email"] . "'>" . $_POST["email"] . "</a>"?></h4>
        <h4><?php echo "This is your major: " . $_POST["major"]?></h4>
        <p><?php 
            if ($_POST["comments"] != "") {
                echo "<h4>Your comments: " . $_POST["comments"] . "</h4>";
            }
            
            ?></p>
        <h4>You've been to the following places:</h4>
        <?php 
            echo "<ul>";
            if (isset($_POST["NA"])) {
                echo "<li>North America</li>";
            } 
            if (isset($_POST["SA"])) {
                echo "<li>South America</li>";
            }
            if (isset($_POST["EU"])) {
                echo "<li>Europe</li>";
            }
            if (isset($_POST["AU"])) {
                echo "<li>Australia</li>";
            }
            echo "</ul>";
        ?>
    </main>
</body>

</html>