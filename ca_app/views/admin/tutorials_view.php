<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $title;?></title>
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
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Tutorials</h3>
            <!--Pagination-->
            <div class="paginationWrap"> <?php //echo ($result)?$links:'';?> </div>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body table-responsive">
            <!-- <form name="search_form" id="search_form" method="post" action="<?php echo base_url('admin/tutorials/search');?>">
              <div class="row" style="background-color:#3C8DBC; padding:10px; margin:0;">
                <div class="col-md-2 margin-bottom-special">
                  <input class="form-control" name="search_title" id="search_title" type="text" placeholder="Search By Job Title" value="<?php echo (isset($search_data["job_title"]))?$search_data["job_title"]:'';?>">
                </div>
                <div class="col-md-2 margin-bottom-special">
                  <input class="form-control" name="search_company" id="search_company" type="text" placeholder="Search By Company Name" value="<?php echo (isset($search_data["company_name"]))?$search_data["company_name"]:'';?>">
                </div>
                <div class="col-md-2 margin-bottom-special">
                  <input class="form-control" name="search_city" id="search_city" type="text" placeholder="Search By City" value="<?php echo (isset($search_data["city"]))?$search_data["city"]:'';?>">
                </div>
                <div class="col-md-2 margin-bottom-special">
                  <select class="form-control" name="search_featured" id="search_featured">
                    <option value="" selected>- Featured -</option>
                    <option value="yes">Featured</option>
                    <option value="no">Non-Featured</option>
                  </select>
                </div>
                <div class="col-md-2 margin-bottom-special">
                  <select class="form-control" name="search_sts" id="search_sts">
                    <option value="" selected>- Status -</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
                    <option value="deactive">Deactive</option>
                    <option value="blocked">Blocked</option>
                  </select>
                </div>
                <div class="col-md-2 margin-bottom-special" style="padding:0;">
                  <input class="btn" name="submit" value="Search" type="submit">
                  &nbsp;&nbsp;
                  <input class="btn" name="button" value="View All" type="button" onClick="document.location='<?php echo base_url('admin/tutorials');?>';">
                </div>
              </div>
            </form> -->
            <div class="clearfix">&nbsp;</div>
            <div class="text-right" style="padding-bottom:2px;">
              <a class="btn btn-primary btn-sm" href="<?php echo base_url('admin/tutorials/add-tutorial');?>" role="button">Add New Tutorial</a>
              <!-- <input type="button" class="btn btn-primary btn-sm" value="Add New Country" onClick="load_countries_add_form();" /> -->
            </div>
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Tutorial Name</th>
                <!--   <th>Tutorial Description</th> -->
                  <th>Created On</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
        if(isset($tutorialData) && $tutorialData != ''):
         $i=1;
          foreach($tutorialData as $row):
            
            ?>
                <tr id="row_<?php echo $row->tutId;?>">
                  <td><?php echo $i; ?></td>
                  <td><a href="<?php echo base_url('admin/tutorials/tutorial_details/'.$row->tutId);?>"><?php echo $row->tutName; ?></a></td>
                  <!-- <td><?php //echo $row->tutDescrip; ?></td> -->
                  <td><?php echo date_formats($row->createdOn, 'd/m/Y');?></td>
                  <!-- <td><a href="<?php //echo base_url('admin/tutorials/details/'.$row->tutId);?>"> <?php //echo ellipsize($row->tutName,36,.8);?></td>   -->
                  <td><?php
              if($row->status==1){
              $class_label = 'success';
              $statusName='active';}
            else{
              $class_label = 'danger';
              $statusName= 'Inactive';
            }
          ?>
                    <a onClick="update_tutorial_status(<?php echo $row->tutId;?>);" href="javascript:;" id="sts_<?php echo $row->tutId;?>" style="color: #000;"> <span class="label label-<?php echo $class_label;?>"><?php echo camelize($statusName);?></span> </a></td>
                  <td><a href="<?php echo base_url('admin/tutorials/edit_tutorial/'.$row->tutId);?>" class="btn btn-primary btn-xs">Edit</a> <a href="<?php echo base_url('admin/tutorials/remove_tutorial/'.$row->tutId);?>" class="btn btn-danger btn-xs">Delete</a></td>
                </tr><?php $i++; ?>
                <?php   endforeach; else:?>
                <tr>    
                  <td colspan="10" align="center" class="text-red">No Record found!</td>
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
          <div class="paginationWrap"> <?php //echo ($result)?$links:'';?> </div>
          
          <!-- /.box-body --> 
        </div>
        <!-- /.box --> 
        
        <!-- /.box --> 
      </div>
    </div>
  </section>
  <!-- /.content --> 
</aside>
<?php $this->load->view('admin/common/footer'); ?>
