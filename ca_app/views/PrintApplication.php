<html>
<head>
	<title><?php echo lang('Applications'); ?>  </title>

	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	<style type="text/css">
		.Main{
			display:none;
		}

		@page {
		    size: auto; 
		    margin: 0; 
		}

		@media print {
			.Titre{
				text-align: center;
			}
			.Main{
				display:block;
				margin-top: 20px;
				margin-left: 10px;
				margin-right: 10px;
			}

		}

	</style>
</head>
<body>

<div class="Main">
	<div class="Titre"><h2><?=lang('Job Applications Received') ?></h2> </div>
	<table class="table">
		<thead>
			<tr>
				<th>
					<?= lang('Ref.') ?>
				</th>
				<th>
					<?= lang('Candidate Name') ?>
				</th>
				<th>
					<?=lang('Job Title')?>
				</th>
				<th>
					<?=lang('Applied Date')?>
				</th>	
			</tr>
				
		</thead>
		 
	 <tbody>
	 	<?php 	foreach($applications as $application) : ?>
	 	 
	 		<tr>
		 		<td>
		 			#JS<?php echo  str_repeat("0",5-strlen($application->job_seeker_ID)).$application->job_seeker_ID ; ?>
		 		</td>
		 			
		 		<td>
		 			 <?php echo $application->first_name .' '.$application->last_name ?>
		 		</td>

		 		<td>
		 			<?= $application->job_title ?>
		 			
		 		</td>


		 		<td>
		 			<?php echo date_formats($application->applied_date, 'M d, Y');?>
		 		</td>		
	 		
	 		</tr>
	 	<?php endforeach; ?>
	</tbody>	
	
	</table>

</div>

<script type="text/javascript">
	
	window.print();
	window.close();

</script>
</body>
</html>