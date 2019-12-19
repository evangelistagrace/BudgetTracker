<!DOCTYPE html>
<html lang="en">
<?php 
include 'head.php';
require 'personalBudgets-process.php';

// initialize variables
// edit variables
$categoryname = $_GET['categoryname'];
$categorybudget = $_GET['categorybudget'];

// budget array
$query3 = pg_query("SELECT SUM(categorybudget) as totalbudget FROM categories WHERE username = '".$_SESSION['username']."' "); 
$result3 = pg_fetch_array($query3);

// arrays for generating budget chart
$budgetNames = array();
$budgetAngles = array();
$budgetColors = array();

$GLOBALS['BALANCE']= 90;
?>

<title>My Budgets - BudgetTracker</title>

<body>

    <?php include 'navbarDashboard.php'?>
    <div class="container-fluid my-container offset-container">

        <div class="row">
            <!-- SIDEBAR -->
            <?php include 'sidebarDashboard.php'?>

            <!-- MAIN CONTENT -->
            <div class="col-10-body collapsed">

                <h1 class="title text-primary">My Budgets</h1>
                <div class="row">
                    <table style="width: 100%">
                        <tr style="height: 400px;">
                            <td style="width:40%">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">Overview</div>
                                        <div class="card-text">
                                            <div class="row mt-4" style="width:100%">
                                               
                                                <section class="mini-section">
                                                <?php 
                                                    $query = pg_query("SELECT SUM(budgetamount) as totalbudget FROM budgets WHERE username = '".$_SESSION['username']."'"); 
                                                    $result = pg_fetch_array($query);

                                                    $query2 = pg_query("SELECT SUM(expenseamount) as totalexpense FROM expenses WHERE username = '".$_SESSION['username']."'"); 
                                                    $result2 = pg_fetch_array($query2);

                                                    $expensesPercentage = $result2['totalexpense']/$result['totalbudget'] * 100;
                                                    $GLOBALS['BALANCE'] = $result['totalbudget'] - $result2['totalexpense'];
                                                    $totalBudget = $result['totalbudget'];
                                                    // format total budget amount 
                                                    if (strpos($totalBudget, '.') !== false) {
                                                        // trim
                                                        $totalBudget = str_replace(".00","",$totalBudget);;

                                                    }

                                                ?>

                                                    <table class="table-overview">
                                                        <tr>
                                                        <td style="width:10%"><span>RM 0</span></td>
                                                        <td style="width:75%"><div class="progress budget-overview">
                                                    <div class="progress-bar budget-progress progress-bar-striped bg-primary" role="progressbar" style="width: <?php echo $expensesPercentage?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div></td>
                                                        <td style="width:15%"><span>RM <?php echo $totalBudget ?></span></td>
                                                        </tr>
                                                    </table>
                                                </section>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </td>
                            <td style="width:60%">
                                <canvas id="budgetChart"></canvas>
                            </td>
                        </tr>
                    </table>
                </div>
                
                
                <div class="row">
                <?php $query = pg_query("SELECT * FROM budgets WHERE username = '".$_SESSION['username']."' ORDER BY budgetid")?>
                <?php while($result = pg_fetch_array($query)) :?>
                    <?php if($result['budgetamount'] > 0)  :?>
                        <div class="card budget" style="width: 100% ;">
                            <table class='table table-condensed budget'>
                                <tr>
                                    <td rowspan="2"><?php echo $result['budgetname'] ?></td>
                                    <td>
                                        <?php 
                                            $query2 = pg_query("SELECT SUM(expenseamount) as amount FROM expenses WHERE budgetid = '".$result['budgetid']."' AND username = '".$_SESSION['username']."' "); 
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
                                        <div><small>Used +RM <?php echo $result2['amount'] ?? 0 ?></small></div>
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
                                            <div><small class="text-danger">Overspent -RM <?php echo $negativeBalance ?></small></div>
                                        <?php elseif($balance == '0'): ?>
                                            <div><small>Left RM <?php echo $balance ?></small></div>
                                        <?php else: ?>
                                            <div><small>Left +RM <?php echo $balance ?></small></div>
                                        <?php endif ?>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td class="right">
                                        <div class='progress expense'>
                                            <?php 
                                                array_push($budgetNames, $result['budgetname']);
                                                array_push($budgetAngles, $result['budgetamount']);
                                                $color = pg_fetch_array(pg_query("SELECT * FROM colors WHERE colorname = '".$result['budgetcolor']."' "));
                                                $budgetColor = $color['colorhex'];
                                                array_push($budgetColors, $budgetColor);

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

     <script>
        let budgetAngles, budgetNames, budgetColors, BALANCE;
        budgetNames = <?php echo json_encode($budgetNames) ?>;
        budgetAngles = <?php echo json_encode($budgetAngles) ?>;
        budgetColors = <?php echo json_encode($budgetColors) ?>;

        BALANCE = <?php echo json_encode($GLOBALS['BALANCE']) ?>;

        if (BALANCE < 0) {
            BALANCE = Math.abs(BALANCE);
            BALANCE = "-RM " + BALANCE;
        }else {
            BALANCE = "RM " + BALANCE + " left";

        }



     </script>                                               

    <?php include 'footer.php' ?>

</body>

</html>