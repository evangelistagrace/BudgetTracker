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
          <p class="dismiss text-right"><a id="dismiss-all" href="notifications-process.php?dismiss-all=<?php echo $_SESSION['username'] ?>">Dismiss All</a></p>

          <?php
            $query = pg_query("SELECT * FROM notifications WHERE recipientusername = '".$_SESSION['username']."' ");
          ?>

          <?php if(pg_num_rows($query) >= 1): ?>
          <?php while($notification = pg_fetch_array($query)): ?>
          <!-- invitation -->
          <?php if($notification['notificationtype'] === 'Invitation'): ?>
          <div class="card notification-card notification-invitation">
            <div class="card-body">
              <table>
                <tr>
                  <td style="width:85%">
                    <div class="card-title">
                      <?php echo $notification['senderusername'] . ' invited you to join '?><b><?php echo $notification['bolddata']?></b><?php echo ' group'?>
                    </div>
                  </td>
                  <td class="right" style="width:15%; justify-content: space-around;
                display: flex;">
                    <!-- accept invitation -->
                    <a href="notifications-process.php?accept-notification-id=<?php echo $notification['id'] ?>&accept-grouping-id=<?php echo $notification['groupingid'] ?>&recipient-username='<?php echo $notification['senderusername'] ?>'"
                      class="btn btn-primary" sytle="margin-right:5px;">Accept</a>
                    <!-- decline invitation -->
                    <a href="notifications-process.php?decline-notification-id=<?php echo $notification['id'] ?>&decline-grouping-id=<?php echo $notification['groupingid']?>&recipient-username='<?php echo $notification['senderusername'] ?>'"
                      class="btn btn-danger dismiss-notification">Decline</a>
                  </td>
                </tr>
                <tr colspan="2">
                  <td><small><i
                        class="far fa-calendar-alt mr-1"></i><?php $d = $notification['notificationdate']; $date = date("j F Y", strtotime($d)); echo $date ?></small>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <!-- declined invitations -->
          <?php elseif($notification['notificationtype'] === 'Decline'): ?>
          <div class="card notification-card notification-invitation">
            <div class="card-body">
              <table>
                <tr>
                  <td style="width:85%">
                    <div class="card-title">
                      <?php echo $notification['notificationmessage']?>
                    </div>
                  </td>
                  <td class="right" style="width:15%; justify-content: space-around;
                display: flex;">
                    <!-- dismiss notification -->
                    <a href="notifications-process.php?dismiss-notification-id=<?php echo $notification['id'] ?>"
                      class="btn btn-danger dismiss-notification">Dismiss</a>
                  </td>
                </tr>
                <tr colspan="2">
                  <td><small><i
                        class="far fa-calendar-alt mr-1"></i><?php $d = $notification['notificationdate']; $date = date("j F Y", strtotime($d)); echo $date ?></small>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <!-- accepted invitations -->
          <?php elseif($notification['notificationtype'] === 'Accept'): ?>
          <div class="card notification-card notification-invitation">
            <div class="card-body">
              <table>
                <tr>
                  <td style="width:85%">
                    <div class="card-title">
                      <?php echo $notification['notificationmessage']?>
                    </div>
                  </td>
                  <td class="right" style="width:15%; justify-content: space-around;
                display: flex;">
                    <!-- dismiss notification -->
                    <a href="notifications-process.php?dismiss-notification-id=<?php echo $notification['id'] ?>"
                      class="btn btn-danger dismiss-notification">Dismiss</a>
                  </td>
                </tr>
                <tr colspan="2">
                  <td><small><i
                        class="far fa-calendar-alt mr-1"></i><?php $d = $notification['notificationdate']; $date = date("j F Y", strtotime($d)); echo $date ?></small>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <?php endif ?>
          <?php endwhile ?>
          <?php elseif(pg_num_rows($query) == 0): ?>
          <h4 class="text-center">All caught up!</h4>
          <?php endif ?>




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
      <!-- dismiss notifications -->
      <script>
        const dismissAll = document.getElementById('dismiss-all');
        const dismissBtns = Array.from(document.querySelectorAll('.dismiss-notification'));

        const notificationCards = document.querySelectorAll('.notification-card');

        dismissBtns.forEach(btn => {
          btn.addEventListener('click', function (e) {
            e.preventDefault;
            console.log("clicked")
            var parent = e.target.parentElement.parentElement.parentElement.parentElement.parentElement
              .parentElement;
            parent.classList.add('display-none');
          })
        });

        // dismissAll.addEventListener('click', function (e) {
        //   e.preventDefault;
        //   notificationCards.forEach(card => {
        //     card.style.display = 'none';
        //   });
        //   const row = document.querySelector('.notification-container');
        //   const message = document.createElement('h4');
        //   message.classList.add('text-center');
        //   message.innerHTML = 'All caught up!';
        //   row.appendChild(message);
        // })
      </script>

</body>

</html>