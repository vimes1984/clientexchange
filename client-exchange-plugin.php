<?php
/**
 * Client Exchange plugin
 *
 * Extends wordpress for Client exchanes needs
 *
 * @package   client-exchange-plugin
 * @author    C.J.Churchill <churchill.c.j@gmail.com>
 * @license   GPL-2.0+
 * @link      http://buildawebdoctor.com
 * @copyright 7-13-2014 BAWD
 *
 * @wordpress-plugin
 * Plugin Name: Client Exchange plugin
 * Plugin URI:  http://buildawebdoctor.com
 * Description: Extends wordpress for Client exchanes needs
 * Version:     1.0.0
 * Author:      C.J.Churchill
 * Author URI:  http://buildawebdoctor.com
 * Text Domain: client-exchange-plugin-locale
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if (!defined("WPINC")) {
	die;
}

require_once(plugin_dir_path(__FILE__) . "ClientExchangePlugin.php");

// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
register_activation_hook(__FILE__, array("ClientExchangePlugin", "activate"));
register_deactivation_hook(__FILE__, array("ClientExchangePlugin", "deactivate"));

ClientExchangePlugin::get_instance();

/*
Global AJax functions
*/

/**
 * 
 */
add_action('wp_ajax_nopriv_watch_add', 'watch_add_callback');
add_action( 'wp_ajax_watch_add', 'watch_add_callback' );
function watch_add_callback() {
global $wpdb;
	$request_body = file_get_contents('php://input');
	$decodeit = json_decode( $request_body );
	$userID = $decodeit->userID;
	$watching = $decodeit->watching;
	$checkresults = $wpdb->get_results( "SELECT ID FROM wp_watchlist WHERE watching = $watching AND userID = $userID" );

	if(count($checkresults) === 0 ){

		$wpdb->replace( 'wp_watchlist', array( 'userID' => $userID, 'watching' => $watching ) );
	
	}
	die(); // this is required to return a proper result
}
/**
 * 
 */
add_action('wp_ajax_nopriv_watch_remove', 'watch_remove_callback');
add_action( 'wp_ajax_watch_remove', 'watch_remove_callback' );
function watch_remove_callback() {
	global $wpdb;
	$request_body = file_get_contents('php://input');
	$decodeit = json_decode( $request_body );
	$userID = intval( $decodeit->userID );
	$watching = intval( $decodeit->watching );
	$checkresults = $wpdb->get_results( "SELECT ID FROM wp_watchlist WHERE watching = $watching AND userID = $userID" );
	if(count($checkresults) === 1 ){
		$wpdb->delete( 'wp_watchlist', array( 'userID' => $userID, 'watching' => $watching ) );	
	}
	die(); // this is required to return a proper result
}
/**
 * 
 */
