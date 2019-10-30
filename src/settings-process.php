<?php
require 'config.php';

if(isset($_GET['del-category'])){
    $categoryname = $_GET['del-category'];
    $query = pg_query("DELETE FROM categories WHERE username = '".$_SESSION['username']."' AND categoryname = $categoryname");
    $_SESSION['message'] = "Category deleted";
    header('location: settings.php');
}

if(isset($_POST['add-category'])){
    $categoryname = $_POST['new-category'];
    if(!empty($categoryname)){
        $query = pg_query("INSERT INTO categories (username, categoryname) VALUES ('".$_SESSION['username']."', '$categoryname')");
        header('location: settings.php');
    }
   
}

// if(isset($_GET['edit-category'])){
//     $categoryname = $_GET['edit-category'];
//     $query = pg_query("DELETE FROM categories WHERE username = '".$_SESSION['username']."' AND categoryname = $categoryname");
//     $_SESSION['message'] = "Category deleted";
//     header('location: settings.php');
// }

if(isset($_POST['edit-category'])){
    $categoryid = $_POST['categoryid'];
    $categoryname = $_POST['categoryname'];
    $query = pg_query("UPDATE categories SET categoryname = '$categoryname' WHERE categoryid = $categoryid");
    header('location: settings.php');
}

?>