<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('common/meta_tags'); ?>
<title><?php echo $title;?></title>
<?php $this->load->view('common/before_head_close'); ?>
<style type="text/css"> .formwraper p{font-size:13px;}</style>
</head>
<body>
<?php $this->load->view('common/after_body_open'); ?>
<div class="siteWraper">
<!--Header-->
<?php $this->load->view('common/header'); ?>
<!--/Header-->
<div class="container detailinfo">
  <div class="row">
  <div class="col-md-3">
  <div class="dashiconwrp">
    <?php $this->load->view('employer/common/employer_menu');?>
  </div>
  </div>
  
    <div class="col-md-9"> 
    <?php echo $this->session->flashdata('msg');?>
    <div class="paginationWrap"> <?php echo ($result_posted_jobs)?$links:'';?> </div>
      <!--Job Application-->
      <div class="formwraper">
        <div class="titlehead">
          <div class="row">
            <div class="col-md-12"><b><?=lang('All Archived Jobs')?></b></div>
          </div>
        </div>
        
        <!--Job Description-->
        <div class="row searchlist"> 
          <br/>
          <!--Job Row-->
          <?php 
          $i=0;
         if($result_posted_jobs):
          foreach($result_posted_jobs as $row_jobs):
            if($row_jobs->sts!="archive")
              goto enddd;
            $i++;
          ?>
          <div class="col-md-12" id="pj_<?php echo $row_jobs->ID;?>">
            <div class="intlist">
              <div class="col-md-12">
                <div class="col-md-8"> <a href="<?php echo base_url('jobs/'.$row_jobs->job_slug);?>" class="jobtitle"><?php echo word_limiter(strip_tags($row_jobs->job_title),9);?></a>
                  <div class="location"><a href="<?php echo base_url('company/'.$row->company_slug);?>"><?php echo $row->company_name;?></a> &nbsp;-&nbsp; <?php echo $row_jobs->city;?></div>
                </div>
                <div class="col-md-4">
                
                  <div class="col-md-4 pull-right text-right"> 
                  <a href="<?php echo base_url('jobs/'.$row_jobs->job_slug);?>" style="text-decoration:none;" title="<?=lang('Quick Preview')?>"><span class="label label-primary"><?=lang('Quick Preview')?></span></a> 
                  </div>
                  
                  <div class="col-md-8">
                    <div class="date"><?php echo date_formats($row_jobs->dated, 'd M Y');?></div>
                  </div>
                </div>
                <div class="clear"> </div>
                <p><?php echo word_limiter(strip_tags($row_jobs->job_description),20);?></p>
                  <br/>
              </div>
              <div class="clear"></div>
            </div>
          </div>
          <?php 
            enddd:
          endforeach;
         else:          
          topp:
          $i=1;
        ?>
          <div align="center" class="text-red"><?=lang('No job archived')?>.</div>
          <?php endif;?>
          <?php
          if($i==0)
            goto topp;
          ?>
        </div>
      </div>
      <div class="paginationWrap"> <?php echo ($result_posted_jobs)?$links:'';?> </div>
    </div>
    <!--/Job Detail-->
    
    <!--Pagination-->
    
  </div>
</div>
<?php $this->load->view('common/bottom_ads');?>
<!--Footer-->
<?php $this->load->view('common/footer'); ?>
<!-- Profile Popups -->
<?php $this->load->view('employer/common/employers_popup_forms'); ?>
<?php $this->load->view('common/before_body_close'); ?>
<script src="<?php echo base_url('public/js/validate_employer.js');?>" type="text/javascript"></script>
</body>
</html>