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
		try {
		// Prepare a select statement
		$query = "SELECT * FROM users WHERE username = :username";
		$stmt = $pdo->prepare($query);
		$stmt->bindParam(':username', $username);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if (empty($result['username'])) {
			$error = "Inexisting username";
		}
		else if (!password_verify($password, $result['password'])) {
			$error = "Invalid password";
		}
		else {
			$_SESSION['username'] = $username;
            header("Location: autos.php?name=".urlencode($_POST['who']));
		}
	}
		catch (PDOException $e) {
		//in case the password is incorrect or the username does not exist
		if ($e->getCode() == 23000) {
			$error = "Some error occurred";
		}
		/* for debugging */
		echo "Error: " . $e->getMessage();
	}
	}
}
?>
<!-- VIEW-->
<!DOCTYPE html>
<html>
<head>
<title> Facundo Lubo's Login Page</title>
<style>
.error {
	color: red;
}
</style>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
if (isset($error)) {
	echo "<p class='error'>" . $error . "</p>";
}
?>
<form method="POST">
<label for="name">User Name</label>
<input type="text" name="who" id="name"><br/>
<label for="pass">Password</label>
<input type="text" name="pass" id="pass"><br/>
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
