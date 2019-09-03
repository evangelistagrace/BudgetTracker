<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BudgetTracker</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito|Varela+Round&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Oleo+Script&display=swap" rel="stylesheet"> 

    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="scss/style.css">
</head>

<body>
    
    <nav class="navbar transparent">

        <a class="navbar-brand" href="#"><img id="logo" src="../assets/bt-logo-white.png" alt=""></a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <li class="nav-link"><a href="/">Sign Up</a></li>
            </li>
            <li class="nav-item">
                <li class="nav-link"><a href="/">Sign In</a></li>
            </li>
        </ul>
    </nav>
    <div class="header">
     <div class="left">
         <span>Spend</span>
         <span>&</span>
         <span>Track</span>
         <span>Mindful spending made easy</span>
     </div>
     <div class="center">
         <button class="btn btn-primary btn-small">Create an account</button>
     </div>

    </div>
<div style="height:1000px;background-color:red;font-size:36px">
Scroll Up and Down this page to see the parallax scrolling effect.
This div is just here to enable scrolling.
Tip: Try to remove the background-attachment property to remove the scrolling effect.
</div>

<!-- jQuery -->
<script
src="https://code.jquery.com/jquery-3.4.1.min.js"
integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
crossorigin="anonymous">
</script>
              
<!-- FontAwesome -->
<script src="https://kit.fontawesome.com/a256fe27cf.js"></script>
<script>
   $(function () {
  $(document).scroll(function () {
    var $nav = $(".navbar");
    $nav.toggleClass('colored', $(this).scrollTop() > $nav.height());
    if($nav.hasClass('colored')){
        $("#logo").attr("src","../assets/bt-logo-color.png");
        // console.log("has color");  
    }else{
        $("#logo").attr("src","../assets/bt-logo-white.png");
    }
  });
});
</script>

</body>

</html>