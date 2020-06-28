<?php
defined('BASEPATH') or exit('No direct script access allowed');

class log_lib
{
	protected $CI;

	public function __construct()
	{
		$this->CI = &get_instance();

		$this->CI->load->helper('url');
		$this->CI->config->item('base_url');
		$this->CI->load->library('session');
		$this->CI->load->library('user_agent');
		$this->CI->load->database();
	}

	public function log_inf($aktifitas)
	{
		//get user from session

		$email_user 	= "";
		if ($this->CI->session->userdata('email') != null) {
			$email_user =  $this->CI->session->userdata('email');
		}


		//get datetime
		$waktu_log 	= date('Y-m-d H:i:s');

		//get ip address
		$iplog = $this->CI->input->ip_address();

		//get browser and OS
		//$browser = get_browser(null, true);
		$user_os    = $this->CI->agent->platform();
		$ua 		= $this->CI->agent->browser() . " (" . $this->CI->agent->version() . ")";

		$infobrowser = "using " . $ua . " in " . $user_os . " (OS)";

		//simpan log
		$save = $this->CI->db->query("insert into wbbm.wbbm.logs(waktulog,email,iplog,systlog,infolog)
										values ('$waktu_log','$email_user','$iplog','$infobrowser','$aktifitas')");
	}
}
