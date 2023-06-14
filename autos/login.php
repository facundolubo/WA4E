<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['who'];
    $password = $_POST['pass'];
// Validate input
// Example: Check if the username and password fields are not empty
if (empty($username) || empty($password)) {
    // Display an error message or redirect back to the login page
    $error = "Please enter both username and password";
}

// Query the database to retrieve the hashed password for the given username
// Example: Use PDO or mysqli to connect to the database and retrieve the hashed password
// Assuming you are using PDO:
$query = "SELECT password FROM users WHERE username = :username";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
	$hashedPasswordFromDatabase = $result['password'];
} else {
	// The username does not exist in the database
	$error = "Invalid username";
}

// Validate input
if ($username == 'fred' && $password == 'zap') {

// Query the database to retrieve the hashed password for the given username

// Verify credentials
if (password_verify($password, $hashedPasswordFromDatabase)) {
	// Authentication successful
	$_SESSION['username'] = $username;
	header('Location: index.php'); // Redirect to the welcome page
	exit();
} 
else {
	// Invalid credentials
	$error = "Invalid username or password";
}
}
?>
<!-- VIEW-->
<!DOCTYPE html>
<html>
<head>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<title> Facundo Lubo's Login Page</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<form method="POST">
<label for="nam">User Name</label>
<input type="text" name="who" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: The password is the three character name of the 
programming language used in this class (all lower case) 
followed by 123. -->
</p>
</div>
</body>
