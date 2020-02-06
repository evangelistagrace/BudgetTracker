<!DOCTYPE html>
<html lang="en">
<?php 
include 'head.php';
require 'report-process.php';

if(!isset($_SESSION['username'])){
    echo "You are not logged in";
    header('location: homepage.php');
}

$month = date("m");
$year = date("Y");
?>
<title>Dashboard - BudgetTracker</title>

<body>

    <?php include 'navbarDashboard.php'?>
    <div class="container-fluid my-container offset-container">

        <div class="row">
            <!-- SIDEBAR -->
            <div class="col-2-sidebar sidebar collapsed position-fixed">
                <div class="close"><a class="toggleBtn" onclick="toggleSidebar()"></a></div>

                <div class="profile"><img src="../assets/profile.jpg" alt="">
                    <div class="desc">@';
                    
                    <?php if(isset($_SESSION['username'])): ?>
                        <?php echo $_SESSION['username'] ?>
                    <?php endif ?>


                    </div>
                </div>

                <!-- count number of notifications -->
                <?php $query = pg_query("SELECT COUNT(notificationstatus) AS count FROM notifications WHERE recipientusername = '".$_SESSION['username']."' "); $result = pg_fetch_array($query); $count = $result['count'] ?>
                <ul class="menu">
                    <li class="menu-item active" id="menuItem1"><a href="dashboard.php" title="dashboard"></a></li>
                    <li class="menu-item" id="menuItem2"><a href="personalBudgets.php" title="budgets"></a></li>
                    <li class="menu-item" id="menuItem3"><a href="personalExpenses.php" title="expenses"></a></li>
                    <li class="menu-item" id="menuItem4"><a href="reminders.php" title="reminders"></a></li>
                    <li class="menu-item" id="menuItem8"><a href="notifications.php" title="notifications"></a>
                    <?php if($count > 0): ?>
                    <span class="badge"><?php echo $count ?></span>
                    <?php endif ?>
                    </li>
                    <li class="menu-item" id="menuItem5"><a href="groups.php" title="groups"></a></li>
                    <li class="menu-item" id="menuItem6"><a href="report.php" title="report"></a></li>
                    <li class="menu-item" id="menuItem7"><a href="settings.php" title="settings"></a></li>
                </ul>
            </div>

            <!-- MAIN CONTENT -->
            <div class="col-10-body collapsed">
                <h1 class="title text-primary">My Dashboard</h1>
                <div class="row">
                <div class="card" style="width: 51rem;">
                        <div class="card-body">
                            <h5 class="card-title">Reminders</h5>
                                <?php $query = pg_query("SELECT reminders.reminderid, reminders.budgetid, reminders.remindername, reminders.reminderamount, reminders.reminderdone, reminders.reminderdate, budgets.budgetid, budgets.budgetname FROM reminders INNER JOIN budgets ON reminders.budgetid = budgets.budgetid WHERE reminders.username = '".$_SESSION['username']."' ORDER BY reminders.reminderid") ?>

                                <?php $query2 = pg_query("SELECT reminders.reminderid, reminders.budgetid, reminders.remindername, reminders.reminderamount, reminders.reminderdone, reminders.reminderdate, budgets.budgetid, budgets.budgetname FROM reminders INNER JOIN budgets ON reminders.budgetid = budgets.budgetid WHERE reminders.username = '".$_SESSION['username']."' ORDER BY reminders.reminderid") ?>

                                <?php $query3 = pg_query("SELECT reminders.reminderid, reminders.budgetid, reminders.remindername, reminders.reminderamount, reminders.reminderdone, reminders.reminderdate, budgets.budgetid, budgets.budgetname FROM reminders INNER JOIN budgets ON reminders.budgetid = budgets.budgetid WHERE reminders.username = '".$_SESSION['username']."' ORDER BY reminders.reminderid") ?>
                                <table class="table table-striped dashboard-reminders">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="dashboard-reminders title">Overdue</th>
                                    </tr>
                                </thead>
                                    <?php $currentDate = strtotime(date("Y-m-d")); while($reminder = pg_fetch_array($query3)):?>
                                    <tr>
                                    <?php 
                                        $reminderDate = strtotime(date("Y-m-d", strtotime($reminder['reminderdate']))); 
                                        $days = ($reminderDate - $currentDate)/60/60/24; //get difference in days between current date and reminder date
                                    ?>
                                    <?php if($days <  0): ?>
                                    <?php if($reminder['reminderdone'] === f):?>
                                    <td><a
                                            href="reminders-process.php?reminder-done=t&reminder-id=<?php echo $reminder['reminderid']?>&budget-id=<?php echo $reminder['budgetid']?>&reminder-name=<?php echo $reminder['remindername']?>&reminder-amount=<?php echo $reminder['reminderamount']?>"><i
                                                class="far fa-square reminder-check"></i></a>
                    
                                    </td>
                                    <td class="text-danger"><?php echo $reminder['remindername'] ?></td>
                                    <?php endif ?>
                                    <?php endif?>
                                    </tr>
                                     <?php endwhile ?>

                                <thead class="thead-light">
                                    <tr>
                                        <th class="dashboard-reminders title">Due this week</th>
                                    </tr>
                                </thead>
                                    <?php $currentDate = strtotime(date("Y-m-d")); while($reminder = pg_fetch_array($query)):?>
                                    <tr>
                                    <?php 
                                        $reminderDate = strtotime(date("Y-m-d", strtotime($reminder['reminderdate']))); 
                                        $days = ($reminderDate - $currentDate)/60/60/24; //get difference in days between current date and reminder date
                                    ?>
                                    <?php if($days >=0 AND $days < 7): ?>
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
                                        <td><h5 class="text-primary">+RM <?php echo $income ?></h5></td>
                                    </tr>
                                    <tr>
                                        <?php 
                                            $query = pg_query("SELECT SUM(expenseamount) as totalexpense FROM expenses WHERE EXTRACT(MONTH FROM expensedate) = $month AND EXTRACT(YEAR FROM expensedate) = $year AND username = '".$_SESSION['username']."'"); 
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
                                        <td><h5 class="text-primary">-RM <?php echo $outflow ?></h5></td>
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

                                            if($balance < 0){
                                                $negativeBalance = abs($balance);
                                            }
                                        ?>
                                        <td>Balance</td>
                                        <td>
                                            <?php if($balance > 0): ?>
                                                <h3 class="text-primary">+RM <?php echo $balance ?></h3>
                                            <?php elseif($balance == 0): ?>
                                                <h3 class="text-primary">RM <?php echo $balance ?></h3> 
                                            <?php elseif($balance < 0): ?>
                                                <h3 class="text-danger">-RM <?php echo $negativeBalance ?></h3>
                                            <?php endif ?>
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
                            <?php $query = pg_query("SELECT * FROM groups WHERE memberusername = '".$_SESSION['username']."' ")?>
                            <?php while($group = pg_fetch_array($query)): ?>
                                <li><a href=<?php echo 'groupDashboard.php?grouping-id='.$group['groupingid'] ?>><?php echo $group['groupname'] ?></a></li>
                            <?php endwhile ?>
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
                            <?php $query = pg_query("SELECT * FROM budgets WHERE EXTRACT(MONTH FROM budgetdate) = $month AND EXTRACT(YEAR FROM budgetdate) = $year AND username = '".$_SESSION['username']."' ORDER BY budgetid")?>
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
                                     <?php if($percentage == '100'): ?>
                                        <div class="progress-bar progress-bar-striped bg-danger" role="progressbar"
                                        style="width: <?php echo $percentage ?>%;">
                                        </div>
                                    <?php else: ?>

                                        <div class="progress-bar progress-bar-striped bg-warning" role="progressbar"
                                            style="width: <?php echo $percentage ?>%;">
                                        </div>
                                    <?php endif ?>
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
                            <canvas id="expensesByCategoryChart"></canvas>
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

    <script>
         let expenseAngles, budgetNames, budgetColors;
        budgetNames = <?php echo json_encode($budgetNames) ?>;
        expenseAngles = <?php echo json_encode($expenseAngles) ?>;
        budgetColors = <?php echo json_encode($budgetColors) ?>;
    </script>
    
    <?php include 'footer.php' ?>

</body>

</html>