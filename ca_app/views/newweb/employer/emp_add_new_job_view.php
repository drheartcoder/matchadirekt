<?php $this->load->view('newweb/inc/header'); ?>
<!-- Include external CSS. -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
<!-- Include Editor style. -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.1/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.1/css/froala_style.min.css" rel="stylesheet" type="text/css" />
<?php 
    $staticUrl = STATICWEBCOMPURL; 
?>
<section class="main-container vheight-100 justify-content-between">
  <div class="container">
    <div class="row">
        <div class="col-12 col-md-11 col-lg-9 col-xl-9 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo WEBURL; ?>/employer/job" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('Post New Job')?></h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="">
                    <form class="row mt-4" action="" method="POST"  onsubmit="return frmValidation();">
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="industry_ID" id="industry_ID">
                                <option selected="" disabled=""><?=lang('Select Industry')?></option>
                                 <?php foreach($result_industries as $row_industry):
                                      $selected = (set_value('industry_id')==$row_industry->ID)?'selected="selected"':'';
                                ?>
                                    <option value="<?php echo $row_industry->ID;?>" <?php echo $selected;?>><?php echo $row_industry->industry_name;?></option>
                                    <?php endforeach;?>
                            </select>
                            <span></span>
                            <small id="errIndustry_id" class="form-text text-muted"><?=lang('This Field is required')?></small> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input name="job_title" type="text" class="form-control" id="job_title" placeholder="Job Title" value="<?php echo set_value('job_title'); ?>" maxlength="150">
                            <span></span>
                            <?php echo form_error('job_title'); ?>
                            <small id="errJob_title" class="form-text text-muted"><?=lang('This Field is required')?></small> 
                        </div>
                        <div class="form-group col-12 mb-3">
                           <input name="diarie" type="text" class="form-control" id="diarie" placeholder="<?=('Diarie Number')?>" value="<?php echo set_value('diarie'); ?>" maxlength="150">
                            <span></span>
                            <?php echo form_error('diarie'); ?> 
                             <small id="errdiarie" class="form-text text-muted"><?=lang('This Field is required')?></small> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" name="vacancies" id="vacancies" maxlength="3"  placeholder="Vacancies"/>
                            <span></span>
                            <?php echo form_error('vacancies'); ?> 
                            <small id="errvacancies" class="form-text text-muted"><?=lang('This Field is required')?></small> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control"  name="experience" id="experience" >
                               <option value="Fresh" <?php echo (set_value('experience')=='Fresh')?'selected="selected"':'';?>><?=('Fresh')?></option>
                              <option value="Less than 1" <?php echo (set_value('experience')=='Less than 1 year')?'selected="selected"':'';?>><?=('Less than 1 year')?></option>
                              <?php for($i=1;$i<=10;$i++):
                                    $selected = (set_value('experience')==$i)?'selected="selected"':'';
                                  $year = ($i<2)?'year':'years';
                                ?>
                              <option value="<?php echo $i;?>" <?php echo $selected;?>><?php echo $i?></option>
                              <?php endfor;?>
                              <option value="10+" <?php echo (set_value('experience')=='10+')?'selected="selected"':'';?>>10+</option>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="job_mode" id="job_mode">
                                 <option value="Full Time" <?php echo (set_value('job_mode')=='Full Time')?'selected="selected"':'';?>><?=('Full Time')?></option>
                                  <option value="Part Time" <?php echo (set_value('job_mode')=='Part Time')?'selected="selected"':'';?>><?=('Part Time')?></option>
                                  <option value="Home Based" <?php echo (set_value('job_mode')=='Home Based')?'selected="selected"':'';?>><?=('Home Based')?></option>
                            </select>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="pay" id="pay">
                                <option selected="" disabled=""><?=lang('Salary Offer(Pk Rs.)')?></option>
                                 <?php
                                  foreach($result_salaries as $row_salaries):
                                    $selected = (set_value('pay')==$row_salaries->val)?'selected="selected"':'';
                                    ?>
                                      <option value="<?php echo $row_salaries->val;?>" <?php echo $selected;?>><?php echo $row_salaries->text;?></option>
                                <?php endforeach;?>
                            </select>
                            <span></span>
                             <?php echo form_error('pay'); ?> 
                             <small id="errPay" class="form-text text-muted"><?=lang('This Field is required')?></small> 
                        </div>
                        <div class="form-group col-12 mb-3">
                             <input name="last_date" type="date" class="form-control" id="last_date" placeholder="<?=('Apply Before')?>" value="<?php echo (set_value('last_date'))?set_value('last_date'):$last_date_dummy; ?>" maxlength="40">
                            <span></span>
                            <?php echo form_error('last_date'); ?>
                            <small id="errlast_date" class="form-text text-muted"><?=lang('Last date is required')?></small> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select name="country" id="country" class="form-control" onchange="getRegionSeeker(this.value);">
                               <option disabled="" value=""><?=lang('Country')?></option>
                                <?php 
                              foreach($result_countries as $row_country):
                                $selected = '';
                                
                                if(set_value('country')=='' && $row->country==$row_country->country_name){
                                  $selected = 'selected="selected"';
                                }
                            ?>
                               <option value="<?php echo $row_country->country_name;?>" <?php echo $selected;?>><?php echo $row_country->country_name;?></option>
                              <?php endforeach;?>
                            </select>
                            <span></span>
                             <?php echo form_error('country'); ?>
                             <small id="errCountry" class="form-text text-muted"><?=lang('This Field is required')?></small> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <!-- <input name="city" type="text" class="form-control" id="city_text" placeholder="<?=('City')?>" value="<?php echo (set_value('city')!='')?set_value('city'):""; ?>" maxlength="50"> -->
                            <select class="form-control" name="city" id="city">
                                <option disabled="" value=""><?=lang('City')?></option>
                                <?php 
                                    $countryID = $this->My_model->getSingleRowData("tbl_countries","ID","country_name = '".set_value('country')."'");
                                    $cities = $this->My_model->selTableData("tbl_cities","","country_ID = ".$countryID->ID);
                                    if(isset($cities) && $cities != ""){
                                        foreach($cities as $city){
                                            if($city->city_name ==set_value('city')) $selected = "selected";
                                            else
                                                $selected="";
                                            ?>
                                            <option value="<?php echo $city->city_name; ?>" <?php echo $selected; ?> ><?php echo $city->city_name; ?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                            <span></span>
                            <?php echo form_error('city'); ?>
                            <small id="errCity" class="form-text text-muted"><?=lang('This Field is required')?></small> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select name="qualification" id="qualification" class="form-control">
                              <option value=""><?=('Select Qualification')?></option>
                              <?php 
                            foreach($result_qualification as $row_qualification):
                                $selected = (set_value('qualification')==$row_qualification->val)?'selected="selected"':'';
                            ?>
                              <option value="<?php echo $row_qualification->val;?>" <?php echo $selected;?>><?php echo $row_qualification->text;?></option>
                              <?php endforeach;?>
                            </select>
                            <span></span>
                            <?php echo form_error('qualification'); ?>
                            <small id="errqualification" class="form-text text-muted"><?=lang('This Field is required')?></small> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <div id='edit' name="txtEdit"></div>
                            <span></span>
                            <?php echo form_error('hiddeninput'); ?>
                            <small id="errhiddeninput" class="form-text text-muted"><?=lang('This Field is required')?></small> 

                        </div>
                        
                        <!-- <div class="form-group col-12 mb-3">
                            <input type="number" class="form-control" placeholder="Mobile Phone" name="txtMobPhone" id="txtMobPhone">
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="number" class="form-control" placeholder="Mobile Phone" name="txtMobPhone" id="txtMobPhone">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="number" class="form-control" placeholder="Home Phone" name="txtHomePhone" id="txtHomePhone">
                            <span></span>
                        </div> -->
                        <div class="form-group col-12 mb-3">
                            <input type="url" class="form-control" placeholder="Company Website" name="txtComweb" id="txtComweb">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                          <?php //myPrint($quizzes); ?>
                           <select multiple="multiple" style="width: 100%;" class="form-control" name="quizzes[]">
                                <option value=""><b><?=('No Quizzes')?></b></option>
                                <?php
                                foreach ($quizzes as $row_) {
                                  ?><option <?php echo (set_value('quizzes')==$row_->ID)? "selected='selected'" : ''; ?> value="<?=$row_->ID?>"><?=$row_->title?></option><?php
                                }
                                ?>
                              </select> 
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="job_analysis" id="job_analysis">
                               <option value=""><?=('Choose a Job Analysis')?></option>
                                  <?php
                                  foreach ($job_analysis as $row) {
                                    ?><option <?php echo (set_value('job_analysis')==$row->ID)? "selected='selected'" : ''; ?> value="<?=$row->ID?>"><?=$row->pageTitle?></option><?php
                                  }
                                  ?>
                            </select>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="employer_certificate" id="employer_certificate">
                                 <option value=""><?=('Choose a Employer Certificate')?></option>
                                  <?php
                                  foreach ($employer_certificates as $row_) {
                                    ?><option <?php echo (set_value('employer_certificate')==$row_->ID)? "selected='selected'" : ''; ?> value="<?=$row_->ID?>"><?=$row_->pageTitle?></option><?php
                                  }
                                  ?>
                            </select>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="interview" id="interview">
                                <option value=""><?=('Choose a Interview')?></option>
                                    <?php
                                    foreach ($interviews as $row_) {
                                    ?><option <?php echo (set_value('interview')==$row_->ID)? "selected='selected'" : ''; ?> value="<?=$row_->ID?>"><?=$row_->pageTitle?></option><?php
                                    }
                                    ?>
                            </select>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <select class="form-control" name="job_type" id="job_type">
                                <option <?php echo (set_value('local_mdp')=="Internal")? " selected='selected'" : ''; ?> value="Internal"><?=lang('Internal')?></option>
                                <option <?php echo (set_value('local_mdp')=="External")? " selected='selected'" : ''; ?> value="External"><?=lang('External')?></option>
                                <option <?php echo (set_value('local_mdp')=="Local")? " selected='selected'" : ''; ?> value="Local"><?=lang('Local')?></option>
                                <option <?php echo (set_value('local_mdp')=="National")? " selected='selected'" : ''; ?> value="National"><?=lang('National')?></option>
                                <option <?php echo (set_value('local_mdp')=="Social channels")? " selected='selected'" : ''; ?> value="Social channels"><?=lang('Social channels')?></option>
                                <option <?php echo (set_value('local_mdp')=="Newspapers")? " selected='selected'" : ''; ?> value="Newspapers"><?=lang('Newspapers')?></option>
                            </select>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input name="local_mdp" class="form-control" placeholder="<?=('local mdp')?>" value="<?php echo (set_value('local_mdp')); ?>"/>
                            <span></span>
                        </div>
                        <!-- <div class="form-group col-12 mb-3">
                            <input type="date" name="dated" class="form-control" value="" placeholder="Date" />
                            <span></span>
                        </div> -->
                        <div class="form-group col-12 mb-3">
                            <textarea class="form-control" placeholder="Note" rows="2" name="Note" id="Note"></textarea>
                            <span></span>
                        </div>
                       
                        <div class="form-group col-12 skill-block py-3 bg-l-grey">
                            <ul class="skill-group mb-0 " id="olTestList2">
                            </ul>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Add Skills" name="txtAddSkills" id="txtAddSkills">
                                <div class="input-group-append ml-0">
                                    <button class="btn btn-blue add-btn rounded-0" type="button" id="btnAddSkill" onclick="appendSkillData();">
                                        <img src="<?php echo  $staticUrl; ?>/images/plus-white.svg" class="w-100">
                                    </button>
                                </div>
                            </div>
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <textarea id="hiddeninput" name="hiddeninput"></textarea> 
                        </div>
                        <div class="col-12 col-lg-9 mx-auto">
                          <div class="row">
                        <div class="form-group col-12 col-sm-6 mb-3">
                            <button type="submit" class="btn btn-blue" name="btnSubmit" id="btnSubmit"><?=lang('Post Job')?></button>
                        </div>
                        <div class="form-group col-12 col-sm-6 mb-3">
                             <button type="submit" class="btn btn-blue" name="btnDraft" id="btnDraft"><?=lang('Save Draft')?></button>
                        </div>
                      </div>
                    </div>
                    </form>
                </div>
            </div>
            <!-- col -->
        </div>
      </div>
        <!-- row -->
    </div>
    </div>
    <!-- container -->
</section>
<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>
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
      $('#btnSubmit').click(function () {
        var chk = $('.fr-element').html();
        $('#hiddeninput').val(chk);
      } );     
  });
