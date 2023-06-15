<?php
/*index.php Will present a list of all profiles in the system with a link to a detailed view
with view.php whether or not you are logged in. If you are not logged in, you will be given a link to login.php. 
If you are logged in you will see a link to add.php 
add a new resume and links to delete or edit any resumes that are owned by the logged in user.
*/
// BARD:


// Check if the user is logged in
if (isset($_SESSION['user_id'])) {

    // Get all profiles
    $profiles = get_profiles();

    // Loop through the profiles and create a list
    foreach ($profiles as $profile) {

        // Create a link to the detailed view
        $link = '<a href="view.php?id=' . $profile['id'] . '">View</a>';

        // Check if the user is the owner of the profile
        if ($profile['user_id'] == $_SESSION['user_id']) {

            // Add links to delete and edit the profile
            $link .= ' | <a href="delete.php?id=' . $profile['id'] . '">Delete</a> | <a href="edit.php?id=' . $profile['id'] . '">Edit</a>';
        }

        // Output the profile
        echo '<li>' . $link . '</li>';
    }

}

?>

<!DOCTYPE html>
<html>
<head>
<title>Facundo Lubo's Resume Registry</title>
<!-- bootstrap.php - this is HTML -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" 
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" 
    crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" 
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" 
    crossorigin="anonymous">

</head>
<body>
<div class="container">
<h1> Facundo Lubo's Resume Registry</h1>
<p><a href="login.php">Please log in</a></p>
<table border="1">
    <tr><th>Name</th><th>Headline</th><tr>
    <tr><td>
    <a href="view.php?profile_id=16467">DSADASDAS DSADASDAS</a></td><td>DASDA</td></tr>
</table>
<p>
<b>Note:</b> Your implementation should retain data across multiple
logout/login sessions.  This sample implementation clears all its
data periodically - which you should not do in your implementation.
</p>
</div>
</body>
