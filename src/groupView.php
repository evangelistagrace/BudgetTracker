<!DOCTYPE html>
<html lang="en">
<?php 

include 'head.php';
require 'report-process.php';

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
                                        <p class="card-text">
                                            wer
                                        </p>
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
                                        <div class="card-text">Overview</div>
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