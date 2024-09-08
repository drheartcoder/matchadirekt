<?php if($this->session->userdata('is_employer')==TRUE)
 $this->load->view('application_views/common/header_emp'); 
 else if($this->session->userdata('is_job_seeker')==TRUE)
     $this->load->view('application_views/common/header'); 
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=2141839581672924&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="siteWraper">
<!--Header-->
<!--/Header--> 
<!--Detail Info-->
<div class="container detailinfo">
  
      <div class="row"> 
        <div class="col-md-12 col-sm-12">
        
        <!--Company Info-->       
          <div class="companyinfoWrp">            
            <h1 class="jobname"><?php echo $row_company->company_name;?></h1>
            <?php
		  	//echo "T".file_exists($real_path = realpath(APPPATH . '../public/uploads/employer/'.$company_logo));
		  ?>
            <div class="companylogo"><img src="<?php echo base_url('public/uploads/employer/'.$company_logo);?>" width="100%" alt="<?php echo base_url('company/'.$row_company->company_slug);?>" /></div>
            <div class="companyInfo">
              <div class="location"><?php echo ($row_company->city)?$row_company->city.',':'';?> <?php echo ($row_company->country)?$row_company->country:'';?></div>
              <div class="comtxt"><span><?=lang('Current Openings')?> :</span> <strong><?php echo $total_opened_jobs;?></strong> </div>
              <?php if($row_company->no_of_employees):?>
              <div class="comtxt"><span><?=lang('Staff Members')?> :</span> <strong><?php echo $row_company->no_of_employees;?> Employees</strong></div>
              <?php endif;?>
              <?php if($company_website):?>
              <div class="comtxt"><span><?=lang('Company Url')?> :</span> <strong><a href="<?php echo $company_website;?>" target="_blank" rel="nofollow"><?php echo $company_website;?></a></strong></div>
              <?php endif;?>
            </div>
            
            
            <!-- <div class="socialWedget" style="top:10px; position:static;"> facebook like & share button
              <div class="fb-share-button" data-href="<?php echo current_url();?>" style="float:left; margin-left:5px;"></div>
              <div class="clearfix"></div>
            </div> -->
            
            
            <div class="clear"></div>
          </div>
        
        <!--Apply-->        

      </div>

   
</div>
<?php $this->load->view('application_views/common/footer_app'); ?>