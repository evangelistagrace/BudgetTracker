<?php
require 'config.php';

// initialize variables
$username = "";
$password = "";
$errors = array();

if(isset($_POST['login'])){
    $username = pg_escape_string($_POST['usernameLogin']);
    $password = pg_escape_string($_POST['passwordLogin']);

    // check for errors
    if($username == ""){
        array_push($errors, "Enter your username");
    }
    if($password == ""){
        array_push($errors, "Enter your password");
    }

    // check for existing account
    $sql = pg_query("SELECT * FROM users WHERE username = '$username' LIMIT 1");
    $result = pg_fetch_assoc($sql);
    if($result){
        if($result['password'] === $password){
            // set session variables
            $_SESSION['username'] = $result['username'];
            $_SESSION['email'] = $result['email'];
            header('location: dashboard.php');
        }else{
            array_push($errors, "Username and password don't match");
        }
    }else {
        array_push($errors, "No account found for user '$username'.");
    }
    


}


?>