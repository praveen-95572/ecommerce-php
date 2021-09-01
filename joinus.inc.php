<?php
$msg='';

if(isset($_POST['joinus'])){
	$fname=get_safe_val($conn,$_POST['firstname']);
	$lname=get_safe_val($conn,$_POST['lastname']);
	$mob=get_safe_val($conn,$_POST['mobile']);
	$pwd=get_safe_val($conn,$_POST['pwd']);
	$email=get_safe_val($conn,$_POST['email']);
	$country=get_safe_val($conn,$_POST['country']);
	$city=get_safe_val($conn,$_POST['city']);
	$state=get_safe_val($conn,$_POST['state']);
	$added_on= date('d-m-y h:M:s');
	$check=mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
	if(mysqli_num_rows($check)>0){
		$msg="account already exist";
	}
	else{
		$sql="INSERT INTO users (firstname, lastname, mobile, password, email, country, city, state, added_on) VALUES ('$fname','$lname','$mob','$pwd','$email','$country','$city','$state','$added_on')";
		mysqli_query($conn,$sql);
		$msg="account successfully created";
	}
}?> 

 <div class="modal fade" id="joinus" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="text-align: center; color: black; letter-spacing: 5px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p class="modal-title"><a href="game.html"><img src="img/dice.png" alt="play game" height="80" id="game"></a></p><h3>Your account <br>is <b style="color: blue;">Everything</b></h3>
        </div>
        <div class="modal-body td">
         <form method="post" action="" id="form_register">
			<div class="form-group">
				<input type="text" name="firstname" placeholder="First Name" class="form-control" required>
			</div>
			<div class="form-group">
				<input type="text" name="lastname" placeholder="Last Name"  class="form-control" required>
			</div>
			
			<div class="form-group">
				<input type="text" name="email" id="email" placeholder="Email address" class="form-control" required style="width:60%; float:left;"><button type="button" onclick="email_sent_otp()" class="email_sent_otp">Send OTP</button>
				<input type="text" id="email_otp" placeholder="OTP" class="email_verify_otp form-control"><?php $otp=''; if(isset($_SESSION['OTP']))	$otp=$_SESSION['OTP']; ?>
				<button type="button" onclick="email_verify_otp($otp)" class="email_verify_otp">Verify OTP</button><span id="email_otp_result"></span>
			</div>
			<div class="form-group">
				<input type="text" name="mobile" placeholder="Mobile No. " class="form-control" required>
			</div>
			<div class="form-group">
				<select name="state" id="state" class="form-control" onchange="stateFun(this.value)" required>
					<option value="">Choose State</option>
					<?php
					//if($conn)	echo "<script>alert('Conn');</script>";
						$sql="SELECT * FROM states where country_id=101";
						$query=mysqli_query($conn,$sql);
					//if($query)	echo "<script>alert('Error');</script>";
						while($fetch=mysqli_fetch_assoc($query)){?>
							<option value="<?php echo $fetch['id']; ?>"><?php echo $fetch['name']; ?></option>
					<?php }?>
				</select>
			</div>
			<div class="form-group">
				<select name="city"  class="form-control" id="city" required>
						<option value="">Choose City</option>
				</select>
			</div>
			<div class="form-group">
				<input type="Password" name="pwd" placeholder="Password" class="form-control" required>
			</div>
			
			<button type="button" name="joinus" style="background-color: black; color: white; padding: 10px; width: 80%; margin: 0 10%;" onclick="register()" disabled>Create</button>
		</form>
          <div class="error"><?php echo $msg; ?></div>
        </div>
        <div class="modal-footer" style="text-align: center;">
           <span>&copy Apni Dukaan</span>
          <button type="submit" class="btn btn-default" data-dismiss="modal" style="float: right; " name="joinus">Close</button>
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript">    
	var xml=new XMLHttpRequest();
	function email_sent_otp(){
		var email=$('#email').val(); 
		var atposition=email.indexOf("@");  
      	var dotposition=email.lastIndexOf(".");
      	var len=email.length;
      	var last_email=email.substring(len-10,len);
      	//alert(last_email);
		if(email==''){
			 $(".error").slideDown();
			$('.error').html('Please enter Email id');
			return ;
		}
		if (!(last_email=="@gmail.com")){ 	//if((atposition<3 || dotposition<atposition+2 || dotposition+2>=email.length )) 
        $(".error").slideDown();
        $(".error").html("Please enter the valid e-mail address");  
        return false;  
       }  

     	$('.error').html('');
      	$(".error").slideUp();
      	$("#email").css('disabled','true');
      	 $.ajax({
            type: "POST",
            url: "smtp/index.php",
            data: {'email':email,'type':'email'},
           	success:function(res){
           		if(res=="-1")
           		{
           			$(".error").slideDown();
					$('.error').html('Account already Exist');
           		}
           		else if(res=="0")
           		{
           			$(".error").slideDown();
					$('.error').html('Invalid Email id');
           		}
           		else{
           		$(".error").slideDown();
				$('.error').html('Otp sent to your email');
           		$('.email_sent_otp').hide();
				$('.email_verify_otp').show();
				return;
			}
			$('#form_register')[0].reset();
           	}

           });
	/*	xml.open('GET','smtp/index.php?email='+email+'&type=email','true');
		xml.onreadystatechange=function(){	
		if(xml.readyState==4 && xml.status==200){
      	alert("USE");
			//document.getElementById('error').innerHTML=xml.responseText;
			//alert(xml.responseText);
			$('#email').attr('disabled',true);
		$('.email_sent_otp').hide();
		$('.email_verify_otp').show();
		}
		}  */
		
	}
	function email_verify_otp(verify){
		alert("sdf");
		var otp=$('#email_otp').val();
		if(otp==""){
			$(".error").slideDown();
			$('.error').html('Please enter OTP');
		}
		else{
		$(".error").slideUp();
		$('.error').html('');
		if(otp==verify){
		$('.email_verify_otp').hide();
		$('#email_otp_result').html('Email id verified');
		$('input[name=joinus]').css('disabled','false');}
		else
			$('#email_otp_result').html('Invalid Otp');
		}
	}

	function register(){
		var data=$('#form_register').serialize();
		var x = $("#form_register").serializeArray();
		var mobile=$('#mobile').val();
		for(i=0;i<x.length;i++){
			if(x[i].value==''){
				$('.error').html("All fields are required .");
				$('.error').slideDown();
				return ;
			}
		}
		var phone=/^\d{10}$/;
    if(!mobile.match(phone)){
    	$(".contact_error").slideDown();
        $(".contact_error").html("Please enter the valid mobile number");  
        return ;
    }
		 $.ajax({
            type: "POST",
            url: "ajax/register.php",
            data: data,
            //dataType: "json";
            beforeSend: function () {
                $(".error").html("Checking your input"); 
                $(".error").addClass("alert alert-primary");
               },
            success:function(data){
            	alert(data);
                setTimeout(function(){$(".error").html(data); 
                        $(".error").addClass("alert alert-success");},3000);
                //setTimeout(function(){location.reload();},3000)
            }
        });
	

	}


function stateFun(data){
	xml.open('GET','ajax/state.inc.php?id='+data,'true');
	xml.send();

	xml.onreadystatechange=function(){
		if(xml.readyState==4 && xml.status==200){

			document.getElementById('city').innerHTML=xml.responseText;
		}
	}

} 
</script>