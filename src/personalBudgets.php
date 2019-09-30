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
                                            style="width: 60%;">
                                            60%
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
                                            style="width: 40%;">
                                            40%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="card budget" style="width: 100% ;">
                        <table class='table table-condensed budget'>
                            <tr>
                                <td rowspan="2">Groceries</td>
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
                <a class="btn btn-danger add-btn" href="#addBudget"><i class="fas fa-plus"></i></a>



                <div id="addBudget" class="overlay">
                    <div class="popup">

                        <div class="content"><a class="close" href="#">x</a>
                            <h3 class="text-center mb-4 mt-4">Add Budget</h3>
                            <form class="popup-form" action="">
                                <div class="form-group">
                                    <label for="budgetCategory">Category</label>
                                    <select class="selectpicker show-tick" data-style="btn-secondary"
                                        title="Pick a category">
                                        <option>Travel</option>
                                        <option>Food</option>
                                        <option>Groceries</option>
                                        <option>Misc</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="budgetAmount">Amount</label>
                                    <div class="input-group ml-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">RM</span>
                                        </div>
                                        <input type="text" class="form-control"
                                            aria-label="Amount (to the nearest ringgit)">
                                        <div class="input-group-append">
                                            <span class="input-group-text">.00</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-lg btn-block">Add budget</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <?php include 'footer.php' ?>


</body>

</html>