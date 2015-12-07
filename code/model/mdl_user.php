<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

        /**
	 * User Model.
	 *
	 * It contain all function which deal with mysql database
	 *
	 *
	 * Function list
	 *    __construct
	 *    get_country_list
	 *    get_login_user_info
	 *    update_login_user_profile
	 *    check_current_pwd
	 *    notification_action
	 * 
	 */

class Mdl_user {

    function __construct() {
        parent::__construct();
    }

    /**
     * get country list array
     *
     * Return country list array 
     *

     * @access	public
     * @return	array
     */
    public function get_country_list() {
        
        $countries_table_name = get_table_name('countries');
        $sql = "SELECT countries_id id, countries_name name
                FROM " . $countries_table_name . "
                WHERE countries_status = 1
                ORDER BY  countries_name ASC";
                
        $query = $this->db->query($sql);
        $row = $query->result_array();

        $country_arr = array();
        if (!empty($row)) {
            foreach ($row as $val) {
                $country_arr[$val['id']] = $val['name'];
            }
        }

        return $country_arr;
    }



    /**
     * get current user info
     *
     * Return current user info array 
     *

     * @access	public
     * @return	array
     */
    public function get_login_user_info() {
        
        $users_address_table_name = get_table_name('users_address');
        $users_info_table_name = get_table_name('users_info');
        $users_table_name = get_table_name('users');
        $user_id = $this->session->userdata("USER_USERID");
        
        $sql = "SELECT usersinfo_fname, usersinfo_mname, usersinfo_lname,users_email,users_name , usersinfo_phone, usersinfo_mobile, usersinfo_dob, usersinfo_gender,
                usersaddress_address, usersaddress_city, usersaddress_state, usersaddress_zip, usersaddress_countryID
                FROM " . $users_info_table_name . "
                LEFT JOIN " . $users_address_table_name . " ON usersinfo_usersID = usersaddress_usersID AND usersaddress_type = 'P'
                LEFT JOIN " . $users_table_name . " on usersinfo_usersID = users_id AND users_status = 1
                WHERE usersinfo_usersID = ?";
                
        $query = $this->db->query($sql, array($user_id));
        $row = $query->row();

        return $row;
    }



    /**
     * update login user profile info
     *
     * update login user profile info and update also user address and contact info
     *

     * @access	public
     * @return	bool
     */
    public function update_login_user_profile() {
        $users_address_table_name = get_table_name('users_address');
        $users_info_table_name = get_table_name('users_info');
        $users_table_name = get_table_name('users');
        $user_id = $this->session->userdata("USER_USERID");

        if ($this->input->post('submit_info')) {
            //update user info table
            $name = get_user_first_and_last_name($this->input->post('name'));
            $user_info_data = array(
                'usersinfo_modifyDate' => date("Y-m-d H:i:s"),
                'usersinfo_fname' => $name['fname'],
                'usersinfo_mname' => "",
                'usersinfo_lname' => $name['lname'],
                'usersinfo_gender' => strtoupper($this->input->post('gender')),
            );
            $this->db->where("usersinfo_usersID", $user_id);
            $this->db->where("usersinfo_status", 1);
            $this->db->update($users_info_table_name, $user_info_data);

            //users table update
            $user_data = array(
                'users_modifyDate' => date("Y-m-d H:i:s"),
                'users_name' => $this->input->post('username'),
                'users_email' => $this->input->post('email')
            );
            $this->db->where("users_id", $user_id);
            $this->db->where("users_status", 1);
            $this->db->update($users_table_name, $user_data);



            $session_array = array(
                "USER_FNAME" => $name['fname'],
                "USER_MNAME" => "",
                "USER_LNAME" => $name['lname'],
                "USER_GENDER" => strtoupper($this->input->post('gender')),
            );
            $this->session->set_userdata($session_array);
        }

        //update contact
        if ($this->input->post('submit_contact')) {
            //update user info table

            $user_info_data = array(
                'usersinfo_mobile' => $this->input->post('mobile')
            );
            $this->db->where("usersinfo_usersID", $user_id);
            $this->db->where("usersinfo_status", 1);
            $this->db->update($users_info_table_name, $user_info_data);
        }


        if ($this->input->post('submit_address')) {

            $lat = "";
            $lng = "";

            $this->load->library('lbs');
            $lat_lng_response = $this->lbs->reverseAddress(urlencode($this->input->post('address') . " " . $this->input->post('city') . " " . $this->input->post('state') . " " . $this->input->post('country') . " " . $this->input->post('zip')));

            if (isset($lat_lng_response['response']['lat']) && isset($lat_lng_response['response']['lng'])) {
                $lat = $lat_lng_response['response']['lat'];
                $lng = $lat_lng_response['response']['lng'];
            }


            $sql = "SELECT COUNT(*) cnt FROM " . $users_address_table_name . "
                WHERE usersaddress_type = 'P' AND usersaddress_usersID = ? AND usersaddress_status = 1";
            $query = $this->db->query($sql, array($user_id));
            $row = $query->row();

            //insert ot update in address table

            $user_address_data = array(
                'usersaddress_modifyDate' => date("Y-m-d H:i:s"),
                'usersaddress_address' => $this->input->post('address'),
                'usersaddress_city' => $this->input->post('city'),
                'usersaddress_state' => $this->input->post('state'),
                'usersaddress_zip' => $this->input->post('zip'),
                'usersaddress_countryID' => $this->input->post('country'),
                'usersaddress_lat' => $lat,
                'usersaddress_lng' => $lng,
            );


            if ($row->cnt > 0) {
                $this->db->where("usersaddress_usersID", $user_id);
                $this->db->where("usersaddress_status", 1);
                $this->db->where("usersaddress_type", 'P');
                $this->db->update($users_address_table_name, $user_address_data);
            } else {
                $user_address_data['usersaddress_usersID'] = $user_id;
                $user_address_data['usersaddress_type'] = 'P';
                $user_address_data['usersaddress_status'] = 1;
                $this->db->insert($users_address_table_name, $user_address_data);
            }
        }
      return true;
    }



