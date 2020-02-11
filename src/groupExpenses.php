<!DOCTYPE html>
<html lang="en">
<?php 

include 'head.php';
require 'groupExpenses-process.php';

// initialize variables
$groupingid = $_GET['grouping-id'];

// initialize variables
$expenseid = $_GET['edit-expense'];
$expensename = $_GET['expense-name'];
$expensebudget = $_GET['expense-budget'];
$expenseamount = $_GET['expense-amount'];
$expensedate = $_GET['expense-date'];

//month and year
$year = date("Y");
$previousYear = $year - 1;
$nextYear = $year + 1;

//minimum date of expenses
$query = pg_query("SELECT EXTRACT(MONTH FROM MIN(expensedate)) as minexpensemonth, EXTRACT(YEAR FROM MIN(expensedate)) as minexpenseyear FROM groupexpenses WHERE groupingid = $groupingid ");
$result = pg_fetch_array($query);
$minexpensemonth = $result['minexpensemonth'];
$minexpenseyear = $result['minexpenseyear'];

if(isset($_GET['report-month'])){
    $month = $_GET['report-month'];
    $year = $_GET['report-year'];

    $previousMonth = $month - 1;
    $nextMonth = $month + 1;

    if($month == 1){
        $previousMonth = 12; //December
        $previousYear = $year - 1; //previous year
    }else{
        $previousYear = $year;
    }

    if($month == 12){
        $nextMonth = 1;
        $nextYear = $_GET['report-year'] + 1;

    }else{
        $nextYear = $_GET['report-year'];

    }

    if($month == 1){
        $monthName = "January";
    }elseif($month == 2){
        $monthName = "February";
    }elseif($month == 3){
        $monthName = "March";
    }elseif($month == 4){
        $monthName = "April";
    }elseif($month == 5){
        $monthName = "May";
    }elseif($month == 6){
        $monthName = "June";
    }elseif($month == 7){
        $monthName = "July";
    }elseif($month == 8){
        $monthName = "August";
    }elseif($month == 9){
        $monthName = "September";
    }elseif($month == 10){
        $monthName = "October";
    }elseif($month == 11){
        $monthName = "November";
    }elseif($month == 12){
        $monthName = "December";
    }


}else{
    $month = date("m");
    $year = date("Y");
    $previousMonth = $month - 1;
    $nextMonth = $month + 1;
    
    if($previousMonth == 0){
        $previousMonth = 12; //December
        $previousYear = date("Y") - 1; //previous year

    }else{
        $previousYear = date("Y");

    }

    if($nextMonth == 13){
        $nextMonth = 1;
        $nextYear = date("Y") + 1;
        $year = $nextYear;

    }else{
        $nextYear = date("Y");
        $year = $nextYear;

    }

    if($month == 1){
        $monthName = "January";
    }elseif($month == 2){
        $monthName = "February";
    }elseif($month == 3){
        $monthName = "March";
    }elseif($month == 4){
        $monthName = "April";
    }elseif($month == 5){
        $monthName = "May";
    }elseif($month == 6){
        $monthName = "June";
    }elseif($month == 7){
        $monthName = "July";
    }elseif($month == 8){
        $monthName = "August";
    }elseif($month == 9){
        $monthName = "September";
    }elseif($month == 10){
        $monthName = "October";
    }elseif($month == 11){
        $monthName = "November";
    }elseif($month == 12){
        $monthName = "December";
    }
}

?>
<title>My Groups - BudgetTracker</title>

