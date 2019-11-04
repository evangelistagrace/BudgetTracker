<?php
require 'config.php';

if(isset($_POST['add-budget'])){
    $categoryname = $_POST['category-name'];
    $categorybudget = $_POST['category-budget'];
    $query = pg_query("UPDATE categories SET categorybudget = $categorybudget WHERE username = '".$_SESSION['username']."' AND categoryname = '$categoryname' ");
}
?>