<!DOCTYPE html>
<html lang="en">

<?php include 'head.php';?>
<title>BudgetTracker</title>

<style>
.container-fluid {
    width: 100%;
    padding-right: 0;
    padding-left: 0;
    margin-right: auto;
    margin-left: auto;
}
</style>
<body>
    
    <nav class="navbar transparent">
        <a class="navbar-brand" href="#"><img id="logo" src="../assets/logo-transparent.svg" alt=""></a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <li class="nav-link"><a href="../src/register.php">Sign Up</a></li>
            </li>
            <li class="nav-item">
                <li class="nav-link"><a href="../src/login.php">Sign In</a></li>
            </li>
        </ul>
    </nav>

    <div class="container-fluid my-container">

     <div class="header">
     <div class="left">
         <span>Spend</span>
         <span>&</span>
         <span>Track</span>
         <span>Mindful spending made easy</span>
     </div>
     <div class="center">
         <a class="btn btn-primary btn-small" href="../src/register.php">Create an account</a> 
     </div>

    </div>
<div style="height:1000px;background-color:white;font-size:16px">
Scroll Up and Down this page to see the parallax scrolling effect.
This div is just here to enable scrolling.
Tip: Try to remove the background-attachment property to remove the scrolling effect.
</div>
    </div>

<?php include 'footer.php' ?>
<script src="../src/js/toggleNavbar.js"></script>
</body>

</html>