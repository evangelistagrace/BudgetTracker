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

                <h1 class="title text-primary">My Groups</h1>

                <div class="row">
                    <div class="card group" style="width:18rem;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3"><img src="../assets/icons/icon-1.png" alt=""></div>
                                <div class="col-8">
                                    <h1 class="card-title">Family</h1>
                                    <div class="links small">View | Edit | Delete</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card group" style="width:18rem;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3"><img src="../assets/icons/icon-2.png" alt=""></div>
                                <div class="col-8">
                                    <h1 class="card-title">Amy's Birthday</h1>
                                    <div class="links small">View | Edit | Delete</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card group" style="width:18rem;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3"><img src="../assets/icons/icon-3.png" alt=""></div>
                                <div class="col-8">
                                    <h1 class="card-title">Hostel</h1>
                                    <div class="links small">View</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <a class="btn btn-danger add-btn" href="#addGroup"><i class="fas fa-plus"></i></a>

                <div id="addGroup" class="overlay">
                    <div class="popup">

                        <div class="content"><a class="close" href="#">x</a>
                            <h3 class="text-center mb-4 mt-4">Add Group</h3>
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