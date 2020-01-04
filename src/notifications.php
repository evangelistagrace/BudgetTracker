<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'?>
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
          <div class="card notification-card notification-invitation">
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
          </div>


        </div>
      </div>

      <?php include 'footer.php' ?>

</body>

</html>