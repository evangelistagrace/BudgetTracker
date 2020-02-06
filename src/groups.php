<!DOCTYPE html>
<html lang="en">
<?php 
include 'head.php';
require 'groups-process.php';

//initialize edit variables
$groupingid = $_GET['grouping-id'];
$groupingname = $_GET['grouping-name'];
$groupingicon = $_GET['grouping-icon'];


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
                    <div class="desc">@';
                    
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
                                    <div class="links small"><a
                                            href="groupDashboard.php?grouping-id=<?php echo $group['groupingid']?>">View</a>
                                        <?php if($_SESSION['username'] == $group['adminusername']): ?>
                                        | <a href="groups.php?grouping-id=<?php echo $group['groupingid']?>&grouping-name=<?php echo $group['groupname']?>&grouping-icon=<?php echo $group['groupicon'] ?>#editGroup">Edit</a> | <a
                                            href="groups.php?del-grouping-id=<?php echo $group['groupingid'] ?>">Delete</a>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile ?>

                </div>
                <a class="btn btn-danger add-btn" href="#addGroup"><i class="fas fa-plus"></i></a>

                <!-- add group -->
                <div id="addGroup" class="overlay">
                    <div class="popup">
                        <div class="content"><a class="close" href="#">x</a>
                            <h3 class="text-center mb-4 mt-4">Add Group</h3>
                            <form class="popup-form" action="groups.php" method="POST">
                                <div class="form-group">
                                    <label for="groupTitle">Group Name</label>
                                    <div class="input-group ml-3">
                                        <input type="text" class="form-control" name="group-name"
                                            placeholder="Enter group name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="groupIcon">Group Icon</label>
                                    <div class="input-group ml-3">
                                        <select id="groupIcon" name="group-icon" class="selectpicker show-tick"
                                            data-style="btn-secondary" data-width="100%" data-size="3"
                                            title="Pick an icon">
                                            <?php 
                                            $directory = "../assets/icons/";
                                            $images = glob($directory . "/*.png");
                                        ?>
                                            <?php foreach($images as $image): ?>
                                            <option value="<?php echo $image ?>"
                                                data-content="<img src='<?php echo $image ?>' style='width:40px;'>">
                                            </option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="budgetAmount">Add Members</label>
                                    <div class="input-group ml-3" id="input-member-group">
                                        <input type="email" class="form-control mb-3 block" name="memberemail1"
                                            placeholder="Enter an email..." style="border-radius:5px;">
                                        <input type="email" class="form-control mb-3 block" name="memberemail2"
                                            placeholder="Enter an email..." style="border-radius:5px;">
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="budgetAmount"></label>
                                    <div class="input-group ml-3" style="display:flex; justify-content:center">
                                        <div class="btn btn-round btn-secondary" id="input-member-btn">+</div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit" name="add-group">Add
                                        group</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- edit group -->
                <div id="editGroup" class="overlay">
                    <div class="popup">
                        <div class="content"><a class="close" href="#">x</a>
                            <h3 class="text-center mb-4 mt-4">Edit Group</h3>
                            <form class="popup-form" action="groups.php" method="POST">
                                <div class="form-group">
                                    <label for="groupTitle">Group Name</label>
                                    <div class="input-group ml-3">
                                        <input type="text" class="form-control" name="group-name"
                                            value='<?php echo $groupingname ?>'>
                                        <input type="hidden" name="group-id" value=<?php echo $groupingid ?>>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="groupIcon">Group Icon</label>
                                    <div class="input-group ml-3">
                                        <select id="groupIcon" name="group-icon" class="selectpicker show-tick"
                                            data-style="btn-secondary" data-width="100%" data-size="3"
                                            title="Pick an icon">
                                            <?php 
                                            $directory = "../assets/icons/";
                                            $images = glob($directory . "/*.png");
                                        ?>
                                            <?php foreach($images as $image): ?>
                                            <?php if($image == $groupingicon): ?>
                                            <option value="<?php echo $image ?>"
                                            data-content="<img src='<?php echo $image ?>' style='width:40px;'>" selected>
                                            </option>
                                            <?php else: ?>
                                            <option value="<?php echo $image ?>"
                                            data-content="<img src='<?php echo $image ?>' style='width:40px;'>">
                                            </option>
                                            <?php endif ?>
                                            
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit" name="edit-group">Edit
                                        group</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <script>
        const inputMemberGroup = document.getElementById('input-member-group');
        const inputMemberBtn = document.getElementById('input-member-btn');
        var inputKey = 3;
        inputMemberBtn.addEventListener('click', (e) => {
            if (inputKey <= 5) { //allow only up to 5 fields at a time
                e.preventDefault();
                //create new input field
                var inputMember = document.createElement('input');
                inputMember.type = "email";
                inputMember.className = "form-control mb-3 block";
                inputMember.name = "memberemail" + inputKey;
                inputMember.placeholder = "Enter an email...";
                inputMember.style = "border-radius:5px;";
                inputMemberGroup.appendChild(inputMember);
                inputKey++;
            }
        })
    </script>

    <?php include 'footer.php' ?>

</body>

</html>