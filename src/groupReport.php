<!DOCTYPE html>
<html lang="en">
<?php 

include 'head.php';
require 'groupReport-process.php';

// initialize variables
$groupingid = $_GET['grouping-id'];

//get current month
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
                        <h3 class="text-primary text-center" id="groupname"><?php echo $group['groupname'] ?></h3>
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
                                    <li class="active">
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
                                    <!-- Report -->
                                    <div class="tab-pane active" id="6">
                                        <div class="row justify-content-center">
                                            <div class="col-4">
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
                                            <a href="groupReport.php?grouping-id=<?php echo $groupingid?>&report-month=<?php echo $previousMonth ?>&report-year=<?php echo $previousYear ?>"><i class="fas fa-angle-double-left"></i></a>
                                            <?php endif ?> 
                                            
                                            <span id="report-month"><?php echo $monthName ?> <?php echo $year ?></span> 
                                            
                                            <?php if($currentMonth > $reportmonth OR $currentYear > $reportyear): ?>
                                            <a href="groupReport.php?grouping-id=<?php echo $groupingid?>&report-month=<?php echo $nextMonth ?>&report-year=<?php echo $nextYear ?>"><i class="fas fa-angle-double-right"></i></a>
                                            <?php endif ?>
                                        </h4>
                                            </div>
                                        </div>
                                        <div class="row justify-content-end">
                                            <div class="col-3">
                                                <div id="btn-print" class="btn btn-primary right">Download Report</div>
                                            </div>
                                        </div>

                                        <div id="" style="display:flex; flex-flow: column wrap;">
                                            <div class="row" style="width: 100%">
                                                <div class="card" style="width: 25rem;">
                                                    <div class="card-body">
                                                        <div class="card-title">
                                                            <h5>Expenses by Category</h5>
                                                        </div>
                                                        <canvas id="expensesByCategoryChart"></canvas>
                                                    </div>
                                                </div>

                                                <div class="card" style="width: 35rem;">
                                                    <div class="card-body">
                                                        <div class="card-title">
                                                            <h5>Expenses by Budget Usage</h5>
                                                        </div>
                                                        <canvas id="expensesByBudgetChart"></canvas>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" style="width: 100%">
                                                <div class="card" style="width: 61rem;">
                                                    <div class="card-body">
                                                        <div class="card-title">
                                                            <h5>Expenses by Day</h5>
                                                        </div>
                                                        <canvas id="expensesByDayChart"></canvas>
                                                    </div>
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
        groupname = document.getElementById('groupname').innerText;

        // expenses by day
        var mainArr = <?php echo json_encode($mainArr, JSON_PRETTY_PRINT) ?> ;
        var expenseAmountsByDay = <?php echo json_encode($expenseAmountsByDay) ?> ;
        // console.log(expenseAmountsByDay);


        console.log(mainArr);

        // expenses by budget
        let budgetPercentages;
        budgetPercentages = <?php echo json_encode($budgetPercentages) ?> ;

        $(document).ready(function () {
            $('#btn-print').click(function () {
                var reportMonth = document.getElementById("report-month").innerHTML;
                var canvasImg = document.getElementById("expensesByCategoryChart").toDataURL(
                    "image/png", 1.0);
                var canvasImg2 = document.getElementById("expensesByBudgetChart").toDataURL("image/png",
                    1.0);
                var canvasImg3 = document.getElementById("expensesByDayChart").toDataURL("image/png",
                    1.0);
                var doc = new jsPDF('p', 'px', 'a4');
                doc.addFont('Verdana');
                doc.setFont('Verdana');
                doc.setFontSize(17);
                doc.text(100, 20, `${groupname}'s Expenses Report - ${reportMonth}`);
                doc.setFontSize(13);
                doc.text(10, 40, 'Expenses by Category');
                doc.addImage(canvasImg, 'png', 80, 50);
                doc.text(10, 200, 'Expenses by Budget');
                doc.addImage(canvasImg2, 'png', 10, 180, 400, 200);
                doc.text(10, 400, 'Expenses by Day');
                doc.addImage(canvasImg3, 'png', 10, 410, 400, 200);
                doc.save(`${groupname} Expenses Report - ${reportMonth}.pdf`);
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.2.61/jspdf.debug.js"></script>;
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.1/html2pdf.bundle.min.js"></script>;
    <?php include 'footer.php' ?>

</body>

</html>