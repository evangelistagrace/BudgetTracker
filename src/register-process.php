<?php
require 'config.php';

// initialize variables
$email = "";
$username = "";
$password = "";
$password2 = "";
$errors = array();

if(isset($_POST['register'])){
    $email = pg_escape_string($_POST['emailRegister']);
    $username = pg_escape_string($_POST['usernameRegister']);
    $password = pg_escape_string($_POST['passwordRegister']);
    $password2 = pg_escape_string($_POST['passwordRegister2']);

    // errors
    if($email == ''){
        array_push($errors, "Please enter an email");
    }
    if($username == ''){
        array_push($errors, "Please enter a username");
    }
    if($password == ''){
        array_push($errors, "Please enter a password");        
    }
    if($password2 == ''){
        array_push($errors, "Please reenter your password");        
    }
    if($password != $password2){
        array_push($errors, "Passwords do not match");
    }

    if(count($errors) == 0){
        $query = "INSERT INTO users (email, username, password) VALUES ('$email', '$username', '$password')";
        $result = pg_query($query);
        // empty form fields
        $email = "";
        $username = "";
        $password = "";
        $password2 = "";
    }


    

    

}

?>