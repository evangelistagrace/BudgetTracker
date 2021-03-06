<!DOCTYPE html>
<html lang="en">
<?php 

include 'head.php';
require 'groupSettings-process.php';

// initialize variables
$groupingid = $_GET['grouping-id'];

//admin username
$query = pg_query("SELECT adminusername FROM groups WHERE groupingid = $groupingid LIMIT 1");
$result = pg_fetch_array($query);
$admin = $result['adminusername'];

$username = $_SESSION['username'];
$income = "Add income...";
if(!isset($_GET['editState']) && !isset($_GET['budgetid'])){
    // set default GET values
    $editState = false;
    $budgetid = "";
    $budgetname = "";
    $budgetamount = "";
    $budgetcolor = "";
}else{
    $editState = $_GET['editState'];
    $budgetid = $_GET['budgetid'];
    $budgetname = $_GET['budgetname'];
    $budgetamount = $_GET['budgetamount'];
    $budgetcolor = $_GET['budgetcolor'];
}

$currentmonth = date("m");
$currentyear = date("Y");

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
                    <li class="menu-item" id="menuItem1"><a href="dashboard.php" title="dashboard"></a></li>
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
                                    <li>
                                        <a href="groupNotifications.php?grouping-id=<?php echo $groupingid?>"><i
                                                class="fas fa-bell"></i> Notifications</a>
                                    </li>
                                    <li>
                                        <a href="groupReport.php?grouping-id=<?php echo $groupingid?>"><i
                                                class="fas fa-chart-line"></i> Report</a>
                                    </li>
                                    <li class="active">
                                        <a href="groupSettings.php?grouping-id=<?php echo $groupingid?>"><i
                                                class="fas fa-cog"></i> Settings</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <!-- settings -->
                                <div class="tab-pane active" id="7">
                                    <div class="row"
                                        style="display:flex;justify-content:center;margin:auto;width:100%;">
                                        <div class="card settings" style="width: 100%">
                                            <div class="card-body">
                                                <h5 class="text-left"><strong>Maximum Budget</strong></h5>
                                                <table class='table borderless'>
                                                <?php if($_SESSION['username'] === $admin):?>
                                                    <form
                                                        action="groupSettings.php?grouping-id=<?php echo $groupingid ?>"
                                                        method="POST">
                                                        <tr>
                                                            <?php 
                                                                    $query = pg_query("SELECT maxbudget FROM groups WHERE groupingid = $groupingid AND memberusername ='".$_SESSION['username']."' "); 
                                                                    $result = pg_fetch_array($query);

                                                                    if($result['maxbudget'] == 0){
                                                                    $placeholder = "Enter maximum budget..."; $btnText = "Add Max. Budget";
                                                                    }
                                                                    elseif($result['maxbudget'] > 0){
                                                                    $placeholder = $result['maxbudget']; 
                                                                    $btnText = "Edit Max. Budget";
                                                                    }?>
                                                            <td style="width:75%">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">RM</span>
                                                                    </div><input class="form-control text-right"
                                                                        name="new-max-budget" id="income" type="text"
                                                                        value=""
                                                                        placeholder="<?php echo $placeholder ?>">
                                                                </div>
                                                                <input type="hidden" name="grouping-id"
                                                                    value=<?php echo $groupingid ?>>
                                                            </td>
                                                            <td style="width:25%"><button name="add-max-budget"
                                                                    class="btn btn-block btn-info"><?php echo $btnText ?></button>
                                                            </td>
                                                        </tr>
                                                    </form>
                                                <?php else: ?>
                                                    <tr>
                                                        <?php 
                                                                $query = pg_query("SELECT maxbudget FROM groups WHERE groupingid = $groupingid AND memberusername ='".$_SESSION['username']."' "); 
                                                                $result = pg_fetch_array($query);

                                                                if($result['maxbudget'] == 0){
                                                                $placeholder = "Enter maximum budget..."; $btnText = "Add Max. Budget";
                                                                }
                                                                elseif($result['maxbudget'] > 0){
                                                                $placeholder = $result['maxbudget']; 
                                                                $btnText = "Edit Max. Budget";
                                                                }?>
                                                        <td style="width:100%">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">RM</span>
                                                                </div><input readonly class="form-control text-right"
                                                                    name="new-max-budget" id="income" type="text"
                                                                    value=""
                                                                    placeholder="<?php echo $placeholder ?>">
                                                            </div>
                                                            <input type="hidden" name="grouping-id"
                                                                value=<?php echo $groupingid ?>>
                                                        </td>
                                                    </tr>
                                                <?php endif ?>
                                                </table>
                                                <hr>

                                                <!-- reminders -->
                                                <h5 class="text-left"><strong>Notifications</strong></h5>
                                                <table class='table table-condensed settings2'>
                                                    <tr>
                                                        <td><input type="checkbox" class="checkbox" checked>Allow pop-up notifications
                                                        </td>

                                                        <td><input type="checkbox" class="checkbox">Email notifications
                                                        </td>

                                                    </tr>
                                                </table>
                                                <hr>

                                                <!-- budgets -->
                                                <h5 class="text-left"><strong>Budgets</strong></h5>
                                                
                                                <?php if($_SESSION['username'] === $admin):?>
                                                <?php
                                                //find total expense amount
                                                $query2 = pg_query("SELECT SUM(expenseamount) AS totalexpense FROM groupexpenses WHERE EXTRACT(MONTH FROM expensedate) = $currentmonth AND EXTRACT(YEAR FROM expensedate) = $currentyear AND groupingid = $groupingid ");
                                                $result = pg_fetch_array($query2);
                                                $outflow = $result['totalexpense'];

                                                // find income
                                                $query3 = pg_query("SELECT maxbudget FROM groups WHERE groupingid = $groupingid ");
                                                $result = pg_fetch_array($query3);
                                                $income = $result['maxbudget'];

                                                // format outflow amount 
                                                if (strpos($outflow, '.') !== false) {
                                                    // do nothing
                                                }else{
                                                    $outflow .= ".00";
                                                }

                                                $balance = $income - $outflow;
                                                // format balance amount 
                                                if (strpos($balance, '.') !== false) {
                                                    // do nothing
                                                }else{
                                                    $balance .= ".00";
                                                }

                                                ?>
                                                    <table class="table table-sm table-borderless mb-0">
                                                    <tr style="display: flex;">
                                                        <td style="flex:1"><small>Create up to 10 budgets</small></td>
                                                        <td style="flex:1; text-align: right"><small><?php echo "Available balance: RM ".$balance ?></small></td>
                                                    </tr>
                                                    </table>
                                                    <form action="groupSettings.php?grouping-id=<?php echo $groupingid ?>"
                                                        method="POST">
                                                        <table class="table borderless">
                                                        <?php if(count($warnings)): ?>
                                                        <div class="error">
                                                            <?php foreach($warnings as $warning): ?>
                                                            <div class="alert alert-warning"><?php echo $warning ?></div>
                                                            <?php endforeach ?>
                                                        </div>
                                                        <?php endif ?>
                                                            <?php if(count($errors)) : ?>
                                                            <div class="error">
                                                                <?php foreach($errors as $error): ?>
                                                                <div class="alert alert-danger"><?php echo $error ?></div>
                                                                <?php endforeach ?>
                                                            </div>
                                                            <?php endif ?>
                                                            <tr>
                                                                <td style="width:35%">
                                                                    <input type="hidden" name="budget-id"
                                                                        value=<?php echo $budgetid ?>>
                                                                    <input class="form-control" type="text"
                                                                        name="budget-name" required
                                                                        placeholder="Budget Name"
                                                                        value=<?php echo $budgetname ?>>
                                                                    <input type="hidden" name="grouping-id"
                                                                        value=<?php echo $groupingid ?>>
                                                                </td>
                                                                <td style="width: 35%">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">RM</span>
                                                                        </div>
                                                                        <input class="form-control text-right"
                                                                            name="budget-amount" type="text" placeholder="0"
                                                                            value=<?php echo $budgetamount ?>>
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text">.00</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td style="width:30%">
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <select id="groupIcon"
                                                                                class="selectpicker show-tick"
                                                                                data-style="bg-light text-dark"
                                                                                data-width="100%" data-size="3"
                                                                                title="Pick a color" name="budget-color"
                                                                                value=<?php echo $budgetcolor ?>>
                                                                                <?php  $query = pg_query("SELECT * FROM groupcolors WHERE groupingid = $groupingid ORDER BY colortaken DESC"); ?>
                                                                                <?php while($result = pg_fetch_array($query)): ?>
                                                                                <?php if($editState == false):?>
                                                                                <?php if($result['colortaken'] == f): ?>
                                                                                <option
                                                                                    value=<?php echo $result['colorname']?>
                                                                                    data-icon='<?php echo "fas fa-circle {$result['colorname']}" ?>'>
                                                                                    <?php echo $result['colorname']?>
                                                                                </option>
                                                                                <?php endif ?>
                                                                                <?php elseif($editState == true):?>
                                                                                <?php if($budgetcolor == $result['colorname']): ?>
                                                                                <option
                                                                                    value=<?php echo $result['colorname']?>
                                                                                    data-icon='<?php echo "fas fa-circle {$result['colorname']}" ?>'
                                                                                    selected>
                                                                                    <?php echo $result['colorname']?>
                                                                                </option>
                                                                                <?php endif ?>
                                                                                <?php if($result['colortaken'] == f): ?>
                                                                                <option
                                                                                    value=<?php echo $result['colorname']?>
                                                                                    data-icon='<?php echo "fas fa-circle {$result['colorname']}" ?>'>
                                                                                    <?php echo $result['colorname']?>
                                                                                </option>
                                                                                <?php endif ?>
                                                                                <?php endif ?>
                                                                                <?php endwhile ?>
                                                                            </select>
                                                                        </div>
                                                                        <input type="hidden" name="budget-previous-color"
                                                                            value=<?php echo $budgetcolor?>>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr style="justify-content: right;">

                                                                <?php if($editState == true):?>
                                                                <td style="width: 50%">
                                                                    <button type="submit" name="edit-budget"
                                                                        class="btn btn-primary btn-block"><i
                                                                            class="fas fa-check"></i> Save budget</button>
                                                                </td>
                                                                <td style="width: 50%">
                                                                    <button type="submit" name="cancel-budget"
                                                                        class="btn btn-danger btn-block"><i
                                                                            class="fas fa-times"></i> Cancel</button>
                                                                </td>
                                                                <?php else: ?>
                                                                <td>
                                                                    <button type="submit" name="add-budget"
                                                                        class="btn btn-info btn-block"><i
                                                                            class="fas fa-plus"></i> Add budget</button>
                                                                </td>

                                                                <?php endif ?>

                                                            </tr>
                                                        </table>
                                                    </form>
                                                <?php endif ?>

                                                <!-- display budgets -->
                                                <table class='table table-condensed settings2'>
                                                    <?php  $query = pg_query("SELECT * FROM groupbudgets WHERE EXTRACT(MONTH FROM budgetdate) = $currentmonth AND EXTRACT(YEAR FROM budgetdate) = $currentyear AND groupingid = $groupingid ORDER BY budgetid"); ?>
                                                    <?php while($result = pg_fetch_array($query)){ ?>
                                                    <tr>
                                                        <td style="flex:11">
                                                            <div
                                                                class='<?php echo "badge bg-{$result['budgetcolor']}" ?>'>
                                                                <?php echo $result['budgetname'] ?></div>
                                                        </td>

                                                        <?php if($_SESSION['username'] === $admin):?>
                                                        <td style="flex:1" rowspan="2">
                                                            <!-- edit budget -->
                                                            <a
                                                                href="groupSettings.php?grouping-id=<?php echo $groupingid ?>&editState=true&budgetid=<?php echo $result['budgetid']?>&budgetname=<?php echo $result['budgetname']?>&budgetamount=<?php echo $result['budgetamount']?>&budgetcolor=<?php echo $result['budgetcolor']?>"><i
                                                                    class="fas fa-edit text-primary"></i></a>
                                                            <!-- delete budget -->
                                                            <a
                                                                href="groupSettings.php?grouping-id=<?php echo $groupingid ?>&del-budget-id=<?php echo $result['budgetid']?>&budget-name=<?php echo $result['budgetname']?>&budget-color=<?php echo $result['budgetcolor']?>"><i
                                                                    class="far fa-trash-alt text-danger"></i></a>
                                                        </td>
                                                        <?php endif ?>
                                                    </tr>
                                                    <tr class="borderless">
                                                        <td class="borderless">
                                                            <small>RM <?php echo $result['budgetamount']?></small>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>

                                                </table>
                                                <hr>

                                                <!-- members -->
                                                <h5 class="text-left"><strong>Members</strong></h5>
                                                <?php if($_SESSION['username'] === $admin):?>
                                                    <small>Add members</small>
                                                    <?php if(count($warnings)) : ?>
                                                        <div class="error">
                                                        <?php foreach($warnings as $warning): ?>
                                                            <div class="alert alert-warning"><?php echo $warning ?></div>
                                                        <?php endforeach ?>
                                                        </div>
                                                    <?php endif ?>
                                                    <?php if(count($messages)) : ?>
                                                        <div class="error">
                                                        <?php foreach($messages as $message): ?>
                                                            <div class="alert alert-info"><?php echo $message ?></div>
                                                        <?php endforeach ?>
                                                        </div>
                                                    <?php endif ?>
                                                    <table class='table borderless'>
                                                        <form
                                                            action="groupSettings.php?grouping-id=<?php echo $groupingid ?>"
                                                            method="POST">
                                                            <tr>
                                                                <td style="width:75%">
                                                                    <div class="input-group">
                                                                        <input class="form-control text-left"
                                                                            name="invitation-email" type="email" value=""
                                                                            placeholder="Enter an email...">
                                                                    </div>
                                                                    <input type="hidden" name="grouping-id"
                                                                        value=<?php echo $groupingid ?>>
                                                                </td>
                                                                <td style="width:25%"><button name="send-invitation"
                                                                        class="btn btn-block btn-info"><?php echo 'Send Invitation' ?></button>
                                                                </td>
                                                            </tr>
                                                        </form>
                                                    </table>
                                                <?php endif ?>

                                                <table class="table borderless text-left">
                                                    <form action="groupSettings.php?grouping-id=<?php echo $groupingid ?>"
                                                        method="POST">
                                                        <?php 
                                                            $query = pg_query("SELECT * FROM groups WHERE groupingid = $groupingid");
                                                            ?>
                                                        <?php while($member = pg_fetch_array($query)): ?>
                                                        <?php $query2 = pg_query("SELECT email FROM users WHERE username = '".$member['memberusername']."' LIMIT 1");
                                                        $memberemail = pg_fetch_assoc($query2) ?>
                                                        <tr>
                                                            <td style="flex:1"><img class="profile-img" src="../assets/profile.jpg" alt=""></td>
                                                            <td style="flex:8"><?php echo $member['memberusername'] ?><br><small><?php echo $memberemail['email'] ?></small></td>
                                                            <td style="flex:2">
                                                            <?php if($_SESSION['username'] === $admin ):?>
                                                                <?php if($member['memberusername'] !== $admin ):?>
                                                                    <a
                                                                    href="groupSettings-process.php?grouping-id=<?php echo $groupingid ?>&remove-user=<?php echo $member['memberusername'] ?>" class="text-danger"><i
                                                                        class="fas fa-times text-danger"></i> Remove</a>
                                                                <?php else: ?>
                                                                    <span class="text-secondary">Admin</span>
                                                                <?php endif ?>
                                                            <?php else: ?>
                                                                <?php if($_SESSION['username'] === $member['memberusername'] AND $member['memberusername'] !== $admin ) :?>
                                                                    <a
                                                                    href="groupSettings-process.php?grouping-id=<?php echo $groupingid ?>&exit-group=<?php echo $member['memberusername'] ?>" class="text-danger"><i
                                                                        class="fas fa-times text-danger"></i> leave group</a>
                                                                <?php elseif($member['memberusername'] == $admin ): ?>
                                                                    <span class="text-secondary">Admin</span>
                                                                <?php endif ?>
                                                            <?php endif ?>    
                                                            </td>
                                                        </tr>
                                                        <?php endwhile ?>
                                                    </form>
                                                </table>

                                            </div>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

</body>

</html>