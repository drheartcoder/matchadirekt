<div class="col-md-3"> 
<div class="">
    <!--Widget-->
    <div class="widget secondary">
      <h3 class="widget-title"><?=lang('Job Title')?></h3><hr/>
      <ul class="nav nav-pills nav-stacked">
        <?php
		
		foreach($left_side_title as $row_titles):?>
        <li> <a href="<?php echo base_url('search-jobs/'.make_friendly_url($row_titles->job_title));?>"><span class="badge pull-right"><?php echo $row_titles->score;?></span><?php echo character_limiter($row_titles->job_title, 10);?></a> </li>
        <?php endforeach;?>
      </ul>
    </div>
    <br/>
    <!--Widget-->
    <div class="widget secondary">
      <h3 class="widget-title"> <?=lang('City')?> </h3><hr/>
      <ul class="nav nav-pills nav-stacked">
      <?php foreach($left_side_city as $row_city):?>
        <li> <a href="<?php echo base_url('search-jobs/'.str_replace(' ','-',trim($param)).'/'.make_friendly_url($row_city->city));?>"><span class="badge pull-right"><?php echo $row_city->score;?></span><?php echo character_limiter($row_city->city, 14);?></a> </li>
      <?php endforeach;?>
      </ul>
    </div>
    <br/>
    <!--Widget-->
    <div class="widget secondary">
      <h3 class="widget-title"><?=lang('Top Companies')?></h3><hr/>
      <ul class="nav nav-pills nav-stacked">
      <?php foreach($left_side_company as $row_company):?>
        <li> <a href="<?php echo base_url('company/'.$row_company->company_slug);?>"><span class="badge pull-right"><?php echo $row_company->score;?></span><?php echo character_limiter($row_company->company_name, 14);?></a> </li>
      <?php endforeach;?>
      </ul>
    </div>
    <br/>
    <!--Widget-->
    <div class="widget secondary">
      <h3 class="widget-title"> <?=lang('Salary Range')?> </h3><hr/>
      <ul class="nav nav-pills nav-stacked">     
        <?php foreach($left_side_salary_range as $row_range): ?>
        <li> <a href="<?php echo base_url('search-jobs/'.$row_range->pay);?>"><span class="badge pull-right"><?php echo $row_range->score;?></span><?php echo character_limiter($row_range->pay, 14);?></a> </li>
      <?php endforeach;?>      
      </ul>
    </div>
    
</div>
</div>