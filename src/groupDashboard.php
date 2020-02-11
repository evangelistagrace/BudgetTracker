<!DOCTYPE html>
<html lang="en">
<?php 

include 'head.php';
require 'groupReport-process.php';

// initialize variables
$groupingid = $_GET['grouping-id'];

$month = date("m");
$year = date("Y");

?>
<title>My Groups - BudgetTracker</title>
<style>
    .dashboard-reminders.title {
        color: #808080;
        font-size: 13px;
    }

    .dashboard-reminders.title::before {
        font-family: "Font Awesome 5 Free";
        content: '\f024';
        display: inline-block;
        margin-right: 5px;
        color: #808080;
    }

    .dashboard-reminders.title {
        width: 100%;
        text-align: left;
    }


    /* style.css | http://localhost/demo/BudgetTracker/src/scss/style.css */

    .my-container .row .col-10-body .row .card .card-body {
        /* justify-content: space-between; */
        justify-content: flex-start;
    }

    /* Inline #11 | http://localhost/demo/BudgetTracker/src/groupDashboard.php?grouping-id=2 */

    .card-title {
        margin-bottom: 1rem;
    }

    table.balance tr {
        display: flex;
        flex: 1;
    }



.progress-container span {
  width: 100%;
  display: block;
  text-align: left;
}

