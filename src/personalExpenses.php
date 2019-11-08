<!DOCTYPE html>
<html lang="en">
<?php 
include 'head.php';
require 'personalExpenses-process.php';
?>

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
                    <?php $query = pg_query("SELECT expenses.expenseid, expenses.categoryid, expenses.expensename, expenses.expenseamount, expenses.expensedate, categories.username, categories.categoryname  FROM expenses INNER JOIN categories ON expenses.categoryid = categories.categoryid ")?>
                    <?php while($expense = pg_fetch_array($query)) : ?>
                        <div class="card-header">
                            <?php echo $expense['expensedate']?>
                        </div>
                        <div class="card-body">
                            <table class='table table-condensed expenses'>
                                <tr>
                                    <td><?php echo $expense['expensename']?></td>
                                    <td>
                                        <div class="small">
                                            <div class="circle bg-danger"></div><?php echo $expense['categoryname']?>
                                        </div>
                                    </td>
                                    <td>RM <?php echo $expense['expenseamount']?></td>
                                    <td>
                                        <a href="#"><i class="fas fa-edit text-primary"></i></a>
                                        <a href="#"><i class="far fa-trash-alt text-danger"></i></a>
                                    </td>
                                </tr>

                            </table>
                        </div>

                        
                        <?php endwhile ?>
                    </div>
                </div>


                <!-- pop-up -->
                <a class="btn btn-danger add-btn" href="#addExpenses"><i class="fas fa-plus"></i></a>

                <div id="addExpenses" class="overlay">
                    <div class="popup">

                        <div class="content"><a class="close" href="#">x</a>
                            <h3 class="text-center mb-4 mt-4">Add Expenses</h3>
                            <form class="popup-form" action="personalExpenses.php" method="POST">
                                <div class="form-group">
                                    <table>
                                        <tr>
                                            <td><label for="expenseTitle">Title</label></td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="expense-name"
                                                        id="expenseTitle" placeholder="Expense name">
                                                </div>
                                            </td>
                                        </tr>
                                    </table>


                                </div>
                                <div class="form-group">
                                    <table>
                                        <tr>
                                            <td><label for="budgetCategory">Category</label></td>
                                            <td>
                                                <div class="input-group">
                                                    <select class="selectpicker show-tick" data-style="btn-secondary"
                                                        data-size="3" title="Pick a category" name="category-name">
                                                        <?php $query = pg_query("SELECT * FROM categories WHERE username = '".$_SESSION['username']."' ")?>
                                                        <?php while($result = pg_fetch_array($query)) : ?>
                                                        <option value="<?php echo $result['categoryname'] ?>">
                                                            <?php echo $result['categoryname'] ?></option>
                                                        <?php endwhile ?>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="form-group">
                                    <table>
                                        <tr>
                                            <td><label for="budgetAmount">Amount</label></td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">RM</span>
                                                    </div>
                                                    <input type="text" class="form-control text-right"
                                                        aria-label="Amount (to the nearest ringgit)" placeholder="0.00" name="expense-amount">
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="form-group">
                                    <table>
                                        <tr>
                                            <td><label for="expenseDate">Date</label></td>
                                            <td>
                                                <div class="input-group">
                                                    <input class="form-control" type="date" name="expense-date"
                                                        id="expenseDate">
                                                </div>
                                            </td>
                                        </tr>
                                    </table>


                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit" name="add-expense">Add expense</button>

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