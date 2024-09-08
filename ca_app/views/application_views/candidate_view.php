

<?php $this->load->view('application_views/common/header_emp'); ?>

<!--/Header-->
<div class="div_signup"></div>
    <div id="msg"></div>
     
        <!--Company Info-->
            <div class="uploadPhoto">
      
              <img src="<?php echo base_url('public/uploads/candidate/'.$photo);?>"  style="width:100%;height:100%;"/>
            
            </div>
     <h3 style="width:100%;text-align:center;padding:10px;"><?php echo $row->first_name.' '.$row->last_name;?></h3>

              <?php if($this->session->userdata('is_employer')==TRUE):?>
         
              <h3 class=""><small style="font-size: 14px;"><?=lang('Ref.')?> <a href="#" onclick="window.location.reload();">#JS<?=str_repeat("0",5-strlen($row->ID)).$row->ID?></a></small></h3>
               <div class="comtxt"><?php echo $latest_job_title;?></div>
              <div class="comtxt-blue"><?php echo $latest_job_company_name;?></div> 
      
              <div class="usercel"><?php echo $row->city;?>, <?php echo $row->country;?></div>
    
              	
                
        <div class="modal fade" id="add_archive">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title"><?=lang('Choose Label')?></h4>
                </div>
                <form action="<?=base_url()?>employer/labels/label_details_add/<?=$row->ID?>/job_seekers" method="post">
              <div class="modal-body" style="min-height: 100px;">
                   <div class="col-md-12">
                     <div class="form-group">
                       <label><?=lang('Label')?></label> 
                       <select class="form-control" name="label" required="required">
                         <option value=""><?=lang('Choose Label')?></option>
                         <?php
                         $result_labels=$this->db->query("SELECT * FROM tbl_labels WHERE company_id='".$this->session->userdata('user_id')."' AND deleted='0'")->result();
                         foreach ($result_labels as $row2) {
                           ?><option value="<?=$row2->ID?>"><?=$row2->label?></option><?php
                         }
                         ?>
                       </select>
                     </div>
                   </div>
              </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"><?=lang('Close')?></button>
                  <button type="submit" class="btn btn-success"><?=lang('Add')?></button>
                </div>
                </form>
              </div>
            </div>
          </div>
              <?php endif;?>
       
            <div class="clear"></div>
          
        <div class="clear"></div>
     
      
      <!--My CV-->
      <?php if($result_resume):?>
    
        <div class="title_div">
            <?=lang('My Document')?>
        </div>
        
        <!--Job Description-->
        <div class="experiance">
          <ul class="myjobList">
            <?php if($result_resume): 
              $chk=1;
		  			foreach($result_resume as $row_resume):
					$file_name = ($row_resume->is_uploaded_resume)?$row_resume->file_name:'';
					$file_array = explode('.',$file_name);
					$file_array = array_reverse($file_array);
					$icon_name = get_extension_name($file_array[0]);
          if($row_resume->is_default_resume=='yes')
          {
		  ?>
            <li class="row" id="cv_<?php echo $row_resume->ID;?>">
              <div class="col-md-4">
              <i class="fa fa-file-<?php echo $icon_name;?>-o">&nbsp;</i>
              <?php if($row_resume->is_uploaded_resume): ?>
              	<a href="<?php echo base_url('resume/download/'.$row_resume->file_name);?>"><?=lang('My Document')?> <small>(<?=lang('Download to your computer')?>)</small></a>
              <?php else: ?>
			         	<a href="#"><?=lang('My Document')?></a>
			         <?php endif;?>
              </div>
              <div class="col-md-8"><?php echo date_formats($row_resume->dated, "d M, Y");?></div>
            </li>
            <?php
             $chk=0;
             //break;
           }
            ?>
            <?php 	endforeach; 
		  		else:?>
            <?=lang('No resume uploaded yet')?>!
            <?php endif;
            if($chk==1)
              echo lang('No resume uploaded yet').' !';
            ?>

          </ul>
        </div>
    
      <?php endif;?>
      
      <!--Job Detail-->
      <?php if($row_additional->summary):?>
      
        <div class="title_div">
          <?=lang('Professional Summary')?>
        </div>
        
        <!--Job Description-->
        <div class="companydescription">
          <div class="row">
            <div class="col-md-12">
              <p><?php echo ($row_additional->summary)?character_limiter($row_additional->summary,500):'';?></p>
            </div>
          </div>
        </div>
     
      <?php endif;?>
      <!--References-->
      <?php if($result_reference):?>
    
        <div class="title_div">
          <?=lang('References')?>
        </div>
        
        <!--Job Description-->
        <div class="experiance">
          <?php 
      if($result_reference):
        foreach($result_reference as $row_reference):
    ?>
          <div class="row expbox">
            <div class="col-md-12">
              <h4><?php echo $row_reference->name;?></h4>
              <ul class="useradon">
                <li>Title: <?php echo $row_reference->title;?></li>
                <li>Phone: <?php echo $row_reference->phone;?></li>
                <li>Email: <?php echo $row_reference->email;?></li>
              </ul>
              <div class="action"> </div>
            </div>
          </div>
          <?php endforeach; endif;?>
          <div class="clear"></div>
        </div>
     
      <?php endif;?>
      <!--Experiance-->
      <?php if($result_experience):?>
     
        <div class="title_div">
         <?=lang('Experience')?>
        </div>
        
        <!--Job Description-->
        <div class="experiance">
          <?php 
			if($result_experience):
				foreach($result_experience as $row_experience):
				$date_to = ($row_experience->end_date)?date_formats($row_experience->end_date, 'M Y'):'Present';
		?>
          <div class="row expbox">
            <div class="col-md-12">
              <h4><?php echo $row_experience->job_title;?></h4>
              <ul class="useradon">
                <li class="company"><?php echo $row_experience->company_name;?></li>
                <?php if($row_experience->city || $row_experience->country):?>
                	<li><?php echo ($row_experience->city)?$row_experience->city.', ':'';?>, <?php echo $row_experience->country;?></li>
                <?php endif;?>
                <li><?php echo date_formats($row_experience->start_date, 'M Y');?> to <?php echo $date_to;?></li>
              </ul>
              <div class="action"> </div>
            </div>
          </div>
          <?php endforeach; endif;?>
          <div class="clear"></div>
        </div>

      <?php endif;?>
      
      <?php if($result_qualification):?>
      <!--Education-->
      
        <div class="title_div">
          <?=lang('Education')?>
        </div>
        
        <!--Job Description-->
        <div class="experiance">
          <?php 
			if($result_qualification):
				foreach($result_qualification as $row_qualification):
			?>
          <div class="row expbox">
            <div class="col-md-12">
              <h4><?php echo $row_qualification->institude;?> <?php echo ($row_qualification->city)?', '.$row_qualification->city:'';?></h4>
              <ul class="useradon">
                <li><?php echo $row_qualification->degree_title;?>, <?php echo $row_qualification->completion_year;?></li>
                <li><?php echo $row_qualification->major;?></li>
              </ul>
              <div class="action"></div>
            </div>
          </div>
          <?php endforeach; endif;?>
          <div class="clear"></div>
        </div>
    
       <?php endif;?>    
      
      

       <?php if($applications!=0) : ?>
       
        <div class="title_div">
          <?=lang('Applications') ?>
        </div>
        
         
      
          <table class="table_list" cellsspacing="10"> 
            <tr>
                <th><?=lang('status')?></th>
                <th><?=lang('Job title')?></th>
                <th><?=lang('Rate')?></th>
                <th><?=lang('Date')?></th>
            </tr>     

            <?php foreach($applications as $app): ?>
              <tr>
                  <td><a><?php  if($app->flag=="") echo lang("Primary"); else echo lang($app->flag) ;?></a></td>
                  
                  <td><a><?php echo $app->job_title;?></a></td>
                  
                  <td><?php echo $app->rate;?></td>
                  
                   <td><?php echo date_formats($app->dated, 'M d, Y');?></td>
              </tr>

            <?php endforeach ?>  
          </table>
       
    
    <?php endif ?>



    
