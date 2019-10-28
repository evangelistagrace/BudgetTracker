<?php

    require 'config.php';

    echo '<div class="col-2-sidebar sidebar collapsed position-fixed">
    <div class="close"><a class="toggleBtn" onclick="toggleSidebar()"></a></div>

    <div class="profile"><img src="../assets/profile.jpg" alt="">
        <div class="desc">@';
        
        if(isset($_SESSION['username'])){
            echo $_SESSION['username']; 
        }


       echo '</div>
    </div>

    <ul class="menu">
        <li class="menu-item" id="menuItem1"><a href="dashboard.php" title="dashboard"></a></li>
        <li class="menu-item" id="menuItem2"><a href="personalBudgets.php" title="budgets"></a></li>
        <li class="menu-item" id="menuItem3"><a href="personalExpenses.php" title="expenses"></a></li>
        <li class="menu-item" id="menuItem4"><a href="reminders.php" title="reminders"></a></li>
        <li class="menu-item" id="menuItem5"><a href="groups.php" title="groups"></a></li>
        <li class="menu-item" id="menuItem6"><a href="report.php" title="report"></a></li>
        <li class="menu-item" id="menuItem7"><a href="settings.php" title="settings"></a></li>
    </ul>
    </div>';
?>