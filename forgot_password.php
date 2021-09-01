<?php include 'header.inc.php'; ?>


<div class="content">
	<div class="row" style="margin: 10px;">
	<div class="col-md-2 col-xs-0 col-sm-0"></div>
	<div class="col-md-8">
		<form method="post" id="contactform">
      <h1>Your Email</h1>
		<div class="form-group">
			<input type="text" id="email" class="form-control"  placeholder="Email*"  >
		</div>
	
		<button type="button" onclick="forgot_password()" class="btn btn-primary" id="btn_submit">Submit</button>
		<div class="form-group">
			<div class="email_error"></div>
		</div>
	</form>
	</div>
	<div class="col-md-2 col-xs-0 col-sm-0"></div>
	</div>
</div>

	


<?php include 'footer.inc.php'; ?>



<script type="text/javascript">

    function forgot_password() {

	alert("yse");     
      var email = $('#email').val();
      var atposition=email.indexOf("@");  
      var dotposition=email.lastIndexOf(".");
      if(email==''){
    	$('.email_error').html("Please enter email id");
		$('.email_error').slideDown();
		return ;}
	if (atposition<3 || dotposition<atposition+2 || dotposition+2>=email.length){  
        $(".email_error").slideDown();
        $(".email_error").html("Please enter the valid e-mail address");  
        return ;  
       }  
       $('.email_error').html("");
		$('.email_error').slideUp();
       jQuery('#btn_submit').html('Please wait...');
		jQuery('#btn_submit').attr('disabled',true);
      $.ajax
        ({
          type: "POST",
          url: "ajax/forgot_password_submit.php",
          data: "email="+email,
          success: function (result) {
            jQuery('#email').val('');
			jQuery('.email_error').html(result);
			jQuery('#btn_submit').html('Submit');
			jQuery('#btn_submit').attr('disabled',false);

            setTimeout(function(){ $(".email_error").slideDown();},2000);
          }
        }); 
    }


</script>