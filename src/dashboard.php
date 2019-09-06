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


    <div class="container-fluid my-container">

        <!-- MAIN CONTENT    -->
        <div class="row">
            <div class="col-2-sidebar sidebar">

                <!-- close button -->
                <div class="close"><a class="toggleBtn" onclick="toggleSidebar()"></a></div>

                <!-- profile section -->
                <div class="profile"><img src="../assets/profile.jpg" alt="">
                    <div class="desc">@chevvycherokee</div>
                </div>

                <!-- menu -->
                <ul class="menu">
                    <li class="menu-item" id="menuItem1"><a href="#" title="dashboard"></a></li>
                    <li class="menu-item" id="menuItem2"><a href="#" title="budgets"></a></li>
                    <li class="menu-item" id="menuItem3"><a href="#" title="expenses"></a></li>
                    <li class="menu-item" id="menuItem4"><a href="#" title="reminders"></a></li>
                    <li class="menu-item" id="menuItem5"><a href="#" title="groups"></a></li>
                    <li class="menu-item" id="menuItem6"><a href="#" title="report"></a></li>
                    <li class="menu-item" id="menuItem7"><a href="#" title="settings"></a></li>
                </ul>


            </div>

        </div>

        <!-- <div class="row">
            <div class="col sidebar">
                <div class="close"><a class="toggleBtn" onclick="toggleSidebar()"></a></div>
                <div class="row">
                    <div class="profile"><img src="../assets/profile.jpg" alt="">
                        <div class="desc">@chevvycherokee</div>
                    </div>
                </div>

                <div class="row">
                   

                    </div>
                </div>
                
            </div> -->


        <div class="row">
            <div class="col-2">SIDEBAR</div>
            <div class="col-7">MAIN</div>
        </div>


    </div>
    </div>



    <?php include 'footer.php' ?>

</body>

</html>