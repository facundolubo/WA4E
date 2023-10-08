<!-- Expecting POST to Redirected to a GET-->
<?php
session_start();
require './conn.php';
$db = new DB();
$pdo = $db->getPDO();

if (!isset($_SESSION['email'])) {
    die('Not logged in');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if ( isset($_POST['Cancel'] ) ) {
            // Redirect the browser to autos.php
            header("Location: autos.php?name=".urlencode($_SESSION['email']));
            return;
        }
        else if (isset($_POST['Add'])) {
            if (!isset($_POST['make']) || $_POST['make'] == '') {
                $_SESSION['error'] = "Make is required";
                header("Location: add.php");
                return;
            }
            if (!isset($_POST['year']) || $_POST['year'] == '') {
                $_SESSION['error'] = "Year is required";
                header("Location: add.php");
                return;
            }
            /* year and mileage must be numeric */
            if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
                $_SESSION['error'] = "Mileage and year must be numeric";
                header("Location: add.php");
                return;
            }
            if (!isset($_POST['mileage']) || $_POST['mileage'] == '') {
                $_SESSION['error'] = "Mileage is required";
                header("Location: add.php");
                return;
            }
            $query = 'INSERT INTO autos (make, year, mileage) VALUES (:make, :year, :mileage)';
            $stmt = $pdo->prepare($query);
            $stmt->execute(array(
                ':make' => htmlentities($_POST['make']),
                ':year' => htmlentities($_POST['year']),
                ':mileage' => htmlentities($_POST['mileage'])
            ));
            $_SESSION['success'] = "Record inserted";
            header("Location: autos.php?name=".urlencode($_SESSION['email']));
            return;
        }
    } catch (PDOException $e) {
        //in case the password is incorrect or the email does not exist
        if ($e->getCode() == 23000) {
            $error = "Some error occurred";
        }
        /* for debugging */
        echo "Error: " . $e->getMessage();
    }
}


?>
<!-- VIEW-->
<!DOCTYPE html>
<html>
<head>
<title> Facundo Lubo's Add New Page</title>
<style>
    body form label {
        display: block;
    }
    body form input {
        display: inline-block;
    }
</style>
</head>
<body>
<?php
if (isset($_SESSION['error'])) {
    echo('<p style="color: red;">' . $_SESSION['error'] . "</p>");
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    echo('<p style="color: green;">' . $_SESSION['success'] . "</p>");
    unset($_SESSION['success']);
}
?>
<form method="POST" action="add.php" >
<label for="make">Make</label>
<input type="text" name="make">
<label for="year">Year</label>
<input type="text" name="year">
<label for="mileage">Mileage</label>
<input type="text" name="mileage">
<br>
<button type="submit" name="Add" value="Add">Add</button>
<button type="submit" name="Cancel" value="Cancel">Cancel</button>
</form>
</body>