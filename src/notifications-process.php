<?php
require 'config.php';

if(isset($_GET['accept-grouping-id'])){
    $groupingid = $_GET['accept-grouping-id'];
    echo $groupingid;
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

    header('location: notifications.php');
}

if(isset($_GET['decline-notification-id'])){
    $notificationid = $_GET['decline-notification-id'];

    // delete invitation notification
    $query = pg_query("DELETE FROM notifications WHERE id = $notificationid AND recipientusername = '".$_SESSION['username']."' ");

    header('location: notifications.php');


}


?>