<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'?>
<!--Font Awesome-->
<link rel="stylesheet" href="../fontawesome/css/all.css">
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


    <div class="container">
        <div class="row">
            <div class="col sidebar">
                <div class="left"><a onclick="toggleSidebar()"><i class="fas fa-times"></i></a></div>
                <div class="row">
                    <div class="profile"><img src="../assets/profile.jpg" alt="">
                        <div class="desc">@chevvycherokee</div>
                    </div>
                </div>

                <div class="row">
                    <ul class="menu">
                        <li class="menu-item" id="menuItem1"><a href="#"></a></li>
                        <li class="menu-item" id="menuItem2"><a href="#"></a></li>
                        <li class="menu-item" id="menuItem3"><a href="#"></a></li>
                        <li class="menu-item" id="menuItem4"><a href="#"></a></li>
                        <li class="menu-item" id="menuItem5"><a href="#"></a></li>
                        <li class="menu-item" id="menuItem6"><a href="#"></a></li>
                        <li class="menu-item" id="menuItem7"><a href="#"></a></li>


                    </div>
                </div>
                
            </div>
        </div>
    </div>


   
<?php include 'footer.php' ?>

</body>

</html>