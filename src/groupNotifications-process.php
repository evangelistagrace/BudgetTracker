<?php
require 'config.php';

$groupingid = $_GET['grouping-id'];

//dimiss notification
if(isset($_GET['dismiss-notification-id'])){
    $notificationid = $_GET['dismiss-notification-id'];

    // delete notification
    $query = pg_query("DELETE FROM groupnotifications WHERE id = $notificationid AND groupingid = $groupingid ");

    header('location: groupNotifications.php?grouping-id='.$groupingid);


}

//dimiss all notifications
if(isset($_GET['dismiss-all'])){
    // delete notification
    $query = pg_query("DELETE FROM groupnotifications WHERE groupingid = $groupingid ");

    header('location: groupNotifications.php?grouping-id='.$groupingid);


}

?>