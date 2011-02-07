<?php
/**
 * Stores all api calls about tracks 
 * @package api
 * @Author Antonio Trigiani
 * Mail:info@webprojectsolution.com | info@zivagoo.com
 * Twitter:http://twitter.com/al0ha
 * @2010 v.0.2
**/


class mxmApiTrack extends mxmApi {
	/**
	 * Stores the config values set in the call
	 * @access public
	 * @var array
	 */
	public $config;
	/**
	 * Stores the auth variables used in all api calls
	 * @access private
	 * @var array
	 */
	private $auth;

	
	private $okAuth;
 
	function __construct($auth, $config) {
		$this->auth = $auth;
  		$this->config = $config;
	}
	
 
 
	public function track_Get($methodVars) {
		$vars = array(
			'track.get?' => '',
			'apikey' => $this->apikey,
			'format' => 'json'
		);
		$vars = array_merge($vars, $methodVars);
		if ( !empty($methodVars['track_id']) || !empty($methodVars['track_mbid']) || !empty($methodVars['track_echonest_id']) ) {
	
			if ( $call = $this->api_GetRequest($vars) ) {
 
				$info['track_id'] = (string) $call->message->body->track->track_id;
				$info['track_name'] = (string) $call->message->body->track->track_name;
				$info['track_mbid'] = (string) $call->message->body->track->track_mbid;
				$info['lyrics_id'] = (string) $call->message->body->track->lyrics_id;
				$info['subtitle_id'] = (string) $call->message->body->track->subtitle_id;
				$info['artist_name'] = (string) $call->message->body->track->artist_name;
				$info['artist_mbid']= (string) $call->message->body->track->artist_mbid;
				$info['artist_id'] = (string) $call->message->body->track->artist_id;
				$info['album_coverart_100x100'] = (string) $track->track->album_coverart_100x100;
				return $info;
			}
			else {
				return FALSE;
				$this->handleError(91, 'Track was not found :P ');
			}
		}
		else {
			$this->handleError(90, 'Some params were missed. At least a track id or mbid or echonest is required :P ');
			return FALSE;
		}
		
	}
 
	public function chart_Get($methodVars) {
		// Check for required variables
 			$vars = array(
				'track.chart.get?' => '',
 				'format' => 'json'
			);
			$vars = array_merge($vars, $methodVars);
			
			if ( $call = $this->api_GetRequest($vars) ) {
				if ( count($call->message->body->track_list) > 0 ) {
					$i = 0;
					foreach ( $call->message->body->track_list as $track ) {
						$chart[$i]['track_id'] = (string) $track->track->track_id;
						$chart[$i]['track_name'] = (string) $track->track->track_name;
						$chart[$i]['track_mbid'] = (string) $track->track->track_mbid;
						$chart[$i]['lyrics_id'] = (string) $track->track->lyrics_id;
						$chart[$i]['subtitle_id'] = (string) $track->track->subtitle_id;
						$chart[$i]['artist_name'] = (string) $track->track->artist_name;
						$chart[$i]['artist_mbid'] = (string) $track->track->artist_mbid;
						$chart[$i]['artist_id'] = (string) $track->track->artist_id;
						$chart[$i]['album_coverart_100x100'] = (string) $track->track->album_coverart_100x100;

						$i++;
					}
					return $chart;
				}
				else {
					$this->handleError(90, 'This track has no chart tracks');
					return FALSE;
				}
			}
			else {
				return FALSE;
			}
 
	}
	
	public function track_Lyrics_Get($methodVars) {
		// Check for required variables
 			$vars = array(
				'track.lyrics.get?' => '',
 				'format' => 'json'
			);
			$vars = array_merge($vars, $methodVars);
						
		if ( !empty($methodVars['track_id']) || !empty($methodVars['track_mbid']) || !empty($methodVars['track_echonest_id']) ) {
 			if ( $call = $this->api_GetRequest($vars) ) {
 				$lyrics['lyrics_id'] = (string) $call->message->body->lyrics->lyrics_id;
				$lyrics['lyrics_body'] = (string) $call->message->body->lyrics->lyrics_body;
				$lyrics['lyrics_language'] = (string) $call->message->body->lyrics->lyrics_language;
				$lyrics['script_tracking_url'] = (string) $call->message->body->lyrics->script_tracking_url;
				return $lyrics;
			}
			else {
				return FALSE;
				$this->handleError(91, 'Lyrics was not found :P ');
			}
		}
		else {
			$this->handleError(90, 'Some params were missed. At least a track id or mbid or echonest is required :P ');
			return FALSE;
		}
 
	}
	
 
 

 
 
	public function track_Search($methodVars) {
		// Check for required variables
		if ( !empty($methodVars['q_track']) || !empty($methodVars['q_artist']) || !empty($methodVars['q_lyrics']) || !empty($methodVars['q']) ) {
			$vars = array(
				'track.search?' => '',
				'format' => 'json'
			);
			$vars = array_merge($vars, $methodVars);
		if ( $call = $this->api_GetRequest($vars) ) {
				if ( count($call->message->body->track_list) > 0 ) {
					$i = 0;$search="";
					foreach ( $call->message->body->track_list as $track ) {
						$search[$i]['track_id'] = (string) $track->track->track_id;
						$search[$i]['track_name'] = (string) $track->track->track_name;
						$search[$i]['track_mbid'] = (string) $track->track->track_mbid;
						$search[$i]['lyrics_id'] = (string) $track->track->lyrics_id;
						$search[$i]['subtitle_id'] = (string) $track->track->subtitle_id;
						$search[$i]['artist_name'] = (string) $track->track->artist_name;
						$search[$i]['artist_mbid'] = (string) $track->track->artist_mbid;
						$search[$i]['artist_id'] = (string) $track->track->artist_id;
						$search[$i]['album_coverart_100x100'] = (string) $track->track->album_coverart_100x100;
						$i++;
					}
					return $search;
				}
				else {
					$this->handleError(90, 'This track was not found');
					return FALSE;
				}
			}
			else {
				return FALSE;
			}
 		}
	}
 
}

?>