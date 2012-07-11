<?php // XMLRPC functionality for posting to a remote blog.

include_once(ABSPATH . WPINC . '/class-IXR.php'); /* not included in wp-settings */
include_once(ABSPATH . WPINC . '/class-wp-http-ixr-client.php'); /* not included in wp-settings */
 

class sibson_xmlrpc {
 
	private $blog_url = '';
	private $remote_login = 'pauls';
	private $remote_passwd = '197854_Ps';
	private $remote_server = 'remote_blog'; // shortname used in custom field
 
	private $currentrequest = null;
	private $currentdate = true; // option to update target/remote date with now !
 	private $content ="";
 
 	public function __construct($url){
		
		
		
		$this->blog_url= $url;
		$this->content = $content;
		$current_user = wp_get_current_user();	
		$userId = $current_user->ID;
		$this->remote_login = $current_user->user_login;
		$this->remote_passwd = get_user_meta($userId, 'remote_blog_pass', true);
		
		add_action( 'publish_post', array( &$this,'send_post_to') );
		
	}

	/**
	 * function fired when a post is published
	 *
	 * @param post ID
	 *
	 */
	function send_post_to ( $post_id ) {
 
		$to_post_id = get_post_meta ( $post_id , $this->remote_server, true );
 
		$this -> create_remote_categories_if ( $post_id );
 
		if ( $to_post_id > 0 ) { // mise à jour
			$remote_id = $this->edit_post_to ( $post_id ); /* not used now */
 
		} else {
			$guids = $this->send_attachments ( $post_id );
			$remote_id = $this->new_post_to ( $post_id ) ;
			if ( $remote_id ) {
			 		update_post_meta ( $post_id , $this->remote_server, $this->currentrequest ) ;
			}
			// update content after changing attachment url
			if ( $guids ) {	
				//error_log ( '- array -');
				$remote_id = $this->edit_post_to ( $post_id, $guids ); // create attachments link to parent in remote
			}
			// get attached medias
			$medias = $this->get_attached_medias ( $post_id , 'image') ;
			$remote_images = array();
			if ( $medias ) { //print_r( $medias );
				// create remote links of medias images
				foreach ( $medias as $oneimage ) {
					$remote_images[] = array ( 
					'link' => $oneimage['link'], 
					'file' => $oneimage['metadata']['file'], 
					'thumbnail' => array ( 'link' => $oneimage['thumbnail'], 
											'file' => $oneimage['metadata']['sizes']['thumbnail']['file'] ), 
					'medium' => array ('file' => $oneimage['metadata']['sizes']['medium']['file'] ), 
					'post-thumbnail' => array('file' => $oneimage['metadata']['sizes']['post-thumbnail']['file'] )   
					);
				}
				// synchronize 
				$search = array(); //local remaining link
				$replace = array();
				foreach ( $guids as $one_id => $one_attachment ) {
 
					foreach ( $remote_images as $oneimage ) {
						if ( $one_attachment['remote'] == $oneimage['link'] ) { //error_log ( '----> '.$oneimage['link'] );
							$remote_folder = str_replace ($oneimage['thumbnail']['file'], "", $oneimage['thumbnail']['link'] );
 
							$replace[] = $remote_folder.$oneimage['medium']['file']; //error_log ( '---med replace-> '.$remote_folder.$oneimage['medium']['file'] );
							$src_m = wp_get_attachment_image_src($one_id, 'medium');
							$search[] = $src_m[0]; // error_log ( '---med search-> '.$src_m[0] );
							$replace[] = $oneimage['thumbnail']['link'];
							$src = wp_get_attachment_image_src($one_id, 'thumbnail');  
							$search[] = $src[0];
						}
					}	
				}
				if ( $replace ) {	
				    // error_log ( '- array replace -');
					$remote_id = $this->edit_post_to ( $post_id, $guids, array ('search' => $search, 'replace' => $replace) );
				}
			}
 
		}
		// send the attachments
 
	}
	
/**
	 * Create a new remote post from a local one
	 *
	 * @param local post ID
	 *
	 */
	function new_post_to ( $post_id ) {
 
		$rpc = new WP_HTTP_IXR_Client( $this->blog_url );
		$original_post = & get_post ($id = $post_id);
		
	
		$post = array(
		    'title' => $original_post->post_title,
		    'categories' => wp_get_object_terms($post_id, 'category', array('fields'=>'names') ),
		    'mt_keywords' => wp_get_object_terms($post_id, 'post_tag', array('fields'=>'names') ),
		    'description' => $original_post->post_content,
		    'wp_slug' => $original_post->post_name
		);
 
		$params = array(
		    0,
		    $this->remote_login,
		    $this->remote_passwd,
		    $post,
		    'publish'
		);
 
		$status = $rpc->query(
			'metaWeblog.newPost',
			$params	
		);
 
		$this->currentrequest = $rpc->getResponse(); 
		return $status; // ID or false
	}
	/**
	 * edit the local post clone content before to edit the remote one
	 *
	 * @param local ID
	 * @param guids of local images or attachments
	 * @param array of local - remote src or url inside content to proceed search and replace
	 */
	function edit_post_to ( $post_id , $guids = array(), $search_replace = array() ) {
 
		$rpc = new WP_HTTP_IXR_Client( $this->blog_url );
		$original_post = & get_post ($id = $post_id);
 
		if ( $guids ) {
			$post_content = $original_post->post_content ;
			foreach ( $guids as $one_id => $one ) {
				$post_content = str_replace ( $one['local'], $one['remote'], $post_content );
			}
			if ( isset( $search_replace ['search']) ) 
				$post_content = str_replace ($search_replace ['search'], $search_replace ['replace'], $post_content);
 
		} else {
			$post_content = $original_post->post_content ;
		}
 
		$post = array(
		    'title' => $original_post->post_title,
		    'categories' => wp_get_object_terms($post_id, 'category', array('fields'=>'names') ),
		    'mt_keywords' => wp_get_object_terms($post_id, 'post_tag', array('fields'=>'names') ),
		    'description' => $post_content,
		    'wp_slug' => $original_post->post_name
		);
 
		if ( $this->currentdate ) {
			$newDate = new IXR_Date(strtotime('now'));
			$post['dateCreated'] =  $newDate;
		}
 
		$to_post_id = get_post_meta ( $post_id , $this->remote_server, true );
 
		if ( $to_post_id > 0 ) {
			$params = array(
		    	$to_post_id,
		    	$this->remote_login,
		    	$this->remote_passwd,
		    	$post,
		    	'publish'
			);
 
			$status = $rpc->query(
				'metaWeblog.editPost',
				$params	
			);
 
		/*
		if(!$status) {
		    echo 'Error [' . $rpc->getErrorCode() . ']: ' . $rpc->getErrorMessage();
		    exit();
		}
		*/
			$request = $rpc->getResponse(); 
 
			return $status; // ID or false
 
		} else {
 
			return false ;
		}
	}
	/** 
	 * create a remote attachment
	 * use metaWeblog.newMediaObject
	 */
	function send_attachments ( $post_id ) {
 
		// get_attachments
		$attachments = & get_children( array(
			'post_parent' => $post_id,
    		'post_type'   => 'attachment',
			) 
		);
		if ( $attachments != array() ) {
 
			$rpc = new WP_HTTP_IXR_Client( $this->blog_url );
			$to_post_id = get_post_meta ( $post_id , $this->remote_server, true );
			// 
			$guids = array();
			foreach ( $attachments as $attachment_id => $attachment ) {
 
 
 
				$params = array(
						0,
				    	$this->remote_login,
				    	$this->remote_passwd,
				    	array( 
				    		'name' => basename( get_attached_file( $attachment_id ) ), //$attachment->post_title,
							'type' => $attachment->post_mime_type,
							'bits' => new IXR_Base64 ( file_get_contents ( get_attached_file( $attachment_id ) ) )  // get_attached_file( $attachment_id)
						)
					);
 
				//error_log ('***'.$params[3]['bits']->getXml() );
				$status = $rpc->query(
						'metaWeblog.newMediaObject',
						$params	
					);
				if(!$status) {
		    			error_log ( 'Error [' . $rpc->getErrorCode() . ']: ' . $rpc->getErrorMessage() );
					}	
				if ( $status ) {
 
					$request = $rpc->getResponse(); //error_log( print_r( $request ) );
					$guids[$attachment_id] = array( 'local' => $attachment->guid, 'remote' => $request['url'] );
						error_log ( $request['url'] );
 
 
					/*
 
					*/
				}
 
			}
 
			return $guids;
		}	
 
		return array();	
	}
	/**
	 * get attached medias
	 *
	 *
	 *
	 */
	function get_attached_medias ( $post_id = 0, $mime_type = '' ) {
 
		$rpc = new WP_HTTP_IXR_Client( $this->blog_url );
		$remote_post_id = get_post_meta ( $post_id , $this->remote_server, true );
 
		// get recent
		$params = array(
			0,
	    	$this->remote_login,
	    	$this->remote_passwd,
	    	array(
	    	'mime_type' => $mime_type,
	    	'parent_id' => $remote_post_id
		)
		);
 
		$status = $rpc->query(
			'wp.getMediaLibrary',
			$params	
		);
		if ( $status ) {
			$requestattach = $rpc->getResponse(); //print_r($requestattach);
 
			return $requestattach ;
			//$guids[$attachment_id] = array( 'local' => $attachment->guid, 'remote' => $requestattach[0]['link'] );
			error_log ( $requestattach[0]['link'] );
		}
		if(!$status) {
   			error_log ( 'Error [' . $rpc->getErrorCode() . ']: ' . $rpc->getErrorMessage() );
		}
		return array();
	}
	/** 
	 * If remote category don't exist, create it
	 *
	 */
	function create_remote_categories_if ( $post_id ) {
 
		$thecats = wp_get_object_terms($post_id, 'category', array('fields'=>'names') ) ;
 
		$rpc = new WP_HTTP_IXR_Client( $this->blog_url );
 
		$params = array(
				0,
		    	$this->remote_login,
		    	$this->remote_passwd
			);
 
		$status = $rpc->query(
				'metaWeblog.getCategories',
				$params	
			);
		if ( $status ) {
 
			$request = $rpc->getResponse();
 
			//print_r( $request );
 
			$remotecatsnames = array();
			foreach ( $request as $remotecategory ) {
 
				$remotecatsnames[] =  $remotecategory ['categoryName'] ;
			}
 
			foreach ( $thecats as $onecatname ) { // error_log ( $onecatname ) ;
 
				if ( !in_array ( $onecatname,  $remotecatsnames ) ) { //error_log ( $onecatname ) ;
					$params = array(
						0,
		    			$this->remote_login,
		    			$this->remote_passwd,
		    			array("name" => $onecatname)
					);
 
					$status = $rpc->query(
						'wp.newCategory',
						$params	
					);
					if(!$status) {
		    			error_log ( 'Error [' . $rpc->getErrorCode() . ']: ' . $rpc->getErrorMessage() );
					}
					if ( $status )  error_log ( $onecatname ) ;
 
				}
			}
		}
	}
	
	/**
	 * get_post from remote with his remote ID
	 *
	 */
	function get_post_from ( $post_id ) { // 
 
		$rpc = new WP_HTTP_IXR_Client( $this->blog_url );
 
		$params = array(
		    $post_id,
		    $this->remote_login,
		    $this->remote_passwd,
		);
 
		$status = $rpc->query(
			'metaWeblog.getPost',
			$params		
		);
 
		if(!$status) {
		    //echo 'Error [' . $rpc->getErrorCode() . ']: ' . $rpc->getErrorMessage();
		    //exit();
		    return false;
		} else {
			$request = $rpc->getResponse();
			return $request ;
		}
		//print_r($request);
	}
 
} // end class