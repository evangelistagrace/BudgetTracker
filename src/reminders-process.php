<?php

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

?>