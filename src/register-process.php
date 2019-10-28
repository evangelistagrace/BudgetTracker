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
    // check for existing account
    $sql = pg_query("SELECT * FROM users WHERE email = '$email' OR username = '$username' LIMIT 1");
    $result = pg_fetch_assoc($sql);
    if($result){
        if($result['email'] === $email){
            array_push($errors, "Email already taken");
        }if($result['username'] === $username){
            array_push($errors, "Username already taken");
        }
    }

    // insert data into database
    if(count($errors) == 0){
        // enter user data into users table
        $query = "INSERT INTO users (email, username, password) VALUES ('$email', '$username', '$password')";
        $result = pg_query($query);

        // get new userID
        $query = pg_query("SELECT * FROM users WHERE username = '$username' ");
        $result = pg_fetch_assoc($query);

        // create default categories for user
        $username = $result['username'];
        $query = "INSERT INTO categories (username, categoryname) VALUES ('$username', 'Food')";
        $result = pg_query($query);

        // set session variables
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        header('location: dashboard.php');
    }
}

?>