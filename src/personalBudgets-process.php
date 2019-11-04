<?php
require 'config.php';

if(isset($_POST['add-budget'])){
    $categoryname = $_POST['category-name'];
    $categorybudget = $_POST['category-budget'];
    $query = pg_query("UPDATE categories SET categorybudget = $categorybudget WHERE username = '".$_SESSION['username']."' AND categoryname = '$categoryname' ");
}

if(isset($_GET['del-budget'])){
    $categoryname = $_GET['del-budget']; //GET values are already strings,no need to wrap it in quotes
    $query = pg_query("UPDATE categories SET categorybudget = 0 WHERE username = '".$_SESSION['username']."' AND categoryname = $categoryname ");
    header('location: personalBudgets.php');
}

?>