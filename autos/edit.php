<?php
session_start();

if (!isset($_SESSION['email'])) {
    die('Not logged in');
}

require './conn.php';
$db = new DB();
$pdo = $db->getPDO();

if (isset($_GET['id'])) {
    $_SESSION['id'] = $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM autos WHERE id = :id');
    $stmt->execute(array(':id' => $_GET['id']));
    $car = $stmt->fetch();  
}

if (isset($_POST['model']) && isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['id'])) {
    if (strlen($_POST['model']) < 1 || strlen($_POST['make']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
        $_SESSION['fail'] = 'All values are required';
        header("Location: edit.php?id=" . urlencode($_SESSION['id']));
        return;
    }
    /* check if year and mileage are numbers */
    if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $_SESSION['fail'] = 'Year and mileage must be numeric';
        header("Location: edit.php?id=" . urlencode($_SESSION['id']));
        return;
    }
    /* FORM TO UPDATE A PROFILE */
    $stmt = $pdo->prepare('UPDATE autos
    SET model = :model,
        make = :make,
        year = :year,
        mileage = :mileage
        WHERE id = :id
    ');
    $stmt->execute(array(
        ':id' => $_POST['id'],
        ':model' => $_POST['model'],
        ':make' => $_POST['make'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage']
    ));
    $_SESSION['success'] = $car['model'] . " updated";
    header("Location: autos.php");
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
        if (isset($_SESSION['success'])) {
            echo('<p style="color: green;">' . htmlentities($_SESSION['success']) . "</p>");
            unset($_SESSION['success']);
        }
        ?>
    <form method="POST">
    <!-- edit a record of an auto with fields: model, make, year, mileage -->
    <label for="model">Model</label>
    <input type="text" name="model" value="<?php echo isset($_POST['model']) ? $_POST['model'] : $car['model']; ?>"/>
    <label for="make">Make</label>
    <input type="text" name="make" value="<?php echo isset($_POST['make']) ? $_POST['make'] : $car['make']; ?>"/>
    <label for="year">Year</label>
    <input type="text" name="year" value="<?php echo isset($_POST['year']) ? $_POST['year'] : $car['year']; ?>"/>
    <label for="mileage">Mileage</label>
    <input type="text" name="mileage" value="<?php echo isset($_POST['mileage']) ? $_POST['mileage'] : $car['mileage']; ?>"/>
    <input type="hidden" name="id" value="<?php echo isset($_POST['id']) ? $_POST['id'] : $car['id']; ?>"/>
    <input type="submit" name="submit" value="Save">
    <input type="submit" name="cancel" value="Cancel">
    </form>
    </div>
</body>
</html>