<!DOCTYPE html>
<html lang="en">
<?php 

include 'head.php';
require 'groupView-process.php';

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
                        $query = pg_query("SELECT * FROM groups WHERE groupingid = $groupingid ");
                        
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
                                    <li class="active">
                                        <a href="#1" data-toggle="tab">Overview</a>
                                    </li>
                                    <li><a href="#2" data-toggle="tab">Budgets</a>
                                    </li>
                                    <li><a href="#3" data-toggle="tab">Expenses</a>
                                    </li>
                                    <li><a href="#4" data-toggle="tab">Reminders</a>
                                    </li>
                                    <li><a href="#5" data-toggle="tab">Notifications</a>
                                    </li>
                                    <li><a href="#6" data-toggle="tab">Report</a>
                                    </li>
                                    <li><a href="#7" data-toggle="tab">Settings</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content ">

                                    <!-- overview -->
                                    <div class="tab-pane active" id="1">
                                        <div class="row">
                                            <!-- reminders -->
                                            <div class="card" style="width: 25rem">
                                                <div class="card-body">
                                                    <h5 class="card-title">Reminders</h5>
                                                    <table class="table table-striped dashboard-reminders">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th class="dashboard-reminders title">Overdue</th>
                                                            </tr>
                                                        </thead>
                                                        <tr>
                                                            <td>title</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- balance -->
                                            <div class="card" style="width: 25rem">
                                                <div class="card-body">
                                                    <h5 class="card-title">Balance</h5>
                                                    <?php
                                                        $query = pg_query("SELECT maxbudget FROM groups WHERE groupingid = $groupingid AND memberusername ='".$_SESSION['username']."' "); 
                                                        $result = pg_fetch_array($query);
                                                    ?>
                                                    <table class="balance">
                                                        <tr>
                                                            <td>Inflow</td>
                                                            <td><h5 class="text-primary">+RM <?php echo $result['maxbudget'] ?></h5></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Outflow</td>
                                                            <td><h5 class="text-primary">-RM <?php echo 'outflow' ?></h5></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Balance</td>
                                                            <td>
                                                                <?php $balance = 0 ?>
                                                                <?php if($balance > 0): ?>
                                                                    <h3 class="text-primary">+RM <?php echo $balance ?></h3>
                                                                <?php elseif($balance == 0): ?>
                                                                    <h3 class="text-primary">RM <?php echo $balance ?></h3> 
                                                                <?php elseif($balance < 0): ?>
                                                                    <h3 class="text-danger">-RM <?php echo $negativeBalance ?></h3>
                                                                <?php endif ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- budgets -->
                                            <div class="card" style="width: 25rem;">
                                                <div class="card-body">
                                                    <h5 class="card-title">Budgets</h5>
                                                    <p class="card-text">
                                                       //budgets
                                                    </p>
                                                    <a href="#" class="btn btn-secondary btn-sm right">Go to group budgets <i
                                                            class="fas fa-arrow-right"></i></i></a>
                                                </div>
                                            </div>

                                            <!-- expenses -->
                                            <div class="card" style="width: 25rem;">
                                                <div class="card-body">
                                                    <h5 class="card-title">Expenses</h5>
                                                    <p class="card-text">
                                                       //expenses
                                                    </p>
                                                    <a href="#" class="btn btn-secondary btn-sm right">Go to group expenses <i
                                                            class="fas fa-arrow-right"></i></i></a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- budgets -->
                                    <div class="tab-pane" id="2">
                                        <div class="card-title">Overview</div>
                                    </div>

                                    <!-- expenses -->
                                    <div class="tab-pane" id="3">
                                        <div class="card-text">Overview</div>
                                    </div>

                                    <!-- reminders -->
                                    <div class="tab-pane" id="4">
                                        <div class="card-text">Overview</div>
                                    </div>

                                    <!-- notifications -->
                                    <div class="tab-pane" id="5">
                                        <div class="card-text">Overview</div>
                                    </div>

                                    <!-- report -->
                                    <div class="tab-pane" id="6">
                                        <div class="card-text">

                                        </div>
                                    </div>

                                    <!-- settings -->
                                    <div class="tab-pane" id="7">
                                        <div class="row">
                                            <div class="card settings" style="width: 60rem">
                                                <div class="card-body">
                                                    <h5 class="text-left"><strong>Maximum Budget</strong></h5>
                                                        <table class='table borderless'>
                                                            <form action="groupView.php?grouping-id=<?php echo $groupingid ?>" method="POST">
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
                                                                    <td style="width:65%">
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">RM</span>
                                                                            </div><input class="form-control text-right" name="new-max-budget"
                                                                                id="income" type="text" value=""
                                                                                placeholder="<?php echo $placeholder ?>">
                                                                        </div>
                                                                    <input type="hidden" name="grouping-id" value=<?php echo $groupingid ?>>
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
                                                    <hr>

                                                    <!-- members -->
                                                    <h5 class="text-left"><strong>Members</strong></h5>
                                                    <small>Send an email invitation</small>
                                                    <table class='table borderless'>
                                                        <form action="groupView.php?grouping-id=<?php echo $groupingid ?>" method="POST">
                                                            <tr>
                                                                <td style="width:65%">
                                                                    <div class="input-group">
                                                                        <input class="form-control text-left" name="new-member" type="email" value=""
                                                                            placeholder="Enter an email...">
                                                                    </div>
                                                                <input type="hidden" name="grouping-id" value=<?php echo $groupingid ?>>
                                                                </td>
                                                                <td style="width:25%"><button name="add-member"
                                                                        class="btn btn-block btn-info"><?php echo 'Add member' ?></button>
                                                                </td>
                                                            </tr>
                                                        </form>
                                                    </table>

                                                    <table class="table borderless text-left">
                                                        <form action="groupView.php?grouping-id=<?php echo $groupingid ?>" method="POST">
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
                                                                        <a href="#"><i
                                                                                class="fas fa-edit text-primary"></i></a>
                                                                        <!-- delete member -->
                                                                        <a href="#"><i class="far fa-trash-alt text-danger"></i></a>
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