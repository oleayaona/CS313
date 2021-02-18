<?php
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $user = getUser($username);
    // no username match
    if (empty($user)) {
        echo "No user amtch";
        include 'sign_up.php';
        die();
    }

    $hashCheck = password_verify($password, $user['password']);
    echo "hascheck: " . $hashCheck;
    if (!$hashCheck) {
        echo "Password no match";
        include 'sign_up.php';
        // header('Location: /week_07/sign_up.php');
        die();
    }

} else {
    echo "Missing input";
    include 'sign_up.php';
    // header('Location: /week_07/sign_up.php');
    die();
}

if (isset($_SESSION['username'])) {
    $user = $_SESSION['username'];
} else {
    header('Location: /week_07/sign_up.php');
    die();
}

function getUser($username) {
    $db = dbConnect();
    echo "Connected!";
    $sql = 'SELECT * FROM public.user WHERE username = :username';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC); 
    $stmt->closeCursor();
    echo "</pre>" . print_r($user, true) . "</pre>";
    return $user;
}


function dbConnect(){
    
    try {
		// default Heroku Postgres configuration URL
		$dbUrl = getenv('DATABASE_URL');

		// Get the various parts of the DB Connection from the URL
		$dbopts = parse_url($dbUrl);

		$dbHost = $dbopts["host"];
		$dbPort = $dbopts["port"];
		$dbUser = $dbopts["user"];
		$dbPassword = $dbopts["pass"];
		$dbName = ltrim($dbopts["path"],'/');

		// Create the PDO connection
		$db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);

		// this line makes PDO give us an exception when there are problems, and can be very helpful in debugging!
		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

		return $db;
	}
	catch (PDOException $e) {
		echo "Error connecting to DB. Details: $e";
		// header('Location: /web/shop/view/500.php');
		exit;
	}

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