</script>
<!-- Initialize the editor. -->
<script type="text/javascript">
    $(function() {
      $('#edit').froalaEditor({
        // Set the file upload URL.
        imageUploadURL: '<?php echo BASEURL; ?>/editorFiles/uploadimgJob.php',

        imageUploadParams: {
          id: 'my_editor'
        }
      })
    });
</script>
<script type="text/javascript">
    function getRegionSeeker(val){
        $.ajax({
        type: "POST",
        url: "<?php echo WEBURL; ?>/registration/getCities",
        data:'country='+val,
            success: function(data){
                $("#city").html(data);
            }
        });
    }

</script>

<script type="text/javascript">
  
   function appendSkillData(){
        if($("#txtAddSkills").val() != ""){
            if($("#olTestList2").hasClass("hasLi")){
                var id = $( "ul li" ).last().attr('id');
                var nextID = ( +id+1);
            }else {
                var nextID = 1;
            }
            var txtAddSkills = $("#txtAddSkills").val();
            var item3 = document.createElement("li");
            item3.innerHTML = "<li class='bg-blue rounded text-white d-inline-block mr-2 skill mb-2' id='"+nextID+"'><input type='text' class='btn btn-sm btn-blue' value='"+txtAddSkills+"' name='skill[]'><button type='button' class='close' onclick='var li = this.parentNode; var ul = li.parentNode; ul.removeChild(li);'><img src='<?php echo  $staticUrl; ?>/images/skill-close.svg' class='w-100 svg'></button></li>";
            $("#olTestList2").append(item3);
            $("#txtAddSkills").val("");
        }else{
            $("#txtAddSkills").attr("placeholder", "Enter skill");  
        }
    }
    function removeParentLi(i){
        alert(i);
        remove("#parent_li_"+i);
    }
    $(function(){
      $('#btnSubmit, #btnDraft').click(function () {
        var chk = $('.fr-element').html();
        $('#hiddeninput').val(chk);
      });
  });
