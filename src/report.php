<!DOCTYPE html>
<html lang="en">
<?php 

include 'head.php';
require 'report-process.php';

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
                    <div class="col-4"><h4 class="text-info text-center"><i class="fas fa-angle-double-left"></i> December 2019 <i class="fas fa-angle-double-right"></i></h4></div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-3">
                        <div class="btn btn-primary right">Download Report</div>
                    </div>
                </div>

                <div class="row">
                        <div class="card" style="width: 25rem;">
                            <div class="card-body">
                                <div class="card-title"><h5>Expenses by Category</h5></div>
                                <div class="card-text">
                                    <canvas id="expensesByCategoryChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="card" style="width: 35rem;">
                            <div class="card-body">
                                <div class="card-title"><h5>Expenses by Day</h5></div>
                                <div class="card-text">
                                    <canvas id="expensesByDayChart"></canvas>
                                </div>
                            </div>
                        </div>
                </div>


                <div class="row">
                    <div class="card" style="width: 61rem;">
                        <div class="card-body">
                            <div class="card-title"><h5>Expenses by Budget</h5></div>
                            <?php $query = pg_query("SELECT * FROM budgets WHERE username = '".$_SESSION['username']."' ORDER BY budgetid")?>
                            <?php while($result = pg_fetch_array($query)) :?>
                            <?php if($result['budgetamount'] > 0)  :?>
                            <?php 
                            $query2 = pg_query("SELECT SUM(expenseamount) as amount FROM expenses WHERE budgetid = '".$result['budgetid']."' AND username = '".$_SESSION['username']."' "); 
                            $result2 = pg_fetch_array($query2);

                            $percentage = $result2['amount']/$result['budgetamount'] * 100;
                            $percentage = number_format($percentage, 0);
                            // if($percentage > '100'){
                            //     $percentage = '100';
                            // }
                            ?>
                                <div class="progress-container">
                                    <span><?php echo $result['budgetname'] ?></span>
                                    <div class="progress">
                                        <?php if($percentage > '100'): ?>
                                            <div class="progress-bar progress-bar-striped bg-danger" role="progressbar"
                                            style="width: <?php echo $percentage ?>%;"><?php echo $percentage ?>%
                                            </div>
                                        <?php else: ?>
                                            <div class="progress-bar progress-bar-striped bg-warning" role="progressbar"
                                                style="width: <?php echo $percentage ?>%;"><?php echo $percentage ?>%
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                            <?php endif ?>
                            <?php endwhile ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // expenses by category
         let expenseAngles, budgetNames, budgetColors;
        budgetNames = <?php echo json_encode($budgetNames) ?>;
        expenseAngles = <?php echo json_encode($expenseAngles) ?>;
        budgetColors = <?php echo json_encode($budgetColors) ?>;

        // expenses by day
        let expenseAmountsByDay;
        expenseAmountsByDay = <?php echo json_encode($expenseAmountsByDay) ?>
    </script>

    <?php include 'footer.php' ?>

</body>

</html>