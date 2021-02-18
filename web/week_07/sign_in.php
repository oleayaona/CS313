<?php
echo $_POST['username'] . " " . $_POST['password'];
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    echo $_POST['username'] . " " . $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    echo $username . " " . $hashedPassword;
    registerUser($username, $hashedPassword); 
    echo "REGISTERED!";
} else {
    header('Location: /week_07/sign_up.php');
}

function registerUser($username, $password) {
    $db = dbConnect();
    echo "CONNECTED!";
    $sql = 'INSERT INTO public.user (username, password) VALUES (:username, :password)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $stmt->execute();
    $stmt->closeCursor();
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