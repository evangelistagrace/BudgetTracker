<!DOCTYPE html>
<html lang="en">
<?php 
include 'head.php';
require 'notifications-process.php'
?>
<title>My Notifications - BudgetTracker</title>

<body>

  <?php include 'navbarDashboard.php'?>
  <div class="container-fluid my-container offset-container">

    <div class="row">
      <!-- SIDEBAR -->
      <?php include 'sidebarDashboard.php'?>

      <!-- MAIN CONTENT -->
      <div class="col-10-body collapsed">
        <h1 class="title text-primary">My Notifications</h1>
        <div class="row notification-container">
          <p class="dismiss text-right"><a id="dismiss-all" href="#">Dimiss All</a></p>

          <?php
            $query = pg_query("SELECT * FROM notifications WHERE recipientusername = '".$_SESSION['username']."' ");
          ?>

          <?php while($notification = pg_fetch_array($query)): ?>
            <!-- invitation -->
            <?php if($notification['notificationtype'] = 'Invitation'): ?>
              
              <div class="card notification-card notification-invitation">
              
                <div class="card-body">
                  <table>
                    <tr>
                      <td style="width:70%">
                        <div class="card-title"><?php echo $notification['senderusername'] . ' invited you to join '?><b><?php echo $notification['bolddata']?></b><?php echo ' group'?></div>
                      </td>
                      <td style="width:30%">
                      <form action="notifications.php" method="POST">
                         <!-- accept invitation -->
                         <input type="hidden" name="grouping-id" value=<?php echo $notification['groupingid'] ?>>
                          <button type="submit" name="accept-invitation" class="btn btn-primary">Accept</button>
                          <!-- decline invitation -->
                          <a href="#" class="btn btn-danger dismiss-notification">Decline</a>
                      </form>
                       
                      </td>
                    </tr>
                    <tr colspan="2">
                      <td><small><i class="far fa-calendar-alt mr-1"></i><?php $d = $notification['notificationdate']; $date = date("j F Y", strtotime($d)); echo $date ?></small></td>
                    </tr>
                  </table>
                </div>
              </div>
            <?php endif ?>
          <?php endwhile ?>
          <!-- <div class="card notification-card notification-invitation">
            <div class="card-body">
              <table>
                <tr>
                  <td style="width:70%">
                    <div class="card-title">Jane invited you to join '<b>Familia</b>' group</div>
                  </td>
                  <td style="width:30%">
                    <a href="#" class="btn btn-primary">View</a>
                    <a href="#" class="btn btn-danger dismiss-notification">Dismiss</a>
                  </td>
                </tr>
              </table>
            </div>
          </div>

          <div class="card notification-card notification-warning">
            <div class="card-body">
              <table>
                <tr>
                  <td style="width:70%">
                    <div class="card-title">Your expenses for '<b>Groceries</b>' has exceeded its budget</div>
                  </td>
                  <td style="width:30%">
                    <a href="#" class="btn btn-primary">View</a>
                    <a href="#" class="btn btn-danger dismiss-notification">Dismiss</a>
                  </td>
                </tr>
              </table>
            </div>
          </div>

          <div class="card notification-card notification-danger">
            <div class="card-body">
              <table>
                <tr>
                  <td style="width:70%">
                    <div class="card-title">Insufficient budget to create '<b>Clothing</b>' budget category</div>
                  </td>
                  <td style="width:30%">
                    <a href="#" class="btn btn-primary">View</a>
                    <a href="#" class="btn btn-danger dismiss-notification">Dismiss</a>
                  </td>
                </tr>
              </table>
            </div>
          </div>

          <div class="card notification-card notification-reminder">
            <div class="card-body">
              <table>
                <tr>
                  <td style="width:70%">
                    <div class="card-title">You have <b>2</b> upcoming payment(s) this week</div>
                  </td>
                  <td style="width:30%">
                    <a href="#" class="btn btn-primary">View</a>
                    <a href="#" class="btn btn-danger dismiss-notification">Dismiss</a>
                  </td>
                </tr>
              </table>
            </div>
          </div> -->


        </div>
      </div>

      <?php include 'footer.php' ?>

</body>

</html>