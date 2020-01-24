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
                                    <div class="card-title"><h5>Expenses by Budget</h5></div>
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
         let expenseAngles, budgetNames, budgetColors;
        budgetNames = <?php echo json_encode($budgetNames) ?>;
        expenseAngles = <?php echo json_encode($expenseAngles) ?>;
        budgetColors = <?php echo json_encode($budgetColors) ?>;

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
            var canvasImg2 = document.getElementById("expensesByDayChart").toDataURL("image/png", 1.0);
            var doc = new jsPDF('p', 'pt', 'a4');
            doc.setFontSize(15);
            doc.setFillColor(255, 255,255);
            doc.rect(10, 10, 400, 160, "F");
            // doc.text(20, 20, 'Chart 1');
            doc.addImage(canvasImg, 'png', 10, 10, 300, 100);
            // doc.text(20, 90, 'Chart 2');
            doc.addImage(canvasImg2, 'png', 10, 300, 400, 200);
            doc.save(`My Report - ${reportMonth}.pdf`);
        });
    });


    </script>
    


    <?php include 'footer.php' ?>

</body>

</html>