    /**

     * check current password is right or wrong
     *

     * @access	public
     * @return	bool
     */
    function check_current_pwd($pwd) {
        $user_id = $this->session->userdata('USER_USERID');   // or we can get the  unique data as per  the session array 
        $user_table_name = get_table_name('users');
        $sql = "SELECT count( * ) AS cnt
                FROM " . $user_table_name . "
                WHERE `users_id` =' " . $user_id . "'
                AND `users_password` = '" . md5($pwd) . "'";
        return $this->db->query($sql)->row_array();
     }



    /**
     * Notification action functionality
     *
     * update notification for the user 
     *

     * @access	public
     * @return	bool
     */
    public function notification_action() {

        $subscription = ($this->input->post('subscription') ? $this->input->post('subscription') : 0);
        $follow = ($this->input->post('follow') ? $this->input->post('follow') : 0);
        $replied = ($this->input->post('replied') ? $this->input->post('replied') : 0);
        $mentioned = ($this->input->post('mentioned') ? $this->input->post('mentioned') : 0);
        $like = ($this->input->post('like') ? $this->input->post('like') : 0);
        $share = ($this->input->post('share') ? $this->input->post('share') : 0);
        $verify = ($this->input->post('verify') ? $this->input->post('verify') : 0);

        $everyone = ($this->input->post('everyone') ? $this->input->post('everyone') : 0);
        $follower = ($this->input->post('follower') ? $this->input->post('follower') : 0);
        $people = ($this->input->post('people') ? $this->input->post('people') : 0);


        //for subscription checkbox 
        if ($subscription) {
            $this->update_notification(1, $this->lang->line('subscription_request'));
        } else {
            $this->update_notification(0, $this->lang->line('subscription_request'));
        }

        //for feedback checkbox
        if ($follow) {
            $this->update_notification(1, $this->lang->line('follow_request'));
        } else {
            $this->update_notification(0, $this->lang->line('follow_request'));
        }

        //for replied checkbox      
        if ($replied) {
            $this->update_notification(1, $this->lang->line('someone_replied'));
        } else {
            $this->update_notification(0, $this->lang->line('someone_replied'));
        }

        //for mentioned checkbox      
        if ($mentioned) {
            $this->update_notification(1, $this->lang->line('someone_mentioned'));
        } else {
            $this->update_notification(0, $this->lang->line('someone_mentioned'));
        }

        //for like checkbox            
        if ($like) {
            $this->update_notification(1, $this->lang->line('someone_like'));
        } else {
            $this->update_notification(0, $this->lang->line('someone_like'));
        }

        //for share checkbox           
        if ($share) {
            $this->update_notification(1, $this->lang->line('someone_share'));
        } else {
            $this->update_notification(0, $this->lang->line('someone_share'));
        }

        //for account verify checkbox           
        if ($verify) {
            $this->update_notification(1, $this->lang->line('account_verified'));
        } else {
            $this->update_notification(0, $this->lang->line('account_verified'));
        }


        //for everyone checkbox
        if ($everyone) {
            $this->update_notification($everyone, $this->lang->line('everyone'));
        } else {
            $this->update_notification(0, $this->lang->line('everyone'));
        }

        // for follower checkbox
        if ($follower) {
            $this->update_notification($follower, $this->lang->line('follower'));
        } else {
            $this->update_notification(0, $this->lang->line('follower'));
        }

        //for people checkbox
        if ($people) {
            $this->update_notification($people, $this->lang->line('people'));
        } else {
            $this->update_notification(0, $this->lang->line('people'));
        }
    }

}

//end class
/* Location: ./application/model/mdl_user.php */


