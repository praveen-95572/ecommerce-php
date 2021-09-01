<?php include 'header.inc.php'; ?>


<div class="content">
	<div class="row" style="margin: 10px;">
	<div class="col-md-2 col-xs-0 col-sm-0"></div>
	<div class="col-md-8">
		<form method="post" id="contactform">
      <h1>Send a mail</h1>
		<div class="form-group">
			<input type="text" id="name" class="form-control" placeholder="Your Name*"  >
		</div>
		<div class="form-group">
			<input type="text" id="email" class="form-control"  placeholder="Email*"  >
		</div>
		<div class="form-group">
			
			<input type="text" id="mobile" class="form-control"  placeholder="Mobile*"  >
		</div>
		<div class="form-group">
			
			<textarea  id="msg" class="form-control" placeholder="Your Message"  ></textarea>
		</div>
		<button type="button" onclick="send()" class="btn btn-primary">Send Message</button>
		<div class="form-group">
			<div class="contact_error"></div>
		</div>
	</form>
	</div>
	<div class="col-md-2 col-xs-0 col-sm-0"></div>
	</div>
</div>

	


<?php include 'footer.inc.php'; ?>



<script type="text/javascript">

    function send() {

      var name = $('#name').val();
      var email = $('#email').val();
      var message = $('#msg').val();
      var mobile = $('#mobile').val();
      var atposition=email.indexOf("@");  
      var dotposition=email.lastIndexOf(".");
      if(name=='' || email=='' || message =='' || mobile==''){
    	$('.contact_error').html("All fields are required");
		$('.contact_error').slideDown();
		return ;}
	if (atposition<3 || dotposition<atposition+2 || dotposition+2>=email.length){  
        $(".contact_error").slideDown();
        $(".contact_error").html("Please enter the valid e-mail address");  
        return ;  
       }  
       var phone=/^\d{10}$/;
    if(!mobile.match(phone)){
    	$(".contact_error").slideDown();
        $(".contact_error").html("Please enter the valid mobile number");  
        return ;
    }
    if(message.length<80){
    	$(".contact_error").slideDown();
        $(".contact_error").html("Please write comment more than 100 characters");  
        return ;
    }
  
      $.ajax
        ({
          type: "POST",
          url: "ajax/send_message.php",
          data: { "name": name, "email": email, "message": message ,"mobile":mobile },
          success: function (data) {
             $('#contactform')[0].reset();
             $(".contact_error").slideDown();
          $(".contact_error").html(data);

            setTimeout(function(){ $(".contact_error").slideUp();},2000);
          }
        }); 
    }


</script>