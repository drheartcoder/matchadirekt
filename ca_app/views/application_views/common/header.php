<?php $this->load->view('application_views/common/head_app'); 
$user_id=$this->session->userdata('user_id');
$row = $this->job_seekers_model->get_job_seeker_by_id($user_id);
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<?php if($title_app!='Jobs' && $title_app!='Manage My Jobs') {?>
<span class="back_icon" <?php if($title_app!="Job Details") echo "style='padding: 9px;'" ?>><i class="fa fa-arrow-left"></i>
</span>
<?php } ?>
  <div class="modal fade" id="chngLngg">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?=lang('Change Website Language')?></h4>
      </div>
      <div class="modal-body">
        <div><a style="font-size: 20px;" href="<?=base_url()?>lang/en?url=<?=$actual_link?>">English</a></div><hr/>
        <?php
            $rows_ln=$this->db->query("SELECT * FROM tbl_lang")->result();
          
            foreach($rows_ln as $row_ln)
            {
            ?>
               <div><a style="font-size: 20px;" href="<?=base_url()?>lang/<?=$row_ln->Abbreviation?>?url=<?=$actual_link?>"><?=$row_ln->Name?></a></div><hr/>
            <?php
            }
            ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('Close')?></button>
      </div>
    </div>
  </div>
</div>
<div class="top_header">

    <div class="content_head">
       <ul class="right_ul">
         <?php if($title_app=='Jobs') {?>
           <li><i id="filter_icon" class="fa fa-filter i_style"></i></li>
            <?php }?>
           <li><center><span class="title_page"><?php echo lang($title_app);?></span></center>
           
          
           </li>
           <li style="float:left;"><span class="my_visible"><i class="fa fa-arrow-right  i_style"></i></span></li>
          
        </ul>
    </div>
     <div class="li_form">
             <?php echo form_open_multipart('app/jobs',array('name' => 'jsearch', 'id' => 'jsearch'));?>            
                <div class="">
                     <input type="text" name="job_params" id="job_params" class="form-control" placeholder="<?=lang('Job title or Skill')?>" value="" />
                     
                          <span class="" id="basic-addon3"><i class="fa fa-search i_style"></i></span>
                       
                <input type="submit" name="job_submit" class="btn" id="job_submit" value="" style="display:none;"/>
             </div>
             
            <?php echo form_close();?>
           </div>
</div>
<div class="father_side_bar"> </div>
<div class="side_bar">
  <span  class="close_side_bar" <?php if($title_app=="Job Details") echo "style='padding: 2px;';" ?>><i class="fa fa-times"></i>
    </span>
	<span onclick="$('.my_visible').click();$('#chngLngg').modal('show');" title="Change Website Language" class="right_side_bar"> <i class="fa fa-language"></i>
  </span>
    <div class="content_side_bar">
       <ul class="side_bar_ul">
           
           <li style="width:100%;">
               <div class="li_img_user">
                   <?php $pht=$row->photo;
                if($pht=="") $pht='no_pic.jpg'; ?>
                  <div class="img_user"> 
               
                   <img src="<?php echo base_url('public/uploads/candidate/'.$pht);?>"/> 
                   </div>
                   <div class="name_user">
                       <?php echo $row->first_name.' '.$row->last_name ;?>
                   </div>
               </div>
               
           </li>
           <hr/>
           
           <li>
               <a href="<?php echo base_url('app/jobseeker/my_account');?>" class=""><i class="fa fa-user i_side_bar"></i> <span class="title_icon"><?=lang('Manage Account')?></span></a>
           </li>
           <li>
               <a href="<?php echo base_url('app/jobs');?>" title="<?=lang('Jobs')?>"><i class="fa fa-briefcase i_side_bar"></i><span class="title_icon"><?=lang('Jobs')?></span></a>
           </li>
           <li>
               <a href="<?php echo base_url('app/jobseeker/My_jobs');?>" ><i class="fa fa-file-text-o i_side_bar"></i> <span class="title_icon"><?=lang('My Applications')?></span></a>
           </li>
           <li>
               <a href="<?php echo base_url('app/jobseeker/Add_skills');?>" ><i class="fa fa-list i_side_bar"></i> <span class="title_icon"><?=lang('Manage Skills')?></span></a>
           </li>
           <li><a href="<?php echo base_url('app/jobseeker/Change_password');?>" ><i class="fa fa-lock i_side_bar"></i> <span class="title_icon"><?=lang('Change Password')?></span></a></li>
           
            <li class="logout_option"><a href="<?php echo base_url('app/User/logout');?>" ><i class="fa fa-lock i_side_bar"></i><?=lang('Log Out')?></a></li>
           
       </ul>
    </div>
</div>
   


