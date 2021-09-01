 <div class="modal fade" id="login" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content--> 
      <div class="modal-content">
        <div class="modal-header" style="text-align: center; color: black; letter-spacing: 5px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p class="modal-title"><a href="game.html"><img src="img/dice.png" alt="play game" height="80" id="game"></a></p><h3>Your account <br>is <b style="color: blue;">Everything</b></h3>
        </div>
        <div class="modal-body td login">
          <form style="align-content: center;" method="post" id='login_form'>
            <div class="form-group">
              <input type="text" name="email" id="lemail" placeholder="Email address" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" name="pwd" placeholder="Password" class="form-control">
            </div>
            <div class="form-group">
              <input type="checkbox" name="remember"><label for="remember">Keep me signed in</label>
              <a href="forgot_password.php" style="float: right;">Forgotten your password ?</a>
            </div>
            <div class="form-group">
              <p>By logging in, you agree to our Privacy Policy and Terms of Use.</p>
            </div>
            <button type="button" onclick="login()" class="submit">Sign in</button>
            
          </form>
          <p>Not a Member? &nbsp;<a href="">Join Us.</a> </p>
          <div class="error1"></div>
        </div>
        <div class="modal-footer" style="text-align: center;">
           <span>&copy Apni Dukaan</span>
          <button type="button" class="btn btn-default" data-dismiss="modal" style="float: right; ">Close</button>
        </div>
      </div>
    </div>
  </div>
      
  <script type="text/javascript">
    function login(){
      var data=$('#login_form').serialize();
      var email=$('#lemail').val();
      var pwd=$('input[name=pwd]').val();
      var atposition=email.indexOf("@");  
      var dotposition=email.lastIndexOf(".");
      if(email=='' || pwd=='')
      {
        $(".error1").slideDown();
        $(".error1").html("All fields are required");
        return;
      }
      if (atposition<3 || dotposition<atposition+2 || dotposition+2>=email.length){  
        $(".error1").slideDown();
        $(".error1").html("Please enter the valid e-mail address");  
        return false;  
       }  
      $.ajax({
        url:"ajax/login.php",
        type:"post",
        data:data,
        //dataType:"json",
        beforeSend:function(){
          $(".error1").slideDown();
          $(".error1").html("Checking your input ...."); 
          $(".error1").addClass("alert alert-primary");
        },
       success:function(data){
        $(".error1").slideDown();
        if(data[10]==0){
          $(".error1").html("Incorrect email or password !"); 
          $(".error1").addClass("alert alert-danger");
        }
        if(data[10]==1){
         setTimeout(function(){$(".error1").html("Login Successful"); 
          $(".error1").addClass("alert alert-primary");},1500);
         setTimeout(function(){location.reload();},2000);}
          },
       error:function(){
          $(".error1").slideDown();
          $(".error1").html("Server is busy right now !"); 
          $(".error1").addClass("alert alert-danger");
        }
        
       
      });
    }
  </script>