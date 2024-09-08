<?php 
$user='';
$password='';

if(isset($_POST['username'])){

  $user=$_POST['username'];

}


if(isset($_POST['password'])){
  $password=$_POST['password'];
}

?>

<!DOCTYPE html>
<html>
<head>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<title>Bixma Chat</title>
</head>
<body>


<iframe src = 'http://matchadirekt.com:3000' id="iframe_a" style="border:none; display: none ; width='100%'; height='100%'" ></iframe>

<script type="text/javascript">

var ifram=document.getElementById('iframe_a')


  function tryLogin(user,password){

    setTimeout((function(user,password){

        console.log( "start : user =>"+ user + " Pass => "+password);
        $.ajax({
            type:'POST',
            url:'https://bixma.com/rocket.chat/test.php',
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

                ifram.style.display='';
                ifram.style.width='100%';
                ifram.style.height='100%';
      
            },
          error:function(){
            console.log('error!');
            ifram.contentWindow.location.reload();
      }
      });


    }), 5000,user,password);
  } 


$("document").ready(function(){

    var user = '<?php echo $user ; ?>';
    var password = '<?php echo $password ; ?>';
    if(user!=''){
      tryLogin(user,password)
    }
    
 
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
