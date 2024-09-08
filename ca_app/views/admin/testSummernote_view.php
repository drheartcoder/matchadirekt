<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $title;?></title>
<?php $this->load->view('admin/common/meta_tags'); ?>
<?php $this->load->view('admin/common/before_head_close'); ?>
<?php $this->load->view('admin/common/datepicker'); ?>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.js"></script>
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
    <h1> Summernote Management
      <!--<small>advanced tables</small>--> 
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <!--<li><a href="#">Examples</a></li>-->
      <li class="active"> Summernote </li>
    </ol>
  </section>
  
  <!-- Main content -->
  <section class="content">
    <!--  <div id="summernote"></div> -->

    <form class="span12" id="postForm" action="" method="POST" enctype="multipart/form-data">
      <fieldset>
        <legend>Make Post</legend>
        <p class="container">
          <textarea class="input-block-level" id="summernote" name="content" rows="18">
          </textarea>
        </p>
      </fieldset>
      <button type="submit" class="btn btn-primary" name="btnSubmitSumm">Save changes</button>
      <button type="button" id="cancel" class="btn">Cancel</button>
    </form>
<!-- 
       <form class="mt-4 box-body" action="#" method="post">  
                        <div class="form-group col-12 mb-3">
                           
                            <div id='edit'></div>
                            <span></span>
                            <?php //echo form_error('hiddeninput'); ?>
                            <small id="errhiddeninput" class="form-text text-muted"><?=lang('This Field is required')?></small> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <textarea id="hiddeninput" name="hiddeninput"></textarea> 
                        </div>

                          <div class="col-xs-12 col-md-6  col-lg-5 mx-auto">
                        <div class="row">
                        <div class="form-group col-xs-4 mb-3">
                          <a href="<?php echo base_url('admin/tutorials');?>" class="btn btn-blue bg-blue" ><?=lang('Cancel')?></a>   
                        </div>
                        <div class="form-group col-xs-4  mb-3">
                         
                            <button type="submit" class="btn btn-blue bg-blue" name="btnSubmitTut" id="btnSubmitTut"><?=lang('Submit')?></button>
                        </div>
                      </div>
                </div>
                    </form> -->
    
  </section>
  <!-- /.content --> 
</aside>
<?php $this->load->view('admin/common/footer'); ?>
<!--  <script>
      $('#summernote').summernote({
        placeholder: 'Hello bootstrap 4',
        tabsize: 2,
        height: 100
      });
    </script> -->

<script type="text/javascript">
$(document).ready(function() {
  $('#summernote').summernote({
    height: "500px"
  });
});
var postForm = function() {
  var content = $('textarea[name="content"]').html($('#summernote').code());
}
</script>