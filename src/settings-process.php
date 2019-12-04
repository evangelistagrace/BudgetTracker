<?php
require 'config.php';

$errors = array();

if(isset($_GET['del-budget'])){
    $budgetname = $_GET['del-budget'];
    $query = pg_query("DELETE FROM budgets WHERE username = '".$_SESSION['username']."' AND budgetname = $budgetname");
    $_SESSION['message'] = "budget deleted";
    header('location: settings.php');
}

if(isset($_POST['add-budget'])){
    $budgetname = $_POST['budget-name'];
    $budgetamount = $_POST['budget-amount'];
    // separate color name and color hex value
    $budgetcolor = $_POST['budget-color'];
    $color = explode(" ", $budgetcolor);
    $budgetcolorname = $color[0];
    $budgetcolorhex= $color[1];

    if(!empty($budgetname)){
        // check for duplicate categories
        $query = pg_query("SELECT * FROM budgets WHERE username = '".$_SESSION['username']."'");
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
            $query = pg_query("INSERT INTO budgets (username, budgetname, budgetamount, budgetcolorname, budgetcolorhex) VALUES ('".$_SESSION['username']."', '$budgetname', '$budgetamount', '$budgetcolorname', '$budgetcolorhex')");

        }
}

if(isset($_POST['edit-budget'])){
    $budgetid = $_POST['budget-id'];
    $budgetname = $_POST['budget-name'];
    $budgetamount = $_POST['budget-amount'];
    $budgetcolor = $_POST['budget-color'];
    
    if(!empty($budgetname)){
        // check for duplicate budgets
        $query = pg_query("SELECT * FROM budgets WHERE username = '".$_SESSION['username']."'");
        while($result = pg_fetch_array($query)){
            if($result['budgetid'] != $budgetid) {
                if($result['budgetname'] == $budgetname)
                    array_push($errors, "Budget '$budgetname' already exists.");
            }
        }
        
    }
    if(count($errors) == 0){
            $query = pg_query("UPDATE budgets SET budgetname = '$budgetname', budgetamount = $budgetamount, budgetcolor = '$budgetcolor' WHERE budgetid = $budgetid");
   
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

if(isset($_POST['cancel-budget'])){
    header('location: settings.php');
}

?>