<?php

require 'config.php';

$groupingid = 1; //set initial grouping id

if(isset($_POST['add-group'])){
    //select maximum groupingid from groups table and increment the value for new grouping id
    $query = pg_query("SELECT MAX(groupingid) as maxgroupid FROM groups");
    $result = pg_fetch_array($query);
    $newgroupingid = $result['maxgroupid'] + 1;

    $adminusername = $_SESSION['username'];
    $groupname = $_POST['group-name'];
    $groupicon = 'null';
    $memberusername = 'null';

    $query = pg_query("INSERT INTO groups(groupingid, adminusername, groupname, groupicon, memberusername) VALUES ($newgroupingid, '".$_SESSION['username']."', '".$groupname."', $groupicon, $memberusername)");


}


?>