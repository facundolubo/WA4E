<?php
session_start();
require './conn.php';
$db = new DB();
$pdo = $db->getPDO();

if (!isset($_SESSION['email'])) {
    die('Not logged in');
}
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
<title> Facundo Lubo's Autos Page</title>
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
    if (isset($_SESSION['success'])) {
        echo "<p style=\"color: green\">" . $_SESSION['success'] . "</p>";
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo "<p style=\"color: red\">" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }
?>
    <h1> Tracking Autos for <?php echo $_GET['name']; ?></h1>
    <?php
    if (isset($_SESSION['new_car'])) {
        echo "<p style=\"color: green\">Record inserted: " . $_SESSION['new_car'] . "</p>";
        unset($_SESSION['new_car']);
    }
    ?>
<table>
    <h1>Automobiles</h1>
    <thead>
        <tr>
            <th>Model</th>
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
            echo "<td>" . $row['model'] . "</td>";
            echo "<td>" . $row['make'] . "</td>";
            echo "<td>" . $row['year'] . "</td>";
            echo "<td>" . $row['mileage'] . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<a href="add.php">Add New Entry</a>
<a href="logout.php">Logout</a>
</body>
</html>