</script>
<script type="text/javascript">
   function frmValidation(){
     var industry_ID  =    $("#industry_ID").val();
     var job_title  =    $("#job_title").val();
     var diarie  =    $("#diarie").val();
     var vacancies  =    $("#vacancies").val();
     var pay  =    $("#pay").val();
     var last_date  =    $("#last_date").val();
     var country  =    $("#country").val();
     var city  =    $("#city").val();
     var qualification  =    $("#qualification").val();
     var hiddeninput  =    $("#hiddeninput").val();
   
     if(industry_ID == "" ||job_title == "" ||diarie == "" ||vacancies == "" ||pay == "" ||last_date == "" ||country == "" ||city == "" ||qualification == "" ||hiddeninput == "" ){
        if(industry_ID == ""){
          $("#errIndustry_id").removeClass("text-muted");
          $("#errIndustry_id").addClass("text-danger");
        }
        if(job_title == ""){
          $("#errJob_title").removeClass("text-muted");
          $("#errJob_title").addClass("text-danger");
        }
        if(diarie == ""){
          $("#errdiarie").removeClass("text-muted");
          $("#errdiarie").addClass("text-danger");
        }
        if(vacancies == ""){
          $("#errvacancies").removeClass("text-muted");
          $("#errvacancies").addClass("text-danger");
        }
        if(pay == ""){
          $("#errPay").removeClass("text-muted");
          $("#errPay").addClass("text-danger");
        }
        if(last_date == ""){
          $("#errlast_date").removeClass("text-muted");
          $("#errlast_date").addClass("text-danger");
        }
        if(country == ""){
          $("#errCountry").removeClass("text-muted");
          $("#errCountry").addClass("text-danger");
        }
        if(city == ""){
          $("#errCity").removeClass("text-muted");
          $("#errCity").addClass("text-danger");
        }
        if(qualification == ""){
          $("#errqualification").removeClass("text-muted");
          $("#errqualification").addClass("text-danger");
        }
        if(hiddeninput == ""){
          $("#errhiddeninput").removeClass("text-muted");
          $("#errhiddeninput").addClass("text-danger");
        }

        return false;

    } else {
      return true;
    }


   }
</script>