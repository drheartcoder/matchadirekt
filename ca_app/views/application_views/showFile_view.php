<!DOCTYPE html>
<html>
<head>
	<title><?=$title?></title>
<style type="text/css">
body {
    width: 100%;
    height: 100%;
    padding: 0;
    margin: 0;
}
    .show_imge
    {
        width: 100%;
        height: 100%;
         max-height:100%;
        max-width: 100%;
        text-align: center;
        padding-top: 70px;
    }
    .content_image{
        width: 80%;
        height: 500px;
        text-align: center;
        margin-left: auto;
        margin-right: auto;
    }
    .content_image img{
        width: 100%;
        height: 100%;
    }
</style>
</head>
<body>
<?php 
$imgExtension=['PNG','JPG','JPEG','GIF','PMP'];
$array = explode('.', $path);
$extension = strtoupper(end($array));
$is_Image=false;
$is_pdf=false;
if(in_array($extension,$imgExtension)){
	$is_Image=true;
}

if($extension=='PDF'){
	$is_pdf=true;
}

	if($is_Image){

		?>
       
		<div class="show_imge">
           
            <div class="content_image"><img src="<?php echo $path; ?>"></div>
         
         </div>	
		
		<?php 


	}else{

		if($is_pdf){
			?>

			<object data='<?php echo $path; ?>' 
		        type='application/pdf' 
		        width='100%' 
		        height='1000px' 
                    >
				
			<?php

		}
		else if ($extension=='MP4')
		{
			?>
			<video class="doc" width="100%" controls>
			  <source src="<?php echo $path; ?>" type="video/mp4">
			</video>
			<?php
		}
		else
		{
		?>
		<iframe width="100%" height="1000px" src="https://docs.google.com/gview?url=<?php echo $path; ?>&embedded=true"></iframe>
		<?php 
		}
	}
?>

</body>
</html>
