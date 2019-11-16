<!DOCTYPE html>
<html lang="en">
<?php 
include 'head.php';
require 'sendEmail-process.php';
?>
<body>

<body>
<form action="sendEmail.php" method="POST">
    <textarea name="emailText" id="" cols="30" rows="10"></textarea>
    <button type="submit" name="sendEmail">Send e-mail</button>
</form>
</body>
</html>