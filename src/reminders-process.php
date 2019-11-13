<?php
require 'config.php';



if(isset($_POST['add-reminder'])){
    $remindername = $_POST['reminder-name'];
    $reminderamount = $_POST['reminder-amount'];
    $categoryname = $_POST['category-name'];

    // get corresponding categoryid based on categoryname
    $query = pg_query("SELECT * FROM categories WHERE username = '".$_SESSION['username']."' AND categoryname = '$categoryname' ");
    $result = pg_fetch_array($query);
    $categoryid = $result['categoryid'];

    // format reminder amount 
    if (strpos($reminderamount, '.') !== false) {
        // do nothing
    }else{
        $reminderamount .= ".00";
    }

    $query = pg_query("INSERT INTO reminders(categoryid, remindername, reminderamount, reminderdone) VALUES ($categoryid, '$remindername', $reminderamount, false)");
}

if(isset($_GET['reminder-done'])){
    $reminderdone = $_GET['reminder-done'];
    $reminderid = $_GET['reminder-id'];

   if($reminderdone === 't'){
       $query = pg_query("UPDATE reminders SET reminderdone = 'true' WHERE reminderid = $reminderid ");
   }elseif($reminderdone === 'f'){
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

?>