<?php
session_start();

if (!isset($_SESSION['email'])) {
    die('Not logged in');
}

require './conn.php';
$db = new DB();
$pdo = $db->getPDO();
/* FORM TO UPDATE A PROFILE */
if (isset($_POST['model']) && isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']))
     {
        $stmt = $pdo->prepare('UPDATE autos
            SET (model, make, year, mileage) = (:model, :make, :year, :mileage)
        ');
        $stmt->execute(array(
            ':model' => $_POST['model'],
            ':make' => $_POST['make'],
            ':year' => $_POST['year'],
            ':mileage' => $_POST['mileage']
        ));
        $_SESSION['success'] = "updated";
        header("Location: index.php");
        return;
    }

}

else $_SESSION['fail']= "All fields are required";

?>

<!DOCTYPE html>
<html>
<head>
<title> Facundo Lubo's Edit registry</title>
</head>
<body>
    <div class="container">
        <h1> Edit the autos of <?php echo htmlentities($_SESSION['email']); ?> </h1>
        <?php
        if (isset($_SESSION['fail'])) {
            echo('<p style="color: red;">' . htmlentities($_SESSION['fail']) . "</p>");
            unset($_SESSION['fail']);
        }
        if (isset($_SESSION['fail_email'])) {
            echo('<p style="color: red;">' . htmlentities($_SESSION['fail_email']) . "</p>");
            unset($_SESSION['fail']);
        }
        if (isset($_SESSION['success'])) {
            echo('<p style="color: green;">' . htmlentities($_SESSION['success']) . "</p>");
            unset($_SESSION['success']);
        }
        ?>
    <form method="POST">
    <!-- edit a record of an auto with fields: model, make, year, mileage -->
    <label for="model">Model</label>
    <input type="text" name="model" value="">
    <label for="make">Make</label>
    <input type="text" name="make" value="">
    <label for="year">Year</label>
    <input type="text" name="year" value="">
    <label for="mileage">Mileage</label>
    <input type="text" name="mileage" value="">
    <input type="submit" name="submit" value="Submit">
    <input type="submit" name="cancel" value="Cancel">
    </form>
    </div>
</body>
</html>