<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'?>
<title>Registration - BudgetTracker</title>
<body>
    <div class="bg-container">
        <div class="half-background"></div>
    </div>
    <div class="logo"><img src="../assets/bt-logo-white.png" alt="">
        <div class="desc">Register</div>
    </div>

    <div class="form-container">
    <form>
    <div class="form-group">
    <label for="emailRegister">Email</label>
    <input type="email" class="form-control" id="emailRegister" name="emailRegister" placeholder="Enter your email">
  </div>
  <div class="form-group">
    <label for="usernameRegister">Username</label>
    <input type="text" class="form-control" id="usernameRegister" name="usernameRegister" placeholder="Enter a username">
  </div>
  <div class="form-group">
    <label for="passwordRegister">Password</label>
    <input type="password" class="form-control" id="passwordRegister" name="passwordRegister" placeholder="Enter a password">
  </div>
  <div class="form-group">
    <label for="passwordRegister2">Confirm password</label>
    <input type="password" class="form-control" id="passwordRegister2" name="passwordRegister2" placeholder="Enter your password again">
  </div>
  <button type="submit" class="btn btn-primary">Register</button>
  <small>Already have an account? <a href="../src/login.php">Login</a></small>
</form>
    </div>


</body>

</html>