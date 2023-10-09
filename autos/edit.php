<?php
session_start();

if (!isset($_SESSION['email'])) {
    die('Not logged in');
}

require './conn.php';
$db = new DB();
$pdo = $db->getPDO();
/* FORM TO UPDATE A PROFILE */
if (isset($_GET['id'])) {
    $_SESSION['id'] = $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM autos WHERE id = :id');
    $stmt->execute(array(':id' => $_GET['id']));
    $car = $stmt->fetch();  
}

if (isset($_POST['Save']) && isset($_POST['model']) && isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['id'])) {
    if (strlen($_POST['model']) < 1 || strlen($_POST['make']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
        $_SESSION['fail'] = 'All values are required';
        header("Location: edit.php?id=" . urlencode($_SESSION['id']));
        return;
    }
        $stmt = $pdo->prepare('UPDATE autos SET (model, make, year, mileage) = (:model, :make, :year, :mileage) 
            WHERE id = :id
        ');
        $stmt->execute(array(
            ':id' => $_POST['id'],
            ':model' => $_POST['model'],
            ':make' => $_POST['make'],
            ':year' => $_POST['year'],
            ':mileage' => $_POST['mileage']
        ));
        $_SESSION['success'] = "updated";
        header("Location: index.php");
        return;
    }


if (isset($_POST['cancel'])) {
    header("Location: autos.php");
    return;
}
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
    <p>First Name: <input type="text" name="first_name" <br/></p>

    <label for="model">Model</label>
    <input type="text" name="model" value="<?php echo isset($_POST['model']) ? $_POST['model'] : $car['model']; ?>"/>
    <label for="make">Make</label>
    <input type="text" name="make" value="<?php $car['make'] ? isset($car) || $car != ''  : ''; ?>">
    <label for="year">Year</label>
    <input type="text" name="year" value="<?php $car['year'] ? isset($car) || $car != ''  : ''; ?>">
    <label for="mileage">Mileage</label>
    <input type="text" name="mileage" value="<?php $car['mileage'] ? isset($car) || $car != ''  : ''; ?>">
    <input type="hidden" name="profile_id" value="<?php $car['id'] ? isset($car) || $car != ''  : ''; ?>">
    <input type="submit" name="submit" value="Save">
    <input type="submit" name="cancel" value="Cancel">
    </form>
    </div>
</body>
</html>