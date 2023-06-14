<?php
    include_once("./header.php");
?>
<head>
    <title>Facundo Lubo's Login Page</title>
</head>
<body>
    <h1>Please Log In</h1>
    <form action="./auth_login.php" method="post">
        <label for="username"> Username </label>
        <input type="text" name="username" id="user">
        <br>
        <label for="password"> Password </label>
        <input type="password" name="password" id="pwd">
        <br>
        <input type="submit" name="login" value="Log in">
        <input type="submit" name="cancel"value="Cancel">
    </form>
</body>