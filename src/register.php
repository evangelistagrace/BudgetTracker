<?php 
  require 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'?>
<title>Register- BudgetTracker</title>

<body>
  <div class="container-fluid my-container">

    <div class="row half">
      <div class="col half-background">
        <div class="logo"><img src="../assets/logo-transparent.svg" alt="">
          <div class="desc">Register</div>
        </div>

        <div class="form-container">
          <form name="register" action="register.php" method="POST">
            <div class="form-group">
              <label for="emailRegister">Email</label>
              <input type="email" class="form-control" id="emailRegister" name="emailRegister"
                placeholder="Enter your email">
            </div>
            <div class="form-group">
              <label for="usernameRegister">Username</label>
              <input type="text" class="form-control" id="usernameRegister" name="usernameRegister"
                placeholder="Enter a username">
            </div>
            <div class="form-group">
              <label for="passwordRegister">Password</label>
              <input type="password" class="form-control" id="passwordRegister" name="passwordRegister"
                placeholder="Enter a password">
            </div>
            <div class="form-group">
              <label for="passwordRegister2">Confirm password</label>
              <input type="password" class="form-control" id="passwordRegister2" name="passwordRegister2"
                placeholder="Enter your password again">
            </div>
            <button class="btn btn-primary btn-block" type="submit" name="submit">Register</button>
            <small>Already have an account? <a href="../src/login.php">Login</a></small>
          </form>
        </div>

      </div>
    </div>

  </div>
</body>

</html>


<?php

$query = "INSERT INTO users (user_email, user_name, user_password) VALUES ('$_POST[emailRegister]','$_POST[usernameRegister]','$_POST[passwordRegister]')";
$result = pg_query($query);

?>