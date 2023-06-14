<?php 
/*
will log the user out by clearing data in the session and redirecting back to index.php.
This file can be very short - similar to the following:

session_start();
unset($_SESSION['name']);
unset($_SESSION['user_id']);
header('Location: index.php');

*/
session_start();
unset($_SESSION['name']);
unset($_SESSION['user_id']);
header('Location: index.php');
?>