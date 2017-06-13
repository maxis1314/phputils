{literal}<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
                    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <script src="/public/js/jquery.js"></script>
  
  <script>
  $(document).ready(function(){
    
    // Start animation
    $("#go").click(function(){
      $(".block").animate({left: '+=400px'}, 2000);
    });

    // Stop animation when button is clicked
    $("#stop").click(function(){
      $(".block").stop();
    });

    // Start animation in the opposite direction
    $("#back").click(function(){
      $(".block").animate({left: '-=100px'}, 2000);
    });

  });
  </script>
  <style>div { 
    position: absolute; 
    background-color: #abc;
    left: 0px;
    top:30px;
    width: 60px; 
    height: 60px;
    margin: 5px; 
  }
  </style>
</head>
<body>
  <button id="go">Go</button> 
  <button id="stop">STOP!</button>
  <button id="back">Back</button>
  <div class="block"></div>
</body>
</html>




{/literal}