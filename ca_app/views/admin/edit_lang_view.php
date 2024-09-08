<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $title;?></title>
<?php $this->load->view('admin/common/meta_tags'); ?>
<?php $this->load->view('admin/common/before_head_close'); ?>
</head>
<body class="skin-blue">
<?php $this->load->view('admin/common/after_body_open'); ?>
<?php $this->load->view('admin/common/header'); ?>
<div class="wrapper row-offcanvas row-offcanvas-left">
<?php $this->load->view('admin/common/left_side'); ?>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Manage Languages
      <!--<small>advanced tables</small>--> 
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <!--<li><a href="#">Examples</a></li>-->
      <li class="active">Languages Management</li>
    </ol>
  </section>
  
  <!-- Main content -->
  <section class="content">
  <?php if($this->session->flashdata('added_action')==true): ?>
      <div class="message-container">
      	<div class="callout callout-success">
        <h4>New Language has been added successfully.</h4>
      </div>
      </div>
      <?php endif;?>
      
      <?php if($this->session->flashdata('update_action')==true): ?>
      <div class="message-container">
      	<div class="callout callout-success">
        <h4>Record has been updated successfully.</h4>
      </div>
      </div>
      <?php endif;?>
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Edit Language</h3>
            <!--Pagination-->
            
          </div>
        

            <div class="box-body">

            <form method="POST" action="<?php echo base_url('admin/languages/update/'.$row->ID) ; ?>">




              <div class="text-right" style="padding-bottom:2px;">
                <button type="submit" name="submitter" class="btn btn-primary">Update</button>
              </div>

                <div class="form-group">
                  <input type="text" class="form-control"  id="edit_name" name="edit_name" value="<?=$row->Name;?>" placeholder="Name">
                  <?php echo form_error('edit_name'); ?> 
                </div>
                <div class="form-group">
                  <input type="text" class="form-control"  id="edit_abbreviation" name="edit_abbreviation" value="<?=$row->Abbreviation ;?>" placeholder="Abbreviation">
                  <?php echo form_error('edit_abbreviation'); ?> 
                </div>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" name="rtl" <?php if($row->rtl=='rtl') echo "checked"; ?> />
                  <label class="form-check-label">RTL</label>
                </div>

                <div class="form-group">
                  <table class="table table-bordered" style="overflow-y:scroll">
                      <th>Key</th>
                      <th>Value</th>

                      <?php 

                    foreach ($trans as $key => $value) {
                       ?>
                        <tr>
                          <td width="50%" >
                            <input type="text" class="form-control" readonly   name="key[]" value="<?=$key ?>" >
                          </td>
                          <td width="50%">
                            <input type="text" class="form-control"   name="value[]" value="<?=$value;?>" >
                          </td>

                        </tr> 

                       <?php 
                    }

                  ?>

                  </table>
                  

                </div>
                
              <input type="hidden" name="key_id" id="key_id" />

              </form>

          </div>

          
          <!-- /.box-body --> 
        </div>
        <!-- /.box --> 
        
        <!-- /.box --> 
      </div>
    </div>
  </section>
  <!-- /.content --> 
</aside>
</div>
 
<!-- /.right-side -->
<?php $this->load->view('admin/common/footer'); ?>
<script src="<?php echo base_url('public/js/admin/plugins/ckeditor/ckeditor.js'); ?>" type="text/javascript"></script> 
<?php if(validation_errors() != false){?>
<script type="text/javascript"> 
	$('#add_language_form').modal('show');
</script>
<?php } ?>
