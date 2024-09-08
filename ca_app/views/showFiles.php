<!DOCTYPE html>
<html>
<head>
	<title><?=$title?></title>
<style type="text/css">
body {
    width: 100%;
    height: 100%;
}
</style>
</head>
<body>
<?php 


foreach ($FileListe as $file) {
	extract($file,EXTR_OVERWRITE);

echo $echo;
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
		<img style="width: 95%" src="<?php echo $path; ?>"/>	
		<div id="btn_print">
		<hr/>
		<button onclick="document.getElementById('btn_print').style.visibility = 'hidden';window.print();document.getElementById('btn_print').style.visibility = 'visible';">Print</button></div>
		<?php 


	}else{

		// if($is_pdf){
		// 	?>

		// 	<object data='<?php echo $path; ?>' 
		//         type='application/pdf' 
		//         width='100%' 
		//         height='1000px'>
				
		// 	<?php

		// }
		// else 
		if ($extension=='MP4')
		{
			?>
			<video class="doc" width="100%" controls>
			  <source src="<?php echo $path; ?>" type="video/mp4">
			</video>
			<?php
		}
		else
		{
			if($redirect=="1")
				redirect("https://docs.google.com/viewerng/viewer?url=$path");
			else
			{
				?>
				<iframe width="100%" height="1000px" src="https://docs.google.com/gview?url=<?php echo $path; ?>&embedded=true"></iframe>
				<?php
			}
		?>
		<!-- <iframe width="100%" height="1000px" src="https://docs.google.com/gview?url=<?php echo $path; ?>&embedded=true"></iframe>
		 -->
		<?php 
		}
	}

}
?>

</body>
</html>
