<?php

/**
* PardonMeAPI is, right now, a lil wrapper around an api
* Initialize with username, email, and userkey
* User Key: 
* APIENDPOINT: 
*/
	
class PardonMeAPI {
	private $api_address = 'https://pi.pardot.com/api/login/version/3';
	private $email = '';
	private $password = '';
	private $user_key = '';
	private $api_key = '';
	
	function __construct($inpemail, $inppassword, $inpkey){
		$this->set_user_key($inpkey);
		$this->set_email($inpemail);
		$this->set_password($inppassword);
	}
	
	public function set_user_key($new_key){
		$this->user_key = $new_key;
	}
	
	public function get_user_key(){
		return $this->user_key;
	}
	
	public function set_password($new_password){
		$this->password = $new_password;
	}
	
	public function get_password(){
		return $this->password;
	}
	
	public function set_email($new_email){
		$this->email = $new_email;
	}
	
	public function get_email(){
		return $this->email;
	}
	
	public function set_api_key($new_key){
		$this->api_key = $new_key;
	}
	
	public function get_response(){
		# wp_remote_post();
	}
	
	public function data(){
		$response = $this->raw_response();
		$body = wp_remote_retrieve_body($response);
		$data = json_decode($body, true)['data'];
		return $data;
	}
	
	private function raw_response(){
		$response = wp_remote_get($this->api_address);
		return $response;
	}
	
	public function authenticate(){
		$body_params = [
			'email' => $this->get_email(),
			'password' => $this->get_password(),
			'user_key' => $this->get_user_key()
		];

		$response = wp_remote_post($this->api_address, ['body' => $body_params]);
		
		# TODO: Error checking
		if ($response['body']) {
			$this->set_api_key($response['body']);
		}

	}

}



?>