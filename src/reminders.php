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

                <h1 class="title text-primary">My Reminders</h1>
                
                <div class="row">
                    <div class="card expenses">
                    <div class="progress" style="height: 3px;">
  <div class="progress-bar progress-reminder" role="progressbar" style="width: 0%; background-color: #8c77d1" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div>
                        <div class="card-body">
                        <table class='table table-condensed reminders'>
                            <tr>
                                <td><input type="checkbox" class="checkbox"><div class="pseudo-checkbox"></div></td>
                                <td>Pay hostel rent</td>
                                <td><div class="small"><div class="circle"></div>Bills</div></td>
                                <td>RM 600.00</td>
                                <td>
                                    <a href="#"><i class="fas fa-edit text-primary"></i></a>
                                    <a href="#"><i class="far fa-trash-alt text-danger"></i></a>
                                </td>
                            </tr>

                            <tr>
                            <td><input type="checkbox" class="checkbox"><div class="pseudo-checkbox"></div></td>
                                <td>Pay phone bill</td>
                                <td><div class="small"><div class="circle"></div>Bills</div></td>
                                <td>RM 60</td>
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
                        <h3 class="text-center mb-4 mt-4">Add Reminder</h3>
                        <form class="popup-form" action="">
                            <div class="form-group">
                                <label for="expenseTitle">Title</label>
                                <div class="input-group ml-3">
                                    <input type="text" class="form-control" name="expenseTitle" id="expenseTitle">
                                </div>
                            </div>
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
                                <button class="btn btn-primary btn-lg btn-block">Add reminder</button>

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