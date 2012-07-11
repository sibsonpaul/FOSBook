<?php

class changeLog {
	
	
	public function __construct($ID){
		
	
	
		
}


public function insertLog($data){
	
	if (!$data){
		
	}
	else {
	
	global $wpdb;
	
	
	$current_user = wp_get_current_user();
	$userId = $current_user->ID;	
	$username = $current_user->user_firstname." ".$current_user->user_lastname;
	$ipaddress = $this->getvisitordetails();
	$browser =$this->getBrowser();
	$log = $wpdb->insert('wp_log', array(
	'userid'=> $userId, 
	'ip' => $ipaddress, 
	'browser'=> $browser, 
	'table' => $data['table'], 
	'oldvalue' => $data['oldvalue'], 
	'newvalue' => $data['newvalue'],
	'username' =>$username,
	'personname' => $data['name']
	));
	
	
		
	}
	
}

public function getvisitordetails(){
	
 if (getenv(HTTP_X_FORWARDED_FOR)) {
        $ip_address = getenv(HTTP_X_FORWARDED_FOR);
    } else {
        $ip_address = getenv(REMOTE_ADDR);
    }
	
	return $ip_address;
	
}

public function getBrowser(){

global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

if($is_lynx) $browser = 'lynx';
elseif($is_gecko) $browser = 'gecko';
elseif($is_opera) $browser = 'opera';
elseif($is_NS4) $browser = 'ns4';
elseif($is_safari) $browser = 'safari';
elseif($is_chrome) $browser = 'chrome';
elseif($is_IE) $browser = 'ie';
else $browser = 'unknown';
if($is_iphone) $browser = 'iphone';


return $browser;
	
}

}



?>