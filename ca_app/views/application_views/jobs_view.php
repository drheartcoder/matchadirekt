<?php $this->load->view('application_views/common/header'); ?>
<?php if($result):
    foreach($result as $key => $row):
        $skills_list=$this->db->query("SELECT tbl_seeker_skills.skill_name from tbl_seeker_skills WHERE tbl_seeker_skills.seeker_ID='".$this->session->userdata('user_id')."' AND INSTR('".$row->required_skills."',tbl_seeker_skills.skill_name)>0")->result(); 
        if(count($skills_list)<=0)
        {
            unset($result[$key]);
        }
    endforeach;
  endif;
  if(count($result)==0) $from_record=0;
?>
            <div style="padding-bottom:15px;"><b style="float:left"><?php echo $param;?> <?=lang('Jobs')?></b>
            <strong style="float:right"><?=lang('Jobs')?> <?php echo $from_record.' - '.count($result);?> <?=lang('of')?> <?php echo count($result);?></strong> </div>
          
     <div class="list_app">
         
          <?php if($result):
		$CI =& get_instance();
        
				  			foreach($result as $row):
								$company_logo = ($row->company_logo)?$row->company_logo:'no_pic.jpg';
								if (!file_exists(realpath(APPPATH . '../public/uploads/employer/thumb/'.$company_logo))){
									$company_logo='no_pic.jpg';
								}
								$is_already_applied = $CI->is_already_applied_for_job($this->session->userdata('user_id'), $row->ID);		
				  
          
			  ?>
        <div>
            <div class="head_post_job">
            <span class="date_post_job"><?php echo date_formats($row->dated, 'M d, Y');?></span>
              <a href="<?php echo base_url('app/job_details/index/'.$row->job_slug);?>" class="apply_job"><?=lang('View')?></a>
            </div>
            <div class="list_search_app">
                <div class="div_img">
                    <a  class="" title="<?php echo $row->job_title;?>"><img src="<?php echo base_url('public/uploads/employer/'.$company_logo);?>"/></a>
                </div>
                <div class="div_list_content">
                    <span class="title_job" >
                    <a class="" title="<?php echo $row->job_title;?>"><?php echo word_limiter(strip_tags(str_replace('-',' ',$row->job_title)),7);?></a>
                    
                    </span>
                    <span class="company_ne" ><a href="<?php echo base_url('app/company/index/'.$row->company_slug);?>" title="<?=lang('Jobs in')?> <?php echo $row->company_name;?>" style="color:#7da400;"><i class="fa fa-users"></i> <?php echo $row->company_name;?></a></span>
                    <span class="city_ne"><a style="color:black;"><i class="fa fa-home"></i> <?php echo $row->city;?></a></span>
                    <?php if($is_already_applied=='yes'){?>
                   <span class="check_apply"><i class="fa fa-check"></i></span>
                  <?php }?>
                </div>
            </div>
            
         </div>
        
         <hr/>
       
          
         <?php 
				  			endforeach;
           
							else: ?>
          <div style="margin-top:150px;" class="err" align="center">
            <p><strong> <?php echo ($param=='')?lang('Please enter keywords above to display the relevant opened jobs.'):lang('Sorry, no record found');?> </strong></p>
          </div>
         
         <div style="margin-top:20px;font-size:30px;" class="" align="center">
            <i class="fa fa-search"></i>
          </div>
          <?php endif;?>
    </div>

<?php $this->load->view('application_views/common/footer_app'); ?>