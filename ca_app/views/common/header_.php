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
    @media (max-width: 700px) {
      .div_hide_me {
          display: none!important;
        }
      #btn_header_hide {
          /*display: none!important;*/
        }
      .div_show_it {
          /*display: block!important;*/
        }
      .candidatesection h1{
        font-size: 28px;
      }
      .div_up_me{
        /*margin-top: -60px;*/
      }
        
    }
    .logo_img{width: 45px;}
    
    ._top{list-style-type: none; padding: 0px;}
    .sous_top{margin-top: 7px;margin-right: 7px;margin-bottom: 10px}
    .sous_top_a{padding: 20px 12px 12px 12px ;text-decoration: none;}
    .iwantcreate{position: absolute;top: 55px;left: 0;z-index: 1500;width: 100%;display:flex;}
    .a_right{float: right;color: #444444;margin-top: 20px;text-align: center;}
    .a_right a{color: #444444;}
    .iwantcreate a{text-decoration: none;padding: 8px 12px 8px 12px;color: #fff;width: 50%;padding-top: 14px;padding-bottom: 14px;cursor: pointer;}
    .iwantcreate a:hover{background-color:#132053 ;color:white;}
    ul{list-style-type: none;}
    #nav_ul li{float: left;text-align: center;width: 20%;}
    #nav_ul{width: 100%;display: flex;float: left;height: 100%;margin-top: 2px;}
    #nav_ul li a{padding: 0px 10px 10px 10px;color: #3f3f3f;font-size: 21px;width: 100%;height: 40px;display: block;text-align: center;border-radius: 2px;;margin-top: -9px; overflow: hidden;}
    ._title{
        color:#3785b3;
        padding: 0;
        text-align: center;
        font-size: 10px;
        margin-top:-6px;
        display: block;
    }
</style>
<div class="topheader">
<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>



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
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="max-height: 55px;">
          <ul class="_top">
            <li class="sous_top" style="float: left"><a  href="<?php echo base_url();?>"><img src="<?php echo base_url('public/images/eye.png');?>" class="logo_img"/></a> </li>
             
              <?php if($this->session->userdata('is_user_login')!=TRUE): ?>

              <li  class="sous_top a_right">
                  <a id="my"  class="sous_top_a" onclick="showme(this);"><?=lang('Sign Up')?> <i class="fa fa-caret-down"></i></a> 
                  <div class="iwantcreate" style="display: none;">
                     <a style="background-color:#132053" href="<?php echo base_url('employer-signup');?>" class=""><?=lang('Post a Job')?></a>
                     <a style="background-color:#505C73" href="<?php echo base_url('jobseeker-signup');?>" class=""><?=lang('Job Seeker')?></a>
                  </div>
              </li>
               <li class="sous_top a_right"><a onclick="me_text(this);" class="sous_top_a" href="<?php echo base_url('login');?>" class="loginBtn div_show_it" title="Jobs openings"><?=lang('Login')?> <i class="fa fa-sign-in"></i></a></li>
              <?php else:
               $c_folder = ($this->session->userdata('is_employer')==TRUE)?'employer':'jobseeker';
               ?>
              <a href="<?php echo base_url('user/logout');?>"  class="regBtn"><?=lang('Logout')?></a>
              <div class="pull-right loginusertxt div_hide_it"><?=lang('Welcome')?>, <a href="<?php echo base_url($c_folder.'/dashboard');?>" class="username"><?php echo $this->session->userdata('first_name');?>!</a></div>
              <?php endif;?>
              <div class="clear"></div>
             
        </ul>
      </div>
      
      
       <div id="div_nav" class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="background-color:white; box-shadow: 0 0 5px  rgba(0,0,0,0.5);padding: 10px 0px 10px 0px;text-align: left;display: flex;flex-flow: nowrap; max-height: 42px;">
            <ul id="nav_ul" class="">
              <?php 
        
        if($this->session->userdata('is_employer')==TRUE):
      ?>
              <li <?php echo active_link('');?>><a href="<?php echo base_url();?>"><i class="fa fa-home" aria-hidden="true"></i></a></li>
              <li <?php echo active_link('employer');?>><a href="<?php echo base_url('employer/dashboard');?>" title="<?=lang('My Dashboard')?>"><i class="fa fa-dashboard"></i></a> </li>
              <li <?php echo active_link('search-resume');?>><a href="<?php echo base_url('search-resume');?>" title="<?=lang('Search Resume')?>"><?=lang('Search Resume')?></a></li>
              <li <?php echo active_link('contact-us');?>><a href="<?php echo base_url('contact-us');?>" title="Contact Us"><?=lang('Contact Us')?></a></li>
              <!-- <li <?php //echo active_link('indeed_jobs');?>><a href="<?php //echo base_url('indeed_jobs');?>" title="Indeed Jobs">Indeed Jobs</a></li> -->
        
    <?php elseif($this->session->userdata('is_job_seeker')==TRUE):?>
              <li <?php echo active_link('');?>><a href="<?php echo base_url();?>"><i class="fa fa-home" aria-hidden="true"></i></a></li>
              <li <?php echo active_link('jobseeker');?>><a href="<?php echo base_url('jobseeker/dashboard');?>" title="<?=lang('My Dashboard')?>"><i class="fa fa-dashboard"></i></a> </li>
              <li <?php echo active_link('search-jobs');?>><a href="<?php echo base_url('search-jobs');?>" title="<?=lang('Search Jobs')?>"><?=lang('Search Jobs')?></a></li>
              <li <?php echo active_link('contact-us');?>><a href="<?php echo base_url('contact-us');?>" title="<?=lang('Contact Us')?>"><?=lang('Contact Us')?></a></li>
              <!-- <li <?php //echo active_link('indeed_jobs');?>><a href="<?php //echo base_url('indeed_jobs');?>" title="Indeed Jobs">Indeed Jobs</a></li> -->
         
         <?php else:?>
                <li <?php echo active_link('');?>><a href="<?php echo base_url();?>" style="border-bottom:3px solid #3785b3 ;"><i class="fa fa-home" aria-hidden="true"></i><span class="_title">home</span></a></li>
              <li <?php echo active_link('search-jobs');?>><a href="<?php echo base_url('search-jobs');?>" title="<?=lang('Search a Job')?>" ><i class="fa fa-filter"></i><span class="_title"><?=lang('Search a Job')?></span></a> </li>
              <li <?php echo active_link('search-resume');?>><a href="<?php echo base_url('search-resume');?>" title="<?=lang('Search Resume')?>"><i class="fa fa-search"></i><span class="_title"><?=lang('Search Resume')?></span></a></li>
              <li <?php echo active_link('about-us.html');?>><a href="<?php echo base_url('about-us.html');?>" title="<?=lang('About Us')?>"><i class="fa fa-info"></i><span class="_title"><?=lang('About Us')?></span></a></li>
              <li <?php echo active_link('contact-us');?>><a href="<?php echo base_url('contact-us');?>" title="<?=lang('Contact Us')?>"><i class="fa fa-phone"></i><span class="_title"><?=lang('Contact Us')?></span></a></li>
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
