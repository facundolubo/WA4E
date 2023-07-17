<?php
session_start();
include_once('conn.php');

if (!isset($_GET['name'])) {
	die("Name parameter missing");
}
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
}

/*If the user has pressed the "Add" button and the data passes validation, you can add the automobile to the database using an INSERT statement.*/
if (isset($_POST['add'])) {
    $stmt = $pdo->prepare('INSERT INTO autos
        (make, year, mileage) VALUES ( :mk, :yr, :mi)');
    $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'])
    );
    $_SESSION['new_car'] = $_POST['make'] . " " . $_POST['year'] . " " . $_POST['mileage'];
}

?>
<html>
<head>
<title> Facundo Lubo's Sign In Page</title>
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
    <h1> Tracking Autos for <?php echo $_GET['name']; ?></h1>
    <?php
    if (isset($_SESSION['new_car'])) {
        echo "<p style=\"color: green\">Record inserted: " . $_SESSION['new_car'] . "</p>";
        unset($_SESSION['new_car']);
    }
    ?>
<form method="POST">
<label for="make">Make</label>
<input type="text" name="make">
<label for="year">Year</label>
<input type="text" name="year">
<label for="mileage">Mileage</label>
<input type="text" name="mileage">
<br>
<input type="submit" name="add" value="Add">
<input type="submit" name="logout" value="Logout">
</form>
<table>
    <h1>Automobiles</h1>
    <thead>
        <tr>
            <th>Make</th>
            <th>Year</th>
            <th>Mileage</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $stmt = $pdo->prepare('SELECT * FROM autos');
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['make'] . "</td>";
            echo "<td>" . $row['year'] . "</td>";
            echo "<td>" . $row['mileage'] . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
</body>
</html>