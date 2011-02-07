<?php
/**
 * Stores all methods used by the api calls 
 * @package api
 * @Author Antonio Trigiani
 * Mail:info@webprojectsolution.com | info@zivagoo.com
 * Twitter:http://twitter.com/al0ha
 * @2010 v.0.0.1
**/

class mxmApi {
 
	public $error;
 
	public $connected;
	
 
	private $port;
 
	private $response;
 
 
	protected function api_GetRequest($vars) {
 
					// Cache doesnt exist
					$url = 'http://api.musixmatch.com/ws/1.1/';
					foreach ( $vars as $name => $value ) {
						if (($value == '')&&($name != "")) { $url .= $name;}
						else {$url .= trim(urlencode($name)).'='.trim(urlencode($value)).'&';}
					}
					$url = substr($url, 0, -1);
					$url = str_replace(' ', '%20', $url); 
	 				$this->response = @file_get_contents($url);
					$this->response = json_decode($this->response);
					if (($this->response->message->header->status_code) == '200'){$this->connected = 1;	}
					else {echo $this->response->message->header->status_code;} 

				return $this->response;				
	}
	
 
	protected function handleError($error = '', $customDesc = '') {
		if ( !empty($error) && is_object($error) ) {
			// Fail with error code
			$this->error['code'] = $error['code'];
			$this->error['desc'] = $error;
		}
		elseif( !empty($error) && is_numeric($error) ) {
			// Fail with custom error code
			$this->error['code'] = $error;
			$this->error['desc'] = $customDesc;
		}
		else {
			//Hard failure
			$this->error['code'] = 0;
			$this->error['desc'] = 'Unknown error';
		}
	}
	
 
 
	public function getPackage($auth, $package, $config = '') {
		if ( $config == '' ) {
			$config = array(
				'enabled' => false
			);
		}
		
		if ( is_object($auth) ) {
			if ( !empty($auth->apikey)    ) {
				$okAuth = 1;
			}
 
			else {
				$this->handleError(91, 'You need to have at least an apikey set');
				return FALSE;
			}
		}
		else {
			$this->handleError(91, 'Pass a mxmApiAuth class as the first variable to this class');
			return FALSE;
		}
		
		if ( $package == 'track' || $package == 'artist'  ) {
			$className = 'mxmApi'.ucfirst($package);
			return new $className($auth, $okAuth, $config);
		}
		else {
			$this->handleError(91, 'Package name passed was invalid');
			return FALSE;
		}
	}
}

?>