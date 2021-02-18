<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>W07 | Team Assignment</title>
    <link href="index.css" rel="stylesheet">
</head>

<body>
    <main>
    <p id="alert"></p>
        <form action="sign_in.php" method="POST" id="form">
            <h1>SIGN UP</h1>
            <input type="text" name="username" id="username" placeholder="Username">
            <input type="text" name="password" id="password" placeholder="Password" >
            <input type="text" name="repeat" id="repeat" placeholder="Type password again" >
            <input type="submit" name="submit" id="submit" value="SIGN IN">
        </form>

    </main>
<script>

document.getElementById("#submit").addEventListener("click", function(event){
  event.preventDefault()
});

let password = document.querySelector('#password');
let repeat = document.querySelector('#repeat');

const form = document.querySelector("#form");

if (password == repeat) {
    form.submit();
} else {
    const alert = document.querySelector('#alert');
    alert.innerHTML = "Passwords don't match. Try again.";
}

</script>
</body>

</html>
