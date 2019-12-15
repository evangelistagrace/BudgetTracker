<!DOCTYPE html>
<html lang="en">
<?php 

include 'head.php';

// initialize arrays for expenses chart
$budgetNames = array();
$expenseAngles = array();
$budgetColors = array();

?>

<title>My Report - BudgetTracker</title>

<body>

    <?php include 'navbarDashboard.php'?>
    <div class="container-fluid my-container offset-container">

        <div class="row">
            <!-- SIDEBAR -->
            <?php include 'sidebarDashboard.php'?>

            <!-- MAIN CONTENT -->
            <div class="col-10-body collapsed">

                <h1 class="title text-primary">My Report</h1>

                <div class="row justify-content-center">
                    <div class="col-4"><h4 class="text-info text-center"><i class="fas fa-angle-double-left"></i> August <i class="fas fa-angle-double-right"></i></h4></div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-3">
                        <div class="btn btn-primary right">Download Report</div>
                    </div>
                </div>

                <!-- SQL query -->
                <?php

                    // expenses total by budget/category
                    $query = pg_query("SELECT budgetid, SUM (expenseamount) as total FROM expenses WHERE username = '".$_SESSION['username']."' GROUP BY budgetid ");
                    // corresponding budget name
                    $query2 = pg_query("SELECT * FROM budgets WHERE username = '".$_SESSION['username']."' ");
                    // corresponding budget/expense category color code
                    $query3 = pg_query("SELECT * FROM colors WHERE username = '".$_SESSION['username']."' ");
                    // total expenses
                    $query4 = pg_query("SELECT SUM(expenseamount) AS totalexpenses FROM expenses WHERE username = '".$_SESSION['username']."' ");

                    // test if query works
                    // if($query4){
                    //     print_r("query executed");
                    // }


                    while($expense = pg_fetch_array($query)){
                        while($budget = pg_fetch_array($query2)){
                            if($expense['budgetid'] = $budget['budgetid'] ){
                                array_push($budgetNames, $budget['budgetname']);
                            }
                        }
                    }

                    // print_r($budgetNames);

                ?>

                <div class="row">
                    <div class="col-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title"><h5>Expenses by Category</h5></div>
                                <div class="card-text">
                                    <canvas id="expensesByCategoryChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title"><h5>Expenses by Day</h5></div>
                                <div class="card-text">
                                    <canvas id="expensesByDayChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title"><h5>Expenses by Budget</h5></div>
                                <div class="card-text">
                                <div class="progress-container">
                                    <span>Food</span>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 60%"
                                        aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="60%">
                                    </div>
                                </div>
                                </div>
                                <div class="progress-container">
                                    <span>Travel</span>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 40%"
                                        aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="40%">
                                    </div>
                                </div>
                                </div>
                                <div class="progress-container">
                                    <span>Shopping</span>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 50%"
                                        aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="50%">
                                    </div>
                                </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php include 'footer.php' ?>

</body>

</html>