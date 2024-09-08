<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $title;?></title>
<link href="https://fonts.googleapis.com/css?family=Raleway:400,600,700" rel="stylesheet">

<link href='http://vps47517.lws-hosting.com/public/css/google-fonts.css' rel='stylesheet' type='text/css'>
<link href='http://vps47517.lws-hosting.com/public/css/flexslider.css' rel='stylesheet' type='text/css'>

<!-- Bootstrap -->
<link href="http://vps47517.lws-hosting.com/public/css/bootstrap.min.css" rel="stylesheet">
<link href="http://vps47517.lws-hosting.com/public/css/font-awesome.css" rel="stylesheet" type="text/css" />

<link href="http://vps47517.lws-hosting.com/public/css/style.css" rel="stylesheet">

<link rel="stylesheet" href="http://vps47517.lws-hosting.com/public/slider/assets/owl.carousel.min.css">
<link rel="stylesheet" href="http://vps47517.lws-hosting.com/public/slider/assets/owl.theme.default.min.css">

<link href="http://vps47517.lws-hosting.com/public/css/style.css" rel="stylesheet">
</head>
<body>
<div class="siteWraper">
<!--/Search Block--> 
<!--Latest Jobs Block-->
<div class="innerpageWrap">
<div class="container">
  <div class="row"> 
    
    <div class="searchjoblist col-md-12"> 
      
      <!--Jobs List-->
      
      <div class="searchpage">
        <div class="toptitlebar">
          <div class="row">
            <div class="col-md-6"><b><?=lang('Jobs List')?></b></div>
            <div class="col-md-6 text-right"><strong><?=lang('Jobs')?> <?php echo '1 - '.count($jobs);?> <?=lang('of')?> <?php echo count($jobs);?></strong> </div>
          </div>
        </div>
        
        
        <ul class="boxwraper" style="list-style: none;padding: 20px;">
        <!--Job Row-->
          
          <?php
				  			foreach($jobs as $row):
								$company_logo = ($row->company_logo)?$row->company_logo:'no_pic.jpg';
								if (!file_exists(realpath(APPPATH . '../public/uploads/employer/thumb/'.$company_logo))){
									$company_logo='no_pic.jpg';
								}
				  ?>
          <li>
            <div class="row">
              <div class="col-md-4">
                <a style="text-decoration:none;" href="<?php echo ('http://vps47517.lws-hosting.com/jobs/'.$row->job_slug);?>">
                  <div class="companyinfoWrp">
                  <h1 class="jobname"><?php echo humanize($row->job_title);?></h1>
                  <div class="jobthumb"><img src="<?php echo ('http://vps47517.lws-hosting.com/public/uploads/employer/'.$row->company_logo);?>" alt="<?php echo ('http://vps47517.lws-hosting.com/company/'.$row->company_slug);?>" /></div>
                  <div class="jobloc"> <a href="<?php echo ('http://vps47517.lws-hosting.com/company/'.$row->company_slug);?>" class="companyname" title="<?php echo $row->company_name;?>"><?php echo $row->company_name;?></a>
                    <div class="location"><?php echo $row->emp_city;?> &nbsp;-&nbsp; <?php echo $row->emp_country;?></div> </div>
                </div>
              </a>
              </div>

              <div class="col-md-6">
                <ul class="reqlist">
                  <li>
                    <div class="col-sm-6"><?=lang('Ref.')?> :</div>
                    <div class="col-sm-6"><a href="<?php echo ('http://vps47517.lws-hosting.com/jobs/'.$row->job_slug);?>" >#JB<?=str_repeat("0",5-strlen($row->JID)).$row->JID?></a></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="col-sm-6"><?=lang('Diarienummer')?> :</div>
                    <div class="col-sm-6"><?php echo $row->diarie;?></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="col-sm-6"><?=lang('Industry')?>:</div>
                    <div class="col-sm-6"><?php echo $row->industry_name;?></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="col-sm-6"><?=lang('Total Positions')?>:</div>
                    <div class="col-sm-6"><?php echo $row->vacancies;?></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="col-sm-6"><?=lang('Job Type')?>:</div>
                    <div class="col-sm-6"><?php echo $row->job_mode;?></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="col-sm-6"><?=lang('Salary')?>:</div>
                    <div class="col-sm-6"><?php echo $row->pay;?> </div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="col-sm-6"><?=lang('Job Location')?>:</div>
                    <div class="col-sm-6"><?php echo $row->city.', '.$row->country;?></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="col-sm-6"><?=lang('Minimum Education')?>:</div>
                    <div class="col-sm-6"><?php echo $row->qualification;?></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="col-sm-6"><?=lang('Minimum Experience')?>:</div>
                    <div class="col-sm-6"><?php echo $row->experience;?> <?php echo ($row->experience<2)?'Year':'Years';?></div>
                    <div class="clear"></div>
                  </li>
                  <?php if($row->age_required):?>
                  <li>
                    <div class="col-sm-6"><?=lang('Age Required')?>:</div>
                    <div class="col-sm-6"><?php echo $row->age_required;?> Years</div>
                    <div class="clear"></div>
                  </li>
                  <?php endif;?>
                  <li>
                    <div class="col-sm-6"><?=lang('Apply By')?>:</div>
                    <div class="col-sm-6"><?php echo date_formats($row->last_date, 'M d, Y');?></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="col-sm-6"><?=lang('Job Posting Date')?>:</div>
                    <div class="col-sm-6"><?php echo date_formats($row->dated, 'M d, Y');?></div>
                    <div class="clear"></div>
                  </li>
                </ul><hr/>
                <div class="jobdescription">
              <div class="col-md-12">
                  <div class="subtitlebar"><?=lang('Job Description')?></div>
                  <p>
                  <h2 class="normal-details">
                    <?php echo "<html><body>".$row->job_description."</body></html>";?>
                  </h2>
                  </p>
                </div><br/>
                      <div class="col-md-12">
                        <div class="subtitlebar"><?=lang('Attachment Files')?></div>
              <!--Job Description-->
                <div class="row">
                  <div class="col-md-12">
                    <ul class="myjobList">
                  <?php
                  $result_files=$this->db->query("SELECT * FROM tbl_employer_files WHERE private='no' AND job_ID='".$row->JID."' AND deleted='0'")->result();
                   if($result_files): 
                    $i=0;
                  foreach($result_files as $row_file):
                $file_name = $row_file->file_name;
                $file_array = explode('.',$file_name);
                $file_array = array_reverse($file_array);
                $icon_name = get_extension_name($file_array[0]);$i++
            ?>
                  <li class="row" id="file_<?php echo $row_file->ID;?>">
                    <div class="col-md-8">
                    <i class="fa fa-file-<?php echo $icon_name;?>-o">&nbsp;</i>
                      <a target="_blank" href="<?php echo ('http://vps47517.lws-hosting.com/file/show/'.$row_file->file_name);?>">File N:<?=$i?><br/>
                        <small style="font-size: 12px;"><?=$row_file->file_name?></small></a>
                    </div>
                    <div class="col-md-4"><?php echo date_formats($row_file->created_at, "d M, Y");?></div>
                  </li>
                  <?php   endforeach; 
                else:?>
                  <?=lang('No file uploaded yet')?>!
                  <?php endif;?>
                </ul>
                  </div>
              </div>
              </div>
            </div>
              </div>

            </div>
             
          </li>
          <div id="line" style="margin-top: 20px;margin-bottom: 40px;float: left; width: 100%; height: 10px;"><hr style="border-top: 1px solid #cecece!important;width: 100%; color: #cccaca; height: 1px;" /></div>
          <?php 
				  			endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</div>
</div>
</body>

</html>