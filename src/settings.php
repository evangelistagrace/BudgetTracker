<!DOCTYPE html>
<html lang="en">
<?php 
include 'head.php';
require 'settings-process.php';

// initialize variables
$username = $_SESSION['username'];
$income = "Add income...";

?>
<title>Settings - BudgetTracker</title>

<body>

    <?php include 'navbarDashboard.php'?>
    <div class="container-fluid my-container offset-container">

        <div class="row">
            <!-- SIDEBAR -->
            <?php include 'sidebarDashboard.php'?>

            <!-- MAIN CONTENT -->
            <div class="col-10-body collapsed">
                <!-- ss testing git -->
                <h1 class="title text-primary">Settings</h1>

                <div class="row">
                    <div class="card settings">
                        <div class="card-body">
                            <h5 class="text-left"><strong>Income</strong></h5>
                            <table class='table table-condensed settings'>
                                <tr>
                                    <td style="width:70%"><input class="form-control" name="income" id="income"
                                            type="text" value="<?php echo $income ?>"></td>
                                    <td style="width:20%"><button class="btn btn-block btn-info">Add Income</button>
                                    </td>
                                </tr>
                            </table>
                            <hr>

                            <h5 class="text-left"><strong>Budget</strong></h5>
                            <table class='table table-condensed settings'>
                                <tr>
                                    <td><label class="container">
                                            <input type="radio" checked="checked" name="radio">
                                            <span class="checkmark"></span>
                                        </label></td>
                                    <td>Monthly recurring</td>

                                    <td><label class="container">
                                            <input type="radio" name="radio">
                                            <span class="checkmark"></span>
                                        </label></td>
                                    <td>Weekly recurring</td>

                                    <td><label class="container">
                                            <input type="radio" name="radio">
                                            <span class="checkmark"></span>
                                        </label></td>
                                    <td>Daily recurring</td>
                                </tr>

                            </table>
                            <hr>


                            <h5 class="text-left"><strong>Reminders</strong></h5>
                            <table class='table table-condensed settings'>
                                <tr>
                                    <td><input type="checkbox" class="checkbox">
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

                            <h5 class="text-left"><strong>Categories</strong></h5>
                            <table class='table table-condensed settings2'>

                                <tr>
                                    <td style="width: 90%">
                                        <input class="form-control" type="text" name="newCategory" id="newCategory"
                                            placeholder="Enter a new category...">
                                    </td>
                                    <td style="width: 10%">
                                        <a href="" class="btn btn-danger btn-round">+</a>
                                    </td>
                                </tr>

                                <?php  $query = pg_query("SELECT * FROM categories WHERE username = '".$_SESSION['username']."' "); ?>
                                <?php while($result = pg_fetch_array($query)){ ?>
                                <tr>
                                    <td style="width: 90%"><?php echo $result['categoryname'] ?></td>
                                    <td style="width: 10%">
                                        <a href="#"><i class="fas fa-edit text-primary"></i></a>
                                        <a href="settings-process.php?del-category='<?php echo $result['categoryname']; ?>'"><i class="far fa-trash-alt text-danger"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>

                            </table>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php include 'footer.php' ?>

</body>

</html>