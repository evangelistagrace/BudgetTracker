<?php
require '../vendor/autoload.php'; 
require 'sendgridAPI.php'; //SendGrid API

if(isset($_POST['sendEmail'])){
    $message = $_POST['emailText'];

$email = new \SendGrid\Mail\Mail(); 
$email->setFrom("evangrace98@gmail.com", "Evan");
$email->setSubject("Sending with SendGrid is Fun yayy");
$email->addTo("grace.evangrace@gmail.com", "Grace");
$email->addContent("text/plain", "$message");
$email->addContent(
    "text/html", "$message"
);
$sendgrid = new \SendGrid($apikey);
try {
    $response = $sendgrid->send($email);
    //print $response->statusCode() . "\n";
    //print_r($response->headers());
    //print $response->body() . "\n";
    if($response){
        echo "success";
    }
} catch (Exception $e) {
    echo 'Caught exception: '. $e->getMessage() ."\n";
}
}
?>