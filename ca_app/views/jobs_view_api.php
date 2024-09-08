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
      
      <div>
          

      <form class="form-inline"> 
        <label for="sel1">Select :</label>
        <select class="form-control" name="lan">
          <?php foreach ($cities as $city) {
            echo '<option value="'.$city->id.'">'.$city->namn.'</option>';
          } ?>
        </select>

        <input type="submit" value="<?php echo lang('Find') ?>" class="btn">
      </form>
            
      </div>


      <!--Jobs List-->

      <br>

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
							 
				  ?>
          <li>
            <div class="row">
              <div class="col-md-4">
                <a style="text-decoration:none;" target="_blank" href="<?php echo  $row->annons->platsannonsUrl ;?>">
                  <div class="companyinfoWrp">
                  <h1 class="jobname"><?php echo humanize($row->annons->annonsrubrik);?></h1>
                  <div class="jobthumb"><img src="<?php echo ($row->arbetsplats->logotypurl);?>"/></div>
                  <div class="jobloc"> <a class="companyname" title="<?php echo $row->arbetsplats->arbetsplatsnamn;?>"><?php echo $row->arbetsplats->arbetsplatsnamn;?></a>
                    <div class="location"><?php echo 'Land' . $row->arbetsplats->land;?></div>
                    
                  </div>
                </div>
              </a>
              </div>

              <div class="col-md-6">
                <ul class="reqlist">
                  <li>
                    <div class="col-sm-6"><?=lang('Ref.')?> :</div>
                    <div class="col-sm-6"><a target="_blank" href="<?php echo $row->annons->platsannonsUrl;?>" ><?= $row->annons->annonsid ?></a></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="col-sm-6"><?=lang('Duration')?> :</div>
                    <div class="col-sm-6"><?php echo $row->villkor->varaktighet;?></div>
                    <div class="clear"></div>
                  </li>
                  
                  <li>
                    <div class="col-sm-6"><?=lang('Total Positions')?>:</div>
                    <div class="col-sm-6"><?php echo $row->antal_platser;?></div>
                    <div class="clear"></div>
                  </li>
                  <li>
                    <div class="col-sm-6"><?=lang('Job Type')?>:</div>
                    <div class="col-sm-6"><?php echo $row->annons->anstallningstyp;?></div>
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
                    <div class="col-sm-6"><?=lang('Job Posting Date')?>:</div>
                    <div class="col-sm-6"><?php echo $row->annons->publiceraddatum;?></div>
                    <div class="clear"></div>
                  </li>
                </ul><hr/>
                <div class="jobdescription">
              <div class="col-md-12">
                  <div class="subtitlebar"><?=lang('Job Description')?></div>
                  <p>
                  <h2 class="normal-details">
                    <?php echo "<html><body>".$row->annons->annonstext."</body></html>";?>
                  </h2>
                  </p>
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