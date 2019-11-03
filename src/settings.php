<!DOCTYPE html>
<html lang="en">
<?php 
include 'head.php';
require 'settings-process.php';

// initialize variables
$username = $_SESSION['username'];
$income = "Add income...";
if(!isset($_GET['editState']) && !isset($_GET['categoryid'])){
    $editState = false;
}else{
    $editState = $_GET['editState'];
    $categoryid = $_GET['categoryid'];
}
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
                                <form action="settings.php" method="POST">
                                    <tr>
                                        <?php 
                                        $query = pg_query("SELECT income FROM users WHERE username ='".$_SESSION['username']."' "); 
                                        $result = pg_fetch_array($query);

                                        if($result['income'] == 0){
                                         $placeholder = "Enter total income..."; $btnText = "Add Income";
                                        }
                                        elseif($result['income'] > 0){
                                        $placeholder = $result['income']; 
                                        $btnText = "Edit Income";
                                        }?>
                                        <td style="width:70%">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RM</span>
                                                </div><input class="form-control text-right" name="new-income"
                                                    id="income" type="text" value=""
                                                    placeholder="<?php echo $placeholder ?>">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>

                                        </td>
                                        <td style="width:20%"><button name="add-income"
                                                class="btn btn-block btn-info"><?php echo $btnText ?></button>
                                        </td>

                                    </tr>

                                </form>

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

                            <h5 class="text-left"><strong>Categories</strong></h5>
                            <table class='table table-condensed settings2'>
                                <form action="settings.php" method="POST">
                                    <?php if(count($errors)) : ?>
                                    <div class="error">
                                        <?php foreach($errors as $error): ?>
                                        <div class="alert alert-danger"><?php echo $error ?></div>
                                        <?php endforeach ?>
                                    </div>
                                    <?php endif ?>
                                    <tr>
                                        <td style="width: 90%">
                                            <input class="form-control" type="text" name="new-category" id="newCategory"
                                                required placeholder="Enter a new category...">
                                        </td>
                                        <td style="width: 10%">
                                            <button type="submit" name="add-category"
                                                class="btn btn-danger btn-round">+</button>
                                        </td>
                                    </tr>
                                </form>

                                <?php  $query = pg_query("SELECT * FROM categories WHERE username = '".$_SESSION['username']."' ORDER BY categoryid"); ?>
                                <?php while($result = pg_fetch_array($query)){ ?>
                                <tr>
                                    <!-- edit category -->
                                    <?php if($editState == false) :?>
                                    <td style="width: 90%"><input type="text" readonly class="form-control-plaintext"
                                            id="categoryName" value="<?php echo $result['categoryname'] ?>"></td>
                                    <td style="width: 10%">
                                        <a id="editCategoryName"
                                            href="settings.php?editState=true&categoryid=<?php echo $result['categoryid'] ?>"><i
                                                class="fas fa-edit text-primary"></i></a>
                                        <!-- delete category -->
                                        <a
                                            href="settings-process.php?del-category='<?php echo $result['categoryname']; ?>'"><i
                                                class="far fa-trash-alt text-danger"></i></a>
                                    </td>
                                    <?php elseif($editState == true) :?>
                                    <!-- category to be edited -->
                                    <?php if($result['categoryid'] == $categoryid):?>
                                    <form action="settings" method="POST">
                                        <td style="width: 90%"><input type="text" class="form-control" id="categoryName"
                                                name="categoryname" value="<?php echo $result['categoryname'] ?>"><input
                                                type="hidden" name="categoryid"
                                                value="<?php echo $result['categoryid'] ?>"></td>
                                        <td style="width: 10%">
                                            <!-- edit category -->
                                            <button id="editCategoryName" type="submit" name="edit-category"><i
                                                    class="fas fa-save text-primary"></i></button>
                                            <!-- delete category -->
                                            <a
                                                href="settings-process.php?del-category='<?php echo $result['categoryname']; ?>'"><i
                                                    class="far fa-trash-alt text-danger"></i></a>
                                        </td>
                                    </form>
                                    <!-- rest of the categories -->
                                    <?php else: ?>
                                    <td style="width: 90%"><input type="text" readonly class="form-control-plaintext"
                                            id="categoryName" value="<?php echo $result['categoryname'] ?>"></td>
                                    <td style="width: 10%">
                                        <a id="editCategoryName"
                                            href="settings.php?editState=true&categoryid=<?php echo $result['categoryid'] ?>"><i
                                                class="fas fa-edit text-primary"></i></a>
                                        <!-- delete category -->
                                        <a
                                            href="settings-process.php?del-category='<?php echo $result['categoryname']; ?>'"><i
                                                class="far fa-trash-alt text-danger"></i></a>
                                    </td>
                                    <?php endif ?>
                                    <?php endif ?>
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