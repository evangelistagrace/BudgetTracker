<?php
require 'config.php';

if(isset($_POST['accept-invitation'])){
    $groupingid = $_POST['grouping-id'];
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

    $query = pg_query("INSERT INTO groups (groupingid, adminusername, groupname, groupicon, memberusername, maxbudget, remindersetting1, remindersetting2) VALUES ($groupingid, '$adminusername','$groupname','$groupicon', '$memberusername', $maxbudget,'TRUE', 'FALSE') ");


}


?>