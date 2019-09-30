<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'?>
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
                    <div class="col-4"><h3 class="text-center"><< August >></h3></div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-3">
                        <div class="btn btn-primary">Download Report</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title"><h5>Expenses by Category</h5></div>
                                <div class="card-text">
                                    <canvas id="expensesChart"></canvas>
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