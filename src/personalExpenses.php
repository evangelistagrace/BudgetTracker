<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'?>
<title>My Expenses - BudgetTracker</title>

<body>

    <?php include 'navbarDashboard.php'?>
    <div class="container-fluid my-container offset-container">

        <div class="row">
            <!-- SIDEBAR -->
            <?php include 'sidebarDashboard.php'?>

            <!-- MAIN CONTENT -->
            <div class="col-10-body collapsed">

                <h1 class="title text-primary">My Expenses</h1>
                
                <div class="row">
                    <div class="card expenses">
                        <div class="card-header">
                            Monday, 12th August
                        </div>
                        <div class="card-body">
                        <table class='table table-condensed expenses'>
                            <tr>
                                <td>Lunch</td>
                                <td><div class="small"><div class="circle bg-danger"></div>Food</div></td>
                                <td>RM 7.00</td>
                                <td>
                                    <a href="#"><i class="fas fa-edit text-primary"></i></a>
                                    <a href="#"><i class="far fa-trash-alt text-danger"></i></a>
                                </td>
                            </tr>

                            <tr>
                                <td>Dinner</td>
                                <td><div class="small"><div class="circle bg-danger"></div>Food</div></td>
                                <td>RM 6.00</td>
                                <td>
                                    <a href="#"><i class="fas fa-edit text-primary"></i></a>
                                    <a href="#"><i class="far fa-trash-alt text-danger"></i></a>
                                </td>
                            </tr>

                        </table>
                        </div>

                        <div class="card-header">
                            Sunday, 11th August
                        </div>
                        <div class="card-body">
                        <table class='table table-condensed expenses'>
                            <tr>
                                <td>Monthly grocery shopping</td>
                                <td><div class="small"><div class="circle bg-primary"></div>Groceries</div></td>
                                <td>RM 70.00</td>
                                <td>
                                    <a href="#"><i class="fas fa-edit text-primary"></i></a>
                                    <a href="#"><i class="far fa-trash-alt text-danger"></i></a>
                                </td>
                            </tr>

                            <tr>
                                <td>Dinner</td>
                                <td><div class="small"><div class="circle bg-danger"></div>Food</div></td>
                                <td>RM 10.00</td>
                                <td>
                                    <a href="#"><i class="fas fa-edit text-primary"></i></a>
                                    <a href="#"><i class="far fa-trash-alt text-danger"></i></a>
                                </td>
                            </tr>

                        </table>
                        </div>

                        <div class="card-header">
                            Friday, 10th August
                        </div>
                        <div class="card-body">
                        <table class='table table-condensed expenses'>
                            <tr>
                                <td>Travel to Rawang</td>
                                <td><div class="small"><div class="circle bg-warning"></div>Travel</div></td>
                                <td>RM 20.00</td>
                                <td>
                                    <a href="#"><i class="fas fa-edit text-primary"></i></a>
                                    <a href="#"><i class="far fa-trash-alt text-danger"></i></a>
                                </td>
                            </tr>

                        </table>
                        </div>

                    </div>
                    
                </div>
                <a class="btn btn-danger add-btn" href="#addExpenses"><i class="fas fa-plus"></i></a>

                <div id="addExpenses" class="overlay">
                    <div class="popup">
                        
                        <div class="content"><a class="close" href="#">x</a>
                        <h3 class="text-center mb-4 mt-4">Add Expenses</h3>
                        <form class="popup-form" action="">
                            <div class="form-group">
                                <label for="expenseTitle">Title</label>
                                <div class="input-group ml-3">
                                    <input type="text" class="form-control" name="expenseTitle" id="expenseTitle">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="budgetCategory">Category</label>
                                <div class="input-group ml-3">
                                    <select class="selectpicker show-tick" data-style="btn-secondary"
                                    title="Pick a category">
                                    <option>Travel</option>
                                    <option>Food</option>
                                    <option>Groceries</option>
                                    <option>Misc</option>
                                </select>
                                </div>
                                
                            </div>

                            <div class="form-group">
                                <label for="budgetAmount">Amount</label>
                                <div class="input-group ml-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">RM</span>
                                    </div>
                                    <input type="text" class="form-control"
                                        aria-label="Amount (to the nearest ringgit)">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="expenseDate">Date</label>
                                <div class="input-group ml-3">
                                    <input class="form-control" type="date" name="expenseDate" id="expenseDate">
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-lg btn-block">Add expense</button>

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