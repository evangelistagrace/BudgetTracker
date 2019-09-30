<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'?>
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

                
              <a href=""><h6 class="text-info text-left"><i class="fas fa-angle-double-left"></i>Back to My Groups</i></h6></a>


                <div class="row justify-content-center">
                    <div class="col-4"><h3 class="text-info text-center">Family</h3></div>
                </div>


                <div class="row">
                    <div class="card" style="width:80rem">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">Overview</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Budget</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Expenses</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">View Report</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                                <div class="row" style="width:100%">
                                    <div class="card" style="width: 15rem;">
                                        <div class="card-body">
                                            <h5 class="card-title">Balance</h5>
                                            <p class="card-text">
                                                <table class="balance">
                                                    <tr>
                                                        <td>Inflow</td>
                                                        <td><span class="text-primary">+RM 1, 000.00</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Outflow</td>
                                                        <td><span class="text-secondary">-RM 700.00</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Balance</td>
                                                        <td>
                                                            <h4 class="text-primary">+RM 300.00</h4>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="card" style="width: 15rem;">
                                        <div class="card-body">
                                            <h5 class="card-title">Budgets</h5>
                                            <p class="card-text">
                                                <div class="progress-container">
                                                    <span>Food</span>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped bg-warning"
                                                            role="progressbar" style="width: 60%" aria-valuenow="10"
                                                            aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip"
                                                            data-placement="top" title="60%">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="progress-container">
                                                    <span>Travel</span>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped bg-warning"
                                                            role="progressbar" style="width: 40%" aria-valuenow="10"
                                                            aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip"
                                                            data-placement="top" title="40%">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="progress-container">
                                                    <span>Groceries</span>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped bg-warning"
                                                            role="progressbar" style="width: 50%" aria-valuenow="10"
                                                            aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip"
                                                            data-placement="top" title="50%">
                                                        </div>
                                                    </div>
                                                </div>

                                            </p>
                                            <a href="personalBudgets.php" class="btn btn-secondary btn-sm right">Go to
                                                budgets <i class="fas fa-arrow-right"></i></i></a>
                                        </div>
                                    </div>

                                    <div class="card" style="width: 15rem;">
                                        <div class="card-body">
                                            <h5 class="card-title">Expenses</h5>
                                            <p class="card-text">
                                                <canvas id="expensesChart2"></canvas>
                                            </p>
                                            <a href="#" class="btn btn-secondary btn-sm right">Go to expenses <i
                                                    class="fas fa-arrow-right"></i></a>
                                        </div>
                                    </div>

                                </div>
                          
                        </div>
                    </div>

                </div>
                <a class="btn btn-danger add-btn" href="#addGroup"><i class="fas fa-plus"></i></a>

                <div id="addGroup" class="overlay">
                    <div class="popup">

                        <div class="content"><a class="close" href="#">x</a>
                            <h3 class="text-center mb-4 mt-4">Add Group</h3>
                            <form class="popup-form" action="">
                                <div class="form-group">
                                    <label for="groupTitle">Group Name</label>
                                    <div class="input-group ml-3">
                                        <input type="text" class="form-control" name="groupTitle" id="groupTitle"
                                            placeholder="Enter group name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="groupIcon">Group Icon</label>
                                    <div class="input-group ml-3">
                                        <select id="groupIcon" class="selectpicker show-tick" data-style="btn-secondary"
                                            data-width="100%" data-size="3" title="Pick an icon">
                                            <option value="icon-1"
                                                data-content="<img src='../assets/icons/icon-1.png' style='width:40px;'>">
                                            </option>
                                            <option value="icon-2"
                                                data-content="<img src='../assets/icons/icon-2.png' style='width:40px;'>">
                                            </option>
                                            <option value="icon-3"
                                                data-content="<img src='../assets/icons/icon-3.png' style='width:40px;'>">
                                            </option>

                                        </select>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="budgetAmount">Add Members</label>
                                    <div class="input-group ml-3">
                                        <input type="email" class="form-control mb-3 block"
                                            placeholder="Enter an email...">
                                        <input type="email" class="form-control block" placeholder="Enter an email...">
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="budgetAmount"></label>
                                    <div class="input-group ml-3">
                                        <div class="btn btn-round btn-secondary">+</div>
                                        <div class="btn btn-secondary">Send invitation</div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary btn-lg btn-block">Add group</button>

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
    
//expenses chart
var ctx = document.getElementById('expensesChart2').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        //labels: ['Food', 'Clothing', 'Travel', 'Gifts', 'Misc'],
        datasets: [{
           // label: '# of Votes',
            data: [12, 8, 3, 5, 2],
            backgroundColor: [
                'rgba(92, 219, 149, 0.5)',
                'rgba(155, 133, 230, 0.5)',
                'rgba(173, 228, 151, 0.5)',
                'rgba(185, 227, 198, 0.5)',
                'rgba(134, 192, 230, 0.5)',
            ],
            borderColor: [
                'rgba(92, 219, 149, 1)',
                'rgba(155, 133, 230, 1)',
                'rgba(173, 228, 151, 1)',
                'rgba(185, 227, 198, 1)',
                'rgba(134, 192, 230, 1)',
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