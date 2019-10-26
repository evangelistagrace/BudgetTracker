<?php 
  require 'login-process.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'?>
<title>Login - BudgetTracker</title>

<body>
  <div class="container-fluid my-container">

    <div class="row half">
      <div class="col half-background">
        <div class="logo"><img src="../assets/logo-transparent.svg" alt="">
          <div class="desc">Login</div>
        </div>

        <div class="form-container">
          <form action="login.php" method="POST">
            <?php if(count($errors)) : ?>
            <div class="error">
              <?php foreach($errors as $error): ?>
              <div class="alert alert-danger"><?php echo $error ?></div>
              <?php endforeach ?>
            </div>
            <?php endif ?>
            <div class="form-group">
              <label for="usernameLogin">Username</label>
              <input type="text" class="form-control" id="usernameLogin" name="usernameLogin"
                placeholder="Enter your username" value="<?php echo $username ?>">
            </div>
            <div class="form-group">
              <label for="passwordLogin">Password</label>
              <input type="password" class="form-control" id="passwordLogin" name="passwordLogin"
                placeholder="Enter you password" value="<?php echo $password ?>">
            </div>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="rememberUser" name="rememberUser">
              <label class="form-check-label" for="rememberUser">Remember Me</label>
            </div>
            <button class="btn btn-primary btn-block" type="submit" name="login">Login</button>
            <small>Don't have an account? <a href="../src/register.php">Sign up</a></small>
          </form>
        </div>

      </div>
    </div>

  </div>
</body>

</html>