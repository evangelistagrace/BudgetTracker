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
                                            <div class="row" style="width:100%">
                                                <div class="col" style="padding:0;margin:0; flex:1" >
                                                    <small>RM 0</small>
                                                </div>

                                                <?php 
                                                    $query = pg_query("SELECT SUM(budgetamount) as totalbudget FROM budgets WHERE username = '".$_SESSION['username']."'"); 
                                                    $result = pg_fetch_array($query);

                                                    $query2 = pg_query("SELECT SUM(expenseamount) as totalexpense FROM expenses WHERE username = '".$_SESSION['username']."'"); 
                                                    $result2 = pg_fetch_array($query);
                                                ?>


                                                <div class="col" style="flex:7;padding:2px;margin:0;">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped bg-warning" role="progressbar"
                                                        style="width: <?php echo 80 ?>%;"></div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col" style="padding:0;margin:0; flex:3">
                                                    
                                                    <small>RM <?php echo $result['totalbudget'] ?></small>
                                                </div>
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
                                            $query2 = pg_query("SELECT SUM(expenseamount) as amount FROM expenses WHERE budgetid = '".$result['budgetid']."'"); 
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
        let budgetAngles, budgetNames, budgetColors;
        budgetNames = <?php echo json_encode($budgetNames) ?>;
        budgetAngles = <?php echo json_encode($budgetAngles) ?>;
        budgetColors = <?php echo json_encode($budgetColors) ?>;

     </script>                                               

    <?php include 'footer.php' ?>

</body>

</html>