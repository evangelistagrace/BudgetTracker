<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'?>
<title>My Budgets - BudgetTracker</title>

<body>

    <?php include 'navbarDashboard.php'?>
    <div class="container-fluid my-container offset-container">

        <div class="row">
            <!-- SIDEBAR -->
            <?php include 'sidebarDashboard.php'?>

            <!-- MAIN CONTENT -->
            <div class="col-10-body collapsed">

                <h1 class="title text-primary">My Budgets</h1>
                <div class="row sm"><canvas id="expensesChart"></canvas></div>

                <div class="row">
                    <div class="card budget" style="width: 100% ;">

                        <table class='table table-condensed budget'>
                            <tr>
                                <td rowspan="2">Food</td>
                                <td>
                                    <div><small>+RM 50</small></div>
                                    <div><small>left RM 80</small></div>
                                </td>
                                <td class="small" rowspan="2">
                                    <a href="#"><i class="fas fa-edit text-primary"></i></a>
                                    <a href="#"><i class="far fa-trash-alt text-danger"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="right">
                                    <div class='progress expense'>
                                        <div class="progress-bar progress-bar-striped bg-warning" role="progressbar"
                                            style="width: 50%;">
                                            50%
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        </table>

                    </div>

                    <div class="card budget" style="width: 100% ;">

                        <table class='table table-condensed budget'>
                            <tr>
                                <td rowspan="2">Travel</td>
                                <td>
                                    <div><small>+RM 50</small></div>
                                    <div><small>left RM 80</small></div>
                                </td>
                                <td class="small" rowspan="2">
                                    <a href="#"><i class="fas fa-edit text-primary"></i></a>
                                    <a href="#"><i class="far fa-trash-alt text-danger"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="right">
                                    <div class='progress expense'>
                                        <div class="progress-bar progress-bar-striped bg-warning" role="progressbar"
                                            style="width: 50%;">
                                            50%
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        </table>

                    </div>
                </div>
                <a href="" onclick="popUp()"><div class="btn btn-danger add-btn"><i class="fas fa-plus"></i></div></a>
            </div>
        </div>
    </div>
    <?php include 'footer.php' ?>

</body>

</html>