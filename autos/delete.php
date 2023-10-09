
<?php
/* i want to delete a profile. 
    i have the id of the profile i want to delete.
    I want to Did find a form with a "Delete" button
    Looking for the form with a value="Delete" submit button
    */
    
session_start();
if (!isset($_SESSION['email'])) {
    die('Not logged in');
}

if (isset($_GET['id'])) {
    require './conn.php';
    $db = new DB();
    $pdo = $db->getPDO();
    $stmt = $pdo->prepare('SELECT * FROM autos WHERE id = :id');
    $stmt->execute(array(
        ':id' => $_GET['id']
    ));
    $auto = $stmt->fetch();
    echo "<h1>Delete auto" . $auto['model'] . "</h1>";
    echo "<p>Are you sure you want to delete this auto ?</p>";
    echo "<p><b>Model: </b>" . $auto['model'] . "</p>";
    echo "<p><b>Make: </b>" . $auto['make'] . "</p>";
    echo "<p><b>Year: </b>" . $auto['year'] . "</p>";
    echo "<p><b>Mileage: </b>" . $auto['mileage'] . "</p>";
    echo "<form method='POST'>";
    echo "<input type='hidden' name='id' value='" . $auto['id'] . "'>";
    echo "<input type='submit' name='submit' value='Delete'>"
    . "<input type='button' value='Cancel' onclick='location.href=\"autos.php\"'>";
    echo "</form>";
    // Delete auto idom the database if the user confirms
    if (isset($_POST['submit'])) {
        $stmt = $pdo->prepare('DELETE FROM autos WHERE id = :id');
        $stmt->execute(array(
            ':id' => $_POST['id']
        ));
        $_SESSION['success'] = "Deleted";
        header("Location: autos.php");
        return;
    }
    // Redirect the browser to the index page after successful deletion
    } else {
      $_SESSION['error'] = "Missing auto id";
    }
        
?>