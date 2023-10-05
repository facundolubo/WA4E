<?php
/*index.php Will present a list of all profiles in the system with a link to a detailed view
with view.php whether or not you are logged in. If you are not logged in, you will be given a link to login.php. 
If you are logged in you will see a link to add.php 
add a new resume and links to delete or edit any resumes that are owned by the logged in user.
*/

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL); 

/*

I've replaced those 3 lines above for 2 modifications in the /etc/php/8.1/fpm/php.ini
and the /etc/php/8.1/cli/php.ini file:
    display_errors On
    display_startup_errors On

and then I've reload it with: systemctl restart php8.1-fpm.service 

*/
session_start();
$_SESSION['pass'] = file_get_contents('../sql/mysql_dumb_passwords');
if (isset($_SESSION['name'])) {
    echo 'Welcome, ' . $_SESSION['name'] . '! <br />';
}
require 'DB.php';
$db = new DB($_SESSION['pass']);
$pdo = $db->getPDO();
$stmt = $pdo->prepare('SELECT * FROM Profile');
$stmt->execute();
$profiles = $stmt->fetchAll();
#echo "Printing the session array: \n "; print_r($_SESSION);
$profiles_table = array();
// Loop through the profiles and create a list
foreach ($profiles as $profile) {
    // Create a link to the detailed view
    $tdName = '<a href="view.php?profile_id=' . $profile['profile_id'] . '">' . $profile['first_name'] . 
        ' ' . $profile['last_name'] . '</a>';
    // Check if the user is the owner of the profile
    // Output the profile
    $tdName = '<td>' . $tdName . '</td>';
    $tdHeadline = '<td>' . $profile['headline'] . '</td>';
    if ((isset($_SESSION['user_id']) && ($profile['user_id'] == $_SESSION['user_id']))) {
        // Add links to delete and edit the profile
        $tdAction = '<td> <a href="delete.php?profile_id=' . $profile['profile_id'] . '"> Delete </a> | <a href="edit.php?profile_id=' .
            $profile['profile_id'] . '"> Edit </a>' . '</td>';
        array_push($profiles_table, [$tdName, $tdHeadline, $tdAction]);
    }
    else array_push($profiles_table, [$tdName, $tdHeadline]);
}

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $addLink = '<a href="add.php"> Add new entry </a>';
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
<button type="button" onclick="window.location='login.php'">Login</button>
<button type="button" onclick="window.location='logout.php'">Logout</button>
<table border="1">
    <tr>
        <th>Name</th>
        <th>Headline</th>
        <th>Action</th>
    </tr>
    <?php 
        foreach ($profiles_table as $td) {
            echo "<tr>" . implode("", $td) . "</tr>";
        }
    ?>
</table>
<p>
    <?php if(isset($addLink)) echo $addLink; ?>
</p>
</div>
</body>
