<?php

require 'config.php';

$errors = array();
$warnings = array();

$groupingid = $_GET['grouping-id'];

$currentmonth = date("m");
$currentyear = date("Y");
$currentdate = date("Y-m-d");


if(isset($_POST['add-expense'])){
    $budgetname = $_POST['budget-name'];
    $expensename = $_POST['expense-name'];
    $expenseamount = $_POST['expense-amount'];
    $expensedate = $_POST['expense-date'];
    $expensedate2 = strtotime($expensedate);
    $month = date("m", $expensedate2);
    $year = date("Y", $expensedate2);

    // select corresponding categoryid from category table
    $query = pg_query("SELECT * FROM groupbudgets WHERE EXTRACT(MONTH FROM budgetdate) = $month AND EXTRACT(YEAR FROM budgetdate) = $year AND groupingid = '$groupingid' AND budgetname = '$budgetname' ");
    $result = pg_fetch_array($query);
    $budgetid = $result['budgetid'];
    $budgetamount = $result['budgetamount'];

    // format expense name with single quote 
    if (strpos($expensename, "'") !== false) { //if single quote is inside input
        //split to pre and post apostrophe
        $pieces = explode("'", $expensename);
        $pieces[0] .= "'";
        $pieces[1] = "'" . $pieces[1];
        $expensename = implode("", $pieces);
    }

    // format expense amount 
    if (strpos($expenseamount, '.') !== false) {
        // do nothing
    }else{
        $expenseamount .= ".00";
    }

    // find total expense amount
    $query2 = pg_query("SELECT SUM(expenseamount) AS totalexpense FROM groupexpenses WHERE EXTRACT(MONTH FROM expensedate) = $currentmonth AND EXTRACT(YEAR FROM expensedate) = $currentyear AND groupingid = '$groupingid' ");
    $result = pg_fetch_array($query2);
    $totalExpense = $result['totalexpense'] + $expenseamount;


    $query3 = pg_query("SELECT SUM(expenseamount) AS totalexpense FROM groupexpenses WHERE EXTRACT(MONTH FROM expensedate) = $currentmonth AND EXTRACT(YEAR FROM expensedate) = $currentyear AND budgetid = $budgetid AND groupingid = '$groupingid' ");
     $result2 = pg_fetch_array($query3);
     $totalExpenseByBudget = $result2['totalexpense'] + $expenseamount;

    // format total expense amount 
    if (strpos($totalExpense, '.') !== false) {
        // do nothing
    }else{
        $totalExpense .= ".00";
    }
    

    // find income
    $query4 = pg_query("SELECT maxbudget FROM groups WHERE groupingid = $groupingid ");
    $result = pg_fetch_array($query4);
    $income = $result['maxbudget'];


    // if total expense exceeds maxbudget, push warning message
    if($totalExpense > $income){
        array_push($errors, "Total expense " . "(RM " . $totalExpense . ")" . " exceeds maxbudget " . "(RM " . $income . ").");
    }

    // if total expense budget exceeds budget amount, push warning message
    if($totalExpenseByBudget > $budgetamount){
        array_push($warnings, "Your expenses for ".$budgetname." (RM ".$totalExpenseByBudget.") has exceeded its budget (RM ".$budgetamount.")" );
    }

    if(count($errors) == 0){
        $query = pg_query("INSERT INTO groupexpenses(budgetid, expensename, expenseamount, expensedate, groupingid, username) VALUES ($budgetid,'".$expensename."', $expenseamount, '$expensedate', '$groupingid', '".$_SESSION['username']."') ");
    }
   

}

if(isset($_POST['edit-expense'])){
    $expenseid = $_POST['expense-id'];
    $expensename = $_POST['expense-name'];
    $expensebudget = $_POST['expense-budget'];
    $expenseamount = $_POST['expense-amount'];
    $expensedate = $_POST['expense-date'];

    $query = pg_query("SELECT * FROM groupbudgets WHERE EXTRACT(MONTH FROM budgetdate) = $currentmonth AND EXTRACT(YEAR FROM budgetdate) = $currentyear AND groupingid = '$groupingid' AND budgetname = '$expensebudget' ");
    $result = pg_fetch_array($query);
    $budgetid = $result['budgetid'];

    // format expense name with single quote 
    if (strpos($expensename, "'") !== false) { //if single quote is inside input
        //split to pre and post apostrophe
        $pieces = explode("'", $expensename);
        $pieces[0] .= "'";
        $pieces[1] = "'" . $pieces[1];
        $expensename = implode("", $pieces);
    }

    // format expense amount 
    if (strpos($expenseamount, '.') !== false) {
        // do nothing
    }else{
        $expenseamount .= ".00";
    }

    $query = pg_query("UPDATE groupexpenses SET budgetid = $budgetid, expensename = '$expensename', expenseamount = $expenseamount, expensedate = '$expensedate' WHERE expenseid = $expenseid ");

}

if(isset($_GET['del-expense'])){
    $expenseid = $_GET['del-expense'];
    $query = pg_query("DELETE FROM groupexpenses WHERE expenseid = $expenseid");
    header('location: groupExpenses.php?grouping-id='.$groupingid);

}

?>