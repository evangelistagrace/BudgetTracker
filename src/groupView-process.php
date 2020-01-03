<?php

require 'config.php';

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
        $query = pg_query("UPDATE groups SET maxbudget = $maxbudget WHERE groupingid = $groupingid AND memberusername = '".$_SESSION['username']."'");
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

    //select username from email 
    $query = pg_query("SELECT * FROM users WHERE email = '$invitationemail'");
    $result = pg_fetch_array($query);
    $username = $result['username'];
    $notificationstatus = 'SENT';

    // send notification if user exists
    if($username){
        // send invitation email/notification
        $query = pg_query("INSERT INTO notifications(notificationtitle, notificationmessage, username, notificationstatus) VALUES ('$notificationtitle', '$notificationmessage', '$username', '$notificationstatus')");
    }else{
        echo 'unsucessful';
    }
    

}

?>