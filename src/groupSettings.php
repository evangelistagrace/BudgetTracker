<!DOCTYPE html>
<html lang="en">
<?php 

include 'head.php';
require 'groupSettings-process.php';

// initialize variables
$groupingid = $_GET['grouping-id'];

?>
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
                                                </table>
                                                <hr>

                                                <!-- reminders -->
                                                <h5 class="text-left"><strong>Reminders</strong></h5>
                                                <table class='table table-condensed settings2'>
                                                    <tr>
                                                        <td><input type="checkbox" class="checkbox" checked>
                                                            <div class="pseudo-checkbox"></div>
                                                        </td>

                                                        <td>Allow pop-up reminders</td>

                                                        <td><input type="checkbox" class="checkbox">
                                                            <div class="pseudo-checkbox"></div>
                                                        </td>

                                                        <td>Allow push notifications</td>
                                                    </tr>
                                                </table>
                                                <hr>

                                                <!-- budgets -->
                                                <h5 class="text-left"><strong>Budgets</strong></h5>
                                                <small>Create up to 10 budgets</small>
                                                <form action="groupSettings.php?grouping-id=<?php echo $groupingid ?>"
                                                    method="POST">
                                                    <table class="table borderless">
                                                        <?php if(count($warnings)): ?>
                                                        <div class="error">
                                                            <?php foreach($warnings as $warning): ?>
                                                            <div class="alert alert-warning"><?php echo $warning ?>
                                                            </div>
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
                                                        <tr style="justify-content: center;">

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
                                                            <td style="width:100%">
                                                                <button type="submit" name="add-budget"
                                                                    class="btn btn-info btn-block"><i
                                                                        class="fas fa-plus"></i> Add budget</button>
                                                            </td>

                                                            <?php endif ?>

                                                        </tr>
                                                    </table>
                                                </form>

                                                <!-- display budgets -->
                                                <table class='table table-condensed settings2'>
                                                    <?php  $query = pg_query("SELECT * FROM groupbudgets WHERE groupingid = $groupingid ORDER BY budgetid"); ?>
                                                    <?php while($result = pg_fetch_array($query)){ ?>
                                                    <tr>
                                                        <td style="width: 90%">
                                                            <div
                                                                class='<?php echo "badge bg-{$result['budgetcolor']}" ?>'>
                                                                <?php echo $result['budgetname'] ?></div>
                                                        </td>

                                                        <td style="width: 10%" rowspan="2">
                                                            <!-- edit budget -->
                                                            <a
                                                                href="settings.php?editState=true&budgetid=<?php echo $result['budgetid']?>&budgetname=<?php echo $result['budgetname']?>&budgetamount=<?php echo $result['budgetamount']?>&budgetcolor=<?php echo $result['budgetcolor']?>"><i
                                                                    class="fas fa-edit text-primary"></i></a>
                                                            <!-- delete budget -->
                                                            <a
                                                                href="settings-process.php?del-budget=<?php echo $result['budgetname']?>&budgetcolor=<?php echo $result['budgetcolor']?>"><i
                                                                    class="far fa-trash-alt text-danger"></i></a>
                                                        </td>
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
                                                <small>Add members</small>
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

                                                <table class="table borderless text-left">
                                                    <form action="groupSettings.php?grouping-id=<?php echo $groupingid ?>"
                                                        method="POST">
                                                        <?php 
                                                                $query = pg_query("SELECT * FROM groups WHERE groupingid = $groupingid");
                                                            ?>
                                                        <?php while($member = pg_fetch_array($query)): ?>
                                                        <tr>
                                                            <td rowspan="2">
                                                                //profile picture
                                                            </td>
                                                            <td>
                                                                <?php echo $member['memberusername'] ?>
                                                            </td>
                                                            <td rowspan="2">
                                                                <!-- edit member -->
                                                                <a href="#"><i class="fas fa-edit text-primary"></i></a>
                                                                <!-- delete member -->
                                                                <a href="#"><i
                                                                        class="far fa-trash-alt text-danger"></i></a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <small>//email</small>
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