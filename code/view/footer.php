  <div id="footer">
    <div class="wrapper">
      <div class="footer-Wrapp">
        <div class="footer-link">
          <ul>
	    <li><a href="<?php echo site_url();?>"> <?php echo $this->lang->line('home') ;?> </a></li>
           <li><a  href="<?php echo site_url($this->config->item('page_url_about'));?>"><?php echo $this->lang->line('about') ;?></a></li>
            <li><a href="<?php echo site_url($this->config->item('page_url_advertise'));?>"> <?php echo $this->lang->line('advertise') ;?> </a></li>
            <li><a href="<?php echo site_url($this->config->item('page_url_careers'));?>"> <?php echo $this->lang->line('careers') ;?> </a></li>
            <li><a href="<?php echo site_url($this->config->item('page_url_privacy'));?>"> <?php echo $this->lang->line('privacy') ;?> </a></li>
            <li><a href="<?php echo site_url($this->config->item('page_url_cookies'));?>"> <?php echo $this->lang->line('cookies') ;?> </a></li>
            <li><a href="<?php echo site_url($this->config->item('page_url_terms'));?>"> <?php echo $this->lang->line('terms') ;?> </a></li>
	    <li><a href="<?php echo site_url($this->config->item('page_url_contact'));?>"> <?php echo $this->lang->line('lbl_contact_us') ;?> </a></li>
            <li><a href="<?php echo site_url($this->config->item('page_url_help'));?>"> <?php echo $this->lang->line('help') ;?></a></li>
          </ul>
        </div>
        <div class="rights"><?php echo $this->config->item('WEBSITE_NAME'); ?><?php echo $this->lang->line('copy_right') ;?></div>
        <div class="clear"></div>
      </div>
    </div>
  </div>
</div>

 <?php if($this->session->userdata('is_logged_in')) {
      ?>
      
      	<!-- This contains the hidden content for inline calls -->
	<div id="inline1" style="display: none;">
    <div class="popup">
		<h3>Create new post</h3>
        
        <div>
        <ul class="popup-nav">
        <li><a href="#"><i class="fa fa-file-text-o"></i>Text</a>
        <div class="dropdown">
        <ul>
        <li><a href="#"><i class="fa fa-upload"></i>Lorem Ipsum 1</a></li>
        <li><a href="#"><i class="fa fa-upload"></i>Lorem Ipsum 2</a></li>
        <li><a href="#"><i class="fa fa-upload"></i>Lorem Ipsum 3</a></li>
        </ul>
        </div>
        </li>
        <li><a href="#"><i class="fa fa-volume-up"></i>Audio</a>
        <div class="dropdown">
        <ul>
        <li><a href="#"><i class="fa fa-upload"></i>Lorem Ipsum 1</a></li>
        <li><a href="#"><i class="fa fa-upload"></i>Lorem Ipsum 2</a></li>
        <li><a href="#"><i class="fa fa-upload"></i>Lorem Ipsum 3</a></li>
        </ul>
        </div>
        </li>
        <li><a href="#"><i class="fa fa-film"></i>Video</a>
        <div class="dropdown">
        <ul>
        <li><a href="#"><i class="fa fa-upload"></i>Lorem Ipsum 1</a></li>
        <li><a href="#"><i class="fa fa-upload"></i>Lorem Ipsum 2</a></li>
        <li><a href="#"><i class="fa fa-upload"></i>Lorem Ipsum 3</a></li>
        </ul>
        </div>
        </li>
        <li><a href="#"><i class="fa fa-picture-o "></i>Photo</a>
        <div class="dropdown">
        <ul>
        <li><a href="#"><i class="fa fa-upload"></i>Upload photo</a></li>
        <li><a href="#"><i class="fa fa-folder"></i>Upload album</a></li>
        <li><a href="#"><i class="fa fa-camera"></i>Take photo</a></li>
        </ul>
        </div>
        </li>
        </ul>
        </div>
        
		<p>
			<textarea cols="" rows="" onfocus="if(this.value=='Add Something')this.value='';" onblur="if(this.value=='')this.value='Add Something';">Add Something</textarea>
		</p>
        <div class="popup-bttm">
        <div class="field-box">
        <span><input type="checkbox" /></span><label>Copyright this post</label>
        </div>
        <input type="submit" class="btn" name="Submit" value="Submit">
        </div>
        </div>
	</div>
      
      <?php } ?>

</body>
</html>