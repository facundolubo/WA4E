<?php
session_start();
include_once('conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if ( isset($_POST['cancel'] ) ) {
		// Redirect the browser to game.php
		header("Location: index.php");
		return;
	}
	$username = $_POST['who'];
	$password = $_POST['pass'];
	// Validate input
	// Example: Check if the username and password fields are not empty
	if (empty($username) || empty($password)) {
		// Display an error message or redirect back to the login page
		$error = "Please enter both username and password";
	}
	else {
		// Prepare a select statement

		$query = "SELECT password FROM users WHERE username = :username";
		$stmt = $pdo->prepare($query);
		$stmt->bindParam(':username', $username);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
	
		$check = hash('md5', $salt.$_POST['pass']);
		if ( $check == $stored_hash ) {
			// Redirect the browser to game.php
			header("Location: game.php?name=".urlencode($_POST['who']));
			return;
		} else {
			$failure = "Incorrect password";
		}
		}
		if ($result) {
			$hashedPasswordFromDatabase = $result['password'];
		} 
		else {
			// The username does not exist in the database
			$error = "Invalid username";
		}
	}

?>
<!-- VIEW-->
<!DOCTYPE html>
<html>
<head>
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
</html>