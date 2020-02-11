<?php

require 'config.php';
require '../vendor/autoload.php'; //send email dependencies
require 'sendgridAPI.php'; //SendGrid API


$groupingid = $_GET['grouping-id'];

$errors = array();
$warnings = array();
$messages = array();

$currentmonth = date("m");
$currentyear = date("Y");
$currentdate = date("Y-m-d");

if(isset($_GET['del-budget-id'])){
    $budgetid= $_GET['del-budget-id'];
    $budgetname = $_GET['budget-name'];
    $budgetcolor = $_GET['budget-color'];

    //check to see if there are current month's expenses with the deleted budget category 
    $query = pg_query("SELECT * FROM groupexpenses WHERE EXTRACT(MONTH FROM expensedate) = $currentmonth AND EXTRACT(YEAR FROM expensedate) = $currentyear AND budgetid = $budgetid AND groupingid = $groupingid ");

    //check to see if there are current month's reminders with the deleted budget category 
    $query2 = pg_query("SELECT * FROM groupreminders WHERE EXTRACT(MONTH FROM reminderdate) = $currentmonth AND EXTRACT(YEAR FROM reminderdate) = $currentyear AND budgetid = $budgetid AND groupingid = $grpupingid ");

    if(pg_num_rows($query) == 0 AND pg_num_rows($query2) == 0){
        // set deleted budget color as not taken
        $query2 = pg_query("UPDATE groupcolors SET colortaken = false WHERE colorname = '$budgetcolor' AND groupingid = $groupingid ");

        $query3 = pg_query("DELETE FROM groupbudgets WHERE budgetid = $budgetid AND groupingid = $groupingid ");
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

    $groupingid = $_POST['grouping-id'];


    //find total expense amount
    $query2 = pg_query("SELECT SUM(expenseamount) AS totalexpense FROM groupexpenses WHERE EXTRACT(MONTH FROM expensedate) = $currentmonth AND EXTRACT(YEAR FROM expensedate) = $currentyear AND groupingid = $groupingid ");
    $result = pg_fetch_array($query2);
    $outflow = $result['totalexpense'];

    // find income
    $query3 = pg_query("SELECT maxbudget FROM groups WHERE groupingid = $groupingid ");
    $result = pg_fetch_array($query3);
    $income = $result['maxbudget'];

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
        array_push($errors, "Insufficient balance (RM ".$balance.")"." to create budget '".$budgetname."' (RM ".$budgetamount.")");
    }


    if(!empty($budgetname)){
        // check for duplicate categories
        $query = pg_query("SELECT * FROM groupbudgets WHERE EXTRACT(MONTH FROM budgetdate) = $currentmonth AND EXTRACT(YEAR FROM budgetdate) = $currentyear AND groupingid = $groupingid");
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

        
        $query = pg_query("INSERT INTO groupbudgets (groupingid, budgetname, budgetamount, budgetcolor, budgetdate) VALUES ('$groupingid', '$budgetname', '$budgetamount', '$budgetcolor', '$currentdate')");

        if($query){
            echo 'true';

            // set selected color as taken
            $query = pg_query("UPDATE groupcolors SET colortaken = true WHERE colorname = '$budgetcolor' AND groupingid = $groupingid ");
        }

    }
}

if(isset($_POST['edit-budget'])){
    $budgetid = $_POST['budget-id'];
    $budgetname = $_POST['budget-name'];
    $budgetamount = $_POST['budget-amount'];
    $budgetpreviouscolor = $_POST['budget-previous-color'];
    $budgetcolor = $_POST['budget-color'];

    $query = pg_query("SELECT * FROM groupcolors WHERE groupingid = $groupingid ");
    while($result = pg_fetch_array($query)){
        if($budgetcolor == $budgetpreviouscolor){
            //do nothing

        }elseif($budgetcolor != $budgetpreviouscolor){
            // set current color
            $query1 = pg_query("UPDATE groupcolors SET colortaken = true WHERE colorname = '$budgetcolor' AND groupingid = $groupingid ");

            // unset previous color
            $query2 = pg_query("UPDATE groupcolors SET colortaken = false WHERE colorname = '$budgetpreviouscolor' AND groupingid = $groupingid ");
        }
    }
    
    if(!empty($budgetname)){
        // check for duplicate groupbudgets
        $query = pg_query("SELECT * FROM groupbudgets WHERE groupingid = $groupingid");
        while($result = pg_fetch_array($query)){
            if($result['budgetid'] != $budgetid) {
                if($result['budgetname'] == $budgetname)
                    array_push($errors, "Budget '$budgetname' already exists.");
            }
        }
        
    }
    if(count($errors) == 0){
            $query = pg_query("UPDATE groupbudgets SET budgetname = '$budgetname', budgetamount = $budgetamount, budgetcolor = '$budgetcolor' WHERE budgetid = $budgetid");
   
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
        $query = pg_query("UPDATE groups SET income = $income WHERE groupingid = $groupingid");
    }
    
}

if(isset($_POST['cancel-budget'])){
    header('location: groupSettings.php?grouping-id='.$groupingid);

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
    $senderusername = $_SESSION['username']; //sender username
    $senderemail = $_SESSION['email']; //sender email
    $bolddata = $groupname;

    // send notification if user exists
    if($recipientusername){
        // send invitation notification if haven't been sent
        $query = pg_query("SELECT * FROM notifications WHERE recipientusername = '$recipientusername' AND groupingid = $groupingid AND notificationtype = 'Invitation' ");
        // check for existing invitation
        if(pg_num_rows($query) == 0){
            $query = pg_query("INSERT INTO notifications(notificationtitle, notificationmessage, notificationdate, notificationtype, notificationstatus, recipientusername, senderusername, bolddata, groupingid) VALUES ('$notificationtitle', '$notificationmessage', '$notificationdate', '$notificationtype', '$notificationstatus', '$recipientusername', '$senderusername', '$bolddata', $groupingid)");
        }else{
            array_push($warnings, 'An invitation has already been sent to this email');
        }
    }else{
        echo 'unsucessful';
    }

    //send email if email exists
    if($invitationemail){
        $email = new \SendGrid\Mail\Mail(); 
        
        $email->setFrom($senderemail, "BudgetTracker");
        $email->setSubject($senderusername." invited you to join ".$groupname);
        $email->addTo($invitationemail, $recipientusername);
        $email->addContent("text/plain", $notificationmessage);
        $email->addContent(
            "text/html", $notificationmessage
        );
        $sendgrid = new \SendGrid($apikey);
        try {
            $response = $sendgrid->send($email);
            //print $response->statusCode() . "\n";
            //print_r($response->headers());
            //print $response->body() . "\n";
            if($response){
                echo "success";
            }
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }

    }


    
}

//remove user (Admin settings)
if(isset($_GET['remove-user'])){
    $memberusername = $_GET['remove-user'];
    array_push($messages, "User '".$memberusername."' has been removed");
    $query = pg_query("DELETE FROM groups WHERE memberusername = '$memberusername' ");
    header('location: groupSettings.php?grouping-id='.$groupingid);
}


//exit group
if(isset($_GET['exit-group'])){
    $memberusername = $_GET['exit-group'];
    array_push($messages, "User '".$memberusername."' has been removed");
    $query = pg_query("DELETE FROM groups WHERE groupingid = $groupingid AND memberusername = '$memberusername' ");
    header('location: groups.php');
}

?>