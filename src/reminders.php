<!DOCTYPE html>
<html lang="en">
<?php 
include 'head.php';
require 'reminders-process.php';

// initialize edit variables
$reminderid = $_GET['edit-reminder'];
$remindername = $_GET['reminder-name'];
$reminderbudget = $_GET['reminder-budget'];
$reminderamount = $_GET['reminder-amount'];
$reminderdate = $_GET['reminder-date'];

$month = date("m");
$year = date("Y");

?>
<title>My Budgets - BudgetTracker</title>

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
                    <li class="menu-item" id="menuItem1"><a href="dashboard.php" title="dashboard"></a></li>
                    <li class="menu-item" id="menuItem2"><a href="personalBudgets.php" title="budgets"></a></li>
                    <li class="menu-item" id="menuItem3"><a href="personalExpenses.php" title="expenses"></a></li>
                    <li class="menu-item active" id="menuItem4"><a href="reminders.php" title="reminders"></a></li>
                    <li class="menu-item" id="menuItem8"><a href="notifications.php" title="notifications"></a>
                    <?php if($count > 0): ?>
                    <span class="badge"><?php echo $count ?></span>
                    <?php endif ?>
                    </li>
                    <li class="menu-item" id="menuItem5"><a href="groups.php" title="groups"></a></li>
                    <li class="menu-item" id="menuItem6"><a href="report.php" title="report"></a></li>
                    <li class="menu-item" id="menuItem7"><a href="settings.php" title="settings"></a></li>
                </ul>
            </div>

            <!-- MAIN CONTENT -->
            <div class="col-10-body collapsed">

                <h1 class="title text-primary">My Reminders</h1>

                <div class="row">
                    <div class="card" style="width: 80%">
                        <div class="progress" style="height: 5px;border-radius:0;">
                            <div class="progress-bar progress-reminder bg-secondary" id="progress-reminder" role="progressbar"
                                style="width: 0%; border-radius:0;" aria-valuenow="25" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                        <div class="card-body reminders">
                            <table class='table table-condensed reminders'>
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="flex:1"></th>
                                        <th style="flex:4">Item</th>
                                        <th style="flex:2">Category</th>
                                        <th style="flex:2">Payment</th>
                                        <th style="flex:2">Due</th>
                                        <th style="flex:1"></th>

                                    </tr>
                                </thead>
                            <?php $query = pg_query("SELECT reminders.reminderid, reminders.budgetid, reminders.remindername, reminders.reminderamount, reminders.reminderdone, reminders.reminderdate, budgets.budgetid, budgets.budgetname, budgets.budgetcolor FROM reminders INNER JOIN budgets ON reminders.budgetid = budgets.budgetid WHERE reminders.username = '".$_SESSION['username']."' ORDER BY reminders.reminderid") ?>
                            <?php while($reminder = pg_fetch_array($query)):?>
                                <tr>
                                <?php if($reminder['reminderdone'] === f):?>
                                    <td><a href="reminders-process.php?reminder-done=t&reminder-id=<?php echo $reminder['reminderid']?>&budget-id=<?php echo $reminder['budgetid']?>&reminder-name=<?php echo $reminder['remindername']?>&reminder-amount=<?php echo $reminder['reminderamount']?>"><i class="far fa-square reminder-check"></i></a></div>
                                    </td>
                                    <td style="flex:4"><?php echo $reminder['remindername'] ?></td>
                                <?php elseif($reminder['reminderdone'] === t):?>
                                    <td><a href="reminders-process.php?reminder-done=f&reminder-id=<?php echo $reminder['reminderid']?>"><i class="fas fa-check-square reminder-check"></i></a></div>
                                    </td>
                                    <td style="flex:4"><s><?php echo $reminder['remindername'] ?></s></td>
                                <?php endif ?>
                                    <td style="flex:2">
                                        <div class='<?php echo "circle bg-{$reminder['budgetcolor']}" ?>'></div><?php echo $reminder['budgetname'] ?>
                                    </td>
                                    <td style="flex:2">RM <?php echo $reminder['reminderamount'] ?></td>
                                    <td style="flex:2"><?php echo date("j F", strtotime($reminder['reminderdate'])) ?></td>
                                    <td>
                                        <!-- edit reminder -->
                                        <a href="reminders.php?edit-reminder=<?php echo $reminder['reminderid']?>&reminder-name=<?php echo $reminder['remindername']?>&reminder-budget=<?php echo $reminder['budgetname']?>&reminder-amount=<?php echo $reminder['reminderamount']?>&reminder-date=<?php echo $reminder['reminderdate']?>#editReminder"><i class="fas fa-edit text-primary"></i></a>
                                        
                                        <!-- delete reminder -->
                                        <a href="reminders-process.php?del-reminder=<?php echo $reminder['reminderid']?>"><i class="far fa-trash-alt text-danger"></i></a>
                                    </td>
                                </tr>
                            <?php endwhile ?>
                            </table>
                        </div>
                    </div>
                </div>


                <a class="btn btn-danger add-btn" href="#addReminder"><i class="fas fa-plus"></i></a>

                <!-- add reminder -->
                <div id="addReminder" class="overlay">
                    <div class="popup">

                        <div class="content"><a class="close" href="#">x</a>
                            <h3 class="text-center mb-4 mt-4">Add Reminder</h3>
                            <form class="popup-form" action="reminders.php" method="POST">
                                <div class="form-group">
                                    <table>
                                        <tr>
                                            <td><label for="expenseTitle">Title</label></td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="reminder-name"
                                                        id="reminderName" maxlength="140" placeholder="e.g: Pay phone bill...">
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="form-group">
                                    <table>
                                        <tr>
                                            <td><label for="budgetCategory">Budget Category</label></td>
                                            <td><select class="selectpicker show-tick" data-style="btn-secondary"
                                                        data-size="3" title="Pick a category" name="budget-name">
                                                        <?php $query = pg_query("SELECT * FROM budgets WHERE EXTRACT(MONTH FROM budgetdate) = $month AND EXTRACT(YEAR FROM budgetdate) = $year AND username = '".$_SESSION['username']."' ")?>
                                                        <?php while($result = pg_fetch_array($query)) : ?>
                                                        <option value="<?php echo $result['budgetname'] ?>">
                                                            <?php echo $result['budgetname'] ?></option>
                                                        <?php endwhile ?>
                                                    </select></td>
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
                                                        aria-label="Amount (to the nearest ringgit)" placeholder="0.00" name="reminder-amount">
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="form-group">
                                    <table>
                                        <tr>
                                            <td><label for="reminderDate">Due Date</label></td>
                                            <td>
                                                <div class="input-group">
                                                    <input class="form-control" type="date" name="reminder-date"
                                                        id="reminderDate">
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>


                                <div class="form-group">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit" name="add-reminder">Add reminder</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- edit reminder -->
                <div id="editReminder" class="overlay">
                    <div class="popup">

                        <div class="content"><a class="close" href="#">x</a>
                            <h3 class="text-center mb-4 mt-4">Edit Reminder</h3>
                            <form class="popup-form" action="reminders.php" method="POST">
                                <div class="form-group">
                                    <table>
                                        <tr>
                                            <td><label for="expenseTitle">Title</label></td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="reminder-name"
                                                        id="reminderName" value="<?php echo $remindername ?>">
                                                    <input type="hidden" name="reminder-id"  value=<?php echo $reminderid ?>>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="form-group">
                                    <table>
                                        <tr>
                                            <td><label for="budgetCategory">Budget Category</label></td>
                                            <td><select class="selectpicker show-tick" data-style="btn-secondary"
                                                    data-size="3" title="Pick a category" name="reminder-budget">
                                                    <?php $query = pg_query("SELECT * FROM budgets WHERE EXTRACT(MONTH FROM budgetdate) = $month AND EXTRACT(YEAR FROM budgetdate) = $year AND username = '".$_SESSION['username']."' ")?>
                                                    <?php while($result = pg_fetch_array($query)) : ?>
                                                    <?php if($result['budgetname'] == $reminderbudget): ?>
                                                        <option value="<?php echo $result['budgetname'] ?>" selected>
                                                        <?php echo $result['budgetname'] ?></option>
                                                    <?php else: ?>
                                                    <option value="<?php echo $result['budgetname'] ?>">
                                                        <?php echo $result['budgetname'] ?></option>
                                                    <?php endif ?>
                                                    <?php endwhile ?>
                                                </select></td>
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
                                                        aria-label="Amount (to the nearest ringgit)" value=<?php echo $reminderamount ?> name="reminder-amount">
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="form-group">
                                    <table>
                                        <tr>
                                            <td><label for="reminderDate">Due Date</label></td>
                                            <td>
                                                <div class="input-group">
                                                    <input class="form-control" type="date" name="reminder-date" value=<?php echo $reminderdate ?>
                                                        id="reminderDate">
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>


                                <div class="form-group">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit" name="edit-reminder">Edit reminder</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <script>
        var text = '<?php echo $json_text ?>';
        console.log(text);
    </script>

    <?php include 'footer.php' ?>


</body>

</html>