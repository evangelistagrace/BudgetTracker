<?php
require 'config.php';

$errors = array();

if(isset($_GET['del-category'])){
    $categoryname = $_GET['del-category'];
    $query = pg_query("DELETE FROM categories WHERE username = '".$_SESSION['username']."' AND categoryname = $categoryname");
    $_SESSION['message'] = "Category deleted";
    header('location: settings.php');
}

if(isset($_POST['add-budget'])){
    $budgetname = $_POST['budget-name'];
    $budgetamount = $_POST['budget-amount'];
    $budgetcolor = $_POST['budget-color'];

    if(!empty($budgetname)){
        // check for duplicate categories
        $query = pg_query("SELECT * FROM budget WHERE username = '".$_SESSION['username']."'");
        while($result = pg_fetch_array($query)){
            if($result['budgetname'] == $budgetname) {
                array_push($errors, "Budget '$budgetname' already exists.");
            }
        }
    }
    if($budgetcolor == ""){
        array_push($errors, "Choose a budget color");
    }
    if(count($errors) == 0){
            $query = pg_query("INSERT INTO budgets (username, budgetname, budgetamount, budgetcolor) VALUES ('".$_SESSION['username']."', '$budgetname', '$budgetamount', '$budgetcolor')");

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