</style>

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
                    <li class="menu-item" id="menuItem1"><a href="dashboard.php" title="dashboard"></a></li>
                    <li class="menu-item" id="menuItem2"><a href="personalBudgets.php" title="budgets"></a></li>
                    <li class="menu-item" id="menuItem3"><a href="personalExpenses.php" title="expenses"></a></li>
                    <li class="menu-item" id="menuItem4"><a href="reminders.php" title="reminders"></a></li>
                    <li class="menu-item" id="menuItem8"><a href="notifications.php" title="notifications"></a>
                        <?php if($count > 0): ?>
                        <span class="badge"><?php echo $count ?></span>
                        <?php endif ?>
                    </li>
                    <li class="menu-item active" id="menuItem5"><a href="groups.php" title="groups"></a></li>
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
                                    <li class="active">
                                        <a href="groupDashboard.php?grouping-id=<?php echo $groupingid?>"><i
                                                class="fas fa-home"></i> Overview</a>
                                    </li>
                                    <li>
                                        <a href="groupBudgets.php?grouping-id=<?php echo $groupingid?>"><i
                                                class="fas fa-chart-pie"></i> Budgets</a>
                                    </li>
                                    <li>
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
                                <div class="tab-content ">

                                    <!-- overview -->
                                    <div class="tab-pane active" id="1">
                                        <div class="row">
                                            <!-- reminders -->
                                            <div class="card" style="width: 25rem">
                                                <div class="card-body">
                                                    <h5 class="card-title">Reminders</h5>
                                                    <?php $query = pg_query("SELECT groupreminders.reminderid, groupreminders.budgetid, groupreminders.remindername, groupreminders.reminderamount, groupreminders.reminderdone, groupreminders.reminderdate, groupbudgets.budgetid, groupbudgets.budgetname FROM groupreminders INNER JOIN groupbudgets ON groupreminders.budgetid = groupbudgets.budgetid WHERE groupreminders.groupingid = $groupingid ORDER BY groupreminders.reminderid") ?>

                                                    <?php $query2 = pg_query("SELECT groupreminders.reminderid, groupreminders.budgetid, groupreminders.remindername, groupreminders.reminderamount, groupreminders.reminderdone, groupreminders.reminderdate, groupbudgets.budgetid, groupbudgets.budgetname FROM groupreminders INNER JOIN groupbudgets ON groupreminders.budgetid = groupbudgets.budgetid WHERE groupreminders.groupingid = $groupingid ORDER BY groupreminders.reminderid") ?>

                                                    <?php $query3 = pg_query("SELECT groupreminders.reminderid, groupreminders.budgetid, groupreminders.remindername, groupreminders.reminderamount, groupreminders.reminderdone, groupreminders.reminderdate, groupbudgets.budgetid, groupbudgets.budgetname FROM groupreminders INNER JOIN groupbudgets ON groupreminders.budgetid = groupbudgets.budgetid WHERE groupreminders.groupingid = $groupingid ORDER BY groupreminders.reminderid") ?>
                                                    <table
                                                        class="table table-striped table-borderless dashboard-groupreminders">
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
                                                                    href="groupreminders-process.php?grouping-id=<?php echo $groupingid ?>&reminder-done=t&reminder-id=<?php echo $reminder['reminderid']?>&budget-id=<?php echo $reminder['budgetid']?>&reminder-name=<?php echo $reminder['remindername']?>&reminder-amount=<?php echo $reminder['reminderamount']?>"><i
                                                                        class="far fa-square reminder-check"></i></a>

                                                            </td>
                                                            <td class="text-danger">
                                                                <?php echo $reminder['remindername'] ?></td>
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
                                                                    href="groupreminders-process.php?grouping-id=<?php echo $groupingid ?>&reminder-done=t&reminder-id=<?php echo $reminder['reminderid']?>&budget-id=<?php echo $reminder['budgetid']?>&reminder-name=<?php echo $reminder['remindername']?>&reminder-amount=<?php echo $reminder['reminderamount']?>"><i
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
                                                                    href="groupreminders-process.php?grouping-id=<?php echo $groupingid ?>&reminder-done=t&reminder-id=<?php echo $reminder['reminderid']?>&budget-id=<?php echo $reminder['budgetid']?>&reminder-name=<?php echo $reminder['remindername']?>&reminder-amount=<?php echo $reminder['reminderamount']?>"><i
                                                                        class="far fa-square reminder-check"></i></a>

                                                            </td>

                                                            <td><?php echo $reminder['remindername'] ?></td>
                                                            <?php endif ?>
                                                            <?php endif?>
                                                        </tr>
                                                        <?php endwhile ?>
                                                    </table>
                                                    <a href="groupreminders.php?grouping-id=<?php echo $groupingid ?>" class="btn btn-secondary btn-sm right">Go to
                                                        reminders <i class="fas fa-arrow-right"></i></a>
                                                </div>
                                            </div>

                                            <!-- balance -->
                                            <div class="card" style="width: 25rem">
                                                <div class="card-body">
                                                    <h5 class="card-title">Balance</h5>
                                                    <table class="balance">
                                                        <tr>
                                                            <?php $query = pg_query("SELECT * FROM groups WHERE groupingid = $groupingid");
                                            $result = pg_fetch_array($query);
                                            $income = $result['maxbudget'];
                                        ?>
                                                            <td>Inflow</td>
                                                            <td>
                                                                <h5 class="text-primary">+RM <?php echo $income ?></h5>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <?php 
                                            $query = pg_query("SELECT SUM(expenseamount) as totalexpense FROM groupexpenses WHERE EXTRACT(MONTH FROM expensedate) = $month AND EXTRACT(YEAR FROM expensedate) = $year AND groupingid = $groupingid "); 
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
                                                            <td>
                                                                <h5 class="text-primary">-RM <?php echo $outflow ?></h5>
                                                            </td>
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
                                                                <h3 class="text-danger">-RM
                                                                    <?php echo $negativeBalance ?></h3>
                                                                <?php endif ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- budgets -->
                                            <div class="card" style="width: 25rem;">
                                                <div class="card-body">
                                                    <h5 class="card-title">Budgets</h5>
                                                    <p class="card-text">
                                                        <?php $query = pg_query("SELECT * FROM groupbudgets WHERE EXTRACT(MONTH FROM budgetdate) = $month AND EXTRACT(YEAR FROM budgetdate) = $year AND groupingid = $groupingid ORDER BY budgetid")?>
                                                        <?php while($result = pg_fetch_array($query)) :?>
                                                        <?php if($result['budgetamount'] > 0)  :?>
                                                        <div class="progress-container">
                                                            <span><?php echo $result['budgetname'] ?></span>
                                                            <div class="progress">
                                                                <?php 
                                    $query2 = pg_query("SELECT SUM(expenseamount) as amount FROM groupexpenses WHERE budgetid = '".$result['budgetid']."'"); 
                                    $result2 = pg_fetch_array($query2);

                                    $percentage = $result2['amount']/$result['budgetamount'] * 100;
                                    $percentage = number_format($percentage, 0);
                                    if($percentage > '100'){
                                        $percentage = '100';
                                    }
                                    ?>
                                                                <?php if($percentage == '100'): ?>
                                                                <div class="progress-bar progress-bar-striped bg-danger"
                                                                    role="progressbar"
                                                                    style="width: <?php echo $percentage ?>%;">
                                                                </div>
                                                                <?php else: ?>

                                                                <div class="progress-bar progress-bar-striped bg-warning"
                                                                    role="progressbar"
                                                                    style="width: <?php echo $percentage ?>%;">
                                                                </div>
                                                                <?php endif ?>
                                                            </div>
                                                        </div>
                                                        <?php endif ?>
                                                        <?php endwhile ?>
                                                    </p>
                                                    <a href="#" class="btn btn-secondary btn-sm right">Go to group
                                                        budgets <i class="fas fa-arrow-right"></i></i></a>
                                                </div>
                                            </div>

                                            <!-- expenses -->
                                            <div class="card" style="width: 25rem;">
                                                <div class="card-body">
                                                    <h5 class="card-title">Expenses</h5>
                                                    <p class="card-text">
                                                        <canvas id="expensesByCategoryChart"></canvas>
                                                    </p>
                                                    <a href="#" class="btn btn-secondary btn-sm right">Go to group
                                                        expenses <i class="fas fa-arrow-right"></i></i></a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <?php endwhile ?>

            </div>
        </div>
    </div>

    <script>
        // expenses by category
        let expenseAngles, budgetNames, budgetColors, groupname;
        budgetNames = <?php echo json_encode($budgetNames) ?> ;
        expenseAngles = <?php echo json_encode($expenseAngles) ?> ;
        budgetColors = <?php echo json_encode($budgetColors) ?> ;
    </script>

    <?php include 'footer.php' ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

</body>

</html>