<?php
session_start();
require './conn.php';
$db = new DB();
$pdo = $db->getPDO();
$salt = 'XyZzy12*_';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	if ( isset($_POST['cancel'] ) ) {
		// Redirect the browser to game.php
		header("Location: index.php");
		return;
	}
	$email = $_POST['email'];
	$password = $_POST['pass'];
	// Validate input
	// Example: Check if the email and password fields are not empty
	if (empty($email) || empty($password)) {
		// Display an error message or redirect back to the login page
		$error = "Please enter both email and password";
	}
	else if (!str_contains($email , "@")) {
		$error = "Invalid email characters (without @)";
	}
	else {
		try {
		// Prepare a select statement
		$query = 'SELECT * FROM users WHERE email = :email';
		/*echo "<br/>" . "Query: " . $query . "<br/>";
		echo "<br/>" . "Username: " . $email . "<br/>";
		*/
		$stmt = $pdo->prepare($query);
		$stmt->bindParam(':email', $email);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		//echo "<br/>" . "Result: " . print_r($result, true) . "<br/>";
		if (empty($result['email'])) {
			$error = "Inexisting email: " . $email . "<br/>" ; 
		}
		else if (hash('md5', $salt . $password) !== $result['password']) {
			$error = "Incorrect password " . $salt . $password . " for " . $email . "Hash: " . $result['password'];
		}
		else {
			$_SESSION['email'] = $email;
            header("Location: autos.php?name=".urlencode($_POST['email']));
		}
	}
		catch (PDOException $e) {
		//in case the password is incorrect or the email does not exist
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
<input type="text" name="email" id="email"><br/>
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