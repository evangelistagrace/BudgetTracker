<?php

require 'config.php';


// initialize arrays for expenses chart
$budgetNames = array();
$expenseAngles = array();
$budgetColors = array();


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

// test if query works
// if($query4){
//     print_r("query executed");
// }


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

?>