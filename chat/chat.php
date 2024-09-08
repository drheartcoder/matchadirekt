<!DOCTYPE html>
<html>
<head>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<title>Bixma Chat</title>
</head>
<body>

<div id="login" style="padding-bottom: 15px; " >

  <input type="text" id="username" value="admin" />
  <input type="text" id="password" value="admin01" />
  <input type="button" id="Login" value="Login" disabled>
<img id='loading' src="loading.gif"  height="15" width="15" style="display: none ; ">
</div>

<iframe src = 'http://matchadirekt.com:3000' id="iframe_a" style="border:none; display: none ; width='100%'; height='100%'" ></iframe>

<script type="text/javascript">

var ifram=document.getElementById('iframe_a')
   
window.addEventListener('message',function(message){
  if(message.data.type=="logout"){
    ifram.style.display='none'; 
  }
});
 


$("document").ready(function(){

    setTimeout(function (){

      $("#Login").attr("disabled", false);

    }, 5000);

    $('#Login').on('click',function(){
      var ifram=document.getElementById('iframe_a')

        $('#loading').show();
        var user = $('#username').val();
        var password = $('#password').val();
        console.log( "start" );
        $.ajax({
            type:'POST',
            url:'test.php',
            dataType: "json",
            data:{user:user,password:password},
            success:function(data){
                 console.log(data);
                 
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
                  $('#loading').hide();
                }, 5000);

                
            },
          error:function(){
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
