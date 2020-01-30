<!DOCTYPE html>
<html lang="en">
<?php 

include 'head.php';
require 'groupReport-process.php';

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
                                        <div class="card-title">Report</div>
                                        <div class="row justify-content-center">
                                            <div class="col-4">
                                                <h4 class="text-info text-center"><i
                                                        class="fas fa-angle-double-left"></i> <span
                                                        id="report-month">December 2019</span> <i
                                                        class="fas fa-angle-double-right"></i></h4>
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