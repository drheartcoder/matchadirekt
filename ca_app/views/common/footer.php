<div class="footerWrap div_hide_me">
  <div class="container">
    <div class="col-md-3">
      <img src="<?php echo base_url('public/images/logo-white.png');?>" alt="Job Portal" />
      <br><br>
      <p><?=lang('BiXma is the best job search engine')?></p>
      
      <!--Social-->
        
        <div class="social">
        <a href="http://www.twitter.com" target="_blank"><i class="fa fa-twitter-square" aria-hidden="true"></i></a>
        <a href="http://www.plus.google.com" target="_blank"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a>
        <a href="http://www.facebook.com" target="_blank"> <i class="fa fa-facebook-square" aria-hidden="true"></i></a>
        <a href="https://www.pinterest.com" target="_blank"><i class="fa fa-pinterest-square" aria-hidden="true"></i></a>
        <a href="https://www.youtube.com" target="_blank"><i class="fa fa-youtube-square" aria-hidden="true"></i></a>
        <a href="https://www.linkedin.com" target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
        </div>
        
      
    </div>
    <div class="col-md-2">
      <h5><?=lang('Quick Links')?></h5>
      <ul class="quicklinks">
        <li><a href="<?php echo base_url('about-us.html');?>" title="<?=lang('About Us')?>"><?=lang('About Us')?></a></li>
        <li><a href="<?php echo base_url('how-to-get-job.html');?>" title="<?=lang('How to get Job')?>"><?=lang('How to get Job')?></a></li>
        <li><a href="<?php echo base_url('search-jobs');?>" title="<?=lang('New Job Openings')?>"><?=lang('New Job Openings')?></a></li>
        <li><a href="<?php echo base_url('search-resume');?>" title="<?=lang('Resume Search')?>"><?=lang('Resume Search')?></a></li>
        <li><a href="<?php echo base_url('contact-us');?>" title="<?=lang('Contact Us')?>"><?=lang('Contact Us')?></a></li>
      </ul>
    </div>
    
    <div class="col-md-3">
      <h5><?=lang('Popular Industries')?></h5>
      <ul class="quicklinks">
        <?php
			$res_inds = $this->industries_model->get_top_industries();
			if($res_inds):
				foreach($res_inds as $row_inds):
		?>
        <li><a href="<?php echo base_url('industry/'.$row_inds->slug);?>" title="<?php echo $row_inds->industry_name;?> Jobs"><?php echo $row_inds->industry_name;?> <?=lang('Jobs')?></a></li>
        <?php 

		  		endforeach;

		  	endif;

		  ?>
      </ul>
    </div>
    <div class="col-md-4">
      <h5><?=lang('Popular Cities')?></h5>
      <ul class="citiesList">
      <?php
      	$res_p_cities=$this->cities_model->get_all_popular_cities();
		if($res_p_cities):
				foreach($res_p_cities as $row_p_cities):
					$ct_url=base_url('search/'.url_title($row_p_cities->city_name,'-',true));
	  ?>
        <li><a href="<?php echo $ct_url;?>" title="<?=lang('Jobs in')?> <?php echo $row_p_cities->city_name;?>"><?php echo $row_p_cities->city_name;?></a></li>
       <?php 
		  		endforeach;
		  	endif;

		  ?>  
      </ul>
      <div class="clear"></div>
    </div>
    
    <div class="clear"></div>
    <div class="copyright">
    <a href="<?php echo base_url('interview.html');?>" title="<?=lang('Preparing for Interview')?>"><?=lang('Preparing for Interview')?></a> | 
    <a href="<?php echo base_url('cv-writing.html');?>" title="<?=lang('CV Writing')?>"><?=lang('CV Writing')?></a> | 
    <a href="<?php echo base_url('how-to-get-job.html');?>" title="<?=lang('How to get Job')?>"><?=lang('How to get Job')?></a> |
    <a href="<?php echo base_url('privacy-policy.html');?>" title="<?=lang('Policy')?>"><?=lang('Policy')?></a>
    </div>
  </div>
</div>
</div>
<?php echo $ads_row->google_analytics;?> 