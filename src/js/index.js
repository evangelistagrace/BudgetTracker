

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
  


function toggleSidebar() {
    console.log("hello");

    var sidebar = $(".sidebar");
    $(sidebar).css("width", "5%");
}