<?php
require 'config.php';

$errors = array();

if(isset($_GET['del-category'])){
    $categoryname = $_GET['del-category'];
    $query = pg_query("DELETE FROM categories WHERE username = '".$_SESSION['username']."' AND categoryname = $categoryname");
    $_SESSION['message'] = "Category deleted";
    header('location: settings.php');
}

if(isset($_POST['add-category'])){
    $categoryname = $_POST['new-category'];
    if(!empty($categoryname)){
        // check for duplicate categories
        $query = pg_query("SELECT * FROM categories WHERE username = '".$_SESSION['username']."'");
        while($result = pg_fetch_array($query)){
            if($result['categoryname'] == $categoryname) {
                array_push($errors, "Category '$categoryname' already exists.");
            }
        }
        if(count($errors) == 0){
            $query = pg_query("INSERT INTO categories (username, categoryname) VALUES ('".$_SESSION['username']."', '$categoryname')");
        }
    }
}

if(isset($_POST['edit-category'])){
    $categoryid = $_POST['categoryid'];
    $categoryname = $_POST['categoryname'];

    if(!empty($categoryname)){
        // check for duplicate categories
        $query = pg_query("SELECT * FROM categories WHERE username = '".$_SESSION['username']."'");
        while($result = pg_fetch_array($query)){
            if($result['categoryname'] == $categoryname) {
                array_push($errors, "Category '$categoryname' already exists.");
            }
        }
        if(count($errors) == 0){
            $query = pg_query("UPDATE categories SET categoryname = '$categoryname' WHERE categoryid = $categoryid");
   
        }
    }
}

?>