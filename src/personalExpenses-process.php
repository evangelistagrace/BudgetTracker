<?php

if(isset($_POST['add-expense'])) {
    $categoryname = $_POST['category-name'];
    $expensename = $_POST['expense-name'];
    $expenseamount = $_POST['expense-amount'];
    $expensedate = $_POST['expense-date'];

    // select corresponding categoryid from category table
    $query = pg_query("SELECT * FROM categories WHERE username = '".$_SESSION['username']."' AND categoryname = '$categoryname' ");

    $result = pg_fetch_array($query);
    $categoryid = $result['categoryid'];

    $query = pg_query("INSERT INTO expenses(categoryid, expensename, expenseamount, expensedate) VALUES ($categoryid,'$expensename', $expenseamount, '$expensedate') ");


}



?>