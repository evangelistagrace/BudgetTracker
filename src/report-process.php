<?php

require 'config.php';

// EXPENSE BY CATEGORY CHART

// initialize arrays for expenses chart
$username = $_SESSION['username'];
$budgetNames = array();
$expenseAngles = array();
$budgetColors = array();
$budgetPercentages = array();

//set month
if(isset($_GET['report-month'])){
    $month = $_GET['report-month'];

    $year = $_GET['report-year'];
}else{
    // $month = 12;
    // $year = 2019;
    $month = date("m");

    $year = date("Y");

}



// corresponding budget name
$query2 = pg_query("SELECT * FROM budgets WHERE username = '".$_SESSION['username']."' ORDER BY budgetid ASC ");
// corresponding budget/expense category color code
$query3 = pg_query("SELECT * FROM colors WHERE username = '".$_SESSION['username']."' ");
// total expenses
$query4 = pg_query("SELECT SUM(expenseamount) AS totalexpenses FROM expenses WHERE EXTRACT(MONTH FROM expensedate) = $month AND EXTRACT(YEAR FROM expensedate) = $year AND username = '".$_SESSION['username']."' ");
$totalExpenses = pg_fetch_array($query4);
$totalexpense = $totalExpenses['totalexpenses'];
// budget usage percentages
$query5 = pg_query("SELECT * FROM budgets WHERE username = '".$_SESSION['username']."' ORDER BY budgetid ASC");
while($result5 = pg_fetch_array($query5)){

    // expenses total by budget/category
    $query = pg_query("SELECT budgetid, SUM (expenseamount) as total FROM expenses WHERE EXTRACT(MONTH FROM expensedate) = $month AND EXTRACT(YEAR FROM expensedate) = $year AND username = '".$_SESSION['username']."' GROUP BY budgetid ORDER BY budgetid ASC");

    while($expense = pg_fetch_array($query)){
        if($result5['budgetid'] == $expense['budgetid']){
            // populate budgetNames array
            array_push($budgetNames, $result5['budgetname']);
            // populate budgetColors array
            $color = pg_fetch_array(pg_query("SELECT * FROM colors WHERE colorname = '".$result5['budgetcolor']."' "));
            $budgetColor = $color['colorhex'];
            array_push($budgetColors, $budgetColor);
            // populate expenseAngles array
            array_push($expenseAngles, $expense['total']);
            $percentage = $expense['total']/$result5['budgetamount'] * 100;
            $percentage = number_format($percentage, 0);
            array_push($budgetPercentages, $percentage);
        }
        
        
    }

}





  // EXPENSE BY DAY CHART

  $day = 1; //start from first day of the month
  $count = 0; // counter
  $expenseDays = array();
  $expenseAmounts = array();
  $expenseAmountsByDay = array(); //to be passed to js file
  $expenseBudgets = array();
 
  $query5 = pg_query("SELECT expensedate, budgetid, SUM(expenseamount) AS totalexpenses, EXTRACT(DAY FROM expensedate) AS expenseday FROM expenses WHERE EXTRACT(MONTH FROM expensedate) = $month AND EXTRACT(YEAR FROM expensedate) = $year AND username = '".$_SESSION['username']."' GROUP BY expensedate, budgetid ORDER BY expensedate ASC ");

  $query8 = pg_query("SELECT expensedate, SUM(expenseamount) AS totalexpenses, EXTRACT(DAY FROM expensedate) AS expenseday FROM expenses WHERE EXTRACT(MONTH FROM expensedate) = $month AND EXTRACT(YEAR FROM expensedate) = $year AND username = '".$_SESSION['username']."' GROUP BY expensedate ORDER BY expensedate ASC ");
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
 
  $query6 = pg_query("SELECT * FROM budgets WHERE username = '".$_SESSION['username']."' ORDER BY budgetname ASC");
 
  while($result = pg_fetch_array($query6)){
      $query7 = pg_query("SELECT * FROM colors WHERE colorname = '".$result['budgetcolor']."' LIMIT 1");
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
         $query6 = pg_query("SELECT * FROM budgets WHERE budgetid = $budgetid LIMIT 1");
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