<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'?>
<title>Dashboard - BudgetTracker</title>

<style>
    body {
        width: 100%;
        height: 100%;
        position: relative;
        display: flex;
        flex-direction: column;
        align-content: flex-start;
        flex-wrap: wrap;
    }
</style>

<body>
    <nav class="navbar small">
        <a class="navbar-brand" href="#"><img id="logo" src="../assets/logo-transparent.svg" alt=""></a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
            <li class="nav-link"><a href="../src/homepage.php">Log Out <i class="fas fa-sign-out-alt"></i></a></li>
            </li>
        </ul>
    </nav>


    <div class="container-fluid my-container offset-container">

        <!-- MAIN CONTENT    -->
        <div class="row">
            <!-- SIDEBAR -->
            <div class="col-2-sidebar sidebar collapsed position-fixed">

                <!-- close button -->
                <div class="close"><a class="toggleBtn" onclick="toggleSidebar()"></a></div>

                <!-- profile section -->
                <div class="profile"><img src="../assets/profile.jpg" alt="">
                    <div class="desc">@chevvycherokee</div>
                </div>

                <!-- menu -->
                <ul class="menu">
                    <li class="menu-item" id="menuItem1"><a href="#"></a></li>
                    <li class="menu-item" id="menuItem2"><a href="#" title="budgets"></a></li>
                    <li class="menu-item" id="menuItem3"><a href="#" title="expenses"></a></li>
                    <li class="menu-item" id="menuItem4"><a href="#" title="reminders"></a></li>
                    <li class="menu-item" id="menuItem5"><a href="#" title="groups"></a></li>
                    <li class="menu-item" id="menuItem6"><a href="#" title="report"></a></li>
                    <li class="menu-item" id="menuItem7"><a href="#" title="settings"></a></li>
                </ul>
            </div>

            <div class="col-10-body collapsed">
                <div class="row">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Balance</h5>
                            <p class="card-text">
                                <table>
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
                                        <td><h4 class="text-primary">+RM 300.00</h4></td>
                                    </tr>
                                </table>
                            </p>
                        </div>
                    </div>

                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Reminders</h5>
                            <p class="card-text">
                                <form action="">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                        <label class="form-check-label" for="defaultCheck1">
                                            Pay hostel fee
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                                        <label class="form-check-label" for="defaultCheck2">
                                            Pay phone bill
                                        </label>
                                    </div>
                                </form>
                            </p>
                            <a href="#" class="btn btn-secondary">Go to reminders <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Groups</h5>
                            <p class="card-text">
                                <ul class="groups-list">
                                    <li><a href="#">Family</a></li>
                                    <li><a href="#">Hostel mates</a></li>
                                    <li><a href="#">Jay's Birthday Party</a></li>
                                </ul>
                            </p>
                            <a href="#" class="btn btn-secondary">Go to groups <i class="fas fa-arrow-right"></i></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="card" style="width: 25rem;">
                        <div class="card-body">
                            <h5 class="card-title">Budgets</h5>
                            <p class="card-text">
                                <div class="progress-container">
                                    <span>Food</span>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 60%"
                                        aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="60%">
                                    </div>
                                </div>
                                </div>
                                <div class="progress-container">
                                    <span>Travel</span>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 40%"
                                        aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="40%">
                                    </div>
                                </div>
                                </div>
                                <div class="progress-container">
                                    <span>Shopping</span>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 50%"
                                        aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="50%">
                                    </div>
                                </div>
                                </div>
                                
                            </p>
                            <a href="#" class="btn btn-secondary">Go to budgets <i class="fas fa-arrow-right"></i></i></a>
                        </div>
                    </div>

                    <div class="card" style="width: 25rem;">
                        <div class="card-body">
                            <h5 class="card-title">Expenses</h5>
                            <p class="card-text">
                            <canvas id="expensesChart"></canvas>
                            </p>
                            <a href="#" class="btn btn-secondary">Go to expenses <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <?php include 'footer.php' ?>

</body>

</html>