<?php

// require 'sendmail-process.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Send mail</title>
</head>
<body>
    <h1>Send an email</h1>
    <form action="sendmail.php" method="POST">
        <div class="form-group">
            <label for="senderEmail">From:</label>
            <input type="email" class="form-control" name="senderEmail">
        </div>
        <div class="form-group">
            <label for="recipientEmail">To:</label>
            <input type="email" class="form-control" name="recipientEmail">
        </div>
        <div class="form-group">
            <label for="subject">Subject:</label>
            <input type="text" class="form-control" name="subject">
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea class="form-control" rows="3" name="message"></textarea>
        </div>
        <div class="form-group">
            <button class="btn btn-primary" name="sendMail">Send</button>
        </div>
    </form>
</body>
</html>