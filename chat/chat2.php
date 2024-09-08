<!DOCTYPE html>
<html>
<head>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<title>Bixma Chat</title>
</head>
<body>

<div id="loginForm" style="padding-bottom: 15px; " >

  <input type="text" id="username" value="admin" />
  <input type="text" id="password" value="admin01" />
  <input type="button" id="Login" value="Login" disabled>
<img id='loading' src="loading.gif"  height="15" width="15" style="display: none ; ">
</div>

<iframe src = 'http://bixma.com:3000' id="iframe_a" style="border:none; display: none ; width='100%'; height='100%'" ></iframe>

<script type="text/javascript">

var ifram=document.getElementById('iframe_a')

$("document").ready(function(){

    setTimeout(function (){

      $("#Login").attr("disabled", false);

    }, 5000);

    $('#Login').on('click',function(){
        $('#loading').show();
        var user = $('#username').val();
        var password = $('#password').val();
  console.log( "start" );
        $.ajax({
            type:'POST',
            url:'http://www.bixma.com/rocket.chat/test.php',
            dataType: "json",
            data:{user:user,password:password},
            success:function(data){
                 
                ifram.contentWindow.postMessage(
                  {
                    event: 'login-with-token',
                    loginToken: data.loginToken
                  },
                  '*'
                );

                setTimeout(function (){
                  ifram.style.display='';
                  ifram.style.width='100%';
                  ifram.style.height='100%';
                  $('#loginForm').remove();
                }, 5000);
            },
          error:function(){
          $('#login').hide();
          console.log('error!');
      }
        });
    });
    
});

</script>


</body>
<style>

html, 
body {
    height: 100%;
}
</style>
</html>
