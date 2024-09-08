<?php $this->load->view('application_views/common/head_app'); 
$user_id=$this->session->userdata('user_id');
$row_1 = $this->employers_model->get_employer_by_id($user_id);
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<style>
    .table_list th
    {    padding: 10px;
         background-color: rgb(6, 102, 159);
         color: white;
         text-align: center;
    }
    
    .table_list td
    {    padding: 10px;
         color: black;
         text-align: center;
         font-size: 13px;
         font-weight: bold;
         border: 0.1px solid rgba(0,0,0,0.5);
    }
    
    .table_list
    {
        width: 100%;
        border-collapse: separate;
        border-spacing: 1;
    }
    .td_action a{
        color: black;
        font-size: 18px;
        text-align: center;
        padding: 5px;
        border-left: 1px solid whitesmoke;
    }
    .td_action{
            white-space: nowrap;
    }
</style>

<?php if($title_app!='Manage My Jobs') {?>
<span class="back_icon"><i class="fa fa-arrow-left"></i>
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
         <?php if($title_app=='hh') {?>
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
    
    <span class="close_side_bar"><i class="fa fa-times" ></i>
    </span>
    
  <span onclick="$('.my_visible').click();$('#chngLngg').modal('show');" title="Change Website Language" class="right_side_bar"> <i class="fa fa-language"></i>
  </span>
    <div class="content_side_bar">
          <ul class="side_bar_ul">
              <li style="width:100%;">
               <div class="li_img_user">
                   <?php $pht=$row_1->company_logo;
                if($pht=="") $pht='no_pic.jpg'; ?>
                  <div class="img_user"> 
               
                   <img src="<?php echo base_url('public/uploads/employer/'.$pht);?>"/> 
                   </div>
                   <div class="name_user">
                       <?php echo $row_1->company_name;?>
                   </div>
               </div>
           </li>
            
           </ul>
     
       <ul class="side_bar_ul_nav">
           
           <li>
               <a href="<?php echo base_url('app/employer/edit_company');?>" class=""><i class="fa fa-user i_side_bar"></i> <span class="title_icon"><?=lang('Company Profile')?></span></a>
            </li>
              <li>
                  <a href="<?php echo base_url('app/employer/post_new_job');?>" class=""><i class="fa fa-file-text-o i_side_bar"></i> <span class="title_icon"><?=lang('Post New Job')?></span></a>
           </li> 
               
               <li>
                   <a href="<?php echo base_url('app/employer/My_posted_jobs');?>" class=""><i class="fa fa-cogs i_side_bar"></i> <span class="title_icon"><?=lang('Manage My Jobs')?></span></a>
           </li>
           <li>
                   <a href="<?php echo base_url('app/employer/quizzes');?>" class=""><i class="fa fa-question-circle i_side_bar"></i> <span class="title_icon"><?=lang('Quizzes')?></span></a>
           </li>
           
           <li>
                   <a href="<?php echo base_url('app/employer/Job_applications');?>" class=""><i class="fa fa-users i_side_bar"></i> <span class="title_icon"><?=lang('View Candidates')?></span></a>
           </li>
           
           
           
           <li>
                   <a href="<?php echo base_url('app/employer/interview');?>" class=""><i class="fa fa-calendar-o i_side_bar"></i> <span class="title_icon"><?=lang('Interview')?></span></a>
           </li>
           
           <li>
                   <a href="<?php echo base_url('app/employer/change_password');?>" class=""><i class="fa fa-cog i_side_bar"></i> <span class="title_icon"><?=lang('Change Password')?></span></a>
           </li>
           
           <li class="logout_option"><a href="<?php echo base_url('app/User/logout');?>" ><i class="fa fa-lock i_side_bar"></i><?=lang('Log Out')?></a></li>
   
       </ul>
        
        
    </div>
</div>
   


