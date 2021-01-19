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
        <form action="teamScript.php" method="POST">
            <h1>Student Registration</h1>
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="First name" required><br>
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Email address" required><br>

            <p>Major:</p>
            <?php 
                $majors = array("Computer Science", "Web Design and Development", "Computer Infromation Technology", "Computer Engineering");

                $radiodiv = '<div>';
                foreach ($majors as $major) {
                    $radiodiv .= "<input type='radio' id='$major' name='major' value='$major'>
                                  <label for='$major'>$major</label><br>";
                }
                $radiodiv .= '</div>';
                echo $radiodiv;
            ?>

            <p>Places you've been to:</p>
            <input type="checkbox" id="NA" name="NA" value="NA">
            <label for="NA">North America</label><br>
            <input type="checkbox" id="SA" name="SA" value="SA">
            <label for="SA">South America</label><br>
            <input type="checkbox" id="EU" name="EU" value="EU">
            <label for="EU">Europe</label><br>
            <input type="checkbox" id="AU" name="AU" value="AU">
            <label for="AU">Australia</label><br>
            
            <br>
            <label for="comments">Comments:</label><br>
            <textarea name="comments" id="comments" rows="6"></textarea><br>
            
            <input type="submit" name="submit" value="SUBMIT">
        </form>

    </main>
</body>

</html>