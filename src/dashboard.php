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
        <a class="navbar-brand" href="#"><img id="logo" src="../assets/bt-logo-white.png" alt=""></a>
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
                                <h1>+RM 500</h1>
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
                                </form>
                            </p>
                            <a href="#" class="btn btn-primary">Go to reminders >></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Reminders</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of
                                the card's content.</p>
                            <a href="#" class="btn btn-primary">Go to reminders -></a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <?php include 'footer.php' ?>

</body>

</html>