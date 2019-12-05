<?php

require 'config.php';


if(isset($_POST['add-expense'])) {
    $budgetname = $_POST['budget-name'];
    $expensename = $_POST['expense-name'];
    $expenseamount = $_POST['expense-amount'];
    $expensedate = $_POST['expense-date'];

    // select corresponding categoryid from category table
    $query = pg_query("SELECT * FROM budgets WHERE username = '".$_SESSION['username']."' AND budgetname = '$budgetname' ");
    $result = pg_fetch_array($query);
    $budgetid = $result['budgetid'];

    // format expense amount 
    if (strpos($expenseamount, '.') !== false) {
        // do nothing
    }else{
        $expenseamount .= ".00";
    }

    $query = pg_query("INSERT INTO expenses(budgetid, expensename, expenseamount, expensedate) VALUES ($budgetid,'$expensename', $expenseamount, '$expensedate') ");
}

if(isset($_GET['del-expense'])){
    $expenseid = $_GET['del-expense'];
    $query = pg_query("DELETE FROM expenses WHERE expenseid = $expenseid");
    header('location: personalExpenses.php');

}

if(isset($_POST['edit-expense'])){
    $expenseid = $_POST['expense-id'];
    $expensename = $_POST['expense-name'];
    $expensebudget = $_POST['expense-budget'];
    $expenseamount = $_POST['expense-amount'];
    $expensedate = $_POST['expense-date'];

    $query = pg_query("SELECT * FROM budgets WHERE username = '".$_SESSION['username']."' AND budgetname = '$expensebudget' ");
    $result = pg_fetch_array($query);
    $budgetid = $result['budgetid'];

    // format expense amount 
    if (strpos($expenseamount, '.') !== false) {
        // do nothing
    }else{
        $expenseamount .= ".00";
    }

    $query = pg_query("UPDATE expenses SET budgetid = $budgetid, expensename = '$expensename', expenseamount = $expenseamount, expensedate = '$expensedate' WHERE expenseid = $expenseid ");

}


?>