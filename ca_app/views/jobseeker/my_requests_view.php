<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('common/meta_tags'); ?>
<title><?php echo $title;?></title>
<?php $this->load->view('common/before_head_close'); ?>
</head>
<body>
<?php $this->load->view('common/after_body_open'); ?>
<div class="siteWraper">
<!--Header-->
<?php $this->load->view('common/header'); ?>
<!--/Header--> 
<!--Detail Info-->
<div class="container detailinfo">
  <div class="row">
  	<div class="col-md-3">
    	<div class="dashiconwrp">
    		<?php $this->load->view('jobseeker/common/jobseeker_menu'); ?>
  		</div>
    </div>
    <div class="col-md-9">
    <!--Job Detail-->
    
      <div class="formwraper">
        <div class="titlehead">
          <div class="row">
            <div class="col-md-12"><b><?=lang('My Requests')?></b></div>
          </div>
        </div>
        
        <!--Job Description-->
        <div class="companydescription">
          <div class="row">
            <div class="col-md-12">
              <ul class="myjobList">
                <?php
                    $id=$this->session->userdata('user_id');
                    if($_GET['approuve'])
                    {
                      $this->db->query("UPDATE tbl_requests_info SET sts='approuved' WHERE jobseeker_id='".$id."' AND employer_id='".$_GET['approuve']."'");
                      redirect(base_url().'jobseeker/my_requests');
                    }
                    if($_GET['deny'])
                    {
                      $this->db->query("UPDATE tbl_requests_info SET sts='not approuved' WHERE jobseeker_id='".$id."' AND employer_id='".$_GET['deny']."'");
                      redirect(base_url().'jobseeker/my_requests');
                    }

                 if($result_requests): 
		  			foreach($result_requests as $row_request):
		  ?>
                  <li class="row" id="aplied_<?php echo $row_request->ID;?>">
                   <div class="col-md-6"><a><?php echo $row_request->employer_name;?></a>
                  </div>
                  <div class="col-md-4 text-right"><?php echo $row_request->sts?></div>
                  <?php
                  if($row_request->sts=="pending")
                  {
                  	?>
                    <div class="col-md-2 text-right"><a href="?approuve=<?=$row_request->employer_id?>"><i class="fa fa-check"></i>&nbsp;<?=lang('Approuve')?></a>
                      <a href="?deny=<?=$row_request->employer_id?>"><i class="fa fa-times"></i>&nbsp;<?=lang('Deny')?></a></div>
                  	<?php
                  }
                  ?>
                </li>
                  <?php
                  lb:
                 ?>
                <?php 	endforeach; 
		  		else:?>
                <?=lang('No record found')?>!
                <?php endif;?>
              </ul>
            </div>
            
            
            
            
          </div>
        </div>
      </div>
    </div>
    <!--/Job Detail--> 
    
    <!--Pagination-->
    <div class="paginationWrap"> <?php echo ($result_applied_jobs)?$links:'';?> </div>
  </div>
</div>
<?php $this->load->view('common/bottom_ads');?>
<!--Footer-->
<?php $this->load->view('common/footer'); ?>
<?php $this->load->view('common/before_body_close'); ?>
</body>
</html>