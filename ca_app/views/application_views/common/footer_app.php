
<script src="<?php echo base_url('public/js/jquery-1.11.0.js');?>" type="text/javascript"></script> 
<script src="<?php echo base_url('public/js/bootstrap.js');?>" type="text/javascript"></script> 
<script src="<?php echo base_url('public/js/script_app.js');?>" type="text/javascript"></script> 
<script src="<?php echo base_url('public/js/functions.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('public/js/validate_jobseeker.js');?>" type="text/javascript"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">

// swal({
//   title: "Are you sure?",
//   text: "Once deleted, you will not be able to recover this imaginary file!",
//   icon: "warning",
//   buttons: true,
//   dangerMode: true,
// })
// .then((willDelete) => {
//   if (willDelete) {
//     swal("Poof! Your imaginary file has been deleted!", {
//       icon: "success",
//     });
//   } else {
//     swal("Your imaginary file is safe!");
//   }
// });

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

// var CONFIRM_TITLE = "<?=lang('Confrimation')?>";
// var ALERT_TITLE = "<?=lang('Alert')?>";
// var ALERT_BUTTON_TEXT = "<?=lang('Ok')?>";
// var CONFIRM_BUTTON_TEXT = "<?=lang('Confirm')?>";
// var CANCEL_BUTTON_TEXT = "<?=lang('Cancel')?>";

// var queue = [];
// if(document.getElementById) {
// 	window.confirm=function(message, callback)
//     {
// 		createCustomConfirm(message);

// 	    $("#confirmBtn").click(function() { if (callback) { callback(true);}removeCustomAlert(); });
// 		$("#cancelBtn").click(function() { if (callback) { callback(false);}removeCustomAlert(); });

//     }
// 	window.alert=function(txt)
//     {
//         createCustomAlert(txt);
//     }
// }

// function createCustomAlert(txt) 
// {
//     // var callback = queue.shift();
// 	d = document;

// 	if(d.getElementById("modalContainer")) return;

// 	mObj = d.getElementsByTagName("body")[0].appendChild(d.createElement("div"));
// 	mObj.id = "modalContainer";
// 	mObj.style.height = d.documentElement.scrollHeight + "px";
	
// 	alertObj = mObj.appendChild(d.createElement("div"));
// 	alertObj.id = "alertBox";
// 	if(d.all && !window.opera) alertObj.style.top = document.documentElement.scrollTop + "px";
// 	alertObj.style.left = (d.documentElement.scrollWidth - alertObj.offsetWidth)/2 + "px";
// 	alertObj.style.visiblity="visible";

// 	h1 = alertObj.appendChild(d.createElement("h1"));
// 	h1.appendChild(d.createTextNode(ALERT_TITLE));

// 	msg = alertObj.appendChild(d.createElement("p"));
// 	//msg.appendChild(d.createTextNode(txt));
// 	msg.innerHTML = txt;
// 	msg.innerHTML += "<hr/>";
    
// 	btn = alertObj.appendChild(d.createElement("button"));
// 	btn.id = "okBtn";
// 	btn.appendChild(d.createTextNode(ALERT_BUTTON_TEXT));
// 	btn.focus();
//     btn.onclick = function() { removeCustomAlert();return false;}

// 	alertObj.style.display = "block";

    
// }
// function createCustomConfirm(txt) {
//     var callback = queue.shift();
// 	d = document;

// 	if(d.getElementById("modalContainer")) return;

// 	mObj = d.getElementsByTagName("body")[0].appendChild(d.createElement("div"));
// 	mObj.id = "modalContainer";
// 	mObj.style.height = d.documentElement.scrollHeight + "px";
	
// 	alertObj = mObj.appendChild(d.createElement("div"));
// 	alertObj.id = "alertBox";
// 	if(d.all && !window.opera) alertObj.style.top = document.documentElement.scrollTop + "px";
// 	alertObj.style.left = (d.documentElement.scrollWidth - alertObj.offsetWidth)/2 + "px";
// 	alertObj.style.visiblity="visible";

// 	h1 = alertObj.appendChild(d.createElement("h1"));
// 	h1.appendChild(d.createTextNode(CONFIRM_TITLE));

// 	msg = alertObj.appendChild(d.createElement("p"));
// 	//msg.appendChild(d.createTextNode(txt));
// 	msg.innerHTML = txt;
// 	msg.innerHTML += "<hr/>";
    
// 	btn = alertObj.appendChild(d.createElement("button"));
// 	btn.id = "confirmBtn";
// 	btn.appendChild(d.createTextNode(CONFIRM_BUTTON_TEXT));
// 	btn.focus();


// 	btn2 = alertObj.appendChild(d.createElement("button"));
// 	btn2.id = "cancelBtn";
// 	btn2.appendChild(d.createTextNode(CANCEL_BUTTON_TEXT));
// 	// btn2.onclick = function() { removeCustomAlert();return false; }
//  //    btn.onclick = function() { confirmCustomAlert();return true; }

// 	alertObj.style.display = "block";
    
// }

// function removeCustomAlert() {
// 	document.getElementsByTagName("body")[0].removeChild(document.getElementById("modalContainer"));
// }

// function confirmCustomAlert() {
// 	document.getElementsByTagName("body")[0].removeChild(document.getElementById("modalContainer"));
// }
//function ful(){
//alert('Alert this pages');
//}
</script>


</body>
</html>