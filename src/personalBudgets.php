<!DOCTYPE html>
<html lang="en">
<?php 
include 'head.php';
require 'personalBudgets-process.php';

// initialize variables
// edit variables
$categoryname = $_GET['categoryname'];
$categorybudget = $_GET['categorybudget'];

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
                <div class="row sm"><canvas id="budgetChart"></canvas></div>

                <div class="row">
                <?php $query = pg_query("SELECT * FROM categories WHERE username = '".$_SESSION['username']."' ORDER BY categoryid")?>
                <?php while($result = pg_fetch_array($query)) :?>
                <?php if($result['categorybudget'] == 0) : ?>
                <!-- don't display budgets that have not yet been set -->
                <?php elseif($result['categorybudget'] > 0)  :?>

                    <div class="card budget" style="width: 100% ;">
                        <table class='table table-condensed budget'>
                            
                            <tr>
                                <td rowspan="2"><?php echo $result['categoryname'] ?></td>
                                <td>
                                    <div><small>+RM 0.00</small></div>
                                    <div><small>left RM <?php echo $result['categorybalance']?></small></div>
                                </td>
                                <td class="small" rowspan="2">
                                    <a href="personalBudgets.php?categoryname=<?php echo $result['categoryname']?>&categorybudget=<?php echo $result['categorybudget']?>#editBudget"><i class="fas fa-edit text-primary"></i></a>
                                    <a href="personalBudgets-process.php?del-budget='<?php echo $result['categoryname'] ?>'"><i class="far fa-trash-alt text-danger"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="right">
                                    <div class='progress expense'>
                                        <div class="progress-bar progress-bar-striped bg-warning" role="progressbar"
                                            style="width: 1%;">1%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <?php endif ?>
                    <?php endwhile ?>
                </div>


                <!-- POP-UP: Add budget -->
                <a class="btn btn-danger add-btn" href="#addBudget"><i class="fas fa-plus"></i></a>

                <div id="addBudget" class="overlay">
                    <div class="popup">

                        <div class="content"><a class="close" href="#">x</a>
                            <h3 class="text-center mb-4 mt-4">Add Budget</h3>
                            <form class="popup-form" action="personalBudgets.php" method="POST">
                                <div class="form-group">
                                    <table>
                                        <tr>
                                            <td><label for="budgetCategory">Category</label></td>
                                            <td>
                                                <select class="selectpicker show-tick" data-style="btn-secondary"
                                                    data-size="3" title="Pick a category" name="category-name">
                                                    <?php $query = pg_query("SELECT * FROM categories WHERE username = '".$_SESSION['username']."' ")?>
                                                    <?php while($result = pg_fetch_array($query)) : ?>
                                                    <?php if($result['categorybudget'] == 0)  :?>
                                                    <option value="<?php echo $result['categoryname'] ?>">
                                                        <?php echo $result['categoryname'] ?></option>
                                                    <?php endif ?>
                                                    <?php endwhile ?>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="form-group">
                                    <table>
                                        <tr>
                                            <td><label for="budgetAmount">Amount</label></td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">RM</span>
                                                    </div>
                                                    <input type="text" class="form-control text-right"
                                                        aria-label="Amount (to the nearest ringgit)" placeholder="0" name="category-budget">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">.00</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit" name="add-budget">Add budget</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- Pop-up: Edit budget -->
                <div id="editBudget" class="overlay">
                    <div class="popup">

                        <div class="content"><a class="close" href="#">x</a>
                            <h3 class="text-center mb-4 mt-4">Edit Budget</h3>
                            <form class="popup-form" action="personalBudgets.php" method="POST">
                                <div class="form-group">
                                    <table>
                                        <tr>
                                            <td><label for="budgetCategory">Category</label></td>
                                            <td>
                                                <button class="btn btn-secondary btn-block">
                                                    <?php echo $categoryname ?>
                                                </button>
                                                <input type="hidden" name="category-name" value=<?php echo $categoryname ?>>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="form-group">
                                    <table>
                                        <tr>
                                            <td><label for="budgetAmount">Amount</label></td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">RM</span>
                                                    </div>
                                                    <input type="text" class="form-control text-right"
                                                        aria-label="Amount (to the nearest ringgit)" name="category-budget" value=<?php echo $categorybudget ?>>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">.00</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit" name="add-budget">Edit budget</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <?php include 'footer.php' ?>

    <script>
        //budget chart
        var ctx = document.getElementById('budgetChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Food', 'Travel', 'Groceries'],
                datasets: [{
                    label: '# of Votes',
                    data: [94.74, 189.47, 75.79],
                    backgroundColor: [
                        'rgba(92, 219, 149, 0.5)',
                        'rgba(155, 133, 230, 0.5)',
                        'rgba(173, 228, 151, 0.5)',

                    ],
                    borderColor: [
                        'rgba(92, 219, 149, 1)',
                        'rgba(155, 133, 230, 1)',
                        'rgba(173, 228, 151, 1)',

                    ],
                    borderWidth: 2,

                }]
            },
            options: {

                legend: {
                    position: 'bottom'
                }
            }
        });
    </script>

</body>

</html>