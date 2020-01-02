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

?>