<!DOCTYPE html>
<?php if($vide==1) goto loppa_h;?>
<html lang="en">
<head>
<?php $this->load->view('common/meta_tags'); ?>
<?php $this->load->view('common/before_head_close'); ?>
</head>
<body>
<?php loppa_h: if($vide==1) goto loppa;?>
<?php $this->load->view('common/after_body_open'); ?>
<div class="siteWraper">
<!--Header-->
<?php $this->load->view('common/header'); ?>
<!--/Header--> 
<!--Detail Info-->
<div class="container detailinfo">
  <div class="row">
    <div class="col-md-12"><!--Job Detail-->
      <div class="boxwraper"><div class="formwraper">
        <div class="titlehead">
          <div class="row">
            <div class="col-md-12"><h1 class="subheading"><?php echo $row->pageTitle;?></h1></div>
          </div>
        </div></div>
        
        <!--Job Description-->
        <div class="companydescription">
          <div class="row">
            <div class="col-md-12">
              <p><?php loppa: ?><?php echo $row->pageContent;?><?php if($vide==1) goto endoppa; ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/Job Detail--> 
    <?php $this->load->view('common/right_ads');?>
  </div>
</div>
<?php $this->load->view('common/bottom_ads');?>
<!--Footer-->
<?php $this->load->view('common/footer'); ?>
<?php $this->load->view('common/before_body_close'); ?>
<?php endoppa: ?>
</body>
</html>