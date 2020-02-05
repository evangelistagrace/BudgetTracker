<!DOCTYPE html>
<html lang="en">
<?php 

include 'head.php';
require 'report-process.php';

//get current month
$year = date("Y");
$previousYear = $year - 1;
$nextYear = $year + 1;

//minimum date of expenses
$query = pg_query("SELECT EXTRACT(MONTH FROM MIN(expensedate)) as minexpensemonth, EXTRACT(YEAR FROM MIN(expensedate)) as minexpenseyear FROM expenses WHERE username = '".$_SESSION['username']."' ");
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
                            <a href="report.php?report-month=<?php echo $previousMonth ?>&report-year=<?php echo $previousYear ?>"><i class="fas fa-angle-double-left"></i></a>
                            <?php endif ?> 
                            
                            <span id="report-month"><?php echo $monthName ?> <?php echo $year ?></span> 
                            
                            <?php if($currentMonth > $reportmonth OR $currentYear > $reportyear): ?>
                            <a href="report.php?report-month=<?php echo $nextMonth ?>&report-year=<?php echo $nextYear ?>"><i class="fas fa-angle-double-right"></i></a>
                            <?php endif ?>
                        </h4>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-3">
                        <div id="btn-print" class="btn btn-primary right">Download Report <i class="fas fa-download"></i></div>
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
        var mainArr = <?php echo json_encode($mainArr, JSON_PRETTY_PRINT) ?>;
        var expenseAmountsByDay = <?php echo json_encode($expenseAmountsByDay) ?>;
        // console.log(expenseAmountsByDay);


        console.log( mainArr);

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