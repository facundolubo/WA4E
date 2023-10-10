<?php
session_start();
include_once 'header.php' ;

if (!isset($_SESSION['name'])) {
    die('Not logged in');
}

require './DB.php';
$db = new DB();
$pdo = $db->getPDO();

if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email'])
    && isset($_POST['headline']) && isset($_POST['summary'])) {
    if (strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 ||
        strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: add.php");
        return;
    } 
    else {
        $stmt = $pdo->prepare('INSERT INTO Profile (user_id,first_name, last_name, email, headline, summary)
            VALUES (:user_id, :first_name, :last_name, :email, :headline,:summary)');
        
        $stmt->execute(array(
                ':user_id' => $_SESSION['user_id'],
                ':first_name' => $_POST['first_name'],
                ':last_name' => $_POST['last_name'],
                ':email' => $_POST['email'],
                ':headline' => $_POST['headline'],
                ':summary' => $_POST['summary'])
        );
        $_SESSION['success'] = "added";
        header("Location: index.php");
        return;
    }

}

else $_SESSION['fail']="All fields are required";

?>

<!DOCTYPE html>
<html>
<head>
    <?php
        require './bootstrap.php';
    ?>
<title> Facundo Lubo's Add registry</title>
</head>
<body>
    <div class="container">
        <h1> Add new profile </h1>
        <?php
        if (isset($_SESSION['fail'])) {
            echo('<p style="color: red;">' . htmlentities($_SESSION['fail']) . "</p>");
            unset($_SESSION['fail']);
        }
        ?>
    <form method="POST">
        <p>First Name: <input type="text" name="first_name" /><br/></p>
        <p>Last Name: <input type="text" name="last_name" /><br/></p>
        <p>Email: <input type="text" name="email" /><br/></p>
        <p>Headline: <input type="text" name="headline" /><br/></p>
        <p>Summary: <input type="text" name="summary" /><br/></p>
        <input name="Add" type="submit" value="Submit">
    </form>
    </div>
</body>
</html>

