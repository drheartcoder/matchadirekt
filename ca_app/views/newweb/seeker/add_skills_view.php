<?php $this->load->view('newweb/inc/header'); ?>
<?php 
    $staticUrl = STATICWEBSEEKERURL; 
?>
<section class="main-container vheight-100">
    <div class="container">
        <div class="row">
        <div class="col-12 col-md-10  col-lg-9 col-xl-8 mx-auto bg-white">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo WEBURL ?>/seeker/my-cv" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0"><?=lang('Add Skills')?></h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="">
                    <form class="row mt-4" action="#" method="POST">
                        <div class="form-group col-12 skill-block py-3 bg-l-grey">
                            <ul class="skill-group mb-0 text-center <?php if(isset($skillData) && $skillData != ""){ echo 'hasLi'; } ?>" id="olTestList2">
                                <?php  if(isset($skillData) && $skillData != ""){
                                            $i=1;
                                        foreach($skillData as $skill){
                                            ?>

                                <li class="bg-blue rounded text-white d-inline-block mr-2 py-2 px-3 skill mb-2" id="<?php echo $i; ?>">
                                    <input type="text" class="btn btn-sm btn-blue" value="<?php echo $skill->skill_name; ?>" name="skill[]">
                                            <button type="button" class="close" onclick="var li = this.parentNode; var ul = li.parentNode; ul.removeChild(li);;">
                                                <img src="<?php echo  $staticUrl; ?>/images/skill-close.svg" class="w-100 svg">
                                            </button>
                                </li>
                                   <?php
                                            $i++;
                                        }
                                    } ?>
                                 
                            </ul>
                        </div>
                         <div class="form-group col-12 mb-3">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="<?=lang('Add Skills')?>" name="txtAddSkills" id="txtAddSkills">
                                    <div class="input-group-append ml-0">
                                        <button class="btn btn-blue add-btn rounded-0" type="button" id="btnAddSkill" onclick="appendSkillData();">
                                            <img src="<?php echo  $staticUrl; ?>/images/plus-white.svg" class="w-100">
                                        </button>
                                    </div>
                                </div>
                                <span></span>
                            </div>
                         <div class="col-12 col-lg-9 col-xl-8 mx-auto mb-3">
                            <div class="row">
                        <div class="form-group col-6 mb-3">
                           <button type="submit" class="btn btn-blue" name="btnSubmit" id="btnSubmit"><?=lang('Update')?></button>
                        </div>
                        <div class="form-group col-6 mb-3">
                            <a href="<?php echo WEBURL; ?>/seeker/my-cv" class="btn btn-blue" name="btnCancel" id="btnCancel" ><?=lang('Cancel')?></a>
                        </div>
                    </div>
                </div>
                    </form>
                </div>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    </div>
</div>
</div>
    <!-- container -->
</section>
<!-- section -->

<!-- section -->
<?php $this->load->view('newweb/inc/footer'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#btnAddSkill").attr("disabled", true); 
    });
    $( "#txtAddSkills" ).keyup(function() {
      $("#btnAddSkill").attr("disabled", false ); 
    });
    
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
</script>