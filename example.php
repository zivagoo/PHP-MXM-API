<?php
/**
 * Stores all api calls about artist
 * @package api
 * @Author Antonio Trigiani
 * Mail:info@webprojectsolution.com | info@zivagoo.com
 * Web:http://iblog.webprojectsolution.com | http://www.zivagoo.com
 * Twitter:http://twitter.com/al0ha
 * @2010 v.0.2
#example results:
# Array
# (
#    [0] => Array
#       (
#            [artist_name] => U2
#            [artist_mbid] => a3cb23fc-acd3-4ce0-8f36-1e5aa6a18432
#            [artist_id] => 121
#        )
#
#    [1] => Array
#        (
#            [artist_name] => U2
#            [artist_mbid] => 704acdbb-1415-4782-b0b6-0596b8c55e46
#            [artist_id] => 391650
#       )
# )
# NOTE: param $config could be false or true. It is not used in this version of mxm php api.
 **/
require ('mxmapi.php');
$authVars = array(	'apikey' => 'YOUR_MXM_API_KEY');
$config = array('enabled' => false,	'path' => 'api/mxmapi/');
$apiClass = new mxmApi();
$artistClass = $apiClass->getPackage($authVars, $config);
$methodVars = array('q_artist' => 'U2');
$methodVars = array_merge($methodVars,$authVars);
$artistClass = new mxmApiArtist($authVars, $config);
if ( $artist = $artistClass->artist_Search($methodVars) ) {
	echo '<b>Results</b>';
	echo '<pre>';
	print_r($artist);
	echo '</pre>';
}
else {
	die('<b>Error '.$artistClass->error['code'].' - </b><i>'.$artistClass->error['desc'].'</i>');
}
 
$trackClass = new mxmApiTrack($auth, $config);
if ( $track = $trackClass->track_Search($methodVars) ) {
	echo '<b>Results</b>';
	echo '<pre>';
	print_r($track);
	echo '</pre>';
}
else {
	die('<b>Error '.$trackClass->error['code'].' - </b><i>'.$trackClass->error['desc'].'</i>');
}
 
$methodVars = array('country' => 'IT','page_size' => '8','page' => '1');
$methodVars = array_merge($methodVars,$authVars);
$trackClass = new mxmApiTrack($auth, 'track', $config);
if ( $chart = $trackClass->chart_Get($methodVars) ) {
	echo '<b>Results</b>';
	echo '<pre>';
	print_r($chart);
	echo '</pre>';
}
else {
	die('<b>Error '.$trackClass->error['code'].' - </b><i>'.$trackClass->error['desc'].'</i>');
}
 

exit();
?>