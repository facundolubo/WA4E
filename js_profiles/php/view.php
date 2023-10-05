<?php
#view.php show the detail for a particular entry. 
#This works even is the user is not logged in. (read)

session_start();

#view.php
// Check if user is logged in
$loggedIn = false; // Assume user is not logged in

// Check if profile_id is set in the query string
if (isset($_SESSION['user_id'])) {
    $loggedIn = true;
    $profileId = $_GET['profile_id'];
    echo "<h1>Profile Details</h1>";
    require './DB.php';
    $db = new DB();
    $pdo = $db->getPDO();
    $stmt = $pdo->prepare('SELECT * FROM Profile WHERE profile_id = :pid');
    $stmt->execute(array(
        ':pid' => $profileId
    ));
    $profile = $stmt->fetch();
    $profile = $profile;
    echo "<p> <b> First Name: </b>" . $profile['first_name'] . "</p>";
    echo "<p> <b> Last Name: </b>" . $profile['last_name'] . "</p>";
    echo "<p> <b> Email: </b>" . $profile['email'] . "</p>";
    echo "<p> <b> Headline: </b>" . $profile['headline'] . "</p>";
    echo "<p> <b> Summary: </b>" . $profile['summary'] . "</p>";
    if ($profile['user_id'] == $_SESSION['user_id']) {
        echo "<p><a href='edit.php?profile_id=$profileId'>Edit Profile</a> | <a href='delete.php?profile_id=$profileId'>Delete Profile</a></p>";
    }
    echo "<p><a href='index.php'>View All Profiles</a></p>";
}
    else {
        echo "<p>Invalid profile ID.</p>";
    }
?>

