<?php $this->load->view('application/inc/header'); ?>
<?php $staticUrl = STATICAPPCOMPURL; ?>
<section>
    <div class="container">
        <div class="row top-header bg-l-grey align-items-center">
            <div class="col-2">
                <a href="<?php echo APPURL; ?>/employer/job-analysis" class="d-block">
                    <img src="<?php echo  $staticUrl; ?>/images/back-arrow.png" class="back-arrow">
                </a>
            </div>
            <div class="col-8 text-center">
                <h2 class="mb-0">New Analysis</h2>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="">
                    <form class="row mt-4" action="#" method="POST">
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" placeholder="Title" name="pageTitle" id="pageTitle">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <input type="text" class="form-control" placeholder="Slug" name="pageSlug" id="pageSlug">
                            <span></span>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <div id='edit'></div>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <textarea id="hiddeninput" name="hiddeninput"></textarea> 
                        </div>
                        <div class="form-group col-6 mb-3">
                            <a href="<?php echo APPURL; ?>/employer/job-analysis" class="btn btn-blue" >Cancel</a>
                        </div>
                        <div class="form-group col-6 mb-3">
                            <button type="submit" class="btn btn-blue" name="btnJobAnalysis" id="btnJobAnalysis">Add</button>
                            
                        </div>
                    </form>
                </div>
            </div>
            <!-- col -->
        </div>
        <!-- row -->
    </div>
    <!-- container -->
</section>
<!-- section -->

<?php $this->load->view('application/inc/footer'); ?>

<script type="text/javascript">
    $(document).ready(function(){
    $('#hiddeninput').hide();
  });

$(function(){
      $('#btnJobAnalysis').click(function () {
        var chk = $('.fr-element').children().html();
        $('#hiddeninput').val(chk);
      });
  });
</script>
<script type="text/javascript">
    new FroalaEditor('div#edit', {
    videoResponsive: true,
    toolbarButtons: ['insertVideo']
  })
</script>