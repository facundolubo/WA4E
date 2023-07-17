<?php
session_start();
include_once('header.php');
?>
<body>
<main>
<div class="container">
<?php

if (isset($_SESSION['new_user'])) {
	echo "<p style=\"color: green\">" . $_SESSION['msg'] . "That was green. </p>"; 	
	unset($_SESSION['new_user']);
	unset($_SESSION['msg']);
}
?>
<p>
Attempt to go to 
<a href="autos.php">autos.php</a> without logging in - it should fail with an error message.
<p>
<a href="https://www.wa4e.com/assn/autosdb/" target="_blank">Specification for this Application</a>
</p>
<p>
<b>Note:</b> Your implementation should retain data across multiple
logout/login sessions.  This sample implementation clears all its
data on logout - which you should not do in your implementation.
</p>
</div>
</main>
</body>