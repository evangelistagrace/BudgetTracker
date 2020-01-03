<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'?>
<title>TITLE</title>

<body>
   
    <?php include 'navbarDashboard.php'?>
    <div class="container-fluid my-container offset-container">

        <div class="row">
            <!-- SIDEBAR -->
            <?php include 'sidebarDashboard.php'?>

            <!-- MAIN CONTENT -->
            <div class="col-10-body collapsed">
                <div class="row">
                    <?php
                        $query = pg_query("SELECT * FROM notifications WHERE username = '".$_SESSION['username']."' ");

                    ?>

                    <?php while($notification = pg_fetch_array($query)): ?>
                        <div class="card">
                        <div class="card-body">
                            <div class="card-title"><?php echo $notification['notificationtitle']?></div>
                        </div>
                    </div>
                    <?php  endwhile ?>
                    
                </div>
            </div>

    <?php include 'footer.php' ?>

</body>

</html>