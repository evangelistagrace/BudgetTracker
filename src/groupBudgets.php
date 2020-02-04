<!DOCTYPE html>
<html lang="en">
<?php 

include 'head.php';
require 'groupBudgets-process.php';

// initialize variables
$groupingid = $_GET['grouping-id'];

// edit variables
// $categoryname = $_GET['categoryname'];
// $categorybudget = $_GET['categorybudget'];

// budget array
// $query3 = pg_query("SELECT SUM(categorybudget) as totalbudget FROM categories WHERE groupingid = $groupingid "); 
// $result3 = pg_fetch_array($query3);

// arrays for generating budget chart
$budgetNames = array();
$budgetAngles = array();
$budgetColors = array();

$GLOBALS['BALANCE']= 90;

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

//select current month and year's budgets
$currentdate = date("Y-m-d");
$currentmonth = date("m");
$currentyear = date("Y");

$message = "some text";

$query = pg_query("SELECT * FROM groupbudgets WHERE EXTRACT(MONTH FROM budgetdate) = $currentmonth AND EXTRACT(YEAR FROM budgetdate) = $currentyear AND groupingid = $groupingid ");
// if most current budget(s) do not exist

if(pg_num_rows($query) == 0){
    //select the most recent set of groupbudgets
    //max budget date
    $message = "query not found";
    $query = pg_query("SELECT MAX(budgetdate) AS maxbudgetdate FROM groupbudgets WHERE groupingid = $groupingid ");
    $result = pg_fetch_array($query);
    $maxbudgetdate = strtotime($result['maxbudgetdate']);
    $maxbudgetmonth = date("m", $maxbudgetdate);
    $maxbudgetyear = date("Y", $maxbudgetdate);

    // bring forward group budgets
    $query2 = pg_query("SELECT * FROM groupbudgets WHERE EXTRACT(MONTH FROM budgetdate) = $maxbudgetmonth AND EXTRACT(YEAR FROM budgetdate) = $maxbudgetyear AND groupingid = $groupingid ORDER BY budgetid ASC");

    while($result2 = pg_fetch_array($query2)){
        $budgetname = $result2['budgetname'];
        $budgetamount = $result2['budgetamount'];
        $budgetcolor = $result2['budgetcolor'];
        $budgetdate = $currentdate;

        $query3 = pg_query("INSERT INTO groupbudgets (groupingid, budgetname, budgetamount, budgetcolor, budgetdate) VALUES ('$groupingid', '$budgetname', '$budgetamount', '$budgetcolor', '$budgetdate')");
    }

}

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
                                    <li class="active">
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
                                    <!-- budgets -->
                                    <div class="tab-pane active" id="2">
                                        <div class="row">
                                            <h4 class="text-info text-center">
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
                                            <a
                                                href="groupBudgets.php?grouping-id=<?php echo $groupingid?>&report-month=<?php echo $previousMonth ?>&report-year=<?php echo $previousYear ?>"><i
                                                    class="fas fa-angle-double-left"></i></a>
                                            <?php endif ?>

                                            <span id="report-month"><?php echo $monthName ?>
                                                <?php echo $year ?></span>

                                            <?php if($currentMonth > $reportmonth OR $currentYear > $reportyear): ?>
                                            <a
                                                href="groupBudgets.php??grouping-id=<?php echo $groupingid?>&report-month=<?php echo $nextMonth ?>&report-year=<?php echo $nextYear ?>"><i
                                                    class="fas fa-angle-double-right"></i></a>
                                            <?php endif ?>
                                            </h4>
                                            <table style="width: 100%">
                                                <tr style="height: 400px;">
                                                    <td style="width:40%">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="card-title">Overview</div>
                                                                <div class="card-text">
                                                                    <div class="row" style="width:100%">

                                                                        <section class="mini-section">
                                                                            <?php 
                                                                            $query = pg_query("SELECT SUM(budgetamount) as totalbudget FROM groupbudgets WHERE EXTRACT(MONTH FROM budgetdate) = $month AND EXTRACT(YEAR FROM budgetdate) = $year AND groupingid = $groupingid "); 
                                                                            $result = pg_fetch_array($query);

                                                                            $query2 = pg_query("SELECT SUM(expenseamount) as totalexpense FROM groupexpenses WHERE EXTRACT(MONTH FROM expensedate) = $month AND EXTRACT(YEAR FROM expensedate) = $year AND groupingid = $groupingid "); 
                                                                            $result2 = pg_fetch_array($query2);

                                                                            $expensesPercentage = $result2['totalexpense']/$result['totalbudget'] * 100;
                                                                            $GLOBALS['BALANCE'] = $result['totalbudget'] - $result2['totalexpense'];
                                                                            $totalBudget = $result['totalbudget'];
                                                                            // format total budget amount 
                                                                            if (strpos($totalBudget, '.') !== false) {
                                                                                // trim
                                                                                $totalBudget = str_replace(".00","",$totalBudget);

                                                                            }

                                                                        ?>

                                                                            <table class="table-overview">
                                                                                <tr>
                                                                                    <td style="width:10%"><span>RM
                                                                                            0</span></td>
                                                                                    <td style="width:75%">
                                                                                        <div
                                                                                            class="progress budget-overview">
                                                                                            <div class="progress-bar budget-progress progress-bar-striped bg-primary"
                                                                                                role="progressbar"
                                                                                                style="width: <?php echo $expensesPercentage?>%"
                                                                                                aria-valuenow="50"
                                                                                                aria-valuemin="0"
                                                                                                aria-valuemax="100">
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td style="width:15%"><span>RM
                                                                                            <?php echo $totalBudget ?></span>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </section>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="width:60%">
                                                        <canvas id="budgetsChart"></canvas>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="row">
                                            <?php $query = pg_query("SELECT * FROM groupbudgets WHERE EXTRACT(MONTH FROM budgetdate) = $month AND EXTRACT(YEAR FROM budgetdate) = $year AND groupingid = $groupingid ORDER BY budgetid")?>
                                            <?php while($result = pg_fetch_array($query)) :?>
                                            <?php if($result['budgetamount'] > 0)  :?>
                                            <div class="card budget" style="width: 100% ;">
                                                <table class='table budget'>
                                                    <tr>
                                                        <td style="width:100%" colspan="2">
                                                            <?php 
                                                            $query2 = pg_query("SELECT SUM(expenseamount) as amount FROM groupexpenses WHERE EXTRACT(MONTH FROM expensedate) = $month AND EXTRACT(YEAR FROM expensedate) = $year AND budgetid = '".$result['budgetid']."' AND groupingid = $groupingid "); 
                                                            $result2 = pg_fetch_array($query2);

                                                            $percentage = $result2['amount']/$result['budgetamount'] * 100;
                                                            $percentage = number_format($percentage, 0);
                                                            if($percentage > '100'){
                                                                $percentage = '100';
                                                            }
                                                            $balance = $result['budgetamount'] - $result2['amount'];
                                                            // format balance amount 
                                                            if (strpos($balance, '.') !== false) {
                                                                // do nothing
                                                            }else{
                                                                $balance .= ".00";
                                                            }
                                                            ?>
                                                            <div><small>Used +RM
                                                            <?php echo $result2['amount'] ?? 0 ?></small></div>
                                                            <?php 
                                                            if($balance < 0){
                                                                $negativeBalance = abs($balance);
                                                            }

                                                            // format balance amount 
                                                            if (strpos($negativeBalance, '.') !== false) {
                                                                // do nothing
                                                            }else{
                                                                $negativeBalance .= ".00";
                                                            }

                                                            ?>
                                                            <?php if($balance  < '0'): ?>
                                                            <div><small class="text-danger">Overspent -RM
                                                                    <?php echo $negativeBalance ?></small></div>
                                                            <?php elseif($balance == '0'): ?>
                                                            <div><small>Left RM <?php echo $balance ?></small></div>
                                                            <?php else: ?>
                                                            <div><small>Left +RM <?php echo $balance ?></small></div>
                                                            <?php endif ?>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:left; padding-bottom:25px">
                                                            <?php echo $result['budgetname'] ?></td>
                                                        <td class="right" style="width:100%;float:right;">
                                                            <div class="progress expense" style="height: 20px;">
                                                                <?php 
                                                                array_push($budgetNames, $result['budgetname']);
                                                                array_push($budgetAngles, $result['budgetamount']);
                                                                $color = pg_fetch_array(pg_query("SELECT * FROM groupcolors WHERE colorname = '".$result['budgetcolor']."' "));
                                                                $budgetColor = $color['colorhex'];
                                                                array_push($budgetColors, $budgetColor);

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
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <?php endif ?>
                                            <?php endwhile ?>
                                            <!-- <?php  print_r($budgetColors) ?>                                 -->
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
        let budgetAngles, budgetNames, budgetColors, BALANCE;
        budgetNames = <?php echo json_encode($budgetNames) ?> ;
        budgetAngles = <?php echo json_encode($budgetAngles) ?> ;
        budgetColors = <?php echo json_encode($budgetColors) ?> ;

        BALANCE = <?php echo json_encode($GLOBALS['BALANCE']) ?> ;

        if (BALANCE < 0) {
            BALANCE = Math.abs(BALANCE);
            BALANCE = "-RM " + BALANCE;
        } else {
            BALANCE = "RM " + BALANCE + " left";

        }
    </script>
    <?php include 'footer.php' ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

</body>

</html>