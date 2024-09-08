 <?php 
$this->db->query("UPDATE tbl_post_jobs SET sts='active',age_required='0' WHERE dated<=CURDATE() AND age_required='1' AND sts='inactive'");
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
 ?>
<style>
    div#google_translate_element div.goog-te-gadget-simple {
        font-size: 19px;
        text-align: center;
        text-decoration: none;
    }
  @media (max-width: 667px) {
    #google_translate_element {
        top: 33px;
        right: 60px;
      }
    }
 
    .logo_img{width: 90px;margin-left: -15px;margin-top:-2px;border-radius: 0px 10px 10px 0px;box-shadow: 1px 2px 10px black;}
    
    ._top{list-style-type: none; padding: 0px;max-height: 50px;}
    .sous_top{margin-top: 2px;margin-right: 3px;margin-bottom: 10px}
    .sous_top_a{text-decoration: none!important;cursor: pointer;}
    .iwantcreate{position: absolute;top: 49px;left: 0;z-index: 1500;width: 100%;display:flex;box-shadow: 0px 25px 50px black;}
    .a_right{float: right;color: #444444;margin-top: 23px;text-align: center;margin-left: 5px;}
    .a_right a{color: #444444;}
    .iwantcreate a{text-decoration: none;padding: 8px 12px 8px 12px;color: #fff;width: 50%;padding-top: 14px;padding-bottom: 14px;cursor: pointer;}
    .iwantcreate a:hover{background-color:#3785b3 ;color:white;}
    ul{list-style-type: none;}
    #nav_ul li{float: left;text-align: center;width: 20%;}
    #nav_ul{width: 100%;display: block;float: left;height: 100%;margin-top: 2px;}
    .fix_me{
        position: fixed;top: 0;left: 0;z-index: 1600;
    }
    #nav_ul li a{padding: 0px 0px 5px 0px;margin-top: -6px;color: #fff;font-size: 21px;width: 100%;height: 54px;display: block;text-align: center;border-radius: 2px;; overflow: hidden;}
     #nav_ul li a:hover{text-decoration: none;}
    ._title{
        color:white;
        padding: 7px;
        text-align: center;
        font-size: 8px;
        margin-top: -8px;
        display: block;

    }
    ._act{border-bottom:3px solid white;color: white;}
    .basic-addon{
        background-color: white;color:#3785b3;border: 1px solid #3785b3;font-size: 22px;cursor: pointer;
    }
    .basic-addon:hover{
        background-color: #3785b3;color:white;border: 1px solid white;font-size: 22px;cursor: pointer;
    }
    #input_search
    {
        display: none;
    }
    .hide_me{display:none}
    .login_btn{background-color: white;color: #3785b3;border: 1px solid #3785b3;padding: 5px 30px 5px 30px;width: 50% ;margin-right: 25%}
    .login_btn:hover{background-color: #3785b3;color: white;border: 1px solid white;}
    .sign_up_btn{background-color: #3785b3;color: white;border: 1px solid white;border-radius: 5px;padding: 8px 30px 8px 30px;text-decoration: none}
    .sign_up_btn:hover{background-color: white;color: #3785b3;border: 1px solid #3785b3;text-decoration: none;}


  @media (max-width: 384px) {
    #nav_ul li a {
        font-size: 20px;
      }
    }
  @media (min-width: 700px) {
    .iwantcreate {
        width: 400px; 
        right: 80px;
        left: initial;
        /*width: 100%;
        left: 0;
        right: 0;*/
      }
    }
    .lang_list{
        position: absolute;
	    top: 50px;
	    right: 40px;
	    z-index: 1598;
	    background-color: white;
	    box-shadow: 0 0 5px rgba(0,0,0,0.5);
	    max-height: 560px;
	    padding: 1px 15px 10px 15px;
	    overflow: auto;
	    display: none;
    }

</style>
<div class="topheader">
<!--
<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'sv', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
-->

<?php if($this->session->userdata('is_employer')==TRUE):?>
              
                <span class="hide_me" id="back_arrow"><i class="fa fa-arrow-right"></i></span>
                
           <div class="dashboard_div" style="display:none;">
            <?php $this->load->view('employer/common/employer_menu_app');?>
          <span  class="" id="close_menu"><i class="fa fa-arrow-left"></i></span>
    </div>

<?php endif;?>
    <?php if($this->session->userdata('is_job_seeker')==TRUE):?>
              
                <span class="hide_me" id="back_arrow"><i class="fa fa-arrow-right"></i></span>
                
           <div class="dashboard_div" style="display:none;">
            <?php $this->load->view('jobseeker/common/jobseeker_menu_app');?>
          <span  class="" id="close_menu"><i class="fa fa-arrow-left"></i></span>
    </div>

<?php endif;?>
<div class="modal fade" id="chngLngg">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?=lang('Change Website Language')?></h4>
      </div>
      <div class="modal-body">
        <div id="google_translate_element"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('Close')?></button>
      </div>
    </div>
  </div>
</div>

  <div class="navbar navbar-default" role="navigation">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="max-height: 50px;">
          <ul class="_top">
            <li class="sous_top" style="float: left"><a  href="<?php echo base_url();?>"><img src="<?php echo base_url('public/images/logo.jpeg');?>" class="logo_img"/></a> </li>
             
            <li onclick="$('.lang_list').slideToggle();" class="btn sous_top a_right" title="Change Website Language" style="font-size: 20px;margin-top:7px;color:darkgreen;border-radius: 20px;" ><i class="fa fa-language"></i> <i class="fa fa-caret-down"></i>
                 <ul class="lang_list">
                       <li><a style="font-size: 14px;text-decoration: none;" href="<?=base_url()?>lang/en?url=<?=$actual_link?>">English</a></li>
               <?php
                    $rows_ln=$this->db->query("SELECT * FROM tbl_lang")->result();
                  
                    foreach($rows_ln as $row_ln)
                    {
                    ?>
                       <li><a style="font-size: 14px;text-decoration: none;" href="<?=base_url()?>lang/<?=$row_ln->Abbreviation?>?url=<?=$actual_link?>"><?=$row_ln->Name?></a></li>
                    <?php
                    }
                    ?>
                  </ul>
                  
              </li>

              <?php if($this->session->userdata('is_user_login')!=TRUE): ?>

              <li  class="sous_top a_right">
                  <a id="my"  class="sous_top_a" onclick="showme(this);"><?=lang('Sign Up')?> <i class="fa fa-caret-down"></i></a> 
                  <div class="iwantcreate" style="display: none;">
                     <a style="background-color:#3785b3" href="<?php echo base_url('employer-signup');?>" class=""><?=lang('Post a Job')?></a>
                     <a style="background-color:#505C73" href="<?php echo base_url('jobseeker-signup');?>" class=""><?=lang('Job Seeker')?></a>
                  </div>
              </li>
               <li class="sous_top a_right"><a onclick="me_text(this);" class="sous_top_a" href="<?php echo base_url('login');?>" class="loginBtn div_show_it"><?=lang('Login')?> <i class="fa fa-sign-in"></i></a></li>
              <?php else:
               $c_folder = ($this->session->userdata('is_employer')==TRUE)?'employer':'jobseeker';
               ?>
              <li class="sous_top a_right"><a href="<?php echo base_url('user/logout');?>"  class=""><?=lang('Logout')?> <i class="fa fa-sign-out"></i></a></li>
              <div style="margin-top:20px;margin-left:-15px;" class="pull-right loginusertxt "><a href="<?php echo base_url($c_folder.'/dashboard');?>" class="username"><?php echo $this->session->userdata('first_name');?>!</a></div>
              <?php endif;?>
              <div class="clear"></div>
             
        </ul>
      </div>
      
      
       <div id="div_nav" class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="background-color:#024972; box-shadow: 0 0 5px  rgba(0,0,0,0.5);padding: 10px 0px 10px 0px;text-align: left;display: flex;flex-flow: nowrap; max-height: 58px;">
            <ul id="nav_ul" class="">
              <?php 
        
        if($this->session->userdata('is_employer')==TRUE):
      ?>
              <li <?php echo active_link('');?>><a <?php echo active_link_('');?> href="<?php echo base_url();?>"><i class="fa fa-home" aria-hidden="true"></i> <span class="_title">home</span></a></li>
              <li <?php echo active_link('employer');?>><a <?php echo active_link_('employer');?> href="<?php echo base_url('employer/dashboard');?>" title="<?=lang('My Dashboard')?>"><i class="fa fa-dashboard"></i><span class="_title"><?=lang('My Dashboard')?></span></a> </li>
              <li <?php echo active_link('search-resume');?>><a <?php echo active_link_('search-resume');?> href="<?php echo base_url('search-resume');?>" title="<?=lang('Search Resume')?>"><i class="fa fa-search"></i><span class="_title"><?=lang('Search Resume')?></span></a></li>
              <li style="float:right;" <?php echo active_link('contact-us');?>><a <?php echo active_link_('contact-us');?> href="<?php echo base_url('contact-us');?>" title="Contact Us"><i class="fa fa-phone"></i><span class="_title"><?=lang('Contact Us')?></span></a></li>
                
              <!-- <li <?php //echo active_link('indeed_jobs');?>><a href="<?php //echo base_url('indeed_jobs');?>" title="Indeed Jobs">Indeed Jobs</a></li> -->
        
    <?php elseif($this->session->userdata('is_job_seeker')==TRUE):?>
              <li <?php echo active_link('');?>><a <?php echo active_link_('');?> href="<?php echo base_url();?>"><i class="fa fa-home" aria-hidden="true"></i> <span class="_title">home</span></a></li>
              <li <?php echo active_link('jobseeker');?>><a <?php echo active_link_('jobseeker');?> href="<?php echo base_url('jobseeker/dashboard');?>" title="<?=lang('My Dashboard')?>"><i class="fa fa-dashboard"></i> <span class="_title"><?=lang('My Dashboard')?></span></a> </li>
              <li <?php echo active_link('search-jobs');?>><a <?php echo active_link_('search-jobs');?> href="<?php echo base_url('search-jobs');?>" title="<?=lang('Search Jobs')?>"><i class="fa fa-search"></i><span class="_title"><?=lang('Search Jobs')?></span></a></li>
              <li style="float:right;" <?php echo active_link('contact-us');?>><a <?php echo active_link_('contact-us');?> href="<?php echo base_url('contact-us');?>" title="<?=lang('Contact Us')?>"><i class="fa fa-phone"></i><span class="_title"><?=lang('Contact Us')?></span></a></li>
              <!-- <li <?php //echo active_link('indeed_jobs');?>><a href="<?php //echo base_url('indeed_jobs');?>" title="Indeed Jobs">Indeed Jobs</a></li> -->
            <?php else:?>
                <li <?php echo active_link('');?>><a <?php echo active_link_('');?> href="<?php echo base_url();?>" style=""><i class="fa fa-home" aria-hidden="true"></i><span class="_title">home</span></a></li>
              <li  <?php echo active_link('search-jobs');?>><a <?php echo active_link_('search-jobs');?> href="<?php echo base_url('search-jobs');?>" title="<?=lang('Search a Job')?>" ><i class="fa fa-filter"></i><span class="_title"><?=lang('Search a Job')?></span></a> </li>
              <li <?php echo active_link('search-resume');?>><a <?php echo active_link_('search-resume');?> href="<?php echo base_url('search-resume');?>" title="<?=lang('Search Resume')?>"><i class="fa fa-search"></i><span class="_title"><?=lang('Search Resume')?></span></a></li>
              <li style="float:right;" <?php echo active_link('about-us.html');?>><a <?php echo active_link_('about-us.html');?> href="<?php echo base_url('about-us.html');?>" title="<?=lang('About Us')?>"><i class="fa fa-info"></i><span class="_title _right"><?=lang('About Us')?></span></a></li>
              <li style="float:right;" <?php echo active_link('contact-us');?>><a <?php echo active_link_('contact-us');?> href="<?php echo base_url('contact-us');?>" title="<?=lang('Contact Us')?>"><i class="fa fa-phone"></i><span class="_title"><?=lang('Contact Us')?></span></a></li>
              <!-- <li <?php //echo active_link('indeed_jobs');?>><a href="<?php //echo base_url('indeed_jobs');?>" title="Indeed Jobs">Indeed Jobs</a></li> -->
            <?php endif;?>

<!--<li class="btn" title="Change Website Language" style="font-size: 20px;margin-top:5px;color:darkgreen;border-radius: 20px;" onclick="$('#chngLngg').modal('show');" id="chngLng"><i class="fa fa-language"></i></li>-->
            </ul>
          </div>
        </div>
    </div>
    <script type="text/javascript">
       function showme(me)
       {
         $('.iwantcreate').slideToggle("fast");
           me.style.textDecoration="none";
          
       }
    function me_text(i)
        {
            i.style.textDecoration="none"
        }

    </script>
        <!--/.nav-collapse -->
      
        <div class="clearfix"></div>
  </div>
</div>
