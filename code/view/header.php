<?php echo doctype(); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
      echo meta('Content-Type', 'text/html; charset=utf-8', 'http-equiv');
      echo meta('viewport', 'width=device-width, initial-scale=1, maximum-scale=1', 'name');
?>

<title><?php echo $this->config->item('WEBSITE_NAME'); ?></title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800,700' rel='stylesheet' type="text/css" />
<?php echo link_tag('css/style.css?t='.time()); ?>
<?php echo link_tag('css/menu.css?t='.time()); ?>
<?php echo link_tag('css/font-awesome.css?t='.time()); ?>
<?php echo link_tag('css/media-queries.css?t='.time()); ?>
<?php echo link_tag('css/animate.min.css?t='.time()); ?>
<?php echo link_tag('css/common_general.css?t='.time()); ?>
<?php echo link_tag('css/validationEngine.jquery.css'); ?>

<script type="text/jscript" src="<?php echo base_url().'js/jquery-1.11.0.min.js';?>"></script> 
<script type="text/jscript" src="<?php echo base_url().'js/jquery-migrate-1.2.1.min.js';?>"></script>
<script type="text/jscript" src="<?php echo base_url().'js/jquery.validate.js';?>"></script>
<script type="text/jscript" src="<?php echo base_url().'js/blockUI.js'?>"></script>
<script type="text/jscript" src="<?php echo base_url().'js/common_jquery.js?t='.time();?>"></script>
<script type="text/jscript" src="<?php echo base_url().'js/jquery.validationEngine.js';?>"></script>
<script type="text/jscript" src="<?php echo base_url().'js/jquery.validationEngine-en.js';?>"></script>
</head>

<body <?php echo $this->session->userdata('is_logged_in')?'class="about-bg"':'';?>>
<div class="animated fadeIn">
      
  <?php if($this->session->userdata('is_logged_in')) {
      ?>
      <?php echo link_tag('css/jquery.fancybox.css?t='.time()); ?>
      <script type="text/jscript" src="<?php echo base_url().'js/jquery.fancybox.js?t='.time();?>"></script>
      <script type="text/jscript" src="<?php echo base_url().'js/jquery.screwdefaultbuttonsV2.js?t='.time();?>"></script>
      <script type="text/javascript">
		$(document).ready(function() {
			$('.fancybox').fancybox();
                        
                        		    $('input:checkbox').screwDefaultButtons({
						image: 'url("<?php echo site_url("images/checkbox.png") ;?>")',
						width: 16,
						height: 16
					});
                    
                    $('input:radio').screwDefaultButtons({
				image: 'url("<?php echo site_url("images/radio-btn.png") ;?>")',
				width: 16,
				height: 16
			});
                    
                    
                    $( "#click-box" ).click(function() {
					$( ".welcome-drop" ).slideToggle( "slow", function() {
				   // Animation complete.
				   });
				   });

                });
      </script>         
      <div id="header">
     <div class="wrapper">
      <div id="logo">
            <a href="<?php echo base_url('timeline') ; ?>">
                     <?php echo img(array("src"=>"images/".$this->config->item('WEBSITE_LOGO'),"alt"=>$this->config->item('WEBSITE_NAME'))) ;?>  
           </a>
      </div>
      <div class="Create"><a class="fancybox" href="#inline1"><i class="fa fa-edit"></i> <?php echo $this->lang->line('create_new_post') ; ?></a></div>
      <div class="Popularpage"><a href="#"><?php echo $this->lang->line('popular_page') ; ?></a></div>
      <div class="top-r-link">
        <div class="right-home-btn"> <a href="<?php echo site_url($this->config->item('page_url_timeline')); ?>"><i class="fa fa-home"></i> </a> <a href="#"><i class="fa fa-bell"></i></a> </div>
        <div id="click-box"  class="WelcomeR"> <a href="<?php echo site_url($this->config->item('page_url_user_profile')); ?>"> <?php echo img(array("src"=>get_profile_header_image())) ;?> <?php echo $this->lang->line('welcome')." ". $this->session->userdata('USER_FNAME')." ".$this->session->userdata('USER_LNAME') ; ?></a><a href="#" onclick="return false;"><span><i class="fa fa-caret-down"></i></span> </a>
        <div class="welcome-drop">
        <i class="fa fa-caret-up arrow"></i>
        <ul>
        <li><a href="#"><i class="fa fa-check-square-o"></i>Lorem Ipsum</a></li>
        <li><a href="#"><i class="fa fa-check-square-o"></i>Lorem Ipsum</a></li>
        <li><a href="<?php echo site_url($this->config->item('page_url_logout')); ?>"><i class="fa fa-sign-out"></i><?php echo $this->lang->line("logout"); ?></a></li>
        </ul>
        </div>
      </div>
      </div>
      <div class="clear"></div>
    </div>
  </div>
  <?php    
      
  }
  else{
      
    ?>  
    <div id="header">
  <div class="wrapper">
      <div id="logo"><a href="<?php echo base_url() ; ?>">
                     <?php echo img(array("src"=>"images/".$this->config->item('WEBSITE_LOGO'),"alt"=>$this->config->item('WEBSITE_NAME'))) ;?>  
                     </a>
      </div>
    </div>
  </div>
    
    <?php } ?>