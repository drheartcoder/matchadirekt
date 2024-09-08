<?php $this->load->view('newweb/inc/header'); ?>
 <div> 
      <?php 
         echo $this->session->flashdata('email_sent'); 
         echo form_open('/newweb/Emailtest/send_mail'); 
      ?> 
		
      <input type = "email" name = "email" required /> 
      <input type = "submit" value = "SEND MAIL"> 
		
      <?php 
         echo form_close(); 
      ?> 
   </div>

<?php $this->load->view('newweb/inc/footer'); ?>