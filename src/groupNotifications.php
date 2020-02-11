<!DOCTYPE html>
<html lang="en">
<?php 

include 'head.php';
require 'groupBudgets-process.php';

// initialize variables
$groupingid = $_GET['grouping-id'];

?>
<title>My Groups - BudgetTracker</title>

<body>

    <?php include 'navbarDashboard.php'?>
    <div class="container-fluid my-container offset-container">

        <div class="row">
            <!-- SIDEBAR -->
            <div class="col-2-sidebar sidebar collapsed position-fixed">
                <div class="close"><a class="toggleBtn" onclick="toggleSidebar()"></a></div>

                <div class="profile"><img src="../assets/profile.jpg" alt="">
                    <div class="desc">@
                    
                    <?php if(isset($_SESSION['username'])): ?>
                        <?php echo $_SESSION['username'] ?>
                    <?php endif ?>


                    </div>
                </div>

                <!-- count number of notifications -->
                <?php $query = pg_query("SELECT COUNT(notificationstatus) AS count FROM notifications WHERE recipientusername = '".$_SESSION['username']."' "); $result = pg_fetch_array($query); $count = $result['count'] ?>
                <ul class="menu">
                    <li class="menu-item active" id="menuItem1"><a href="dashboard.php" title="dashboard"></a></li>
                    <li class="menu-item" id="menuItem2"><a href="personalBudgets.php" title="budgets"></a></li>
                    <li class="menu-item" id="menuItem3"><a href="personalExpenses.php" title="expenses"></a></li>
                    <li class="menu-item" id="menuItem4"><a href="reminders.php" title="reminders"></a></li>
                    <li class="menu-item" id="menuItem8"><a href="notifications.php" title="notifications"></a>
                    <?php if($count > 0): ?>
                    <span class="badge"><?php echo $count ?></span>
                    <?php endif ?>
                    </li>
                    <li class="menu-item active" id="menuItem5"><a href="groups.php" title="groups"></a></li>
                    <li class="menu-item" id="menuItem6"><a href="report.php" title="report"></a></li>
                    <li class="menu-item" id="menuItem7"><a href="settings.php" title="settings"></a></li>
                </ul>
            </div>

            <!-- MAIN CONTENT -->
            <div class="col-10-body collapsed">

                <h1 class="title text-primary">My Groups</h1>


                <a href="groups.php">
                    <h6 class="text-info text-left"><i class="fas fa-angle-double-left"></i>Back to My Groups</i></h6>
                </a>

                <?php 
                        //select all groups the session user is in
                        $query = pg_query("SELECT * FROM groups WHERE groupingid = $groupingid LIMIT 1");
                        
                    ?>

                <?php while($group = pg_fetch_array($query)): ?>
                <div class="row justify-content-center">
                    <div class="col-4">
                        <h3 class="text-primary text-center"><?php echo $group['groupname'] ?></h3>
                    </div>
                </div>

                <div class="row">
                    <div class="container">

                        <div class="card text-center">
                            <div class="card-header tabbed-card">
                                <ul class="nav nav-tabs card-header-tabs">
                                    <li>
                                        <a href="groupDashboard.php?grouping-id=<?php echo $groupingid?>"><i
                                                class="fas fa-home"></i> Overview</a>
                                    </li>
                                    <li>
                                        <a href="groupBudgets.php?grouping-id=<?php echo $groupingid?>"><i
                                                class="fas fa-chart-pie"></i> Budgets</a>
                                    </li>
                                    <li>
                                        <a href="groupExpenses.php?grouping-id=<?php echo $groupingid?>"><i
                                                class="fas fa-wallet"></i> Expenses</a>
                                    </li>
                                    <li>
                                        <a href="groupReminders.php?grouping-id=<?php echo $groupingid?>"><i
                                                class="fas fa-list"></i> Reminders</a>
                                    </li>
                                    <li class="active">
                                        <a href="groupNotifications.php?grouping-id=<?php echo $groupingid?>"><i
                                                class="fas fa-bell"></i> Notifications</a>
                                    </li>
                                    <li>
                                        <a href="groupReport.php?grouping-id=<?php echo $groupingid?>"><i
                                                class="fas fa-chart-line"></i> Report</a>
                                    </li>
                                    <li>
                                        <a href="groupSettings.php?grouping-id=<?php echo $groupingid?>"><i
                                                class="fas fa-cog"></i> Settings</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content ">
                                    <!-- Notifications -->
                                    <div class="tab-pane active" id="5">
                                        <div class="row notification-container" style="width:100%">
                                            <p class="dismiss text-right"><a id="dismiss-all" href="groupnotifications-process.php?dismiss-all=<?php echo $groupingid ?>">Dismiss All</a></p>

                                            <?php
                                            $query = pg_query("SELECT * FROM groupnotifications WHERE groupingid = $groupingid ");
                                        ?>

                                        <?php if(pg_num_rows($query) >= 1): ?>
                                        <?php while($notification = pg_fetch_array($query)): ?>
                                        <!-- invitation -->
                                        <!-- accepted invitations -->
                                        <?php if($notification['notificationtype'] === 'Accept'): ?>
                                        <div class="card notification-card notification-invitation">
                                            <div class="card-body">
                                            <table>
                                                <tr>
                                                <td style="width:85%">
                                                    <div class="card-title">
                                                    <?php echo $notification['notificationmessage']?>
                                                    </div>
                                                </td>
                                                <td class="right" style="width:15%; justify-content: space-around;
                                                display: flex;">
                                                    <!-- dismiss notification -->
                                                    <a href="groupnotifications-process.php?grouping-id=<?php echo $groupingid ?>&dismiss-notification-id=<?php echo $notification['id'] ?>"
                                                    class="btn btn-danger dismiss-notification">Dismiss</a>
                                                </td>
                                                </tr>
                                                <tr colspan="2">
                                                <td><small><i
                                                        class="far fa-calendar-alt mr-1"></i><?php $d = $notification['notificationdate']; $date = date("j F Y", strtotime($d)); echo $date ?></small>
                                                </td>
                                                </tr>
                                            </table>
                                            </div>
                                        </div>
                                        <?php endif ?>
                                        <?php endwhile ?>
                                        <?php elseif(pg_num_rows($query) == 0): ?>
                                        <h4 class="text-center">All caught up!</h4>
                                        <?php endif ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <?php endwhile ?>

            </div>
        </div>
    </div>

    <?php include 'footer.php' ?>
    <!-- dismiss notifications -->
    <script>
        const dismissAll = document.getElementById('dismiss-all');
        const dismissBtns = Array.from(document.querySelectorAll('.dismiss-notification'));

        const notificationCards = document.querySelectorAll('.notification-card');

        dismissBtns.forEach(btn => {
          btn.addEventListener('click', function (e) {
            e.preventDefault;
            console.log("clicked")
            var parent = e.target.parentElement.parentElement.parentElement.parentElement.parentElement
              .parentElement;
            parent.classList.add('display-none');
          })
        });

        // dismissAll.addEventListener('click', function (e) {
        //   e.preventDefault;
        //   notificationCards.forEach(card => {
        //     card.style.display = 'none';
        //   });
        //   const row = document.querySelector('.notification-container');
        //   const message = document.createElement('h4');
        //   message.classList.add('text-center');
        //   message.innerHTML = 'All caught up!';
        //   row.appendChild(message);
        // })
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

</body>

</html>