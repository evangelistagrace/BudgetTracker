<!DOCTYPE html>
<html lang="en">
<?php 

include 'head.php';
require 'groupDashboard-process.php';

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
                                    <li class="active" >
                                        <a href="groupDashboard.php?grouping-id=<?php echo $groupingid?>"><i class="fas fa-home"></i> Overview</a>
                                    </li>
                                    <li>
                                        <a href="groupBudgets.php?grouping-id=<?php echo $groupingid?>"><i class="fas fa-chart-pie"></i> Budgets</a>
                                    </li>
                                    <li>
                                        <a href="groupExpenses.php?grouping-id=<?php echo $groupingid?>"><i class="fas fa-wallet"></i> Expenses</a>
                                    </li>
                                    <li>
                                        <a href="groupReminders.php?grouping-id=<?php echo $groupingid?>"><i class="fas fa-list"></i> Reminders</a>
                                    </li>
                                    <li>
                                        <a href="groupNotifications.php?grouping-id=<?php echo $groupingid?>"><i class="fas fa-bell"></i> Notifications</a>
                                    </li>
                                    <li>
                                        <a href="groupReport.php?grouping-id=<?php echo $groupingid?>"><i class="fas fa-chart-line"></i> Report</a>
                                    </li>
                                    <li>
                                        <a href="groupSettings.php?grouping-id=<?php echo $groupingid?>"><i class="fas fa-cog"></i> Settings</a>
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
                                                    <table class="table table-striped dashboard-reminders">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th class="dashboard-reminders title">Overdue</th>
                                                            </tr>
                                                        </thead>
                                                        <tr>
                                                            <td>title</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- balance -->
                                            <div class="card" style="width: 25rem">
                                                <div class="card-body">
                                                    <h5 class="card-title">Balance</h5>
                                                    <?php
                                                        $query = pg_query("SELECT maxbudget FROM groups WHERE groupingid = $groupingid AND memberusername ='".$_SESSION['username']."' "); 
                                                        $result = pg_fetch_array($query);
                                                    ?>
                                                    <table class="balance">
                                                        <tr>
                                                            <td>Inflow</td>
                                                            <td><h5 class="text-primary">+RM <?php echo $result['maxbudget'] ?></h5></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Outflow</td>
                                                            <td><h5 class="text-primary">-RM <?php echo 'outflow' ?></h5></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Balance</td>
                                                            <td>
                                                                <?php $balance = 0 ?>
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
                                                </div>
                                            </div>

                                            <!-- budgets -->
                                            <div class="card" style="width: 25rem;">
                                                <div class="card-body">
                                                    <h5 class="card-title">Budgets</h5>
                                                    <p class="card-text">
                                                       //budgets
                                                    </p>
                                                    <a href="#" class="btn btn-secondary btn-sm right">Go to group budgets <i
                                                            class="fas fa-arrow-right"></i></i></a>
                                                </div>
                                            </div>

                                            <!-- expenses -->
                                            <div class="card" style="width: 25rem;">
                                                <div class="card-body">
                                                    <h5 class="card-title">Expenses</h5>
                                                    <p class="card-text">
                                                       //expenses
                                                    </p>
                                                    <a href="#" class="btn btn-secondary btn-sm right">Go to group expenses <i
                                                            class="fas fa-arrow-right"></i></i></a>
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

    <?php include 'footer.php' ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

</body>

</html>