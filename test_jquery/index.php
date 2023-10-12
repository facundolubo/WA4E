<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test jQuery</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>
<body>
    <h1>Test jQuery</h1>
    <div id="test">
        <p>Test</p>
    </div>
    <script src="script.js"></script>
</body>
</html>

<?php
sleep(3);
header('Content-Type: application/json');
json_encode(array('first' => 'first thing', 'second' => 'second thing'));

?>