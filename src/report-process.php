<?php

require 'config.php';

// EXPENSE BY CATEGORY CHART

// initialize arrays for expenses chart
$username = $_SESSION['username'];
$budgetNames = array();
$expenseAngles = array();
$budgetColors = array();
$budgetPercentages = array();

// expenses total by budget/category
$query = pg_query("SELECT budgetid, SUM (expenseamount) as total FROM expenses WHERE username = '".$_SESSION['username']."' GROUP BY budgetid ORDER BY budgetid ASC");
// corresponding budget name
$query2 = pg_query("SELECT * FROM budgets WHERE username = '".$_SESSION['username']."' ORDER BY budgetid ASC ");
// corresponding budget/expense category color code
$query3 = pg_query("SELECT * FROM colors WHERE username = '".$_SESSION['username']."' ");
// total expenses
$query4 = pg_query("SELECT SUM(expenseamount) AS totalexpenses FROM expenses WHERE username = '".$_SESSION['username']."' ");
$totalExpenses = pg_fetch_array($query4);
$totalexpense = $totalExpenses['totalexpenses'];
// budget usage percentages
$query5 = pg_query("SELECT * FROM budgets WHERE username = '".$_SESSION['username']."' ORDER BY budgetid");
while($result5 = pg_fetch_array($query5)){
    $query6 = pg_query("SELECT SUM(expenseamount) as amount FROM expenses WHERE budgetid = '".$result5['budgetid']."' AND username = '".$_SESSION['username']."' "); 

    while($result6 = pg_fetch_array($query6)){
        $percentage = $result6['amount']/$result5['budgetamount'] * 100;
        $percentage = number_format($percentage, 0);
        array_push($budgetPercentages, $percentage);
    }
}


while($expense = pg_fetch_array($query)){
    while($budget = pg_fetch_array($query2)){
        if($expense['budgetid'] = $budget['budgetid'] ){
            // populate budgetNames array
            array_push($budgetNames, $budget['budgetname']);
            // populate budgetColors array
            $color = pg_fetch_array(pg_query("SELECT * FROM colors WHERE colorname = '".$budget['budgetcolor']."' "));
            $budgetColor = $color['colorhex'];
            array_push($budgetColors, $budgetColor);
        }
    }
    // populate expenseAngles array
    array_push($expenseAngles, $expense['total']);
}


 // EXPENSE BY DAY CHART

 $day = 1; //start from first day of the month
 $month = 12; // an arbitary number for the month
 $count = 0; // counter
 $expenseDays = array();
 $expenseAmounts = array();
 $expenseAmountsByDay = array(); //to be passed to js file

 $query5 = pg_query("SELECT expensedate, SUM(expenseamount) AS totalexpenses, EXTRACT(DAY FROM expensedate) AS expenseday FROM expenses WHERE EXTRACT(MONTH FROM expensedate) = $month AND username = '".$_SESSION['username']."' GROUP BY expensedate ORDER BY expensedate ASC ");

 while($expense = pg_fetch_array($query5)){
     array_push($expenseDays, $expense['expenseday']);
     array_push($expenseAmounts, $expense['totalexpenses']);

 }

 while($day <= 31){
     if($day != $expenseDays[$count]){
         array_push($expenseAmountsByDay, 0); 
     }
     elseif($day = $expenseDays[$count]){
         array_push($expenseAmountsByDay, $expenseAmounts[$count]);
         $count++; //increment counter if match is found
     }
     $day++;
 }


?>