<body>

    <?php include 'navbarDashboard.php'?>
    <div class="container-fluid my-container offset-container">

        <div class="row">
            <!-- SIDEBAR -->
            <div class="col-2-sidebar sidebar collapsed position-fixed">
                <div class="close"><a class="toggleBtn" onclick="toggleSidebar()"></a></div>

                <div class="profile"><img src="../assets/profile.jpg" alt="">
                    <div class="desc">@
                    
                    <?php if(isset($_SESSION['username'])): ?>
                        <?php echo $_SESSION['username'] ?>
                    <?php endif ?>


                    </div>
                </div>

                <!-- count number of notifications -->
                <?php $query = pg_query("SELECT COUNT(notificationstatus) AS count FROM notifications WHERE recipientusername = '".$_SESSION['username']."' "); $result = pg_fetch_array($query); $count = $result['count'] ?>
                <ul class="menu">
                    <li class="menu-item" id="menuItem1"><a href="dashboard.php" title="dashboard"></a></li>
                    <li class="menu-item" id="menuItem2"><a href="personalBudgets.php" title="budgets"></a></li>
                    <li class="menu-item" id="menuItem3"><a href="personalExpenses.php" title="expenses"></a></li>
                    <li class="menu-item" id="menuItem4"><a href="reminders.php" title="reminders"></a></li>
                    <li class="menu-item" id="menuItem8"><a href="notifications.php" title="notifications"></a>
                    <?php if($count > 0): ?>
                    <span class="badge"><?php echo $count ?></span>
                    <?php endif ?>
                    </li>
                    <li class="menu-item  active" id="menuItem5"><a href="groups.php" title="groups"></a></li>
                    <li class="menu-item" id="menuItem6"><a href="report.php" title="report"></a></li>
                    <li class="menu-item" id="menuItem7"><a href="settings.php" title="settings"></a></li>
                </ul>
            </div>

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
                                        <h4 class="text-info text-center" style="width: 100%;">
                                        <?php $currentMonth = date("m"); $currentYear = date("Y");
                                            if(isset($_GET['report-month']) AND isset($_GET['report-year'])){
                                                $reportmonth = $_GET['report-month'];
                                                $reportyear = $_GET['report-year'];
                                            }else{
                                                $reportmonth = date("m");
                                                $reportyear = date("Y");
                                            }
                                        ?>

                                        <?php if($reportmonth > $minexpensemonth OR $reportyear > $minexpenseyear): ?>
                                        <a href="groupExpenses.php?grouping-id=<?php echo $groupingid ?>&report-month=<?php echo $previousMonth ?>&report-year=<?php echo $previousYear ?>"><i class="fas fa-angle-double-left"></i></a>
                                        <?php endif ?> 
                                        
                                        <span id="report-month"><?php echo $monthName ?> <?php echo $year ?></span> 
                                        
                                        <?php if($currentMonth > $reportmonth OR $currentYear > $reportyear): ?>
                                        <a href="groupExpenses.php?grouping-id=<?php echo $groupingid ?>&report-month=<?php echo $nextMonth ?>&report-year=<?php echo $nextYear ?>"><i class="fas fa-angle-double-right"></i></a>
                                        <?php endif ?>
                                    </h4>
                                    <?php if(count($errors)): ?>
                                    <div class="error" style="width: 80%">
                                        <?php foreach($errors as $error): ?>
                                        <div class="alert alert-danger"><?php echo $error?></div>
                                        <?php endforeach ?>
                                    </div>
                                    <?php endif ?>
                                        <?php if(count($warnings)): ?>
                                        <div class="error" style="width: 80%">
                                            <?php foreach($warnings as $warning): ?>
                                            <div class="alert alert-warning"><?php echo $warning ?></div>
                                            <?php endforeach ?>
                                        </div>
                                        <?php endif ?>
                                        <div class="card settings" style="width: 100%">
                                            <?php $query = pg_query("SELECT groupexpenses.expenseid, groupexpenses.budgetid, groupexpenses.expensename, groupexpenses.expenseamount, groupexpenses.expensedate, groupexpenses.username, groupbudgets.groupingid, groupbudgets.budgetname, groupbudgets.budgetcolor  FROM groupexpenses INNER JOIN groupbudgets ON groupexpenses.budgetid = groupbudgets.budgetid WHERE EXTRACT(MONTH FROM expensedate) = $month AND EXTRACT(YEAR FROM expensedate) = $year AND groupexpenses.groupingid = $groupingid ORDER BY groupexpenses.expensedate DESC, groupexpenses.expenseid ASC")?>
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
                                                        <td style="flex:3"><?php echo $expense['expensename']?></td>
                                                        <td style="flex:2">
                                                                <div
                                                                    class='<?php echo "circle bg-{$expense['budgetcolor']}" ?>'>
                                                                </div><?php echo $expense['budgetname']?>
                                                        </td>
                                                        <td style="flex:2">RM <?php echo $expense['expenseamount']?>
                                                        </td>
                                                        <td>
                                                            <i class="fas fa-user"></i><?php echo $expense['username'] ?>
                                                        </td>
                                                        <?php if($expense['username'] == $_SESSION['username'] ):?>
                                                        <td style="flex:2">
                                                            <!-- edit expense -->
                                                            <a
                                                                href="groupExpenses.php?grouping-id=<?php echo $groupingid ?>&edit-expense=<?php echo $expense['expenseid']?>&budget-id=<?php echo $expense['budgetid']?>&expense-name='<?php echo $expense['expensename']?>'&expense-budget=<?php echo $expense['budgetname']?>&expense-amount=<?php echo $expense['expenseamount']?>&expense-date=<?php echo $expense['expensedate']?>#editExpense"><i
                                                                    class="fas fa-edit text-primary"></i></a>
                                                            <!-- delete expense -->
                                                            <a
                                                                href="groupExpenses-process.php?grouping-id=<?php echo $groupingid ?>&del-expense=<?php echo $expense['expenseid']?>"><i
                                                                    class="far fa-trash-alt text-danger"></i></a>
                                                        </td>
                                                        <?php else: ?>
                                                            <td style="flex:2"></td>
                                                        <?php endif ?>
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
                                                        <?php $query = pg_query("SELECT * FROM groupbudgets WHERE EXTRACT(MONTH FROM budgetdate) = $month AND EXTRACT(YEAR FROM budgetdate) = $year AND groupingid = $groupingid ")?>
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
                            <form class="popup-form" action="groupExpenses.php?grouping-id=<?php echo $groupingid ?>" method="POST">
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
                                                        data-size="3" title="Pick a category" name="expense-budget">
                                                        <?php $query = pg_query("SELECT * FROM groupbudgets WHERE EXTRACT(MONTH FROM budgetdate) = $month AND EXTRACT(YEAR FROM budgetdate) = $year AND groupingid = $groupingid ")?>
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