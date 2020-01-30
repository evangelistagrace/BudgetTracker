<?php

require 'config.php';

// EXPENSE BY CATEGORY CHART
$username = $_SESSION['username'];
$groupingid = $_GET['grouping-id'];

// initialize arrays for expenses chart

$budgetNames = array();
$expenseAngles = array();
$budgetColors = array();
$budgetPercentages = array();

// expenses total by budget/category
$query = pg_query("SELECT budgetid, SUM (expenseamount) as total FROM groupexpenses WHERE groupingid = $groupingid GROUP BY budgetid ORDER BY budgetid ASC");
// corresponding budget name
$query2 = pg_query("SELECT * FROM groupbudgets WHERE groupingid = $groupingid ORDER BY budgetid ASC ");
// corresponding budget/expense category color code
$query3 = pg_query("SELECT * FROM groupcolors WHERE groupingid = $groupingid ");
// total expenses
$query4 = pg_query("SELECT SUM(expenseamount) AS totalexpenses FROM groupexpenses WHERE groupingid = $groupingid ");
$totalExpenses = pg_fetch_array($query4);
$totalexpense = $totalExpenses['totalexpenses'];
// budget usage percentages
$query5 = pg_query("SELECT * FROM groupbudgets WHERE groupingid = $groupingid ORDER BY budgetid");
while($result5 = pg_fetch_array($query5)){
    $query6 = pg_query("SELECT SUM(expenseamount) as amount FROM groupexpenses WHERE budgetid = '".$result5['budgetid']."' AND groupingid = $groupingid "); 

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
            $color = pg_fetch_array(pg_query("SELECT * FROM groupcolors WHERE colorname = '".$budget['budgetcolor']."' "));
            $budgetColor = $color['colorhex'];
            array_push($budgetColors, $budgetColor);
        }
    }
    // populate expenseAngles array
    array_push($expenseAngles, $expense['total']);
}


  // EXPENSE BY DAY CHART

  $day = 1; //start from first day of the month
  $count = 0; // counter
  $month = 12; // an arbitary number for the month
  $expenseDays = array();
  $expenseAmounts = array();
  $expenseAmountsByDay = array(); //to be passed to js file
  $expenseBudgets = array();
 
  $query5 = pg_query("SELECT expensedate, budgetid, SUM(expenseamount) AS totalexpenses, EXTRACT(DAY FROM expensedate) AS expenseday FROM groupexpenses WHERE EXTRACT(MONTH FROM expensedate) = $month AND groupingid = $groupingid GROUP BY expensedate, budgetid ORDER BY expensedate ASC ");

  $query8 = pg_query("SELECT expensedate, SUM(expenseamount) AS totalexpenses, EXTRACT(DAY FROM expensedate) AS expenseday FROM groupexpenses WHERE EXTRACT(MONTH FROM expensedate) = $month AND groupingid = $groupingid GROUP BY expensedate ORDER BY expensedate ASC ");
  while($expense = pg_fetch_array($query8)){
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
 
 $expenses = array();
 while($expense = pg_fetch_array($query5)){
     $expenses[] = $expense;
 }
 $mainArr = array();
 
  $query6 = pg_query("SELECT * FROM groupbudgets WHERE groupingid = $groupingid ORDER BY budgetname ASC");
 
  while($result = pg_fetch_array($query6)){
      $query7 = pg_query("SELECT * FROM groupcolors WHERE colorname = '".$result['budgetcolor']."' LIMIT 1");
      $color = pg_fetch_array($query7);
      $colorhex = $color['colorhex'];
     $arr = array(
         "label" => $result['budgetname'],
         "data" => array(),
         "backgroundColor" => $colorhex
     );
     array_push($mainArr, $arr);
  }
 
  for($i=0;$i<count($mainArr);$i++){
     for($j=0;$j<31;$j++){
         array_push($mainArr[$i]["data"], 0);
     }
  }
 $date = 1;
 $i= 0;
 
 while($date <= 31){ //loop through each day
     while($i < count($expenses)){ //loop through each expenses
 
         $budgetid = $expenses[$i]['budgetid'];
         // find corresponding expense budget name
         $query6 = pg_query("SELECT * FROM groupbudgets WHERE budgetid = $budgetid LIMIT 1");
         $expensebudget = pg_fetch_array($query6);
         $budgetname = $expensebudget['budgetname'];
         $budgetexpense = $expenses[$i]['totalexpenses'];
     
         $expenseday = $expenses[$i]['expenseday'];
 
         if($date = $expenseday){
             for($j=0;$j<count($mainArr);$j++){
                 if(in_array($budgetname, $mainArr[$j])){
                     // array_push($mainArr[$j]["data"], $budgetexpense);
                     
                     if($expenseday != $mainArr[$j]["data"][$date]){
                        $mainArr[$j]["data"][$date] = $budgetexpense;
                     }
                     
                 }
             }
             $i++;
         }
     }
     $date++;
 }

 for($j=0;$j<count($mainArr);$j++){
    array_shift($mainArr[$j]["data"]);
 }


?>