add_action('wp_ajax_nopriv_tab_select_deallloop', 'tab_select_deallloop_callback');
add_action( 'wp_ajax_tab_select_deallloop', 'tab_select_deallloop_callback' );
function tab_select_deallloop_callback() {
	global $wpdb;
	
	$request_body = file_get_contents('php://input');
	$decodeit = json_decode( $request_body );
	$tab = $decodeit->tab;
	$user_ID = get_current_user_id(); 
	$i = 0;
	$res = array();
	$rd_args_buyer = array( 'post_type'=>'deals', 'meta_query' => array( array( 'key' => 'wpcf-buyer-id', 'value' => $user_ID ), ), );
	$rd_args_seller = array( 'post_type'=>'deals', 'meta_query' => array( array( 'key' => 'wpcf-seller-id', 'value' => $user_ID ), ), );
	#Buyer query to retive the deal id's
	$query_buyer = new WP_Query( $rd_args_buyer );
	while ($query_buyer->have_posts()) : $query_buyer->the_post();
		$i ++;
		$postmeta = get_post_meta( $query_buyer->post->ID );
		$res[$i]['id'] = $postmeta['wpcf-deal-id'][0];
		$res[$i]['post'] = $query_buyer->post;
		$res[$i]['postmeta'] = $postmeta;
		$res[$i]['sellerlisting'] = false;
	endwhile;

	#Seller query to retive the deal id's
	$query_seller = new WP_Query( $rd_args_seller );
	while ($query_seller->have_posts()) : $query_seller->the_post();
		$i ++;
		$postmeta = get_post_meta( $query_seller->post->ID );
		$res[$i]['id'] = $postmeta['wpcf-deal-id'][0];
		$res[$i]['post'] = $query_buyer->post;
		$res[$i]['postmeta'] = $postmeta;
		$res[$i]['sellerlisting'] = true;
	endwhile;
	#Call to escrow
	$keynumb = 0;
	foreach ($res as $key => $value) {
		$data = array('');
		$transid = $value['id'];
		$data_string = json_encode($data);                                                                                   			 
		$ch = curl_init("https://stgsecureapi.escrow.com/api/Transaction/$transid");
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',
			'Authorization: Basic Q2xpZW50RXhjaGFuZ2U6NWkzOTkwYTE=',                                                                            
		) );
		$result = curl_exec($ch);
		$reslutarray = json_decode($result);
		$reslutarray->sellerlisting = $value['sellerlisting'];
		$reslutarray->post = $value['post'];
		$reslutarray->post->meta = $value['postmeta'];
		foreach ($reslutarray as $keysub => $valuesub) {
			# code...
			if ($keysub == 'Status') {
				
					if($valuesub === 0){
						$reslutarray->dealstatus = 'Transaction Cancelled';
					}elseif ($valuesub ===  3) {
						$reslutarray->dealstatus = 'Cliented Exchange Started Transaction';
					}
					elseif ($valuesub ===  5) {
						$reslutarray->dealstatus = 'Buyer Accepted';
					}
					elseif ($valuesub ===  6) {
						$reslutarray->dealstatus = 'Buyer Agreed to Transaction';
					}
					elseif ($valuesub ===  9) {
						$reslutarray->dealstatus = 'Seller Agreed to Transaction';
					}
					elseif ($valuesub ===  10) {
						$reslutarray->dealstatus = 'Seller Accepted';
					}
					elseif ($valuesub === 15) {
						$reslutarray->dealstatus = 'Both parties accepted';
					}
					elseif ($valuesub === 20) {
						$reslutarray->dealstatus = 'Buyer paid Escrow.com (Payment type selected, funds not secure)';
					}
					elseif ($valuesub === 22) {
						$reslutarray->dealstatus = 'Buyer paid Escrow.com (Payment type selected, funds not secure)';
					}
					elseif ($valuesub === 25) {
						$reslutarray->dealstatus = 'Buyers funds secured by Escrow.com';
					}
					elseif ($valuesub === 30) {
						$reslutarray->dealstatus = 'Seller shipped merchandise';
					}
					elseif ($valuesub === 40) {
						$reslutarray->dealstatus = 'Buyer accepted merchandise';
					}
					elseif ($valuesub === 45) {
						$reslutarray->dealstatus = 'Buyer declined';
					}
					elseif ($valuesub === 50) {
						$reslutarray->dealstatus = 'Buyer shipped returned merchandise';
					}
					elseif ($valuesub === 55) {
						$reslutarray->dealstatus = 'Seller received merchandise';
					}
					elseif ($valuesub === 60) {
						$reslutarray->dealstatus = 'Seller accepted merchandise';
					}
					elseif ($valuesub === 75) {
						$reslutarray->dealstatus = 'Cancellation Pending';
					}
					elseif ($valuesub === 80) {
						$reslutarray->dealstatus = 'Transaction Closed. Buyer Accepts';
					}
					elseif ($valuesub === 85) {
						$reslutarray->dealstatus = 'Transaction Closed. Seller Accepts';
					}else{
						$reslutarray->dealstatus = 'Error Status';
					}							
			}
		}
			
		$resultsreturn[$keynumb] = $reslutarray;

		$keynumb ++;
	}
	$reslutarraylast = json_encode($resultsreturn);
	#Results to plugin!
	echo $reslutarraylast;
	//return $reslutarraylast;
	die(); // this is required to return a proper result
}
/**
 * 
 */
