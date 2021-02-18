<?php

if (isset($POST['username']) && isset($POST['password'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    $user = getUser($username);

    if (empty($user)) {
        header('Location: /week_07/sign_in.php');
        die();
    }
} else {
    header('Location: /week_07/sign_up.php');
    die();
}

$hashCheck = password_verify($password, $user['password']);
if (!$hashCheck) {
    header('Location: /week_07/sign_up.php');
    die();
}

if (isset($SESSION['username'])) {
    $user = $SESSION['username'];
} else {
    header('Location: /web/week_07/sign_up.php');
    die();
}

function getUser($username) {
    $db = dbConnect();
    $sql = 'SELECT * FROM user WHERE username = :username';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC); 
    $stmt->closeCursor();
    return $user;
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
        <h1>Welcome, <?php $user?></h1>
    </main>
</body>

</html>