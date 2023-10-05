
<?php
/* i want to delete a profile. */
session_start();

// Check if profile_id is set in the query string
if (isset($_GET['profile_id'])) {
    //$confirm = false;
    $profileId = $_GET['profile_id'];
    // Delete profile from the database
    require './DB.php';
    $db = new DB($_SESSION['pass']);
    $pdo = $db->getPDO();
    $stmt = $pdo->prepare('DELETE FROM Profile WHERE profile_id = :profileId');
    $stmt->execute(array(':profileId' => $profileId));
    // Redirect the browser to the index page after successful deletion
    header("Location: index.php");
    exit();
}
?>