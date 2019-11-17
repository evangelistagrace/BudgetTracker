<!DOCTYPE html>
<html lang="en">
<?php 
include 'head.php';
require 'reminders-process.php';

// initialize edit variables
$reminderid = $_GET['edit-reminder'];
$remindername = $_GET['reminder-name'];
$remindercategory = $_GET['reminder-category'];
$reminderamount = $_GET['reminder-amount'];

?>
<title>My Budgets - BudgetTracker</title>

<body>

    <?php include 'navbarDashboard.php'?>
    <div class="container-fluid my-container offset-container">

        <div class="row">
            <!-- SIDEBAR -->
            <?php include 'sidebarDashboard.php'?>

            <!-- MAIN CONTENT -->
            <div class="col-10-body collapsed">

                <h1 class="title text-primary">My Reminders</h1>

                <div class="row">
                    <div class="card expenses">
                        <div class="progress" style="height: 3px;">
                            <div class="progress-bar progress-reminder" id="progress-reminder" role="progressbar"
                                style="width: 0%; background-color: #8c77d1" aria-valuenow="25" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                        <div class="card-body">
                            <table class='table table-condensed reminders'>
                            <?php $query = pg_query("SELECT reminders.reminderid, reminders.categoryid, reminders.remindername, reminders.reminderamount, reminders.reminderdone, categories.categoryid, categories.categoryname FROM reminders INNER JOIN categories ON reminders.categoryid = categories.categoryid ORDER BY reminders.reminderid") ?>
                            <?php while($reminder = pg_fetch_array($query)):?>
                                <tr>
                                <?php if($reminder['reminderdone'] === f):?>
                                    <td><a href="reminders-process.php?reminder-done=t&reminder-id=<?php echo $reminder['reminderid']?>"><i class="far fa-square reminder-check"></i></a></div>
                                    </td>
                                <?php elseif($reminder['reminderdone'] === t):?>
                                    <td><a href="reminders-process.php?reminder-done=f&reminder-id=<?php echo $reminder['reminderid']?>"><i class="fas fa-check-square reminder-check"></i></a></div>
                                    </td>
                                <?php endif ?>
                                    <td><?php echo $reminder['remindername'] ?></td>
                                    <td>
                                        <div class="small">
                                            <div class="circle bg-secondary"></div><?php echo $reminder['categoryname'] ?>
                                        </div>
                                    </td>
                                    <td>RM <?php echo $reminder['reminderamount'] ?></td>
                                    <td>
                                        <a href="reminders.php?edit-reminder=<?php echo $reminder['reminderid']?>&reminder-name=<?php echo $reminder['remindername']?>&reminder-category=<?php echo $reminder['categoryname']?>&reminder-amount=<?php echo $reminder['reminderamount']?>#editReminder"><i class="fas fa-edit text-primary"></i></a>
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
                                            <td><label for="budgetCategory">Category</label></td>
                                            <td><select class="selectpicker show-tick" data-style="btn-secondary"
                                                    data-size="3" title="Pick a category" name="category-name">
                                                    <?php $query = pg_query("SELECT * FROM categories WHERE username = '".$_SESSION['username']."' ")?>
                                                    <?php while($result = pg_fetch_array($query)) : ?>
                                                    <option value="<?php echo $result['categoryname'] ?>">
                                                        <?php echo $result['categoryname'] ?></option>
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
                                            <td><label for="budgetCategory">Category</label></td>
                                            <td><select class="selectpicker show-tick" data-style="btn-secondary"
                                                    data-size="3" title="Pick a category" name="reminder-category">
                                                    <?php $query = pg_query("SELECT * FROM categories WHERE username = '".$_SESSION['username']."' ")?>
                                                    <?php while($result = pg_fetch_array($query)) : ?>
                                                    <?php if($result['categoryname'] == $remindercategory): ?>
                                                        <option value="<?php echo $result['categoryname'] ?>" selected>
                                                        <?php echo $result['categoryname'] ?></option>
                                                    <?php else: ?>
                                                    <option value="<?php echo $result['categoryname'] ?>">
                                                        <?php echo $result['categoryname'] ?></option>
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
                                    <button class="btn btn-primary btn-lg btn-block" type="submit" name="edit-reminder">Edit reminder</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    

    <?php include 'footer.php' ?>


</body>

</html>