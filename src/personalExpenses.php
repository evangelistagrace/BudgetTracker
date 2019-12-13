<!DOCTYPE html>
<html lang="en">
<?php 
include 'head.php';
require 'personalExpenses-process.php';

// initialize variables
$expenseid = $_GET['edit-expense'];
$expensename = $_GET['expense-name'];
$expensebudget = $_GET['expense-budget'];
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
                        <?php $query = pg_query("SELECT expenses.expenseid, expenses.budgetid, expenses.expensename, expenses.expenseamount, expenses.expensedate, budgets.username, budgets.budgetname, budgets.budgetcolor  FROM expenses INNER JOIN budgets ON expenses.budgetid = budgets.budgetid WHERE expenses.username = '".$_SESSION['username']."' ORDER BY expenses.expensedate DESC, expenses.expenseid ASC")?>
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
                                            <div class='<?php echo "circle bg-{$expense['budgetcolor']}" ?>'></div><?php echo $expense['budgetname']?>
                                        </div>
                                    </td>
                                    <td>RM <?php echo $expense['expenseamount']?></td>
                                    <td>
                                        <!-- edit expense -->
                                        <a href="personalExpenses.php?edit-expense=<?php echo $expense['expenseid']?>&budget-id=<?php echo $expense['budgetid']?>&expense-name='<?php echo $expense['expensename']?>'&expense-budget=<?php echo $expense['budgetname']?>&expense-amount=<?php echo $expense['expenseamount']?>&expense-date=<?php echo $expense['expensedate']?>#editExpense"><i class="fas fa-edit text-primary"></i></a>
                                        <!-- delete expense -->
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
                                            <td><label for="budgetCategory">Budget Category</label></td>
                                            <td>
                                                <div class="input-group">
                                                    <select class="selectpicker show-tick" data-style="btn-secondary"
                                                        data-size="3" title="Pick a category" name="budget-name">
                                                        <?php $query = pg_query("SELECT * FROM budgets WHERE username = '".$_SESSION['username']."' ")?>
                                                        <?php while($result = pg_fetch_array($query)) : ?>
                                                        <option value="<?php echo $result['budgetname'] ?>">
                                                            <?php echo $result['budgetname'] ?></option>
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
                                            <td><label for="budgetCategory">Budget Category</label></td>
                                            <td>
                                                <div class="input-group">
                                                    <select class="selectpicker show-tick" data-style="btn-secondary"
                                                        data-size="3" title="Pick a category" name="expense-budget" >
                                                        <?php $query = pg_query("SELECT * FROM budgets WHERE username = '".$_SESSION['username']."' ")?>
                                                        <?php while($result = pg_fetch_array($query)) : ?>
                                                        <?php if($result['budgetname'] == $expensebudget): ?>
                                                            <option value="<?php echo $result['budgetname'] ?>" selected>
                                                            <?php echo $result['budgetname'] ?></option>
                                                        <?php else:?>
                                                        <option value="<?php echo $result['budgetname'] ?>">
                                                            <?php echo $result['budgetname'] ?></option>
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