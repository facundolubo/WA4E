<?php
#view.php show the detail for a particular entry. 
#This works even is the user is not logged in. (read)

echo "Printing the array";
print_r($_GET);

require './DB.php';
$db = new DB();
$pdo = $db->getPDO();
$stmt = $pdo->prepare('SELECT * FROM Profile WHERE user_id = :uid');
$stmt->execute(array(
    ':uid' => $_GET['profile_id']
));

#view.php
// Check if user is logged in
$loggedIn = false; // Assume user is not logged in

// Check if profile_id is set in the query string
if (isset($_GET['profile_id'])) {
    $profileId = $_GET['profile_id'];

    // Fetch profile details from the database
    // ...

    // Display profile details
    echo "<h1>Profile Details</h1>";

    // ...

    if ($loggedIn) {
        echo "<p><a href='edit.php?profile_id=$profileId'>Edit Profile</a></p>";
        echo "<p><a href='delete.php?profile_id=$profileId'>Delete Profile</a></p>";
    }
} else {
    echo "<p>Invalid profile ID.</p>";
}
?>

