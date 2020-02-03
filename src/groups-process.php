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

    $memberemails = array();

    // send invitation to other members
    $memberemail1 = $_POST['memberemail1'];
    $memberemail2 = $_POST['memberemail2'];
    $memberemail3 = $_POST['memberemail3'];
    $memberemail4 = $_POST['memberemail4'];
    $memberemail5 = $_POST['memberemail5'];

    //push to array if email field isnot empty
    if($memberemail1 != ''){
        array_push($memberemails, $memberemail1);
    }if($memberemail2 != ''){
        array_push($memberemails, $memberemail2);
    }if($memberemail3 != ''){
        array_push($memberemails, $memberemail3);
    }if($memberemail4 != ''){
        array_push($memberemails, $memberemail4);
    }if($memberemail5 != ''){
        array_push($memberemails, $memberemail5);
    }

    $notificationtitle = "Invitation to join" . " " . $groupname;
    $notificationmessage = "Join here: <insert link>";
    $notificationdate = date("Y-m-d"); //current date
    $notificationtype = 'Invitation';
    $notificationstatus = 'SENT';

    $senderusername = $_SESSION['username']; //sender
    $bolddata = $groupname;


    //select username from email 
    for($i=0;$i<count($memberemails);$i++){
        if($i == 0 or count($memberemails) == 1){
            $queryMessage = "SELECT * FROM users WHERE email = ".'\''.$memberemails[0].'\'';
        }else{
            $queryMessage = $queryMessage." OR email = ".'\''.$memberemails[$i].'\''; 
        }
    }

    $query2 = pg_query($queryMessage);

    while($result = pg_fetch_array($query2)){
        // send notification if user exists
        if($result['username']){
            // send invitation notification if haven't been sent
            $query = pg_query("SELECT * FROM notifications WHERE recipientusername = '".$result['username']."' AND groupingid = $newgroupingid AND notificationtype = 'Invitation' ");
            // check for existing invitation
            if(pg_num_rows($query) == 0){
                $query = pg_query("INSERT INTO notifications(notificationtitle, notificationmessage, notificationdate, notificationtype, notificationstatus, recipientusername, senderusername, bolddata, groupingid) VALUES ('$notificationtitle', '$notificationmessage', '$notificationdate', '$notificationtype', '$notificationstatus', '".$result['username']."', '$senderusername', '$bolddata', $newgroupingid)");
            }else{
                array_push($warnings, 'An invitation has already been sent to this email');
            }
            
        }else{
            echo 'unsucessful';
        }
    }
    
}


?>