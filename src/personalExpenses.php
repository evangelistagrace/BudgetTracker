<!DOCTYPE html>
<html lang="en">
<?php 
include 'head.php';
require 'personalExpenses-process.php';

// initialize variables
$expenseid = $_GET['edit-expense'];
$expensename = $_GET['expense-name'];
$expensecategory = $_GET['expense-category'];
$expenseamount = $_GET['expense-amount'];
$expensedate = $_GET['expense-date'];

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
                        <?php $query = pg_query("SELECT expenses.expenseid, expenses.categoryid, expenses.expensename, expenses.expenseamount, expenses.expensedate, categories.username, categories.categoryname  FROM expenses INNER JOIN categories ON expenses.categoryid = categories.categoryid ORDER BY expenses.expensedate DESC, expenses.expenseid ASC")?>
                        <?php $date1 = date('2000-01-01') ?>
                        <?php while($expense = pg_fetch_assoc($query)) : ?>
                        <?php $date2 = $expense['expensedate']?>
                        <?php if($date2 !== $date1) :?>
                        <div class="card-header">
                            <?php echo date("j F Y", strtotime($expense['expensedate'])) ?>
                        </div>
                        <?php $date1 = $date2?>
                        <?php endif ?>
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
                                        <a href="personalExpenses.php?edit-expense=<?php echo $expense['expenseid']?>&category-id=<?php echo $expense['categoryid']?>&expense-name=<?php echo $expense['expensename']?>&expense-category=<?php echo $expense['categoryname']?>&expense-amount=<?php echo $expense['expenseamount']?>&expense-date=<?php echo $expense['expensedate']?>#editExpense"><i class="fas fa-edit text-primary"></i></a>
                                        <a href="personalExpenses-process.php?del-expense=<?php echo $expense['expenseid']?>"><i class="far fa-trash-alt text-danger"></i></a>
                                    </td>
                                </tr>

                            </table>
                        </div>


                        <?php endwhile ?>
                    </div>
                </div>


                <!-- pop-up -->
                <a class="btn btn-danger add-btn" href="#addExpense"><i class="fas fa-plus"></i></a>

                <!-- add expense -->
                <div id="addExpense" class="overlay">
                    <div class="popup">

                        <div class="content"><a class="close" href="#">x</a>
                            <h3 class="text-center mb-4 mt-4">Add Expense</h3>
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
                                                        aria-label="Amount (to the nearest ringgit)" placeholder="0.00"
                                                        name="expense-amount">
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
                                    <button class="btn btn-primary btn-lg btn-block" type="submit"
                                        name="add-expense">Add expense</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- edit expense -->
                <div id="editExpense" class="overlay">
                    <div class="popup">

                        <div class="content"><a class="close" href="#">x</a>
                            <h3 class="text-center mb-4 mt-4">Edit Expense</h3>
                            <form class="popup-form" action="personalExpenses.php" method="POST">
                                <div class="form-group">
                                    <table>
                                        <tr>
                                            <td><label for="expenseTitle">Title</label></td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="expense-name"
                                                        id="expenseTitle" value=<?php echo $expensename ?>>
                                                    <input type="hidden" name="expense-id" value=<?php echo $expenseid ?>>
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
                                                        data-size="3" title="Pick a category" name="expense-category" >
                                                        <?php $query = pg_query("SELECT * FROM categories WHERE username = '".$_SESSION['username']."' ")?>
                                                        <?php while($result = pg_fetch_array($query)) : ?>
                                                        <?php if($result['categoryname'] == $expensecategory): ?>
                                                            <option value="<?php echo $result['categoryname'] ?>" selected>
                                                            <?php echo $result['categoryname'] ?></option>
                                                        <?php else:?>
                                                        <option value="<?php echo $result['categoryname'] ?>">
                                                            <?php echo $result['categoryname'] ?></option>
                                                        <?php endif ?>
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
                                                        aria-label="Amount (to the nearest ringgit)" value=<?php echo $expenseamount ?>
                                                        name="expense-amount">
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
                                                        id="expenseDate" value=<?php echo $expensedate ?>>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>


                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit"
                                        name="edit-expense">Edit expense</button>

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