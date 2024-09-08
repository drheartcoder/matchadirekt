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
            <div class="col-md-12"><b>My Job Applications</b></div>
          </div>
        </div>
        
        <!--Job Description-->
        <div class="companydescription">
          <div class="row">
            <div class="col-md-12">
              <ul class="myjobList">
                <?php if($result_applied_jobs): 
		  			foreach($result_applied_jobs as $row_applied_job):
		  ?>
            <?php 
            if($row_applied_job->withdraw==1) goto nd;
            ?>
                <li class="row" id="aplied_<?php echo $row_applied_job->applied_id;?>">
                  <div class="col-md-4"><a href="<?php echo base_url('jobs/'.$row_applied_job->job_slug);?>"><?php echo $row_applied_job->job_title;?></a></div>
                   <div class="col-md-4"><a href="<?php echo base_url('jobs/'.$row_applied_job->job_slug);?>"><?php echo $row_applied_job->company_name;?></a><br/><?php if($row_applied_job->answer!="") echo'Your answer : ('.$row_applied_job->answer.')';if($row_applied_job->file_name!="" && $row_applied_job->answer!="") echo '<br/>';?>
                    <?php 
                    if($row_applied_job->file_name!="")
                    {
                      $filenames=explode("$*_,_*$", $row_applied_job->file_name);
                      for($i=0;$i<count($filenames);$i++)
                      {
                          echo "<i style='color:darkgreen!important;font-size: 13px!important;' class='fa fa-file'></i> <a style='color:darkgreen!important;font-size: 13px!important;' href='./download/".$filenames[$i]."'>Attached file ".($i+1)."</a>"; 
                          if($i!=count($filenames)-1)
                            echo "<br/>";
                      }
                      if(count($filenames)==0)
                      {
                          echo "<i style='color:darkgreen!important;font-size: 13px!important;' class='fa fa-file'></i> <a style='color:darkgreen!important;font-size: 13px!important;' href='./download/".$row_applied_job->file_name."'>Attached file</a>";  
                      }
                    }
                    ?>
                  </div>
                  <div class="col-md-2 text-right"><?php echo date_formats($row_applied_job->applied_date, 'M d, Y');?></div>
                  <div class="col-md-2 text-right"><a onclick="if(confirm('Do you really wanna withraw this Application ?')){window.location='<?=base_url()?>jobseeker/my_jobs/withdraw/<?php echo $row_applied_job->applied_id;?>';}" style="cursor:pointer;font-size: 12px;" >Withdraw</a>&nbsp;&nbsp;&nbsp; <a href="javascript:;" onClick="del_applied_job(<?php echo $row_applied_job->applied_id;?>);" title="Delete" class="delete-ico"><i class="fa fa-times">&nbsp;</i></a></div>
                </li>
                <?php 
                  nd:
                  if($row_applied_job->withdraw==0) goto lb;
                  ?>
                  <li class="row" id="aplied_<?php echo $row_applied_job->applied_id;?>">
                  <div class="col-md-4"><a style="font-style: oblique;"><?php echo $row_applied_job->job_title;?></a></div>
                   <div class="col-md-4"><a style="font-style: oblique;"><?php echo $row_applied_job->company_name;?></a>
                  </div>
                  <div class="col-md-2 text-right"><?php echo date_formats($row_applied_job->applied_date, 'M d, Y');?></div>
                  <div class="col-md-2 text-right"><i style="color:gray;font-size: 12px;" >Withdrawn</i>&nbsp;&nbsp;&nbsp; <a href="javascript:;" onClick="del_applied_job(<?php echo $row_applied_job->applied_id;?>);" title="Delete" class="delete-ico"><i class="fa fa-times">&nbsp;</i></a></div>
                </li>
                  <?php
                  lb:
                 ?>
                <?php 	endforeach; 
		  		else:?>
                No record found!
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