<?php 
include_once('conn.php');
session_start();
//if cancel, then go to index.php
if (isset($_POST['cancel'])) {
    header("Location: index.php");
    return;
}
//Create user and store it in the database with a hashed password
if (isset($_POST['username']) && (isset($_POST['pass1'])) && (isset($_POST['pass2']))) {
    // Validation: extension and check valid email with an '@'. Only allows "_" and "." as special characters
    if (strlen($_POST['username']) < 8 || strlen($_POST['username']) > 32) {
        $msg = "Your username must be an email with an extension between 8 and 32 characters";
        /*header("Location: signIn.php");*/
    }
    else if (!preg_match("/^[a-zA-Z0-9@_.]+$/", $_POST['username'])) {
        $msg = "Invalid email characters";
    }
    else if (!str_contains($_POST['username'], "@")) {
        $msg = "Email must have an at-sign (@)";
    }
    else if ($_POST['pass1'] != $_POST['pass2']) {
        $msg = "Passwords do not match";
    }
    // pass length
    else if (strlen($_POST['pass1']) < 8 || strlen($_POST['pass1']) > 32) {
        $msg = "Your password must be between 8 and 32 characters";
    }
    //Your password must be between 8 and 32 characters and contain at least one number and one uppercase and lowercase letter
    else if (!preg_match('/[0-9]/', $_POST['pass1'])) {
        $msg = "You need a password with at least one number";
        $msg .= "<br/> You tried this password: " . $_POST['pass1'];
    }
    else if (!preg_match('/[A-Z]/', $_POST['pass1'])) {
        $msg = "You need a password with at least one uppercase letter";
        $msg .= "<br/> You tried this password: " . $_POST['pass1'];
    }
    else if (!preg_match('/[a-z]/', $_POST['pass1'])) {
        $msg = "You need a password with at least one lowercase letter";
        $msg .= "<br/> You tried this password: " . $_POST['pass1'];
    }
        
    else {
        try {
            $result = password_hash($_POST['pass1'], PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->execute(array(
                ':username' => $_POST['username'],
                ':password' => $result
            ));
            $_SESSION['new_user'] = $_POST['username'];
            $_SESSION['msg'] = "Successfully registered" . "<br/> Username: " . $_POST['username'] . "<br/> Email: " . $_POST['username'] . "<br/>" . " password: " . $_POST['pass1'] . "<br/> Hashed password: " . $result;
            header("Location: index.php");
        }
        catch (PDOException $e) {
            //in case the user already exists
            if ($e->getCode() == 23000) {
                $msg = "Username already exists";
            }
            else {
                $msg = "Error: " . $e->getMessage();
            }
        }
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
<input type="password" name="pass1"><br/>
<label for="pass2">Confirm Password</label>
<input type="password" name="pass2"><br/>
<input type="submit" value="Sign In">
<input type="submit" name="cancel" value="Cancel">
</form>

</div>
</body>
</html>