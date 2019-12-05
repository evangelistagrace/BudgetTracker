<?php
require 'config.php';

$errors = array();

if(isset($_GET['del-budget'])){
    $budgetname = $_GET['del-budget'];
    $budgetcolor = $_GET['budget-color'];

    // set deleted budget color as not taken
    $query = pg_query("UPDATE colors SET colortaken = false WHERE colorname = '$budgetcolor' AND username = '".$_SESSION['username']."' ");

    $query = pg_query("DELETE FROM budgets WHERE username = '".$_SESSION['username']."' AND budgetname = $budgetname");
    $_SESSION['message'] = "budget deleted";
    header('location: settings.php');
}

if(isset($_POST['add-budget'])){
    $budgetname = $_POST['budget-name'];
    $budgetamount = $_POST['budget-amount'];
    $budgetcolor = $_POST['budget-color'];

    // set selected color as taken
    $query = pg_query("UPDATE colors SET colortaken = true WHERE colorname = '$budgetcolor' AND username = '".$_SESSION['username']."' ");

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
    if($budgetamount == ""){
        array_push($errors, "Enter a budget amount");
    }

    // format budget amount 
    if (strpos($budgetamount, '.') !== false) {
        // do nothing
    }else{
        $budgetamount .= ".00";
    }

    if(count($errors) == 0){
        $query = pg_query("INSERT INTO budgets (username, budgetname, budgetamount, budgetcolor) VALUES ('".$_SESSION['username']."', '$budgetname', '$budgetamount', '$budgetcolor')");

    }
}

if(isset($_POST['edit-budget'])){
    $budgetid = $_POST['budget-id'];
    $budgetname = $_POST['budget-name'];
    $budgetamount = $_POST['budget-amount'];
    $budgetpreviouscolor = $_POST['budget-previous-color'];
    $budgetcolor = $_POST['budget-color'];

    $query = pg_query("SELECT * FROM colors WHERE username = '".$_SESSION['username']."' ");
    while($result = pg_fetch_array($query)){
        if($budgetcolor == $budgetpreviouscolor){
            //do nothing

        }elseif($budgetcolor != $budgetpreviouscolor){
            // set current color
            $query1 = pg_query("UPDATE colors SET colortaken = true WHERE colorname = '$budgetcolor' AND username = '".$_SESSION['username']."' ");

            // unset previous color
            $query2 = pg_query("UPDATE colors SET colortaken = false WHERE colorname = '$budgetpreviouscolor' AND username = '".$_SESSION['username']."' ");
        }
    }
    
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