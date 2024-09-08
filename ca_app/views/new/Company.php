<?php 
	$this->load->view('new/header');
 ?>
<div id="DIV_1">
	<div id="DIV_2">

		<?php $image_name = ($row->company_logo)?$row->company_logo:'no_logo.jpg';?>

		<img src="<?php echo base_url('public/uploads/employer/'.$image_name);?>" id="IMG_3" alt='' />
	</div>
	<div id="DIV_4">
		<h1 id="H1_5">
			<a id="A_6"><?php echo $row->company_name;?></a>
		</h1>
		<div id="DIV_7">
			<?=lang('Staff Members')?>: <?php echo $row->no_of_employees;?>
		</div>
		<div id="DIV_8">
			<?=lang('Current Openings')?>: <?php echo $total_opened_jobs;?>
		</div>
		<div id="DIV_9">
			<a href="<?php if(strpos($row->company_website,'http') === false) echo 'http://'; echo $row->company_website;?>" rel="nofollow" target="_blank"><?php echo $row->company_website;?></a>
		</div>
	</div>
	<div id="DIV_11">
		<div id="DIV_12">
			<?php echo $row->mobile_phone;?>
		</div>
		<div id="DIV_13">
			<?php echo $row->city;?>, <?php echo $row->country;?>
		</div>
		<a href="<?php echo base_url('employer/edit_company');?>" id="edit_company_profileee" class="editLink"><i class="fa fa-pencil">&nbsp;</i> <?=lang('Edit Company Profile')?></a>
	</div>
	<div id="DIV_16">
	</div>
<br/>
<br/>
<div class="candidate">
	<h2>Candidate</h2>

	<table class="table-tm">
  <tr>
    <th><input type="checkbox" name=""></th>
    <th width="2%"></th>
    <th>Name</th>
    <th>Status</th>
    <th>Skills</th>
  </tr>
	<?php foreach ($result_applied_jobs as $app) { ?>

	<tr>
	<td><input type="checkbox" name=""></td>
	<td><img style="width: 30px;" src="<?php echo base_url('public/new/images/search.png');?>"/></td>
	<td><?=$app->first_name.' '.$app->last_name ?></td>
	<td> <?php if($app->flag=="") echo lang("Primary"); else echo lang($app->flag);?> </td>
	<td></td>
	</tr>
	<?php } ?>
  
</table>

<br/>

<br/>
<br/>
	<h2>Company Feeds</h2>
 
<br/>
<br/>
 

<br/>
 
<br/>
<br/>
</div>
</div>


<?php 
	$this->load->view('new/footer');
 ?>