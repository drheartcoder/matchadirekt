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
            <h3 class="box-title">All Languages</h3>
            <!--Pagination-->
            <div class="paginationWrap"> <?php echo ($result)?$links:'';?> </div>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body table-responsive">
            <div class="text-right" style="padding-bottom:2px;">
              <input type="button" class="btn btn-primary btn-sm" value="Add New Language" onClick="load_language_add_form();" />
            </div>
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Abbreviation</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
				if($result):
					foreach($result as $row):?>
                <tr id="row_<?php echo $row->ID;?>">
                  <td><?php echo $row->Name;?></td>
                  <td><?php echo $row->Abbreviation;?></td>
                  <!-- https://matchadirekt.com/admin/languages/edit_lang/9 -->
                  <td><a href="<?php echo base_url().'/admin/languages/edit_lang/'.$row->ID;?>" class="btn btn-success btn-xs">Edit</a> <a href="javascript:delete_language(<?php echo $row->ID;?>);" class="btn btn-danger btn-xs">Delete</a></td>
                </tr>
                <?php endforeach; else:?>
                <tr>
                  <td colspan="3" align="center" class="text-red">No Record found!</td>
                </tr>
                <?php
					endif;
				?>
              </tbody>
              <tfoot>
              </tfoot>
            </table>
          </div>
          
          <!--Pagination-->
          <div class="paginationWrap"> <?php echo ($result)?$links:'';?> </div>
          
          <!-- /.box-body --> 
        </div>
        <!-- /.box --> 
        
        <!-- /.box --> 
      </div>
    </div>
  </section>
  <!-- /.content --> 
</aside>
<div class="modal fade" id="add_language_form">
  <div class="modal-dialog">
    <form name="frm_Language" id="frm_Language" role="form" method="post" action="<?php echo base_url('admin/languages/add');?>">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Add Language</h4>
        </div>
        <div class="modal-body"> 
          <!-- /.box-header --> 
          <!-- form start -->
          
          <div class="box-body">
            <div class="form-group">
              <input type="text" class="form-control"  id="name" name="name" value="<?php echo set_value('name');?>" placeholder="Name">
              <?php echo form_error('name'); ?> 
            </div>
            <div class="form-group">
              <input type="text" class="form-control"  id="abbreviation" name="abbreviation" value="<?php echo set_value('abbreviation');?>" placeholder="Abbreviation">
              <?php echo form_error('abbreviation'); ?> 
            </div>

            <div class="form-check">
            <input type="checkbox" class="form-check-input" name="rtl">
            <label class="form-check-label" for="exampleCheck1">RTL</label>
          </div>

          </div>
          <!-- /.box-body --> 
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" name="submitter" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </form>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
<!-- Edit Model-->
<div class="modal fade" id="edit_language_form">
  <div class="modal-dialog">
    <form name="frm_cms" id="frm_cms" role="form" method="post" action="<?php echo base_url('admin/languages/update');?>" onSubmit="return validate_edit_language_form(this)">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Edit Language</h4>
        </div>
        <div class="modal-body"> 
          <!-- /.box-header --> 
          <!-- form start -->
          
          <div class="box-body">

                <div class="form-group">
                  <input type="text" class="form-control"  id="edit_name" name="edit_name" value="<?php echo set_value('edit_name');?>" placeholder="Name">
                  <?php echo form_error('edit_name'); ?> 
                </div>
                <div class="form-group">
                  <input type="text" class="form-control"  id="edit_abbreviation" name="edit_abbreviation" value="<?php echo set_value('edit_abbreviation');?>" placeholder="Abbreviation">
                  <?php echo form_error('edit_abbreviation'); ?> 
                </div>
                <div class="form-group">
                  <textarea class="form-control" rows="20" placeholder="translations" id="edit_content" name="edit_content"><?php echo set_value('edit_content');?></textarea>
                </div>

              <input type="hidden" name="key_id" id="key_id" />
          </div>
          <!-- /.box-body --> 
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" name="submitter" class="btn btn-primary">Update</button>
        </div>
      </div>
    </form>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
<!-- /.modal --> 
<!-- /.right-side -->
<?php $this->load->view('admin/common/footer'); ?>
<script src="<?php echo base_url('public/js/admin/plugins/ckeditor/ckeditor.js'); ?>" type="text/javascript"></script> 
<?php if(validation_errors() != false){?>
<script type="text/javascript"> 
	$('#add_language_form').modal('show');
</script>
<?php } ?>