add_action('wp_ajax_nopriv_deal_details', 'deal_details_callback');
add_action( 'wp_ajax_deal_details', 'deal_details_callback' );
function deal_details_callback() {
	/*
		tab number two deal details traverses our 
		deals array returned from tab_select_deallloop_callback()
		and returns the one currently selected to view 
	*/
	$request_body = file_get_contents('php://input');
	$decodeit = json_decode( $request_body );
	$deals = $decodeit->deals;
	$currentdeal = $decodeit->dealID;
	$dealarray = array();

	foreach ($deals as $key => $value) {
		if ($currentdeal == $value->EscrowUniqueIdentifier) {
		  	$dealarray = $value;
		}

	}
	foreach ($dealarray->post->meta as $keysub => $valuesub) {
		$keysub = str_replace("-", "_", $keysub);
		$dealarray->post->meta->$keysub = $valuesub[0];
	
	}
	$reslutarraylast = json_encode($dealarray);
	#Results to plugin!
	echo $reslutarraylast;
	die(); // this is required to return a proper result
}
/**
 * 
 */
add_action('wp_ajax_nopriv_deal_Correspondence', 'deal_Correspondence_callback');
add_action( 'wp_ajax_deal_Correspondence', 'deal_Correspondence_callback' );
function deal_Correspondence_callback() {
	/*
		this returns the other user, the current deal, 
		and any messages that have that deal id sent from the current account...

	*/
	global $wpdb;
	$user_ID = get_current_user_id();
	$request_body = file_get_contents('php://input');
	$decodeit = json_decode( $request_body );
	$currentuser = $decodeit->currentuser;
	$currentdeal = $decodeit->currentdeal;
	$dealidcurrent = $currentdeal->EscrowUniqueIdentifier;
	$cleandata = array();
	if ($currentdeal->post->meta->wpcf_buyer_id == $currentuser) {
		$otheruserinfo = get_userdata( $currentdeal->post->meta->wpcf_seller_id );
	}else{
		$otheruserinfo = get_userdata( $currentdeal->post->meta->wpcf_buyer_id );
	}
	$onlydata = $otheruserinfo->data;

	foreach ($onlydata as $key => $value) {
		# code...
		if($key != 'user_pass' && $key != 'user_registered' && $key != 'user_activation_key'){
			$cleandata[$key] = $value; 
		}
	}

	$checkresults = $wpdb->get_results( "SELECT * FROM wp_bp_messages_messages WHERE dealid = $dealidcurrent AND sender_id = $currentuser" );

	$cleandata['messages'] = $checkresults;

	$reslutarraylast = json_encode($cleandata);
	#Results to plugin!
	echo $reslutarraylast;
	die(); // this is required to return a proper result
}
/**
 * 
 */
add_action('wp_ajax_nopriv_deal_stage', 'deal_stage_callback');
add_action( 'wp_ajax_deal_stage', 'deal_stage_callback' );
function deal_stage_callback() {
	global $wpdb;
	
	$request_body = file_get_contents('php://input');
	$decodeit = json_decode( $request_body );
	$tab = $decodeit->tab;
		echo "tab four";
	die(); // this is required to return a proper result
}
/**
 * 
 */
add_action('wp_ajax_nopriv_deal_Payment', 'deal_Payment_callback');
add_action( 'wp_ajax_deal_Payment', 'deal_Payment_callback' );
function deal_Payment_callback() {
	global $wpdb;
	
	$request_body = file_get_contents('php://input');
	$decodeit = json_decode( $request_body );
	$tab = $decodeit->tab;
		echo "tab five";
	die(); // this is required to return a proper result
}
/**
 * 
 */
