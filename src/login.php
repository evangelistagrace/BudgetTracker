<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'?>
<title>Login - BudgetTracker</title>
<body>
    <div class="bg-container">
        <div class="half-background"></div>
    </div>
    <div class="logo"><img src="../assets/bt-logo-white.png" alt="">
        <div class="desc">Login</div>
    </div>

    <div class="form-container">
    <form>
  <div class="form-group">
    <label for="usernameLogin">Email address</label>
    <input type="text" class="form-control" id="usernameLogin" name="usernameLogin" placeholder="Enter username">
  </div>
  <div class="form-group">
    <label for="passwordLogin">Password</label>
    <input type="password" class="form-control" id="passwordLogin" name="passwordLogin" placeholder="Password">
  </div>
  <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="rememberUser" name="rememberUser">
    <label class="form-check-label" for="rememberUser">Remember Me</label>
  </div>
  <button type="submit" class="btn btn-primary">Login</button>
</form>
    </div>


</body>

</html>