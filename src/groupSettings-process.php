<?php

require 'config.php';


$errors = array();
$warnings = array();


if(isset($_GET['del-budget'])){
    $budgetname = $_GET['del-budget'];
    $budgetcolor = $_GET['budgetcolor'];

    // set deleted budget color as not taken
    $query = pg_query("UPDATE colors SET colortaken = false WHERE colorname = '$budgetcolor' AND username = '".$_SESSION['username']."' ");

    $query = pg_query("DELETE FROM budgets WHERE budgetname = '$budgetname' AND username = '".$_SESSION['username']."' ");
    
    $_SESSION['message'] = "budget deleted";
    header('location: settings.php');
}

if(isset($_POST['add-budget'])){
    $budgetname = $_POST['budget-name'];
    $budgetamount = $_POST['budget-amount'];
    $budgetcolor = $_POST['budget-color'];
    $groupingid = $_POST['grouping-id'];

    // find total budget amount
    $query3 = pg_query("SELECT SUM(budgetamount) AS totalbudget FROM groupbudgets WHERE groupingid = $groupingid ");
    $result = pg_fetch_array($query3);
    $totalBudget = $result['totalbudget'] + $budgetamount;

    // format total budget amount 
    if (strpos($totalBudget, '.') !== false) {
        // do nothing
    }else{
        $totalBudget .= ".00";
    }

    // find income
    $query4 = pg_query("SELECT maxbudget FROM groups WHERE groupingid = $groupingid ");
    $result = pg_fetch_array($query4);
    $maxbudget = $result['maxbudget'];

    // if total budget exceeds maxbudget, push warning message
    if($totalBudget > $maxbudget){
        array_push($warnings, "Total budget " . "(RM " . $totalBudget . ")" . " exceeds maxbudget " . "(RM " . $maxbudget . ").");
    }


    if(!empty($budgetname)){
        // check for duplicate categories
        $query = pg_query("SELECT * FROM groupbudgets WHERE groupingid = $groupingid ");
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
         // set selected color as taken
         $query = pg_query("UPDATE groupcolors SET colortaken = true WHERE colorname = '$budgetcolor' AND groupingid = $groupingid ");

        $query = pg_query("INSERT INTO groupbudgets (groupingid, budgetname, budgetamount, budgetcolor) VALUES ('$groupingid', '$budgetname', '$budgetamount', '$budgetcolor')");

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


// to-do: control user access
if(isset($_POST['add-max-budget'])){
    $maxbudget = $_POST['new-max-budget'];
    $groupingid = $_POST['grouping-id'];
    if(!empty($maxbudget)){
        // format income amount 
        if (strpos($maxbudget, '.') !== false) {
            // do nothing
        }else{
            $maxbudget .= ".00";
        }
        $query = pg_query("UPDATE groups SET maxbudget = $maxbudget WHERE groupingid = $groupingid");
    }
    
}

if(isset($_POST['send-invitation'])){
    $groupingid = $_POST['grouping-id'];
    $invitationemail = $_POST['invitation-email'];

    // get group name from group id
    $query = pg_query("SELECT * FROM groups WHERE groupingid = $groupingid");
    $result = pg_fetch_array($query);
    $groupname = $result['groupname'];

    $notificationtitle = "Invitation to join" . " " . $groupname;
    $notificationmessage = "Join here: <insert link>";
    $notificationdate = date("Y-m-d"); //current date
    $notificationtype = 'Invitation';
    $notificationstatus = 'SENT';

    //select username from email 
    $query = pg_query("SELECT * FROM users WHERE email = '$invitationemail'");
    $result = pg_fetch_array($query);
    $recipientusername = $result['username']; //recipient
    $senderusername = $_SESSION['username']; //sender
    $bolddata = $groupname;

    // send notification if user exists
    if($recipientusername){
        // send invitation email/notification
        $query = pg_query("INSERT INTO notifications(notificationtitle, notificationmessage, notificationdate, notificationtype, notificationstatus, recipientusername, senderusername, bolddata, groupingid) VALUES ('$notificationtitle', '$notificationmessage', '$notificationdate', '$notificationtype', '$notificationstatus', '$recipientusername', '$senderusername', '$bolddata', $groupingid)");
    }else{
        echo 'unsucessful';
    }
    

}

?>