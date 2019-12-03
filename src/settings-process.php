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
    $categoryname = $_POST['category-name'];
    $categorycolor = $_POST['category-color'];

    if(!empty($categoryname)){
        // check for duplicate categories
        $query = pg_query("SELECT * FROM categories WHERE username = '".$_SESSION['username']."'");
        while($result = pg_fetch_array($query)){
            if($result['categoryname'] == $categoryname) {
                array_push($errors, "Category '$categoryname' already exists.");
            }
        }
        
    }
    if($categorycolor == ""){
        array_push($errors, "Choose category color");
    }
    if(count($errors) == 0){
            $query = pg_query("INSERT INTO categories (username, categoryname, categorycolor) VALUES ('".$_SESSION['username']."', '$categoryname', '$categorycolor')");

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
        
    }
    if(count($errors) == 0){
            $query = pg_query("UPDATE categories SET categoryname = '$categoryname' WHERE categoryid = $categoryid");
   
        }
}


if(isset($_POST['add-income'])){
    $income = $_POST['new-income'];
    if(!empty($income)){
            // format income amount 
            if (strpos($income, '.') !== false) {
                // do nothing
            }else{
                $income .= ".00";
            }
            $query = pg_query("UPDATE users SET income = $income WHERE username = '".$_SESSION['username']."'");
        }
    
}

?>