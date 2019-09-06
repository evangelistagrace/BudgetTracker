<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'?>
<title>Login - BudgetTracker</title>

<body>
  <div class="container-fluid my-container">

    <div class="row half">
      <div class="col half-background">
        <div class="logo"><img src="../assets/bt-logo-white.png" alt="">
          <div class="desc">Login</div>
        </div>

        <div class="form-container">
          <form>
            <div class="form-group">
              <label for="usernameLogin">Username</label>
              <input type="text" class="form-control" id="usernameLogin" name="usernameLogin"
                placeholder="Enter your username">
            </div>
            <div class="form-group">
              <label for="passwordLogin">Password</label>
              <input type="password" class="form-control" id="passwordLogin" name="passwordLogin"
                placeholder="Enter you password">
            </div>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="rememberUser" name="rememberUser">
              <label class="form-check-label" for="rememberUser">Remember Me</label>
            </div>
            <a class="btn btn-primary" href="../src/dashboard.php">Login</a>
            <small>Don't have an account? <a href="../src/register.php">Sign up</a></small>
          </form>
        </div>
        
      </div>
    </div>

  </div>
</body>

</html>