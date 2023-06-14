<!-- CONTROLER-->
<?php
    session_start();
    include_once("./header.php");
?> 
<!-- VIEW-->

<body>
    <h1>Welcome to Broken Rock Paper Scissor</h1>
    <br>
    <a href="login.php">Please Log In</a>
    <br>
    <!-- Attempt to go to game.php without logging in - it should fail with an error message.-->
    <a href="game.php">Play Rock Paper Scissor</a>
</body>
</html>