add_action('wp_ajax_nopriv_deal_Files', 'deal_Files_callback');
add_action( 'wp_ajax_deal_Files', 'deal_Files_callback' );
function deal_Files_callback() {
	global $wpdb;
	
	$request_body = file_get_contents('php://input');
	$decodeit = json_decode( $request_body );
	$tab = $decodeit->tab;
		echo "tab seven";
	die(); // this is required to return a proper result
}
/**
 * 
 */
add_action('wp_ajax_nopriv_deal_Contacts', 'deal_Contacts_callback');
add_action( 'wp_ajax_deal_Contacts', 'deal_Contacts_callback' );
function deal_Contacts_callback() {
	global $wpdb;
	
	$request_body = file_get_contents('php://input');
	$decodeit = json_decode( $request_body );
	$tab = $decodeit->tab;
		echo "tab six";
	die(); // this is required to return a proper result
}
/**
 * 
 */
add_action('wp_ajax_nopriv_create_deal', 'create_deal_callback');
add_action( 'wp_ajax_create_deal', 'create_deal_callback' );
function create_deal_callback() {
	global $wpdb;
	$request_body = file_get_contents('php://input');
	$decodeit = json_decode( $request_body );
		//values from form
	$title   		= $decodeit->title;
	$description   	= $decodeit->description;
	$price   		= $decodeit->price;
	$listingID   		= $decodeit->listingID;
	//Buyer info
	$buyeremail   		= $decodeit->buyer_email;
	$buyerid 	  		= $decodeit->buyer_id;
	//Seller info
	$selleremail   		= $decodeit->seller_email;
	$sellerid    		= $decodeit->seller_id;

		/*
		Sale Price                               Commission to Client Exchange
		 
		$0-$49,999                                                  5.0%
		$50,000 - $99,999                                     4.5%                    
		$100,000 - $499,999                                4.0%

		$500,000 - $999,999                                3.5%
		 
		$1,000,000 - $1,999,999                         3.0%
		 
		$2,000,000 and above                            2.5%
		*/
	if($price < 49999){
		$BrkCommissionSellerPortion = ($price / 100) * 5;

	}elseif ($price > 49999 && $price < 99999) {
		$BrkCommissionSellerPortion = ($price / 100) * 4.5;

	}elseif ($price > 99999 && $price < 499999) {
		$BrkCommissionSellerPortion = ($price / 100) * 4;

	}elseif ($price > 499999 && $price < 999999) {
		$BrkCommissionSellerPortion = ($price / 100) * 3.5;

	}elseif ($price > 1000000 && $price < 1999999) {
		$BrkCommissionSellerPortion = ($price / 100) *  3;
	}elseif ($price > 2000000 ) {
		$BrkCommissionSellerPortion = ($price / 100) * 2.5;
	}else{
		$BrkCommissionSellerPortion = ($price / 100) * 5;
	}


	/*
		$post = array(
		  'ID'             => [ <post id> ] // Are you updating an existing post?
		  'post_content'   => [ <string> ] // The full text of the post.
		  'post_name'      => [ <string> ] // The name (slug) for your post
		  'post_title'     => [ <string> ] // The title of your post.
		  'post_status'    => [ 'draft' | 'publish' | 'pending'| 'future' | 'private' | custom registered status ] // Default 'draft'.
		  'post_type'      => [ 'post' | 'page' | 'link' | 'nav_menu_item' | custom post type ] // Default 'post'.
		  'post_author'    => [ <user ID> ] // The user ID number of the author. Default is the current user ID.
		  'ping_status'    => [ 'closed' | 'open' ] // Pingbacks or trackbacks allowed. Default is the option 'default_ping_status'.
		  'post_parent'    => [ <post ID> ] // Sets the parent of the new post, if any. Default 0.
		  'menu_order'     => [ <order> ] // If new post is a page, sets the order in which it should appear in supported menus. Default 0.
		  'to_ping'        => // Space or carriage return-separated list of URLs to ping. Default empty string.
		  'pinged'         => // Space or carriage return-separated list of URLs that have been pinged. Default empty string.
		  'post_password'  => [ <string> ] // Password for post, if any. Default empty string.
		  'guid'           => // Skip this and let Wordpress handle it, usually.
		  'post_content_filtered' => // Skip this and let Wordpress handle it, usually.
		  'post_excerpt'   => [ <string> ] // For all your post excerpt needs.
		  'post_date'      => [ Y-m-d H:i:s ] // The time post was made.
		  'post_date_gmt'  => [ Y-m-d H:i:s ] // The time post was made, in GMT.
		  'comment_status' => [ 'closed' | 'open' ] // Default is the option 'default_comment_status', or 'closed'.
		  'post_category'  => [ array(<category id>, ...) ] // Default empty.
		  'tags_input'     => [ '<tag>, <tag>, ...' | array ] // Default empty.
		  'tax_input'      => [ array( <taxonomy> => <array | string> ) ] // For custom taxonomies. Default empty.
		  'page_template'  => [ <string> ] // Requires name of template file, eg template.php. Default empty.
		); 
	*/


	$data = array(
		"Title" => "$title", 
		"Description" => "$description", 
		"TransactionType" => 1, 
		"Partner" => 
			array(
				"PartnerId" => '6901' 
			), 
		"Buyer" => 
			array(
				'Email' => 'buyer@accruemarketing.com',
				'Initiator' => false, 
				'CompanyChk' => false, 
				"AutoAgree" => false,
				"AgreementChecked" => false
			),
		"Seller" => 
			array(
				'Email' => 'seller@accruemarketing.com',
				'Initiator' => false, 
				'CompanyChk' => false, 
				"AutoAgree" => false,
				"AgreementChecked" => false
			),
		"LineItems" => array(
			array(
				"ItemName" => "$title",
				"Description" => "$description",
				"Quantity" => 1,
				"Price" => $price,
				"Accept" => true,
				"SellComm" =>  $BrkCommissionSellerPortion,
				"BuyComm" => 0,
			)),
		"Broker"=> array(
				"Email" => "churchill.c.j@gmail.com",
				"FirstName" => "FirstNameValue",
				"LastName" => "LastNameValue",
				"MiddleName" => "MiddleNameValue",
				"AddressLine" => "1st Address value",
				"AddressSecondLine" => "2nd address value",
				"City" => "CityValue",
				"County" => "CountyValue",
				"State" => "StateValue",
				"Country" => "CountryValue",
				"ZipCode" => "Zip code value",
				"PhoneNumber" => "Phone number value",
				"FaxNumber" => "FaxNumber Value",
				"CompanyName" => "Company Name value",
				"Initiator" => true,
				),
		"BrokerCommissionPayee" => "Seller",
		"BrkCommissionSellerPortion" => $BrkCommissionSellerPortion,
		"EscrowPayment" => 0,
		"ShipmentFee" => 0,
		"ShipmentPayment" =>0,
		"DomainNameType" => 0,
		"InspectionLength" => 6,
		"Currency" => "USD",
		"Fulfillment" => 1,
		"CommissionType" => 1,
		"InitiationDate" => "2014-04-15",
		"TermsLocked" => true,
		"AllowReject" => true
		);
	$data_string = json_encode($data);                                                                                   
	 
	$ch = curl_init('https://stgsecureapi.escrow.com/api/Transaction');                                                                      
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
	    'Content-Type: application/json',
	    'Authorization: Basic T3BhbmFrOlRlc3QxMjM0',                                                                            
	    'Content-Length: ' . strlen($data_string))                                                                       
	);                                                                                                                   
	

	$result = curl_exec($ch);
	$reslutarray = json_decode($result);


	/*
	 ["wpcf-deal-id"]=>string(0) ""
	  ["wpcf-seller-id"]=>string(0) ""
	  ["wpcf-buyer-id"]=>string(0) ""
	  ["wpcf-consultant-id"]=>string(0) ""
	  ["wpcf-deal-date"]=>string(0) ""
	  ["wpcf-deal-status"]=>string(0) ""
	  ["wpcf-description"]=>string(0) ""
	  ["wpcf-address-line-one"]=>string(0) ""
	  ["wpcf-city"]=>string(0) ""
	  ["wpcf-country-code"]=>string(0) ""
	  ["wpcf-sales-price"]=>string(0) ""
	  ["wpcf-commission"]=>string(0) ""
	  ["wpcf-proceeds"]=>string(0) ""
	  ["wpcf-buyer-paid-escrow"]=>string(0) ""
	  ["wpcf-seller-delivered"]=>string(0) ""
	  ["wpcf-buyer-confirmed"]=>string(0) ""
	  ["wpcf-escrow-paid-sellers"]=>string(0) ""
	  ["wpcf-escrow-ref1"]=>string(0) ""
	  ["wpcf-escrow-paid-ce"]=>string(0) ""
	  ["wpcf-escrow-ref2"]=>string(0) ""
	}
	*/


	$newdealtitle = 'Deal between Buyer: '. $buyeremail . ' Seller: ' . $selleremail;  
	$post = array(
			  'post_title'     => $newdealtitle, // The title of your post.
			  'post_status'    => 'private', // Default 'draft'.
			  'post_type'      => 'deals', // Default 'post'.
			  'ping_status'    => 'closed', // Pingbacks or trackbacks allowed. Default is the option 'default_ping_status'.
			);  
	$newdeal = wp_insert_post( $post );

	$wpdb->replace( 'wp_deals', array( 'Buyer' => $buyerid, 'Seller' => $sellerid, 'DealID' =>  $newdeal, 'listingID' => $listingID) );

	$gettime = get_the_time( 'F j, Y', $newdeal );

	update_post_meta($newdeal, 'wpcf-deal-id', $reslutarray->TransactionID);
	update_post_meta($newdeal, 'wpcf-escrow-ref1', $reslutarray->TransactionID);
	update_post_meta($newdeal, 'wpcf-buyer-id', $buyerid);
	update_post_meta($newdeal, 'wpcf-seller-id', $sellerid);
	update_post_meta($newdeal, 'wpcf-sales-price', $price);
	update_post_meta($newdeal, 'wpcf-deal-date-full', $gettime);

	die(); // this is required to return a proper result
}

