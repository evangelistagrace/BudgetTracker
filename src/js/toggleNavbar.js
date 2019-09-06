//toggle navbar on scroll
$(function () {
    $(document).scroll(function () {
      var $nav = $(".navbar");
      $nav.toggleClass('colored', $(this).scrollTop() > $nav.height());
      if($nav.hasClass('colored')){
          $("#logo").attr("src","../assets/logo-color.svg");
          // console.log("has color");  
      }else{
          $("#logo").attr("src","../assets/logo-transparent.svg");
      }
    });
});
