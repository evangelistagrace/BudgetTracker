<?php
require 'config.php';

$errors = array();
$warnings = array();

$currentmonth = date("m");
$currentyear = date("Y");
$currentdate = date("Y-m-d");

if(isset($_GET['del-budget-id'])){
    $budgetid = $_GET['del-budget-id'];
    $budgetname = $_GET['budget-name'];
    $budgetcolor = $_GET['budget-color'];

    //check to see if there are current month's expenses with the deleted budget category 
    $query = pg_query("SELECT * FROM expenses WHERE EXTRACT(MONTH FROM expensedate) = $currentmonth AND EXTRACT(YEAR FROM expensedate) = $currentyear AND budgetid = $budgetid AND username = '".$_SESSION['username']."' ");

    //check to see if there are current month's reminders with the deleted budget category 
    $query2 = pg_query("SELECT * FROM reminders WHERE EXTRACT(MONTH FROM reminderdate) = $currentmonth AND EXTRACT(YEAR FROM reminderdate) = $currentyear AND budgetid = $budgetid AND username = '".$_SESSION['username']."' ");

    // $result = pg_fetch_array($query);

    if(pg_num_rows($query) == 0 AND pg_num_rows($query2) == 0){
        // set deleted budget color as not taken
        $query2 = pg_query("UPDATE colors SET colortaken = false WHERE colorname = '$budgetcolor' AND username = '".$_SESSION['username']."' ");

        $query3 = pg_query("DELETE FROM budgets WHERE budgetid = $budgetid AND username = '".$_SESSION['username']."' ");
        header('location: settings.php');
        // echo 'true';

    }else{
        array_push($errors, "Error deleting '".$budgetname."'. There are expenses and/or reminders with the budget '".$budgetname."'");
    }
    
}

if(isset($_POST['add-budget'])){
    $budgetname = $_POST['budget-name'];
    $budgetamount = $_POST['budget-amount'];
    $budgetcolor = $_POST['budget-color'];


    //find total expense amount
    $query2 = pg_query("SELECT SUM(expenseamount) AS totalexpense FROM expenses WHERE EXTRACT(MONTH FROM expensedate) = $currentmonth AND EXTRACT(YEAR FROM expensedate) = $currentyear AND username = '".$_SESSION['username']."' ");
    $result = pg_fetch_array($query2);
    $outflow = $result['totalexpense'];

    // find income
    $query3 = pg_query("SELECT income FROM users WHERE username = '".$_SESSION['username']."' ");
    $result = pg_fetch_array($query3);
    $income = $result['income'];

    // format outflow amount 
    if (strpos($outflow, '.') !== false) {
        // do nothing
    }else{
        $outflow .= ".00";
    }

    $balance = $income - $outflow;
    // format balance amount 
    if (strpos($balance, '.') !== false) {
        // do nothing
    }else{
        $balance .= ".00";
    }

    // if total budget exceeds income, push warning message
    if($budgetamount > $balance){
        array_push($errors, "Insufficient balance (RM ".$balance.")"." to create budget \'".$budgetname."\' (RM ".$budgetamount.")");
    }


    if(!empty($budgetname)){
        // check for duplicate categories
        $query = pg_query("SELECT * FROM budgets WHERE EXTRACT(MONTH FROM budgetdate) = $currentmonth AND EXTRACT(YEAR FROM budgetdate) = $currentyear AND username = '".$_SESSION['username']."'");
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
        
        $query = pg_query("INSERT INTO budgets (username, budgetname, budgetamount, budgetcolor, budgetdate) VALUES ('".$_SESSION['username']."', '$budgetname', '$budgetamount', '$budgetcolor', '$currentdate')");

        if($query){
            // set selected color as taken
            $query = pg_query("UPDATE colors SET colortaken = true WHERE colorname = '$budgetcolor' AND username = '".$_SESSION['username']."' ");
        }

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
        $query = pg_query("SELECT * FROM budgets WHERE EXTRACT(MONTH FROM budgetdate) = $currentmonth AND EXTRACT(YEAR FROM budgetdate) = $currentyear AND username = '".$_SESSION['username']."' ");
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