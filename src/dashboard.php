<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'?>
<title>Dashboard - BudgetTracker</title>


<body>
   
<?php include 'navbarDashboard.php'?>
    <div class="container-fluid my-container offset-container">

        <div class="row">
            <!-- SIDEBAR -->
            <?php include 'sidebarDashboard.php'?>

            <!-- MAIN CONTENT -->
            <div class="col-10-body collapsed">
            <h1 class="title text-primary">My Dashboard</h1>
                <div class="row">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Balance</h5>
                            <p class="card-text">
                                <table class="balance">
                                    <tr>
                                        <td>Inflow</td>
                                        <td><span class="text-primary">+RM 1, 000.00</span></td>
                                    </tr>
                                    <tr>
                                        <td>Outflow</td>
                                        <td><span class="text-secondary">-RM 700.00</span></td>
                                    </tr>
                                    <tr>
                                        <td>Balance</td>
                                        <td><h4 class="text-primary">+RM 300.00</h4></td>
                                    </tr>
                                </table>
                            </p>
                        </div>
                    </div>

                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Reminders</h5>
                            <p class="card-text">
                                <form action="">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                        <label class="form-check-label" for="defaultCheck1">
                                            Pay hostel fee
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                                        <label class="form-check-label" for="defaultCheck2">
                                            Pay phone bill
                                        </label>
                                    </div>
                                </form>
                            </p>
                            <a href="#" class="btn btn-secondary btn-sm right">Go to reminders <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Groups</h5>
                            <p class="card-text">
                                <ul class="groups-list">
                                    <li><a href="#">Family</a></li>
                                    <li><a href="#">Hostel mates</a></li>
                                    <li><a href="#">Jay's Birthday Party</a></li>
                                </ul>
                            </p>
                            <a href="#" class="btn btn-secondary btn-sm right">Go to groups <i class="fas fa-arrow-right"></i></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="card" style="width: 25rem;">
                        <div class="card-body">
                            <h5 class="card-title">Budgets</h5>
                            <p class="card-text">
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
                                    <span>Groceries</span>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 50%"
                                        aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="50%">
                                    </div>
                                </div>
                                </div>
                                
                            </p>
                            <a href="personalBudgets.php" class="btn btn-secondary btn-sm right">Go to budgets <i class="fas fa-arrow-right"></i></i></a>
                        </div>
                    </div>

                    <div class="card" style="width: 25rem;">
                        <div class="card-body">
                            <h5 class="card-title">Expenses</h5>
                            <p class="card-text">
                            <canvas id="expensesChart"></canvas>
                            </p>
                            <a href="#" class="btn btn-secondary btn-sm right">Go to expenses <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <?php include 'footer.php' ?>

</body>

</html>