
<?php
/* i want to delete a profile. 
    i have the id of the profile i want to delete.
    I want to Did find a form with a "Delete" button
    Looking for the form with a value="Delete" submit button
    */
    
session_start();
    //load the profile
if (isset($_GET['profile_id'])) {
    require './DB.php';
    $db = new DB();
    $pdo = $db->getPDO();
    $stmt = $pdo->prepare('SELECT * FROM Profile WHERE profile_id = :pid');
    $stmt->execute(array(
        ':pid' => $_GET['profile_id']
    ));
    $profile = $stmt->fetch();
    echo "<h1>Delete Profile</h1>";
    echo "<p>Are you sure you want to delete this profile?</p>";
    echo "<p><b>First Name: </b>" . $profile['first_name'] . "</p>";
    echo "<p><b>Last Name: </b>" . $profile['last_name'] . "</p>";
    echo "<p><b>Email: </b>" . $profile['email'] . "</p>";
    echo "<p><b>Headline: </b>" . $profile['headline'] . "</p>";
    echo "<p><b>Summary: </b>" . $profile['summary'] . "</p>";
    echo "<p><b>User ID: </b>" . $profile['user_id'] . "</p>";
    echo "<p><b>Profile ID: </b>" . $profile['profile_id'] . "</p>";
    echo "<form method='POST'>";
    echo "<input type='hidden' name='profile_id' value='" . $profile['profile_id'] . "'>";
    echo "<input type='submit' name='submit' value='Delete'>"
        . "<input type='button' value='Cancel' onclick='location.href=\"index.php\"'>";
    echo "</form>";
    // Delete profile from the database if the user confirms
    if (isset($_POST['submit'])) {
        $stmt = $pdo->prepare('DELETE FROM Profile WHERE profile_id = :pid');
        $stmt->execute(array(
            ':pid' => $_POST['profile_id']
        ));
        $_SESSION['success'] = "Deleted";
        header("Location: index.php");
        return;
    }
    // Redirect the browser to the index page after successful deletion
} else {
    $_SESSION['error'] = "Missing profile_id";
}

?>