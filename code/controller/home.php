<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home {

	/**
	 * Home Page controller.
	 *
	 * This handle front end functionality
	 *
	 *
	 * Function list
	 *    __construct
	 *    index
	 *    logout
	 *    about
	 *    advertise
	 * 
	 */
	
	
	public function __construct()
	{
	    parent::__construct();
	  
	  
	    $select_language = $this->session->userdata('select_language');
	    if($select_language != "")
	    {
	      $this->lang->load($select_language, $select_language);
	    }
	}

	
	
	/**
	 * index Page .
	 *
	 * This handle index page functionality
	 * 
	 */
	public function index()
	{
	  
	  if(isset($this->session->userdata['USER_USERID'])) {
	     ob_start();
	     redirect('timeline');
	   }
	
	  $data['WEBSITE_NAME'] = $this->config->item('WEBSITE_NAME');
	  $data['BASE_URL'] = $this->config->item('base_url');
	  
	  
	  $username = $this->input->post('user_name');
	  $name = $this->input->post('name');
	  $email = $this->input->post('email');
	  $gender = $this->input->post('gender');
	 
	   
	  $name = get_user_first_and_last_name($name);
	  $data['username'] = $username;
	  $data['name'] = $name['fname'];
	 
	  $data['email'] = $email;
	  $data['gender'] = $gender;
	  
	  $data['error_sign_up_form'] = "";
	  $data['error_sign_in_form'] = "";
	  
	  
	  //code for login functionality	  
	  if($this->input->post('login_submit') != "")
	  {
	     $this->form_validation->set_rules('username', $this->lang->line('username'), 'trim|required|xss_clean');
	     $this->form_validation->set_rules('user_password', $this->lang->line('password'), 'trim|required');
	    
	    if ($this->form_validation->run() == FALSE)
	    {
	      $data['error_sign_in_form'] = validation_errors();
	    }
	    else
	    { 
	       $this->load->model('loginregistration');
	       $tmp_error_var = "";
	       $res_login = $this->loginregistration->check_login($tmp_error_var);
	       if($res_login)
	       { 
		 redirect_url(site_url($this->config->item('page_url_timeline')),"Y");
	       }
	       else
	       {
	         $data['error_sign_in_form'] .= "<p>".$tmp_error_var."</p>";
	       } 
	       
	    }
	  }
	
	
	
	
	  //code for sign up functionality
	  if($this->input->post('sign_up_submit') != "")
	  {
	    $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|xss_clean');
	    $this->form_validation->set_rules('user_name', $this->lang->line('username'), 'trim|required|xss_clean');
	    $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email|xss_clean');
	    $this->form_validation->set_rules('password', $this->lang->line('password'), 'required|min_length[6]|max_length[20]|matches[repassword]');
	    $this->form_validation->set_rules('repassword', $this->lang->line('re_password'), 'required');
	    $this->form_validation->set_rules('gender', $this->lang->line('gender'), 'trim|required|xss_clean');
	    
	    if ($this->form_validation->run() == FALSE)
	    {
	      $data['error_sign_up_form'] = validation_errors();
	    }
	    else
	    {
	      $this->load->model('loginregistration');
	      $res_dup = $this->loginregistration->duplicate_user_email_check();
	      $dup_username = $this->loginregistration->duplicate_user_name_check();
	      $ok = true;
	      
	      if($res_dup == false)
	      {
		$ok = false;
	        $data['error_sign_up_form'] .= "<p>".$this->lang->line('error_duplicate_email')."</p>";
	      }
	      
	      if($dup_username == false)
	      {
		$ok = false;
	        $data['error_sign_up_form'] .= "<p>".$this->lang->line('error_duplicate_username')."</p>";
	      }
	      
	      
	      if($ok)
	      {
		$sign_up_res = $this->loginregistration->user_signup();
		if($sign_up_res)
		{
		   redirect_url(site_url($this->config->item('page_url_registration_successfull')),"Y");//redirect(site_url($this->config->item('page_url_registration_successfull')), 'location',301);
		}
	      }
	      
	    }
	  }
	 

          $this->load->view('front/header',$data);
	  $this->load->view('front/home');
	  $this->load->view('front/footer');
	}
	

	
	/**
	 * user logout Page .
	 *
	 * This is user logout page functionality
	 * 
	 */
	public function logout()
	{ 
            
	    $this->load->model('loginregistration');
	    $res_logout = $this->loginregistration->user_logout();
	    
	    if($res_logout)
	    { 
	      $this->session->sess_destroy();  
	      redirect_url(base_url(),"refresh");
	    }
        }

   
   
   
        /**
	 * About us  Page .
	 *
	 * This is user about  page functionality
	 * 
	 */
        
        public function about()
        {
            $data = array();
            $data['active_tab'] = "About"; 
            
            $this->load->view('front/header_front');  
            $this->load->view('front/left_side_bar_about_page',$data); 
            $this->load->view('front/about');
            $this->load->view('front/footer',$data); 
        }




         /**
	 * Advertise  Page .
	 *
	 * This is user about  page functionality
	 * 
	 */ 
        
        public function advertise()
        {
            $data = array();
            $data['active_tab'] = "";
            
            $this->load->view('front/header_front');  
            $this->load->view('front/left_side_bar_about_page',$data); 
            $this->load->view('front/advertise');
            $this->load->view('front/footer'); 
        }

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
