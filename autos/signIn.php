<?php 
include_once('conn.php');
//if cancel, then go to index.php
if (isset($_POST['cancel'])) {
    header("Location: index.php");
    return;
}
//Create user and store it in the database with a hashed password
if (isset($_POST['username']) && (isset($_POST['pass1'])) && (isset($_POST['pass2']))) {
    //check if the username is valid. Validate that has between 6 and 16 characters and contains only letters and numbers
    if (strlen($_POST['username']) < 6 || strlen($_POST['username']) > 16 || !preg_match("/^[a-zA-Z0-9]+$/", $_POST['username'])) {
        $msg = "Your username must be between 6 and 16 characters and contain only letters and numbers";
        /*header("Location: signIn.php");*/
    }
    else if ($_POST['pass1'] != $_POST['pass2']) {
        $msg = "Passwords do not match";
    }
    else {
        password_hash($_POST['pass1'], PASSWORD_DEFAULT, $result);
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->execute(array(
            ':username' => $_POST['username'],
            ':password' => $result
        ));
        $msg = "Successfully registered";
    }
}

?>
<!-- VIEW-->
<!DOCTYPE html>
<html>
<head>
<title> Facundo Lubo's Sign In Page</title>
<style>
.error {
    color: #FF0000;
}
</style>
</head>
<body>
<div class="container">
<h1>Please Sign In</h1>
<?php 
if (isset($msg)) {
    echo ("<p class=\"error\">" . $msg ."</p>");
}
?>
<form method="POST">
<label for="name">Username</label>
<input type="text" name="username"><br/>
<label for="pass1">Password</label>
<input type="text" name="pass1"><br/>
<label for="pass2">Confirm Password</label>
<input type="text" name="pass2"><br/>
<input type="submit" value="Sign In">
<input type="submit" name="cancel" value="Cancel">
</form>

</div>
</body>
</html>