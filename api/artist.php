<?php
/**
 * Stores all api calls about artist
 * @package api
 * @Author Antonio Trigiani
 * Mail:info@webprojectsolution.com | info@zivagoo.com
 * Web:http://iblog.webprojectsolution.com | http://www.zivagoo.com
 * Twitter:http://twitter.com/al0ha
 * @2010 v.0.2
**/

class mxmApiArtist extends mxmApi {
 	public $config;
 	private $auth;
 	function __construct($auth,  $config) {
		$this->auth = $auth;
		$this->config = $config;
	}
	
 
 	public function artist_Get($methodVars) {
 		if ( (!empty($methodVars['artist_id'])) || (!empty($methodVars['artist_mbid'])) ) {
		$vars = array(
			'artist.get?' => '',
	 		'format' => 'xml'
		);
		$vars = array_merge($vars, $methodVars);
		if ( $call = $this->api_GetRequest($vars) ) {
			$info['artist_name'] = (string) $call->message->body->artist->artist_name;
			$info['artist_mbid'] = (string) $call->message->body->artist->mbid;
			$info['artist_id'] = (string) $call->message->body->artist->id;
			return $info;
		}
		else {
			return false;
		}
		}
		else {
					$this->handleError(90, 'This artist was not found');
					return false;
		}
	}
	

 	public function chart_Get($methodVars) {
		// Check for required variables
 			$vars = array(
				'artist.chart.get?' => '',
 				'format' => 'json'
			);
			$vars = array_merge($vars, $methodVars);
			
			if ( $call = $this->api_GetRequest($vars) ) {
				if ( count($call->message->body->artist_list) > 0 ) {
//					print_r($call->message->body->artist_list);
					$i = 0;
					foreach ( $call->message->body->artist_list as $artist ) {
						$chart[$i]['artist_name'] = (string) $artist->artist->artist_name;
						$chart[$i]['artist_mbid'] = (string) $artist->artist->artist_mbid;
						$chart[$i]['artist_id'] = (string) $artist->artist->artist_id;
						$i++;
					}
					return $chart;
				}
				else {
					$this->handleError(90, 'This chart has no artists');
					return FALSE;
				}
			}
			else {
				return FALSE;
			}
 
	}
 
	public function artist_Search($methodVars) {
 		if ( (!empty($methodVars['q_track'])) || (!empty($methodVars['q_artist'])) || (!empty($methodVars['q_lyrics'])) || (!empty($methodVars['q'])) ) {
			$vars = array(
			'artist.search?' => '',
	 		'format' => 'json'
			);
			$vars = array_merge($vars, $methodVars);
			if ( $call = $this->api_GetRequest($vars) ) {
//			print_r($call);
				if ( count($call->message->body->artist_list) > 0 ) {
				$i = 0;
					foreach ( $call->message->body->artist_list as $artist ) {
						$search[$i]['artist_name'] = (string) $artist->artist->artist_name;
						$search[$i]['artist_mbid'] = (string) $artist->artist->artist_mbid;
						$search[$i]['artist_id'] = (string) $artist->artist->artist_id;
						$i++;
					}
					return $search;
				}
				else {
					$this->handleError(90, 'This artist was not found');
					return false;
				}
			}
			else {
				return false;
			}
   		}
	} 

}
?>