<!DOCTYPE html>
<html lang="en">
<?php 
include 'head.php';
require 'groups-process.php';
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

                <div class="row">

                    <?php 
                        //select all groups the session user is in
                        $query = pg_query("SELECT * FROM groups WHERE memberusername = '".$_SESSION['username']."' ORDER BY groupname");
                        
                    ?>

                    <?php while($group = pg_fetch_array($query)): ?>
                    <div class="card group" style="width:18rem;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3"><img src=<?php echo $group['groupicon'] ?> alt=""></div>
                                <div class="col-8">
                                    <h1 class="card-title"><?php echo $group['groupname'] ?></h1>
                                    <div class="links small"><a href="groupDashboard.php?grouping-id=<?php echo $group['groupingid']?>">View</a>  | <a href="">Edit</a> | <a href="">Delete</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile ?>

                </div>
                <a class="btn btn-danger add-btn" href="#addGroup"><i class="fas fa-plus"></i></a>

                <div id="addGroup" class="overlay">
                    <div class="popup">
                        <div class="content"><a class="close" href="#">x</a>
                            <h3 class="text-center mb-4 mt-4">Add Group</h3>
                            <form class="popup-form" action="groups.php" method="POST">
                                <div class="form-group">
                                    <label for="groupTitle">Group Name</label>
                                    <div class="input-group ml-3">
                                        <input type="text" class="form-control" name="group-name" placeholder="Enter group name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="groupIcon">Group Icon</label>
                                    <div class="input-group ml-3">
                                        <select id="groupIcon" name="group-icon" class="selectpicker show-tick" data-style="btn-secondary" data-width="100%" data-size="3"
                                        title="Pick an icon">
                                        <?php 
                                            $directory = "../assets/icons/";
                                            $images = glob($directory . "/*.png");
                                        ?>
                                        <?php foreach($images as $image): ?>
                                            <option value="<?php echo $image ?>" data-content="<img src='<?php echo $image ?>' style='width:40px;'>"></option>
                                        <?php endforeach ?>
                                    </select>
                                    </div>
                               
                                </div>

                                <div class="form-group">
                                    <label for="budgetAmount">Add Members</label>
                                    <div class="input-group ml-3">
                                        <input type="email" class="form-control mb-3 block" placeholder="Enter an email...">
                                        <input type="email" class="form-control block" placeholder="Enter an email...">   
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="budgetAmount"></label>
                                    <div class="input-group ml-3">
                                        <div class="btn btn-round btn-secondary">+</div>
                                        <div class="btn btn-secondary">Send invitation</div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit"name="add-group">Add group</button>

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