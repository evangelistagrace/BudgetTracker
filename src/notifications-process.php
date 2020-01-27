<?php
require 'config.php';

// accept invitation
if(isset($_GET['accept-grouping-id'])){
    $notificationid = $_GET['accept-notification-id'];
    $groupingid = $_GET['accept-grouping-id'];
    // find admin username
    $query = pg_query("SELECT * FROM groups WHERE groupingid = $groupingid LIMIT 1");
    $result = pg_fetch_array($query);

    $adminusername = $result['adminusername'];
    $groupname = $result['groupname'];
    $groupicon = $result['groupicon'];
    $maxbudget = $result['maxbudget'];

    // new member username
    $memberusername = $_SESSION['username'];

    // default reminder settings
    $remindersetting1 = 'TRUE';
    $remindersetting2 = 'FALSE';

    // add user as member of the group
    $query = pg_query("INSERT INTO groups (groupingid, adminusername, groupname, groupicon, memberusername, maxbudget, remindersetting1, remindersetting2) VALUES ($groupingid, '$adminusername','$groupname','$groupicon', '$memberusername', $maxbudget,'TRUE', 'FALSE') ");

    //remove notification
    $query = pg_query("DELETE FROM notifications WHERE id = $notificationid AND recipientusername = '".$_SESSION['username']."' ");

    // send notification to invitation sender

    //compose new notification
    $senderusername = $memberusername; //sender
    $recipientusername = $_GET['recipient-username']; //recipient
    $bolddata = $groupname;

    $notificationtitle = "Accepted to join group";
    $notificationmessage = $senderusername." accepted invitation to join "."<b>".$bolddata."</b>";
    $notificationdate = date("Y-m-d"); //current date
    $notificationtype = 'Accept';
    $notificationstatus = 'SENT';
    
    // send notification if user exists
    if($recipientusername){
        // echo $groupingid;
        $query = pg_query("INSERT INTO notifications(notificationtitle, notificationmessage, notificationdate, notificationtype, notificationstatus, recipientusername, senderusername, bolddata, groupingid) VALUES ('$notificationtitle', '$notificationmessage', '$notificationdate', '$notificationtype', '$notificationstatus', $recipientusername, '$senderusername', '$bolddata', $groupingid)");
    }else{
        echo 'unsucessful';
    }

    header('location: notifications.php');
}


//decline invitation
if(isset($_GET['decline-notification-id'])){
    $notificationid = $_GET['decline-notification-id'];

    // delete invitation notification
    $query = pg_query("DELETE FROM notifications WHERE id = $notificationid AND recipientusername = '".$_SESSION['username']."' ");

    // send notification to invitation sender
    $groupingid = $_GET['decline-grouping-id'];
    // get group name from group id
    $query = pg_query("SELECT * FROM groups WHERE groupingid = $groupingid");
    $result = pg_fetch_array($query);
    $groupname = $result['groupname'];

    //compose new notification
    $senderusername = $_SESSION['username']; //sender
    $recipientusername = $_GET['recipient-username']; //recipient
    $bolddata = $groupname;

    $notificationtitle = "Declined to join group";
    $notificationmessage = $senderusername." declined to join "."<b>".$bolddata."</b>";
    $notificationdate = date("Y-m-d"); //current date
    $notificationtype = 'Decline';
    $notificationstatus = 'SENT';
    
    // send notification if user exists
    if($recipientusername){
        // echo $groupingid;
        $query = pg_query("INSERT INTO notifications(notificationtitle, notificationmessage, notificationdate, notificationtype, notificationstatus, recipientusername, senderusername, bolddata, groupingid) VALUES ('$notificationtitle', '$notificationmessage', '$notificationdate', '$notificationtype', '$notificationstatus', $recipientusername, '$senderusername', '$bolddata', $groupingid)");
    }else{
        echo 'unsucessful';
    }

    header('location: notifications.php');

}

//dimiss notification
if(isset($_GET['dismiss-notification-id'])){
    $notificationid = $_GET['dismiss-notification-id'];

    // delete notification
    $query = pg_query("DELETE FROM notifications WHERE id = $notificationid AND recipientusername = '".$_SESSION['username']."' ");

    header('location: notifications.php');

}

?>