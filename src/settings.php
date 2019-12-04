<!DOCTYPE html>
<html lang="en">
<?php 
include 'head.php';
require 'settings-process.php';

// initialize variables
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
                            <table class='table borderless'>
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
                            <table class='table table-condensed settings2'>
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

                            <h5 class="text-left"><strong>Budgets</strong></h5>

                            <form action="settings.php" method="POST">
                                <table class="table borderless">
                                    <?php if(count($errors)) : ?>
                                    <div class="error">
                                        <?php foreach($errors as $error): ?>
                                        <div class="alert alert-danger"><?php echo $error ?></div>
                                        <?php endforeach ?>
                                    </div>
                                    <?php endif ?>
                                    <tr>
                                        <td style="width:35%">
                                            <input type="hidden" name="budget-id" value=<?php echo $budgetid ?>>
                                            <input class="form-control" type="text" name="budget-name" required
                                                placeholder="Budget Name" value=<?php echo $budgetname ?>>
                                        </td>
                                        <td style="width: 35%">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RM</span>
                                                </div>
                                                <input class="form-control text-right" name="budget-amount" type="text"
                                                    placeholder="0" value=<?php echo $budgetamount ?>>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width:30%">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <select id="groupIcon" class="selectpicker show-tick"
                                                        data-style="bg-light text-dark" data-width="100%" data-size="3"
                                                        title="Pick a color" name="budget-color" value=<?php echo $budgetcolor ?>>
                                                        <?php  $query = pg_query("SELECT * FROM colors WHERE username = '".$_SESSION['username']."' ORDER BY colortaken DESC"); ?>
                                                        <?php while($result = pg_fetch_array($query)): ?>
                                                            <?php if($editState == false):?> 
                                                                <?php if($result['colortaken'] == f): ?>
                                                                    <option value=<?php echo $result['colorname']?> data-icon='<?php echo "fas fa-circle {$result['colorname']}" ?>'><?php echo $result['colorname']?></option>
                                                                <?php endif ?>
                                                            <?php elseif($editState == true):?>
                                                                <?php if($budgetcolor == $result['colorname']): ?>
                                                                    <option value=<?php echo $result['colorname']?> data-icon='<?php echo "fas fa-circle {$result['colorname']}" ?>' selected><?php echo $result['colorname']?></option>
                                                                <?php endif ?>
                                                                <?php if($result['colortaken'] == f): ?>
                                                                    <option value=<?php echo $result['colorname']?> data-icon='<?php echo "fas fa-circle {$result['colorname']}" ?>'><?php echo $result['colorname']?></option>
                                                                <?php endif ?>
                                                            <?php endif ?>
                                                        <?php endwhile ?>
                                                    </select>
                                                </div>
                                                <input type="hidden" name="budget-previous-color" value=<?php echo $budgetcolor?>>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        
                                        <?php if($editState == true):?>
                                            <td colspan="2">
                                            <button type="submit" name="edit-budget" class="btn btn-primary btn-block"><i class="fas fa-check"></i> Save budget</button></td>
                                            <td colspan="1">
                                                <button type="submit" name="cancel-budget" class="btn btn-danger btn-block"><i class="fas fa-times"></i> Cancel</button>
                                            </td>
                                        <?php else: ?>
                                            <td colspan="3">
                                                <button type="submit" name="add-budget" class="btn btn-info btn-block"><i class="fas fa-plus"></i> Add budget</button>
                                            </td>
                                            
                                        <?php endif ?>
                                    
                                    </tr>
                                </table>
                            </form>


                            <table class='table table-condensed settings2'>
                                <?php  $query = pg_query("SELECT * FROM budgets WHERE username = '".$_SESSION['username']."' ORDER BY budgetid"); ?>
                                <?php while($result = pg_fetch_array($query)){ ?>
                                <tr>
                                    <td style="width: 90%"><div class='<?php echo "badge bg-{$result['budgetcolor']}" ?>'><?php echo $result['budgetname'] ?></div></td>
                                    
                                    <td style="width: 10%" rowspan="2">
                                        <!-- edit budget -->
                                        <a href="settings.php?editState=true&budgetid=<?php echo $result['budgetid']?>&budgetname=<?php echo $result['budgetname']?>&budgetamount=<?php echo $result['budgetamount']?>&budgetcolor=<?php echo $result['budgetcolor']?>"><i
                                                class="fas fa-edit text-primary"></i></a>
                                        <!-- delete budget -->
                                        <a href="settings-process.php?del-budget=<?php echo $result['budgetname']?>&budgetcolor=<?php echo $result['budgetcolor']?>"><i class="far fa-trash-alt text-danger"></i></a>
                                    </td>
                                </tr>
                                <tr class="borderless">
                                    <td class="borderless">
                                        <small>RM <?php echo $result['budgetamount']?></small>
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