<?php

require 'config.php';

$groupingid = 1; //set initial grouping id

if(isset($_POST['add-group'])){
    //select maximum groupingid from groups table and increment the value for new grouping id
    $query = pg_query("SELECT MAX(groupingid) as maxgroupid FROM groups");
    $result = pg_fetch_array($query);
    $newgroupingid = $result['maxgroupid'] + 1;
    $groupname = $_POST['group-name'];
    $groupicon = $_POST['group-icon'];

    // create default set of colors for group categories
    $query = "INSERT INTO groupcolors (colorname, colorhex, colortaken, groupingid) VALUES 
        ('watermelon-red', '#e97877', false, '$newgroupingid'),
        ('mustard', '#f9d677', false, '$newgroupingid'),
        ('lime', '#dfd277', false, '$newgroupingid'),
        ('cyan', '#4ccead', false, '$newgroupingid'),
        ('dark-blue', '#348c9f', false, '$newgroupingid'),
        ('hot-pink', '#dc6372', false, '$newgroupingid'),
        ('mud', '#c18f6b', false, '$newgroupingid'),
        ('baby-blue', '#73aad8', false, '$newgroupingid'),
        ('lavender', '#c785da', false, '$newgroupingid'),
        ('tangerine', '#fa9a4c', false, '$newgroupingid')";
        $result = pg_query($query);

    // the first member of the group is the admin itself
    $query = pg_query("INSERT INTO groups(groupingid, adminusername, groupname, groupicon, memberusername) VALUES ($newgroupingid, '".$_SESSION['username']."', '".$groupname."', '$groupicon', '".$_SESSION['username']."')");


}


?>