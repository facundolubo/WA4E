<?php 
/*login.php will present the user the login screen with an email address and password to get the user to log in. 
If there is an error, redirect the user back to the login page with a message. 
If the login is successful, redirect the user back to index.php after setting up the session.
In this assignment, you will need to store the user's hashed password in the users table as described below.

Since the email address and salted hash are stored in the database, we must use a different approach than in the previous assignment to check to see if the email and password match using the following approach:
*/
session_start();
if (isset($_POST['email']) && isset($_POST['pass'])) { 
    require './DB.php';
    $salt = 'XyZzy12*_';
    $db = new DB($_SESSION['pass']);
    $pdo = $db->getPDO();
    
    $check = hash('md5', $salt.$_POST['pass']);
    $stmt = $pdo->prepare('SELECT user_id, name FROM users
        WHERE email = :em AND password = :pw');
    $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    print($row);
    /*
    Since we are checking if the stored hashed password matches the hash computation of the user-provided password, 
    If we get a row, then the password matches, if we don't get a row (i.e. $row is false) then the password did not match. 
    If he password matches, put the user_id value for the user's row into session as well as the user's name:
        /*
        Make sure to redirect back to login.php with an error message when there is no row selected.
    */
    if ( $row !== false ) {
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];
        // Redirect the browser to index.php
        header("Location: index.php");
    }
    else {
        // Redirect the browser to login.php with an error message
        $_SESSION['message'] = 'Invalid email or password';
        echo $_SESSION['message'];
        unset($_SESSION['message']);
        }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Facundo Lubo's Login Page</title>
    <link rel="stylesheet" 
        href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" 
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" 
        crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" 
        href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" 
        integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" 
        crossorigin="anonymous">
</head>
<body>
    <div class="container">
    <h1>Please Log In</h1>
    <form method="POST" action="login.php">
        <label for="email">Email</label>
        <input type="text" name="email" id="email"><br/>
        <label for="id_1723">Password</label>
        <input type="password" name="pass" id="id_1723"><br/>
        <input type="submit" onclick="return doValidate();" value="Log In">
        <input type="submit" name="cancel" value="Cancel">
    </form>
    <br>

    <script>
    function doValidate() {
        console.log('Validating...');
        try {
            addr = document.getElementById('email').value;
            pw = document.getElementById('id_1723').value;
            console.log("Validating addr=" + addr + " pw=" + pw);
            if (addr == null || addr == "" || pw == null || pw == "") {
                alert("Both fields must be filled out");
                return false;
                }
            if (addr.indexOf('@') == -1 ) {
                alert("Invalid email address");
                return false;
                }
            return true;
        }
        catch(e) {
            return false
        }    
        return false;
    }
    </script>
    </div>
</body>
</html>