<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $title;?></title>
<!-- Include external CSS. -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
<!-- Include Editor style. -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.1/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.1/css/froala_style.min.css" rel="stylesheet" type="text/css" />
<?php $this->load->view('admin/common/meta_tags'); ?>
<?php $this->load->view('admin/common/before_head_close'); ?>
<?php $this->load->view('admin/common/datepicker'); ?>
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
    <h1> Tutorial Management
      <!--<small>advanced tables</small>--> 
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin/dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <!--<li><a href="#">Examples</a></li>-->
      <li class="active"> Tutorials </li>
    </ol>
  </section>
  
  <!-- Main content -->
  <section class="content">
          <div class="">
            <div class="col-xs-12">
                <div class="box">
                    <?php if(isset($tutorialData) && $tutorialData!=''){?>
        <div class="row align-items-center box-body">
            <div class="col-12">
                <div class="card py-3 border-0">
                    <h5 class="card-title mb-1">Tutorial Name: <small><?php echo $tutorialData->tutName;?></small></h5>
                    <div class="about-summary">
                        <h5 class="mb-2"><?=lang('About Summary')?>:</h5>
                        <p><?php echo $tutorialData->tutDescrip;?></p>
                    </div>
                </div>
            </div>
            <!-- col -->
        </div>
    <?php } ?>

               <div class="col-12 mb-3 text-center px-0">
                <a href="<?php echo base_url('admin/tutorials');?>" class="btn btn-comm btn-blue bg-blue"><?=lang('Back')?></a>
            </div>
                </div>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
  </section>
  <!-- /.content --> 
</aside>
<?php $this->load->view('admin/common/footer'); ?>

