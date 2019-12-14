<!DOCTYPE html>
<html lang="en">
<?php 
include 'head.php';
if(!isset($_SESSION['username'])){
    echo "You are not logged in";
    header('location: homepage.php');
}
?>
<title>Dashboard - BudgetTracker</title>

<body>

    <?php include 'navbarDashboard.php'?>
    <div class="container-fluid my-container offset-container">

        <div class="row">
            <!-- SIDEBAR -->
            <?php include 'sidebarDashboard.php'?>

            <!-- MAIN CONTENT -->
            <div class="col-10-body collapsed">
                <h1 class="title text-primary">My Dashboard</h1>
                <div class="row">
                <div class="card" style="width: 51rem;">
                        <div class="card-body">
                            <h5 class="card-title">Reminders</h5>
                                <?php $query = pg_query("SELECT reminders.reminderid, reminders.budgetid, reminders.remindername, reminders.reminderamount, reminders.reminderdone, reminders.reminderdate, budgets.budgetid, budgets.budgetname FROM reminders INNER JOIN budgets ON reminders.budgetid = budgets.budgetid WHERE reminders.username = '".$_SESSION['username']."' ORDER BY reminders.reminderid") ?>
                                <?php $query2 = pg_query("SELECT reminders.reminderid, reminders.budgetid, reminders.remindername, reminders.reminderamount, reminders.reminderdone, reminders.reminderdate, budgets.budgetid, budgets.budgetname FROM reminders INNER JOIN budgets ON reminders.budgetid = budgets.budgetid WHERE reminders.username = '".$_SESSION['username']."' ORDER BY reminders.reminderid") ?>
                                <table class="table table-striped dashboard-reminders">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="dashboard-reminders title">Due this week</th>
                                    </tr>
                                </thead>
                                    <?php $currentDate = strtotime(date("Y-m-d")); while($reminder = pg_fetch_array($query)):?>
                                    <tr>
                                    <?php 
                                        $reminderDate = strtotime(date("Y-m-d", strtotime($reminder['reminderdate']))); 
                                        $days = ($reminderDate - $currentDate)/60/60/24;
                                        // print_r($days);
                                    ?>
                                    <?php if($days <  7): ?>
                                    <?php if($reminder['reminderdone'] === f):?>
                                    <td><a
                                            href="reminders-process.php?reminder-done=t&reminder-id=<?php echo $reminder['reminderid']?>&budget-id=<?php echo $reminder['budgetid']?>&reminder-name=<?php echo $reminder['remindername']?>&reminder-amount=<?php echo $reminder['reminderamount']?>"><i
                                                class="far fa-square reminder-check"></i></a>
                    
                                    </td>

                        <td><?php echo $reminder['remindername'] ?></td>
                        <?php endif ?>
                        <?php endif?>
                        </tr>
                        <?php endwhile ?>
                        <thead>
                            <tr>
                                <th class="dashboard-reminders title">Due next week</th>
                            </tr>
                        </thead>
                        <?php $currentDate = strtotime(date("Y-m-d")); while($reminder = pg_fetch_array($query2)):?>
                                    <tr>
                                    <?php 
                                        $reminderDate = strtotime(date("Y-m-d", strtotime($reminder['reminderdate']))); 
                                        $days = ($reminderDate - $currentDate)/60/60/24;
                                        // print_r($days);
                                    ?>
                                    <?php if($days >  7): ?>
                                    <?php if($reminder['reminderdone'] === f):?>
                                    <td><a
                                            href="reminders-process.php?reminder-done=t&reminder-id=<?php echo $reminder['reminderid']?>&budget-id=<?php echo $reminder['budgetid']?>&reminder-name=<?php echo $reminder['remindername']?>&reminder-amount=<?php echo $reminder['reminderamount']?>"><i
                                                class="far fa-square reminder-check"></i></a>
                    
                                    </td>

                        <td><?php echo $reminder['remindername'] ?></td>
                        <?php endif ?>
                        <?php endif?>
                        </tr>
                        <?php endwhile ?>
                        </table>
                        <a href="reminders.php" class="btn btn-secondary btn-sm right">Go to reminders <i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                    </div>
                </div>

                <div class="row">
                    <div class="card" style="width: 25rem;">
                        <div class="card-body">
                            <h5 class="card-title">Balance</h5>
                            <p class="card-text">
                                <table class="balance">
                                    <tr>
                                        <?php $query = pg_query("SELECT * FROM users WHERE username = '".$_SESSION['username']."' ");
                                            $result = pg_fetch_array($query);
                                            $income = $result['income'];
                                        ?>
                                        <td>Inflow</td>
                                        <td><span class="text-primary">+RM <?php echo $income ?></span></td>
                                    </tr>
                                    <tr>
                                        <?php 
                                            $query = pg_query("SELECT SUM(expenseamount) as totalexpense FROM expenses WHERE username = '".$_SESSION['username']."'"); 
                                            $result2 = pg_fetch_array($query);

                                            $outflow = $result2['totalexpense'];
                                            // format outflow amount 
                                            if (strpos($outflow, '.') !== false) {
                                                // do nothing
                                            }else{
                                                $outflow .= ".00";
                                            }
                                        ?>
                                        <td>Outflow</td>
                                        <td><span class="text-secondary">-RM <?php echo $outflow ?></span></td>
                                    </tr>
                                    <tr>
                                        <?php 
                                            $balance = $income - $outflow;
                                            // format balance amount 
                                            if (strpos($balance, '.') !== false) {
                                                // do nothing
                                            }else{
                                                $balance .= ".00";
                                            }
                                        ?>
                                        <td>Balance</td>
                                        <td>
                                            <h4 class="text-primary">+RM <?php echo $balance ?></h4>
                                        </td>
                                    </tr>
                                </table>
                            </p>
                        </div>
                    </div>



                <div class="card" style="width: 25rem;">
                    <div class="card-body">
                        <h5 class="card-title">Groups</h5>
                        <p class="card-text">
                            <ul class="groups-list">
                                <li><a href="#">Family</a></li>
                                <li><a href="#">Hostel mates</a></li>
                                <li><a href="#">Jay's Birthday Party</a></li>
                            </ul>
                        </p>
                        <a href="groups.php" class="btn btn-secondary btn-sm right">Go to groups <i
                                class="fas fa-arrow-right"></i></i></a>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="card" style="width: 25rem;">
                    <div class="card-body">
                        <h5 class="card-title">Budgets</h5>
                        <p class="card-text">
                            <?php $query = pg_query("SELECT * FROM budgets WHERE username = '".$_SESSION['username']."' ORDER BY budgetid")?>
                            <?php while($result = pg_fetch_array($query)) :?>
                            <?php if($result['budgetamount'] > 0)  :?>
                            <div class="progress-container">
                                <span><?php echo $result['budgetname'] ?></span>
                                <div class="progress">
                                    <?php 
                                    $query2 = pg_query("SELECT SUM(expenseamount) as amount FROM expenses WHERE budgetid = '".$result['budgetid']."'"); 
                                    $result2 = pg_fetch_array($query2);

                                    $percentage = $result2['amount']/$result['budgetamount'] * 100;
                                    $percentage = number_format($percentage, 0);
                                    if($percentage > '100'){
                                        $percentage = '100';
                                    }
                                    ?>
                                    <div class="progress-bar progress-bar-striped bg-warning" role="progressbar"
                                        style="width: <?php echo $percentage ?>%;"></div>
                                </div>
                            </div>
                            <?php endif ?>
                            <?php endwhile ?>
                        </p>
                        <a href="personalBudgets.php" class="btn btn-secondary btn-sm right">Go to budgets <i
                                class="fas fa-arrow-right"></i></i></a>
                    </div>
                </div>

                <div class="card" style="width: 25rem;">
                    <div class="card-body">
                        <h5 class="card-title">Expenses</h5>
                        <p class="card-text">
                            <canvas id="expensesChart"></canvas>
                        </p>
                        <a href="personalExpenses.php" class="btn btn-secondary btn-sm right">Go to expenses <i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

            </div>
        </div>

    </div>


    </div>

    </div>
    </div>

    <?php include 'footer.php' ?>

</body>

</html>