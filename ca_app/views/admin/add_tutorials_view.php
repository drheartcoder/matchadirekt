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
                    <form class="mt-4 box-body" action="#" method="post">
                      <!--   <div class="form-group col-12 mb-3">
                                  <select class="form-control" name="selCompIndustry" id="selCompIndustry" required>
                                    <option value="" selected><?=lang('Select Industry')?></option>
                                      <?php foreach($result_industries as $row_industry):
                                                    $selected = (set_value('selCompIndustry')==$row_industry->ID)?'selected="selected"':'';
                                          ?>
                                      <option value="<?php echo $row_industry->ID;?>" <?php echo $selected;?>><?php echo $row_industry->industry_name;?></option>
                                      <?php endforeach;?>
                                  </select>
                                <span></span>
                        </div> -->
                        <div class="form-group col-12 mb-3">
                            <input type="text" name="txtTutorialName" id="txtTutorialName" class="form-control" value="" placeholder="<?=lang('Tutorial Name')?>" required>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                           
                            <div id='edit'></div>
                            <span></span>
                            <?php //echo form_error('hiddeninput'); ?>
                            <small id="errhiddeninput" class="form-text text-muted"><?=lang('This Field is required')?></small> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <textarea id="hiddeninput" name="hiddeninput"></textarea> 
                        </div>

                          <div class="col-xs-12 col-md-7  col-lg-7 mx-auto">
                        <div class="row">
                        <div class="form-group col-xs-6 mb-3">
                          <a href="<?php echo base_url('admin/tutorials');?>" class="btn btn-blue bg-blue" ><?=lang('Cancel')?></a>   
                        </div>
                        <div class="form-group col-xs-6  mb-3">
                         
                            <button type="submit" class="btn btn-blue" name="btnSubmitTut" id="btnSubmitTut"><?=lang('Submit')?></button>
                        </div>
                      </div>
                </div>
                    </form>
                </div>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
  </section>
  <!-- /.content --> 
</aside>
<?php $this->load->view('admin/common/footer'); ?>
<!-- Include external JS libs. -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>

  <!-- Include Editor JS files. -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.1//js/froala_editor.pkgd.min.js"></script>

 <script type="text/javascript">
    $(document).ready(function(){
    $('#hiddeninput').hide();
  });
    $(function(){
      $('#btnSubmitTut').click(function () {
        var chk = $('.fr-element').html();
        console.log(chk)
        $('#hiddeninput').val(chk);
      } );     
  });
</script>
<!-- Initialize the editor. -->
<script type="text/javascript">
    $(function() {
      $('#edit').froalaEditor({
        // Set the file upload URL.
        imageUploadURL: '<?php echo BASEURL; ?>/editorFiles/uploadimgTutorial.php',

        imageUploadParams: {
          id: 'my_editor'
        }
      })
    });
</script>
