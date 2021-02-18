<?php
echo $POST['username'] . $POST['password'];
if (isset($POST['username']) && isset($POST['password'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    registerUser($username, $hashedPassword); 
} else {
    header('Location: /week_07/sign_up.php');
    die();
}

function registerUser($username, $password) {
    $db = dbConnect();
    $sql = 'INSERT INTO user (username, password) VALUES (:username, :password)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>W07 | Team Assignment</title>
    <link href="index.css" rel="stylesheet">
</head>

<body>
    <main>
        <form action="welcome.php" method="POST">
            <h1>SIGN IN</h1><br>
            <input type="text" name="username" placeholder="Username"><br>
            <input type="password" name="password" placeholder="Password" ><br>
            <input type="submit" name="submit" value="SIGN IN">
            <p><a href="sign_up.php">Don't have an account? Sign up here</a></p>
        </form>

    </main>
</body>

</html>