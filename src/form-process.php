<?php
require 'config.php';



if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $day = $_POST['day'];
    $query = pg_query("INSERT INTO nurses(remark, daynum) VALUES ('$name', '$day')");
}


?>