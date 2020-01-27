<!DOCTYPE html>
<html lang="en">
<?php 

include 'head.php';
require 'report-process.php';

?>

<title>My Report - BudgetTracker</title>

<body>

    <?php include 'navbarDashboard.php'?>
    <div class="container-fluid my-container offset-container">

        <div class="row">
            <!-- SIDEBAR -->
            <?php include 'sidebarDashboard.php'?>

            <!-- MAIN CONTENT -->
            <div class="col-10-body collapsed">

                <h1 class="title text-primary">My Report</h1>

                <div class="row justify-content-center">
                    <div class="col-4"><h4 class="text-info text-center"><i class="fas fa-angle-double-left"></i> <span id="report-month">December 2019</span> <i class="fas fa-angle-double-right"></i></h4></div>
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
                                    <div class="card-title"><h5>Expenses by Category</h5></div>
                                    <canvas id="expensesByCategoryChart"></canvas>
                                </div>
                            </div>

                            <div class="card" style="width: 35rem;">
                                <div class="card-body">
                                    <div class="card-title"><h5>Expenses by Budget Usage</h5></div>
                                    <canvas id="expensesByBudgetChart"></canvas>
                                </div>
                            </div>
                    </div>

                    <div class="row" style="width: 100%">
                        <div class="card" style="width: 61rem;">
                            <div class="card-body">
                                <div class="card-title"><h5>Expenses by Day</h5></div>
                                <canvas id="expensesByDayChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <script>
    
        // expenses by category
         let expenseAngles, budgetNames, budgetColors,username;
        budgetNames = <?php echo json_encode($budgetNames) ?>;
        expenseAngles = <?php echo json_encode($expenseAngles) ?>;
        budgetColors = <?php echo json_encode($budgetColors) ?>;
        username = <?php echo json_encode($username) ?>;

        // expenses by day
        let expenseAmountsByDay;
        expenseAmountsByDay = <?php echo json_encode($expenseAmountsByDay) ?>;

        // expenses by budget
        let budgetPercentages;
        budgetPercentages = <?php echo json_encode($budgetPercentages) ?>;

        $(document).ready(function(){
            $('#btn-print').click(function(){
            var reportMonth = document.getElementById("report-month").innerHTML;
            var canvasImg = document.getElementById("expensesByCategoryChart").toDataURL("image/png", 1.0);
            var canvasImg2 = document.getElementById("expensesByBudgetChart").toDataURL("image/png", 1.0);
            var canvasImg3 = document.getElementById("expensesByDayChart").toDataURL("image/png", 1.0);
            var doc = new jsPDF('p', 'px', 'a4');
            doc.addFont('Verdana');
            doc.setFont('Verdana');
            doc.setFontSize(17);
            doc.text(100, 20, `${username}'s Expenses Report - ${reportMonth}`);
            doc.setFontSize(13);
            doc.text(10, 40, 'Expenses by Category');
            doc.addImage(canvasImg, 'png', 80, 50);
            doc.text(10, 200, 'Expenses by Budget');
            doc.addImage(canvasImg2, 'png', 10, 180, 400, 200);
            doc.text(10, 400, 'Expenses by Day');
            doc.addImage(canvasImg3, 'png', 10, 410, 400, 200);
            doc.save(`My Report - ${reportMonth}.pdf`);
        });
    });


    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.2.61/jspdf.debug.js"></script>;
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.1/html2pdf.bundle.min.js"></script>;


    <?php include 'footer.php' ?>

</body>

</html>