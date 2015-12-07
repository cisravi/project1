  <div class="sign-bg">
    <div class="wrapper">
      <div class="welcomeText">
        <div class="signinR"><span><?php echo $this->lang->line('sign_in_sign_up') ;?> </span> <a class="twitter-icon" href="Facebook_Twitter_Login/login-twitter.php"><i class="fa fa-twitter"></i></a> <a class="facebook-icon" href="Facebook_Twitter_Login/login-facebook.php"><i class="fa fa-facebook"></i></a> <a class="envelope-o-icon" href="google-openid/login-google.php"><i class="fa fa-google-plus"></i></a> </div>
        <div class="clear"></div>
	 <div class="success_msg">
                <?php
		if(isset($this->session->userdata['message']))
		{
		echo  $this->session->userdata['message'];
		$this->session->set_userdata(array('message'=>""));
		}
		?>
            </div>
        <div class="welcome-main">
          <div class="welcome-l">
            <h1><?php echo $this->lang->line('welcome_to') ;?> <?php echo $WEBSITE_NAME; ?>.<span><?php echo $this->lang->line('welcome_desc') ;?> </span></h1>
            <div class="iphon-img"><?php echo img(array("src"=>"images/iphon-img.png","alt"=>"")) ;?></div>
            <p class="View-devices"><?php echo $this->lang->line('view_other_device') ;?></p>
            <div class="app-btn"> <a href="#"><?php echo img(array("src"=>"images/app-btn.png","alt"=>"")) ;?>  </a> <a href="#"><?php echo img(array("src"=>"images/play-btn.png","alt"=>"")) ;?> </a> </div>
          </div>
          <div class="Sign-In">
            <div class="UsernameDiv">
              <form name="frm_login" id="frm_login" action="" method="post">
              <h1><?php echo $this->lang->line('sign_in') ;?></h1>
              <div class="form_error">
                <?php echo $error_sign_in_form; ?>
              </div>
              <input type="text" value="<?php echo $username ;?>" name="username" id="username"  placeholder="<?php echo $this->lang->line('email_or_username') ;?>" class="validate[required,maxSize[50]]" maxlength="50"/>
              <input type="password" value="" name="user_password" id="user_password"  placeholder="<?php echo $this->lang->line('password') ;?>"  class="validate[required,maxSize[20]]" maxlength="20" />
              <div class="remember-me">
                
                 <div class="forgot-password"><a href="<?php echo $this->config->item('page_url_forgot'); ?>"  ><?php echo $this->lang->line('forgot_pwd') ;?></a>?</div>
                <div class="clear"></div>
              </div>
              <div class="sign-up">
                <input class="btn" id="login_submit" name="login_submit" type="submit" value="<?php echo $this->lang->line('sign_in') ;?>" />
              </div>
              </form>
            </div>
            <h1> <?php echo $this->lang->line('sign_up') ;?></h1>
            <div class="form_error">
                <?php echo $error_sign_up_form; ?>
		
              </div>
	   
	    
            <form name="frm_signup" id="frm_signup" action="" method="post">
                <input type="text" name="name" id="name"  maxlength="100" placeholder="<?php echo $this->lang->line('name') ;?>" class="validate[required,maxSize[100]]]"/>
                <input type="text" name="user_name" id="user_name"  maxlength="30" placeholder="<?php echo $this->lang->line('username') ;?>" class="validate[required,maxSize[100]],custom[username]]"/><span id="check_user_name" class="check_user_name"></span>
                <input type="text" name="email" id="email" maxlength="50" value="<?php echo $email ;?>"  placeholder="<?php echo $this->lang->line('email') ;?>" class="validate[required,maxSize[100],custom[email]]"/><span id="check_email" class="check_user_name"></span>
                <input type="password" name="password" maxlength="20" id="password" value=""  placeholder="<?php echo $this->lang->line('password') ;?>" class="validate[required,maxSize[20],minSize[6],custom[nospace]]"/>
                <input type="password" name="repassword" maxlength="20" id="repassword" value=""  placeholder="<?php echo $this->lang->line('re_password') ;?>" class="validate[equals[password],required,maxSize[20],minSize[6],custom[nospace]]"/>
                <select class="Gender validate[required]" name="gender" id="gender">
                  <option value=""><?php echo $this->lang->line('gender') ;?></option>
                  <?php
                       $gender_array = gender_array();
                       echo select_list($gender_array,$gender);
                  ?>
                </select>
              
            <div class="sign-up">
              <input class="btn" name="sign_up_submit" id="sign_up_submit" type="submit" value="<?php echo $this->lang->line('sign_up') ;?>" />
            </div>
            </form>
          </div>
          <div class="clear"></div>
        </div>
      </div>
      <!--welcomeText--> 
      
    </div>
  </div>
  
  <script>
    $(document).ready(function() {
      
      $('#email').keypress(function(){
	$('.form_error').hide()
	});
    
    });
  
    $("#user_name").blur(function(){
	
	
	      if ($("#user_name").val()!= "") {
		
		$.ajax({
		  type:"POST",
		  url:"<?php echo base_url('home/check_user_name_registration') ?>",
		  data:{'username':$("#user_name").val()},
		  
		  success:function(data){
		    
		     data = $.parseJSON(data);
		     
		     if(data.MSG == "EXIST")
		     {
		       $("#check_user_name").html('<i class="fa fa-times cls_not_avilable cross" aria-required="true"></i>');
		       form_val = false;
		     }
		     else if(data.MSG == "AVAILABLE")
		     {
		       $("#check_user_name").html('<i class="fa fa-check cls_avilable" aria-required="true"></i>');
		       form_val = true;
		     }
		  }
		 });
	    }
      
      });	
        
	
</script>