/*
Register sidebars!
*/

// Register Sidebar
function deals_sidebar() {

	$args = array(
		'id'            => 'deals',
		'name'          => __( 'Deals sidebar', 'text_domain' ),
		'description'   => __( 'Sidebar for the My Deals->Deal Deatils tab', 'text_domain' ),
	);
	register_sidebar( $args );

}

// Hook into the 'widgets_init' action
add_action( 'widgets_init', 'deals_sidebar' );



// update deal id if the message is a deal message
add_action( 'messages_message_after_save', 'mycred_restrict_messages' );

function mycred_restrict_messages( $message ) {
	global $wpdb;
	$messageid =  $message->id;

	if(isset($_POST['dealid'])){
		$dealid = $_POST["dealid"];
		$wpdb->query(" UPDATE wp_bp_messages_messages  SET dealid = $dealid WHERE ID = $messageid  " );
	}
}

if(!is_admin()){
	//add_filter('show_admin_bar', '__return_false');
}
/**
 * used on the watch list page
 */
function get_watch_list(){
	global $wpdb;
	$user_ID = get_current_user_id();
	$postsarry = array();
	$watchresults = $wpdb->get_results( "SELECT watching FROM wp_watchlist WHERE  userID = $user_ID" ) ;
	$i = 0;
	foreach ($watchresults as $key => $value) { 
		$i++; $postsarry[$i] = $value->watching; 
	}
	return $postsarry;
}