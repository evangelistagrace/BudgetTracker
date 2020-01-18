<!DOCTYPE html>
<html lang="en">
<?php 

include 'head.php';
require 'groupExpenses-process.php';

// initialize variables
$groupingid = $_GET['grouping-id'];

?>
<title>My Groups - BudgetTracker</title>

<body>

    <?php include 'navbarDashboard.php'?>
    <div class="container-fluid my-container offset-container">

        <div class="row">
            <!-- SIDEBAR -->
            <?php include 'sidebarDashboard.php'?>

            <!-- MAIN CONTENT -->
            <div class="col-10-body collapsed">

                <h1 class="title text-primary">My Groups</h1>


                <a href="groups.php">
                    <h6 class="text-info text-left"><i class="fas fa-angle-double-left"></i>Back to My Groups</i></h6>
                </a>

                <?php 
                        //select all groups the session user is in
                        $query = pg_query("SELECT * FROM groups WHERE groupingid = $groupingid LIMIT 1");
                        
                    ?>

                <?php while($group = pg_fetch_array($query)): ?>
                <div class="row justify-content-center">
                    <div class="col-4">
                        <h3 class="text-primary text-center"><?php echo $group['groupname'] ?></h3>
                    </div>
                </div>

                <div class="row">
                    <div class="container">

                        <div class="card text-center">
                            <div class="card-header tabbed-card">
                                <ul class="nav nav-tabs card-header-tabs">
                                    <li>
                                        <a href="groupDashboard.php?grouping-id=<?php echo $groupingid?>"><i
                                                class="fas fa-home"></i> Overview</a>
                                    </li>
                                    <li>
                                        <a href="groupBudgets.php?grouping-id=<?php echo $groupingid?>"><i
                                                class="fas fa-chart-pie"></i> Budgets</a>
                                    </li>
                                    <li class="active">
                                        <a href="groupExpenses.php?grouping-id=<?php echo $groupingid?>"><i
                                                class="fas fa-wallet"></i> Expenses</a>
                                    </li>
                                    <li>
                                        <a href="groupReminders.php?grouping-id=<?php echo $groupingid?>"><i
                                                class="fas fa-list"></i> Reminders</a>
                                    </li>
                                    <li>
                                        <a href="groupNotifications.php?grouping-id=<?php echo $groupingid?>"><i
                                                class="fas fa-bell"></i> Notifications</a>
                                    </li>
                                    <li>
                                        <a href="groupReport.php?grouping-id=<?php echo $groupingid?>"><i
                                                class="fas fa-chart-line"></i> Report</a>
                                    </li>
                                    <li>
                                        <a href="groupSettings.php?grouping-id=<?php echo $groupingid?>"><i
                                                class="fas fa-cog"></i> Settings</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <!-- expenses -->
                                <div class="tab-pane active" id="3">
                                    <div class="row"
                                        style="display:flex;justify-content:center;margin:auto;width:100%;">
                                        <?php if(count($warnings)): ?>
                                        <div class="error" style="width: 80%">
                                            <?php foreach($warnings as $warning): ?>
                                            <div class="alert alert-warning"><?php echo $warning ?></div>
                                            <?php endforeach ?>
                                        </div>
                                        <?php endif ?>
                                        <div class="card settings" style="width: 100%">
                                            <?php $query = pg_query("SELECT groupexpenses.expenseid, groupexpenses.budgetid, groupexpenses.expensename, groupexpenses.expenseamount, groupexpenses.expensedate, groupbudgets.groupingid, groupbudgets.budgetname, groupbudgets.budgetcolor  FROM groupexpenses INNER JOIN groupbudgets ON groupexpenses.budgetid = groupbudgets.budgetid WHERE groupexpenses.groupingid = $groupingid ORDER BY groupexpenses.expensedate DESC, groupexpenses.expenseid ASC")?>
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
                                                        <td style="flex:4"><?php echo $expense['expensename']?></td>
                                                        <td style="flex:2">
                                                            <div class="small">
                                                                <div
                                                                    class='<?php echo "circle bg-{$expense['budgetcolor']}" ?>'>
                                                                </div><?php echo $expense['budgetname']?>
                                                            </div>
                                                        </td>
                                                        <td style="flex:2">RM <?php echo $expense['expenseamount']?>
                                                        </td>
                                                        <td style="flex:2">
                                                            <!-- edit expense -->
                                                            <a
                                                                href="personalExpenses.php?edit-expense=<?php echo $expense['expenseid']?>&budget-id=<?php echo $expense['budgetid']?>&expense-name='<?php echo $expense['expensename']?>'&expense-budget=<?php echo $expense['budgetname']?>&expense-amount=<?php echo $expense['expenseamount']?>&expense-date=<?php echo $expense['expensedate']?>#editExpense"><i
                                                                    class="fas fa-edit text-primary"></i></a>
                                                            <!-- delete expense -->
                                                            <a
                                                                href="personalExpenses-process.php?del-expense=<?php echo $expense['expenseid']?>"><i
                                                                    class="far fa-trash-alt text-danger"></i></a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <?php endwhile ?>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    <?php endwhile ?>
                </div>

                <!-- pop-up -->
                <a class="btn btn-danger add-btn" href="#addExpense"><i class="fas fa-plus"></i></a>

                <!-- add expense -->
                <div id="addExpense" class="overlay">
                    <div class="popup">

                        <div class="content"><a class="close" href="#">x</a>
                            <h3 class="text-center mb-4 mt-4">Add Expense</h3>
                            <form class="popup-form" action="groupExpenses.php?grouping-id=<?php echo $groupingid ?>" method="POST">
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
                                                        <?php $query = pg_query("SELECT * FROM groupbudgets WHERE groupingid = $groupingid ")?>
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

        <?php include 'footer.php' ?>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

</body>

</html>