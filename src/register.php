<?php 
  require 'register-process.php';
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
            <?php if(count($errors)) : ?>
              <div class="error">
                <?php foreach($errors as $error): ?>
                  <div class="alert alert-danger"><?php echo $error ?></div>
                <?php endforeach ?>
              </div>
            <?php endif ?>
            <div class="form-group">
              <label for="emailRegister">Email</label>
              <input type="email" class="form-control" id="emailRegister" name="emailRegister"
                placeholder="Enter your email" value="<?php echo $email ?>">
            </div>
            <div class="form-group">
              <label for="usernameRegister">Username</label>
              <input type="text" class="form-control" id="usernameRegister" name="usernameRegister"
                placeholder="Enter a username" value="<?php echo $username ?>">
            </div>
            <div class="form-group">
              <label for="passwordRegister">Password</label>
              <input type="password" class="form-control" id="passwordRegister" name="passwordRegister"
                placeholder="Enter a password" value="<?php echo $password ?>">
            </div>
            <div class="form-group">
              <label for="passwordRegister2">Confirm password</label>
              <input type="password" class="form-control" id="passwordRegister2" name="passwordRegister2"
                placeholder="Enter your password again" value="<?php echo $password2 ?>">
            </div>
            <button class="btn btn-primary btn-block" type="submit" name="register">Register</button>
            <small>Already have an account? <a href="../src/login.php">Login</a></small>
          </form>
        </div>

      </div>
    </div>

  </div>
</body>

</html>
