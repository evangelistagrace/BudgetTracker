<?php

require 'config.php';


// initialize arrays for expenses chart
$username = $_SESSION['username'];

 // EXPENSE BY DAY CHART

 $day = 1; //start from first day of the month
 $count = 0; // counter

 $month = 12; // an arbitary number for the month
 $expenseDays = array();
 $expenseAmounts = array();
 $expenseAmountsByDay = array(); //to be passed to js file
 $expenseBudgets = array();

 $query5 = pg_query("SELECT expensedate, budgetid, SUM(expenseamount) AS totalexpenses, EXTRACT(DAY FROM expensedate) AS expenseday FROM expenses WHERE EXTRACT(MONTH FROM expensedate) = $month AND username = '".$_SESSION['username']."' GROUP BY expensedate, budgetid ORDER BY expensedate ASC ");

$expenses = array();
while($expense = pg_fetch_array($query5)){
    $expenses[] = $expense;
}
$mainArr = array();

 $query6 = pg_query("SELECT * FROM budgets WHERE username = '".$_SESSION['username']."' ORDER BY budgetname ASC");

 while($result = pg_fetch_array($query6)){
    $arr = array(
        "label" => $result['budgetname'],
        "data" => array(),
        "backgroundColor" => $result['budgetcolor']
    );
    array_push($mainArr, $arr);
 }

 for($i=0;$i<count($mainArr);$i++){
    for($j=1;$j<=31;$j++){
        array_push($mainArr[$i]["data"], 0);
    }
 }
$date = 1;
$i= 0;
$n = 0;

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Testing</title>
</head>
<body>
    

    <script>
        var mainArr = <?php echo json_encode($mainArr, JSON_PRETTY_PRINT) ?>;

        console.log( mainArr);

    </script>
    <?php include 'footer.php' ?>

</body>
</html>