<div class="modal fade" id="send_msg">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?=lang('Send a Message to')?> <?php echo $row->first_name;?></h4>
      </div>
      <form action="<?=base_url().'candidate/send_message/'.$IDCD?>" method="post">
        <div class="modal-body">
          <div id="emsg"></div>
          <div class="box-body">
            <div class="form-group">
              <label><?=lang('Message')?></label>
              <textarea required="required" id="message" name="message" required="required"  class="form-control" rows="12" placeholder=""><?php echo set_value('message');?></textarea>
              <?php echo form_error('message'); ?> </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="jsid" name="jsid" value="<?php echo $this->uri->segment(2);?>"/>
          <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('Close')?></button>
          <button type="button" name="msg_submit" id="msg_submit" class="btn btn-warning"><i class="fa fa-envelope"></i>&nbsp; <?=lang('Send Email')?></button>
          <?php
          if($chat_url!=""):
            ?>
          <button type="button" onclick="location.href='<?=$chat_url?>'" class="btn btn-primary"><?=lang('Open Chat')?></button><?php
          endif;
          ?>
          <button type="submit" id="sub_send" class="btn btn-success"><i class="fa fa-send"></i>&nbsp; <?=lang('Send')?></button>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
function invite_job()
{
  $('#job').val();
  var msg="Hi , please take a look at this Job<br/><a target=\"_blank\" href=\"<?=base_url()?>jobs/"+$('#job').val()+"\"><i class=\"fa fa-link\"></i> "+$( "#job option:selected" ).text()+"</a>";

  $('#message').val(msg);
   $('#sub_send').click();
}
$("#sendcandidatemsg").click(function(){
		$('#send_msg').modal('show');
	});	
</script>
<?php $this->load->view('application_views/common/footer_app'); ?>