<?php
if (!isset($_SESSION['username']))
    $_SESSION['username'] = $_POST['username']
?>
<html>
<body>
    <p>Your login info is</p>
    <ul>
        <li><b>username</b>: <?php echo $_POST['username']; ?></li>
    </ul>
</body>
</html>
<?php 
    footer("Location: login.php")
?>