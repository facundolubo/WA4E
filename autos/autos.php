<?php
if (!isset($_GET['name'])) {
	die("Name parameter missing");
}
/*If the Logout button is pressed the user should be redirected back to the index.php page using:*/
#header('Location: index.php');
/*If the user has pressed the "Add" button and the data passes validation, you can add the automobile to the database using an INSERT statement.

...
    $stmt = $pdo->prepare('INSERT INTO autos
        (make, year, mileage) VALUES ( :mk, :yr, :mi)');
    $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'])
    );
...
*/
?>

</body>
</html>