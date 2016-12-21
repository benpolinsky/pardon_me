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
	
	public function get_campaigns(){
		# this can be abstracted -> grabbing the user and api key and transforming to qparams
		# in fact, the whole act can be
		$this->authenticate(); #eventually we need to store and cache etc

		$params = [
			'user_key' => $this->get_user_key(),
			'api_key' => $this->api_key,
		];
		
		$query_params = http_build_query($params);
		$response = wp_remote_get("https://pi.pardot.com/api/campaign/version/3/do/query?$query_params");
		$xml = $this->to_xml($response);
		return $xml->result;
	}
	
	public function get_competitors(){
		$this->authenticate(); #eventually we need to store and cache etc

		$params = [
			'user_key' => $this->get_user_key(),
			'api_key' => $this->api_key,
			'type' => 'Competitor'
		];
		
		$query_params = http_build_query($params);
		$response = wp_remote_get("https://pi.pardot.com/api/tagObject/version/3/do/query?$query_params");
		$xml = $this->to_xml($response);
		print_r($xml);
		return $xml->result;
	}
	
	public function current_visitor_id($cookies=null){
		
		$visitor_entry = $this->preg_grep_keys("/^visitor_id/i", $_COOKIE);
		$visitor_id = reset($visitor_entry);
		return trim($visitor_id);
	}
	
	public function has_filled_out_form($formName='Test Form Handler'){
		$this->authenticate(); #eventually we need to store and cache and expire
		
		$visitor_id = $this->current_visitor_id();
		
		$params = [
			'api_key' => reset($this->api_key),
			'user_key' => $this->get_user_key()
		];
		
		$query_params = http_build_query($params);
		$response = wp_remote_get("https://pi.pardot.com/api/visitor/version/3/do/read/id/$visitor_id?$query_params");
		$xml = $this->to_xml($response);
		
		echo('<pre>');
		print_r($xml);
		echo('</pre>');
		return $xml->result;
	}

	public function to_xml($response){
		$body = wp_remote_retrieve_body($response);
		$xml = new SimpleXMLElement($body);
		return $xml;
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
			$xml = $this->to_xml($response);
			$key = $xml->api_key; 
			$this->set_api_key($key);
		}
	}
	
	private function preg_grep_keys($pattern, $input, $flags = 0) {
    return array_intersect_key($input, array_flip(preg_grep($pattern, array_keys($input), $flags)));
	}

}



?>