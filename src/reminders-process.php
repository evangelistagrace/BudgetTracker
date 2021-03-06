<?php
require 'config.php';

$currentmonth = date("m");
$currentyear = date("Y");
$currentdate = date("Y-m-d");

if(isset($_POST['add-reminder'])){
    $remindername =  $_POST['reminder-name'];
    $reminderamount = $_POST['reminder-amount'];
    $budgetname = $_POST['budget-name'];
    $reminderdate = $_POST['reminder-date'];

    // get corresponding budgetid based on budgetname
    $query = pg_query("SELECT * FROM budgets WHERE EXTRACT(MONTH FROM budgetdate) = $currentmonth AND EXTRACT(YEAR FROM budgetdate) = $currentyear AND username = '".$_SESSION['username']."' AND budgetname = '$budgetname' ");
    $result = pg_fetch_array($query);
    $budgetid = $result['budgetid'];

    // format expense name with single quote 
    if (strpos($remindername, "'") !== false) { //if single quote is inside input
        //split to pre and post apostrophe
        $pieces = explode("'", $remindername);
        $pieces[0] .= "'";
        $pieces[1] = "'" . $pieces[1];
        $remindername = implode("", $pieces);
    }

    // format reminder amount 
    if (strpos($reminderamount, '.') !== false) {
        // do nothing
    }else{
        $reminderamount .= ".00";
    }

    $query = pg_query("INSERT INTO reminders(budgetid, remindername, reminderamount, reminderdate, reminderdone, username) VALUES ($budgetid, '$remindername', $reminderamount, '$reminderdate', false, '".$_SESSION['username']."')");
}

if(isset($_GET['reminder-done'])){
    $reminderdone = $_GET['reminder-done'];
    $reminderid = $_GET['reminder-id'];
    $budgetid = $_GET['budget-id'];
    $remindername = $_GET['reminder-name'];
    $reminderamount = $_GET['reminder-amount'];
    $remindercheckeddate= date("Y-m-d");


   if($reminderdone === 't'){
       $query = pg_query("UPDATE reminders SET reminderdone = 'true' WHERE reminderid = $reminderid ");
       // insert reminder as expense
       $query = pg_query("INSERT INTO expenses (budgetid, expensename, expenseamount, expensedate, username) VALUES ($budgetid, '$remindername','$reminderamount','$remindercheckeddate', '".$_SESSION['username']."') ");
   }elseif($reminderdone === 'f'){
    //    update boolean value
        $query = pg_query("UPDATE reminders SET reminderdone = 'false' WHERE reminderid = $reminderid ");
        
    }
    
    if($query){
        header('location: reminders.php');
    }
    
}

if(isset($_GET['del-reminder'])){
    $reminderid = $_GET['del-reminder'];
    $query = pg_query("DELETE FROM reminders WHERE reminderid = $reminderid");
    header('location: reminders.php');
}

if(isset($_POST['edit-reminder'])){
    $reminderid = $_POST['reminder-id'];
    $remindername = $_POST['reminder-name'];
    $reminderbudget = $_POST['reminder-budget'];
    $reminderamount = $_POST['reminder-amount'];
    $reminderdate = $_POST['reminder-date'];


    $query = pg_query("SELECT * FROM budgets WHERE EXTRACT(MONTH FROM budgetdate) = $currentmonth AND EXTRACT(YEAR FROM budgetdate) = $currentyear AND username = '".$_SESSION['username']."' AND budgetname = '$reminderbudget'");
    $result = pg_fetch_array($query);
    $budgetid = $result['budgetid'];

    // format reminder name with single quote 
    if (strpos($remindername, "'") !== false) { //if single quote is inside input
        //split to pre and post apostrophe
        $pieces = explode("'", $remindername);
        $pieces[0] .= "'";
        $pieces[1] = "'" . $pieces[1];
        $remindername = implode("", $pieces);
    }

    // format reminder amount 
    if (strpos($reminderamount, '.') !== false) {
        // do nothing
    }else{
        $reminderamount .= ".00";
    }

    $query = pg_query("UPDATE reminders SET remindername = '$remindername', budgetid = $budgetid, reminderamount = $reminderamount, reminderdate = '$reminderdate' WHERE reminderid = $reminderid");
}

?>