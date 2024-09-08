<div class="modal fade" id="p_p">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Privacy Policy</h4>
      </div>
       <div class="modal-body">
          <iframe style="width: 100%;height: 30em;border: 0;" src="<?php echo (base_url().'qcsh/privacy-policy.html');?>"></iframe>
      </div>
  </div>
</div>
</div

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="<?php echo base_url('public/js/jquery-1.11.0.js');?>"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="<?php echo base_url('public/js/bootstrap.min.js');?>"></script>
<script src="<?php echo base_url('public/js/bootbox.min.js');?>"></script>
<script src="<?php echo base_url('public/js/functions.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('public/js/validation.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('public/slider/owl.carousel.min.js');?>" type="text/javascript"></script> 
<script src="<?php echo base_url('public/js/custom.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('public/js/script.js');?>" type="text/javascript"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
<script type="text/javascript">

function Confirm(message,callback=null) //rdr, //,title_fct="<?=lang('Are you sure?')?>"
{
	swal({
	  title: "<?=lang('Are you sure?')?>",
	  text: message,
	  icon: "warning",
	  buttons: true,
	  dangerMode: true,
	})
	.then((willDelete) => {
	  	callback&&callback(willDelete);
	});
}

if(document.getElementById) {
	window.alert=function(message)
	{
		swal({
		  title: "<?=lang('Alert')?>",
		  text: message,
		  icon: "warning"
		});
	}
}
</script>

<!-- <script src="<?php echo base_url('public/tinymce/tinymce.min.js');?>"></script> -->
<!-- <script>tinymce.init({ selector:'#editor1' });</script>  -->
<!-- <script type="text/javascript">
    $(document).ready(function(){
    	setTimeout(function() {
		    $("#editor_html").hide();
		    $("#mceu_31").hide();
		    $("#mceu_30").hide();
		    $("#editor_html").show();
		}, 2000);
	});
</script> -->