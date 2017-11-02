<?php
/**
 * Client Exchange plugin
 *
 * @package   client-exchange-plugin
 * @author    C.J.Churchill <churchill.c.j@gmail.com>
 * @license   GPL-2.0+
 * @link      http://buildawebdoctor.com
 * @copyright 7-13-2014 BAWD
 */

/**
 * Client Exchange plugin class.
 *
 * @package ClientExchangePlugin
 * @author  C.J.Churchill <churchill.c.j@gmail.com>
 */
class ClientExchangePlugin{
	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	protected $version = "1.0.0";

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = "client-exchange-plugin";

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action("init", array($this, "load_plugin_textdomain"));

		// Add the options page and menu item.
		add_action("admin_menu", array($this, "add_plugin_admin_menu"));

		// Load admin style sheet and JavaScript.
		add_action("admin_enqueue_scripts", array($this, "enqueue_admin_styles"));
		add_action("admin_enqueue_scripts", array($this, "enqueue_admin_scripts"));

		// Load public-facing style sheet and JavaScript.
		add_action("wp_enqueue_scripts", array($this, "enqueue_styles"));
		add_action("wp_enqueue_scripts", array($this, "enqueue_scripts"));

		// Define custom functionality. Read more about actions and filters: http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		add_action("TODO", array($this, "action_method_name"));
		add_filter("TODO", array($this, "filter_method_name"));
		//Custom post type deal
		add_action( 'init',  array($this, "custompost_type"));
		//Custom post type listing
		add_action( 'init',  array($this, "custompost_type_listing"));
				//add shortcode
		add_shortcode( 'addlisting', array($this, 'addlisting'));
		add_shortcode( 'addealsshrtsellerlisting', array($this, 'addealsshrtsellerlisting'));
		add_shortcode( 'addealsshrtbuyerlisting', array($this, 'addealsshrtbuyerlisting'));
		add_shortcode( 'addealsshrtconsultantlisting', array($this, 'addealsshrtconsultantlisting'));
		add_shortcode( 'dashboardpage', array($this, 'adprivateloopsshrt'));
		add_shortcode( 'sellloopsshrt', array($this, 'sellloopsshrt'));
		add_shortcode( 'buyloopsshrt', array($this, 'buyloopsshrt'));
		add_shortcode( 'fullloopsshrt', array($this, 'fullloopsshrt'));
		add_shortcode( 'watchlistshrt', array($this, 'watchlistshrt'));
		add_shortcode( 'regpageshrt', array($this, 'regpageshrt'));
		add_shortcode( 'addshrtdealoop', array($this, 'addshrtdealoop'));
		add_shortcode( 'mylistings', array($this, 'mylistings'));
		add_shortcode( 'editlisting', array($this, 'editlisting'));
		add_shortcode( 'add_shortcode_advertise', array($this, 'add_shortcode_advertise'));
		//Login page stuff
		add_action('login_head', array($this, 'custom_login_logo'));

		add_filter('login_headerurl', array($this, 'change_wp_login_url'));

		//add_filter( 'show_admin_bar', '__return_false', 99 );
		// require wp-api  ANGULARJS https://github.com/jeffsebring/angular-wp-api
		add_theme_support( 'angular-wp-api' );
		//add capabilities
		//add_filter( 'map_meta_cap', array($this, 'my_map_meta_cap'), 10, 4 );
		//user roles
		add_action('bp_core_signup_user', array($this, 'custom_signup'), 10, 5);
		//
		add_action( 'bp_core_activated_user', array($this, 'newslettersignup_bp_activate'), 10, 3 );

		//Get watch list
		add_action('wp_ajax_nopriv_watch_list', array($this, 'watch_list') );
		add_action( 'wp_ajax_watch_list', array($this, 'watch_list') );
		//get all listings
		add_action('wp_ajax_nopriv_get_listing_loop', array($this, 'get_listing_loop') );
		add_action( 'wp_ajax_get_listing_loop', array($this, 'get_listing_loop') );
		//Get users own listings
		add_action('wp_ajax_nopriv_get_my_listings', array($this, 'get_my_listings') );
		add_action( 'wp_ajax_get_my_listings', array($this, 'get_my_listings') );
		//get single listing
		add_action('wp_ajax_nopriv_get_list_edit', array($this, 'get_list_edit') );
		add_action( 'wp_ajax_get_list_edit', array($this, 'get_list_edit') );
		//Delete a listing
		add_action('wp_ajax_delete_listing', array($this, 'delete_listing') );
		add_action('wp_ajax_nopriv_delete_listing', array($this, 'delete_listing') );
		//Edit a listing
		add_action('wp_ajax_edit_listing', array($this, 'edit_listing') );
		add_action('wp_ajax_nopriv_edit_listing', array($this, 'edit_listing') );

		//Regform actions
		add_action('wp_ajax_reg_form_one_check', array($this, 'reg_form_one_check') );
		add_action('wp_ajax_nopriv_reg_form_one_check', array($this, 'reg_form_one_check') );

		//Regform actions
		add_action('wp_ajax_reg_form_three', array($this, 'reg_form_three') );
		add_action('wp_ajax_nopriv_reg_form_three', array($this, 'reg_form_three') );

		add_action( 'init', array($this, 'get_ID') );

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn"t been set, set it now.
		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}
	public function reg_form_three(){

		$request_body = file_get_contents('php://input');
		$decodeit 		= json_decode( $request_body );
		/**
		 *$decodit returns
		 *object(stdClass)#672 (9) {
			* ["username"]=> string(5) "chris"
			* ["email"]=> string(15) "teststs@tet.com"
			* ["pass"]=> string(5) "Chris"
			* ["passconfirm"]=> string(5) "Chris"
			* ["accounttype"]=> string(6) "Seller"
			* ["fname"]=> string(5) "Chris"
			* ["lname"]=> string(9) "Churchill"
			* ["phone"]=> string(7) "8989809"
			* ["companyname"]=> string(4) "BAWD"
		 *}
		 **/
		$usermeta = array(
			'first_name' 	=> 	$decodeit->fname,
			'last_name' 	=> 	$decodeit->lname,
			'accounttype' =>  $decodeit->accounttype,
			'phone' 			=> 	$decodeit->companyname,
			'companyname' => 	$decodeit->phone,
		);

		$user_id = bp_core_signup_user( $decodeit->username, $decodeit->pass, $decodeit->email, $usermeta );
		var_dump($user_id);
		//xprofile_set_field_data();

		/*
			update_user_meta($user_id, 'last_name', $decodeit->lname);
			update_user_meta($user_id, 'first_name', $decodeit->fname);


			bp_core_signup_user( $user_login, $user_password, $user_email, $usermeta )   X-Ref
			Process data submitted at user registration and convert to a signup object.

			param: string $user_login    Login name requested by the user.
			param: string $user_password Password requested by the user.
			param: string $user_email    Email address entered by the user.
			param: array  $$usermeta      Miscellaneous metadata about the user (blog-specific
			return: bool|WP_Error True on success, WP_Error on failure.


		*/
		//xprofile_set_field_data();
		//bp_update_user_last_activity();
		die();
	}
	/**
	 *
	 */
	 public function reg_form_one_check(){

		$request_body 	= file_get_contents('php://input');
 		$decodeit 		= json_decode( $request_body );

		//check if username allready exists
		if(username_exists( $decodeit->username )){
			echo json_encode(array(
							'error' => array(
									'msg' => 'Username in use',
									'code' => 'userexsit',
							),
					));
					die();
		}
		//check if email allready exists
		if(email_exists( $decodeit->email )){
			echo json_encode(array(
							'error' => array(
									'msg' => 'Email in use',
									'code' => 'emailexsit',
							),
					));
					die(); // this is required to return a proper result
		}
		die(); // this is required to return a proper result
	}
	/**
	 *
	 */
	public function edit_listing(){
		$request_body 	= file_get_contents('php://input');
		$decodeit 		= json_decode( $request_body );
		$author 		= intval($decodeit->author_info_mine->ID);
		$post_id		= $decodeit->posteditID;
		$user_ID 		= get_current_user_id();

		if($author != $user_ID ){
			echo "error";
			die(); // this is required to return a proper result
		}
		//listing values

		// Update post non meta values
		$the_post = array(
			'ID'         => $post_id,
		    'post_title' => $decodeit->wpcf_listing_name
		);
		// Update the post into the database
		  wp_update_post( $the_post );

		//listing update meta data
		foreach ($decodeit as $key => $value) {
			# code...
			switch ($key) {
				case 'author_info':
					# code...
					break;
				case 'author_info_mine':
					# code...
					break;
				case 'posteditID':
					# code...
					break;
				default:
					# code...
						$key = str_replace("_", "-", $key);
						update_post_meta( $post_id, $key, $value );

					break;
			}
		}



		//return $tojson;
		var_dump(  $decodeit  );
		die(); // this is required to return a proper result
	}
	/**
	 * used on the watch list page
	 */
	public function get_watch_list(){
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
	public function get_ID(){
		$posteditID = get_query_var( 'id' );
		return $posteditID;
	}
	/**
	 *
	 */
	public function get_list_edit(){
		$request_body 	= file_get_contents('php://input');
		$posteditID 	= json_decode( $request_body );
		$user_ID 		= get_current_user_id();
		$user_info 		= get_userdata($user_ID);
		$post 			= get_post( $posteditID );
		$author 		= intval($post->post_author);

		if($author != $user_ID && $posteditID != NULL){
			return false;
			die(); // this is required to return a proper result
		}


		$postmeta 				= get_post_meta( $post->ID);

		$tojson 				= array();

		foreach ($postmeta as $key => $value) {
			$tojson[str_replace("-", "_", $key)] = $value[0];
		}

		foreach ($user_info->data as $key => $value) {
			if($key != 'user_pass'  && $key != 'user_activation_key'){
				$tojson['author_info_mine'][$key] = $value;
			}
		}

		//return $tojson;
		echo  json_encode( $tojson );
		die(); // this is required to return a proper result
	}
	/**
	 *
	 */
	public function delete_listing(){
		$request_body 	= file_get_contents('php://input');
		$posteditID 	= json_decode( $request_body );
		$user_ID 		= get_current_user_id();
		$user_info 		= get_userdata($user_ID);
		$post 			= get_post( $posteditID );
		$author 		= intval($post->post_author);

		if($author != $user_ID && $posteditID != NULL){
			return false;
			die(); // this is required to return a proper result
		}

		wp_delete_post( $posteditID, 'true' );
		die(); // this is required to return a proper result
	}
	/**
	 *
	 */
	public function get_my_listings(){
		global $wpdb, $bp;
		$user_ID = get_current_user_id();
		$request_body = file_get_contents('php://input');
		$decodeit = json_decode( $request_body );
		$postsarry = $this->get_watch_list();
		$query = new WP_Query( array( 'post_type' => 'listing', 'posts_per_page' => -1, 'author' => $user_ID ) );
		$watch_results = array();
		$key = 0;
		$postmetacleanarray = array();
		foreach ($query->posts as $key => $value) {
			# code...
			//var_dump($value);

			$post_id 							= $value->ID;
			$author_id							= $value->post_author;
			$getpostmeta 						= get_post_meta( $post_id );

				foreach ($getpostmeta as $keysub => $valuesub) {
					$postmetacleanarray[str_replace('-', '_', $keysub)] 	= $valuesub[0];
				}

			$first_name 						= get_user_meta( $author_id, 'first_name' );
			$last_name 							= get_user_meta( $author_id, 'last_name' );
			$user_login 						= get_userdata( $author_id );
			$permalink 							= get_permalink( $post_id );
			//var_dump($user_login);




			$watch_results[$key] 				= $value;
			//$watch_results[$key]->authormeta 	= get_user_meta( $author_id );
			$watch_results[$key]->first_name 	= $first_name[0];
			$watch_results[$key]->last_name 	= $last_name[0];
			$watch_results[$key]->user_login 	= $user_login->data->user_login;
			$watch_results[$key]->postmeta 		= $postmetacleanarray;
			$watch_results[$key]->permalink 	= $permalink;
			$watch_results[$key]->avatar		= $this->get_avatar_url( $author_id );

		}
		//var_dump( $bp );
		echo  json_encode($watch_results);
		die(); // this is required to return a proper result
	}
	/**
	 *
	 */
	public function get_listing_loop() {
		global $wpdb, $bp;
		$request_body = file_get_contents('php://input');
		$decodeit = json_decode( $request_body );
		$postsarry = $this->get_watch_list();
		$query = new WP_Query( array( 'post_type' => 'listing', 'posts_per_page' => -1, 'post_status' => 'publish') );
		$watch_results = array();
		$key = 0;
		$postmetacleanarray = array();
		foreach ($query->posts as $key => $value) {
			# code...
			//var_dump($value);

			$post_id 							= $value->ID;
			$author_id							= $value->post_author;
			$getpostmeta 						= get_post_meta( $post_id );

				foreach ($getpostmeta as $keysub => $valuesub) {
					$postmetacleanarray[str_replace('-', '_', $keysub)] 	= $valuesub[0];
				}

			$first_name 						= get_user_meta( $author_id, 'first_name' );
			$last_name 							= get_user_meta( $author_id, 'last_name' );
			$user_login 						= get_userdata( $author_id );
			$permalink 							= get_permalink( $post_id );
			//var_dump($user_login);




			$watch_results[$key] 				= $value;
			//$watch_results[$key]->authormeta 	= get_user_meta( $author_id );
			$watch_results[$key]->first_name 	= $first_name[0];
			$watch_results[$key]->last_name 	= $last_name[0];
			$watch_results[$key]->user_login 	= $user_login->data->user_login;
			$watch_results[$key]->postmeta 		= $postmetacleanarray;
			$watch_results[$key]->permalink 	= $permalink;
			$watch_results[$key]->avatar		= $this->get_avatar_url( $author_id );

		}
		//var_dump( $bp );
		echo  json_encode($watch_results);
		die(); // this is required to return a proper result
	}
	/**
	 *
	 */
	public function mylistings( $atts ) {
			extract( shortcode_atts( array(), $atts ) );
			ob_start();
				include_once("views/mylistings.php");
         	return ob_get_clean();
	}
	/**
	 *
	*/
	public function watch_list() {
		global $wpdb, $bp;
		$request_body = file_get_contents('php://input');
		$decodeit = json_decode( $request_body );
		$postsarry = $this->get_watch_list();
		$user_ID 		= get_current_user_id();
		$query = new WP_Query( array( 'post_type' => 'listing', 'post__in' => $postsarry ) );
		$watch_results = array();
		$key = 0;
		$postmetacleanarray = array();
		foreach ($query->posts as $key => $value) {
			# code...
			//var_dump($value);

			$post_id 							= $value->ID;
			$author_id							= $value->post_author;
			$getpostmeta 						= get_post_meta( $post_id );

				foreach ($getpostmeta as $keysub => $valuesub) {
					$postmetacleanarray[str_replace('-', '_', $keysub)] 	= $valuesub[0];
				}

			$first_name 						= get_user_meta( $author_id, 'first_name' );
			$last_name 							= get_user_meta( $author_id, 'last_name' );
			$user_login 						= get_userdata( $author_id );
			$permalink 							= get_permalink( $post_id );
			//var_dump($user_login);


			$watch_results[$key] 							= $value;

			$checkresults_deal 		= count( $wpdb->get_results( "SELECT ID FROM wp_deals WHERE listingID = $post_id  AND ( Buyer = $user_ID OR Seller = $user_ID )" ) );
			if($checkresults_deal >= 1){
				$watch_results[$key]->has_deal = 'true';
			}else{
				$watch_results[$key]->has_deal 		= 'false';
			}

			//$watch_results[$key]->authormeta 	= get_user_meta( $author_id );
			$watch_results[$key]->first_name 	= $first_name[0];
			$watch_results[$key]->last_name 	= $last_name[0];
			$watch_results[$key]->user_login 	= $user_login->data->user_login;
			$watch_results[$key]->postmeta 		= $postmetacleanarray;
			$watch_results[$key]->permalink 	= $permalink;
			$watch_results[$key]->avatar		= $this->get_avatar_url( $author_id );

		}

		echo  json_encode($watch_results);
		die(); // this is required to return a proper result
	}
	/**
	 * Extract url
	 */
	public function get_avatar_url($user_id) {
    	$avatar_url = get_avatar($user_id);
    	$doc = new DOMDocument();
    	$doc->loadHTML($avatar_url);
    	$xpath = new DOMXPath($doc);
    	$src = $xpath->evaluate("string(//img/@src)");
    	return $src;
	}
	/**
	*
	*Custom login styles!
	*
	*
	*/
	public function custom_login_logo() {

		wp_enqueue_style($this->plugin_slug . "-loginstyles", plugins_url("css/loginstyles.css", __FILE__), array(),$this->version);

	}
	/**
	*
	*Custom login page url...
	*
	*/
	public function change_wp_login_url() {
		//return bloginfo('url');
	}
	/**
	 * Register the front end short code.
	 *
	 *  [bartag foo="foo-value"]
	 *
	 * @since    1.0.0
	 */
	public function addlisting( $atts ) {
			extract( shortcode_atts( array(), $atts ) );
			ob_start();
				include_once ('includes/dealsClass.php');
				include_once ('includes/dealsfunctions.php');
				include_once("views/public.php");
         	return ob_get_clean();
	}
		/**
	 * Register the front end short code.
	 *
	 *  [bartag foo="foo-value"]
	 *
	 * @since    1.0.0
	 */
	public function editlisting( $atts ) {
			extract( shortcode_atts( array(), $atts ) );
			ob_start();
				include_once ('includes/dealsClass.php');
				include_once ('includes/dealsfunctions.php');
				include_once("views/edit.php");
         	return ob_get_clean();
	}
	/**
	 * Register the front end short code.
	 *
	 *  [bartag foo="foo-value"]
	 *
	 * @since    1.0.0
	 */
	public function addealsshrtsellerlisting( $atts ) {
			extract( shortcode_atts( array(), $atts ) );
			include_once ('includes/dealsClass.php');
			include_once ('includes/dealsfunctions.php');
			include_once("views/addlistingseller.php");

	}
	/**
	 * Register the front end short code.
	 *
	 *  [bartag foo="foo-value"]
	 *
	 * @since    1.0.0
	 */
	public function addealsshrtbuyerlisting( $atts ) {
			extract( shortcode_atts( array(), $atts ) );
			ob_start();
				include_once ('includes/dealsClass.php');
				include_once ('includes/dealsfunctions.php');
				include_once("views/addlistingbuyer.php");
         	return ob_get_clean();
	}
	/**
	 * Register the front end short code.
	 *
	 *  [bartag foo="foo-value"]
	 *
	 * @since    1.0.0
	 */
	public function addealsshrtconsultantlisting( $atts ) {
			extract( shortcode_atts( array(), $atts ) );
			ob_start();
				include_once ('includes/dealsClass.php');
				include_once ('includes/dealsfunctions.php');
				include_once("views/addlistingconsultant.php");
         	return ob_get_clean();
	}
	/**
	 * Register the front end short code.
	 *
	 *  [bartag foo="foo-value"]
	 *
	 * @since    1.0.0
	 */
	public function addshrtdealoop( $atts ) {
			extract( shortcode_atts( array(), $atts ) );
			ob_start();
				include_once("views/addshrtdealoop.php");
         	return ob_get_clean();
	}
	/**
	 * Register the front end short code.
	 *
	 *  [bartag foo="foo-value"]
	 *
	 * @since    1.0.0
	 */
	public function add_shortcode_advertise( $atts ) {
			extract( shortcode_atts( array(), $atts ) );
			ob_start();
				include_once("views/add_shortcode_advertise.php");
         	return ob_get_clean();
	}
	/**
	 * Register the front end short for private loop with tabs
	 *
	 *  [bartag foo="foo-value"]
	 *
	 * @since    1.0.0
	 */
	public function adprivateloopsshrt( $atts ) {
			extract( shortcode_atts( array(), $atts ) );
			ob_start();
				include_once("views/privateloop.php");
         	return ob_get_clean();

	}
	/**
	 * Register the front end Selling loop
	 *
	 *  [bartag foo="foo-value"]
	 *
	 * @since    1.0.0
	 */
	public function sellloopsshrt( $atts ) {
			extract( shortcode_atts( array(), $atts ) );

			ob_start();
			include_once("views/sellloop.php");
         	return ob_get_clean();

	}
	/**
	 * Register the front end Full loop
	 *
	 *  [bartag foo="foo-value"]
	 *
	 * @since    1.0.0
	 */
	public function fullloopsshrt( $atts ) {
			extract( shortcode_atts( array(), $atts ) );
		    ob_start();

			include_once("views/fullloop.php");

         	return ob_get_clean();
	}
	/**
	 * Register the client's watch lsis
	 *
	 *  [bartag foo="foo-value"]
	 *
	 * @since    1.0.0
	 */
	public function watchlistshrt( $atts ) {
			extract( shortcode_atts( array(), $atts ) );
			include_once("views/watchlist.php");

	}
	/**
	* Register the client's watch lsis
	*
	*  [bartag foo="foo-value"]
	*
	* @since    1.0.0
	 */
	 public function regpageshrt($atts){
		 extract( shortcode_atts( array(), $atts ) );
		 include_once("views/regform_shortcode.php");
	 }

	/**
	 * Register the front end Selling loop
	 *
	 *  [bartag foo="foo-value"]
	 *
	 * @since    1.0.0
	 */
	public function buyloopsshrt( $atts ) {
			extract( shortcode_atts( array(), $atts ) );
			include_once("views/buyloop.php");

	}
	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate($network_wide) {
		// TODO: Define activation functionality here
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	public static function deactivate($network_wide) {
		// TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters("plugin_locale", get_locale(), $domain);

		load_textdomain($domain, WP_LANG_DIR . "/" . $domain . "/" . $domain . "-" . $locale . ".mo");
		load_plugin_textdomain($domain, false, dirname(plugin_basename(__FILE__)) . "/lang/");
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		if (!isset($this->plugin_screen_hook_suffix)) {
			return;
		}

		$screen = get_current_screen();
		if ($screen->id == $this->plugin_screen_hook_suffix) {
			wp_enqueue_style($this->plugin_slug . "-admin-styles", plugins_url("css/admin.css", __FILE__), array(),
				$this->version);
		}

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if (!isset($this->plugin_screen_hook_suffix)) {
			return;
		}

		$screen = get_current_screen();
		if ($screen->id == $this->plugin_screen_hook_suffix) {
			wp_enqueue_script($this->plugin_slug . "-admin-script", plugins_url("js/client-exchange-plugin-admin.js", __FILE__),
				array("jquery"), $this->version);
		}

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style($this->plugin_slug . "-plugin-styles", plugins_url("css/public.css", __FILE__), array(),$this->version);
		wp_enqueue_style($this->plugin_slug . "-plugin-styles-animate", plugins_url("css/animate.css", __FILE__), array(),$this->version);
		wp_enqueue_style($this->plugin_slug . "-plugin-styles-nprpogress", plugins_url("css/nprogress.css", __FILE__), array(),$this->version);
		wp_enqueue_style($this->plugin_slug . "-plugin-styles-slider", plugins_url("css/angular.rangeSlider.css", __FILE__), array(),$this->version);
		wp_enqueue_style($this->plugin_slug . "-plugin-styles-bootstrap", "//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css", array(),$this->version);
		wp_enqueue_style($this->plugin_slug . "-plugin-styles-jqueryUI", "//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css", array(),$this->version);

	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_slug . "-plugin-script-jqueryui", "//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js",array("jquery"), $this->version);
		wp_enqueue_script( $this->plugin_slug . "-plugin-script-autocomplete", "http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false",array("jquery"), $this->version);
		wp_enqueue_script($this->plugin_slug . "-plugin-script-uploadshim", plugins_url("js/angular-file-upload-shim.min.js", __FILE__), array("jquery"),$this->version);
		wp_enqueue_script( $this->plugin_slug . "-plugin-script-angular", "//ajax.googleapis.com/ajax/libs/angularjs/1.2.15/angular.min.js",array("jquery"), $this->version);
		wp_enqueue_script( $this->plugin_slug . "-plugin-script-angularoute", plugins_url("js/angular-route.min.js", __FILE__),array("jquery"), $this->version);
		wp_enqueue_script( $this->plugin_slug . "-plugin-script-angular-animate", "//ajax.googleapis.com/ajax/libs/angularjs/1.2.12/angular-animate.js",array("jquery"), $this->version);
		wp_enqueue_script( $this->plugin_slug . "-plugin-script-angularjs-resource", "//cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.18/angular-resource.min.js", array("jquery"),$this->version);
		wp_enqueue_script( $this->plugin_slug . "-plugin-script-angularjs-slider", plugins_url("js/angular.rangeSlider.js", __FILE__), array("jquery"),$this->version);
		wp_enqueue_script( $this->plugin_slug . "-plugin-script-angular", "http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.9.0.js",array("jquery"), $this->version);
		wp_enqueue_script($this->plugin_slug . "-plugin-script-angular-nploader", plugins_url("js/nprogress.js", __FILE__), array("jquery"),$this->version);
		wp_enqueue_script($this->plugin_slug . "-data-equalizer", plugins_url("js/grids.min.js", __FILE__), array("jquery"),$this->version);
		wp_enqueue_script($this->plugin_slug . "-plugin-ngautocomplete", plugins_url("js/ngAutocomplete.js", __FILE__), array("jquery"),$this->version);
		wp_enqueue_script($this->plugin_slug . "-plugin-script-upload", plugins_url("js/angular-file-upload.min.js", __FILE__), array("jquery"),$this->version);




		wp_register_script($this->plugin_slug . "-plugin-script", plugins_url("js/client-exchange-plugin.js", __FILE__), array("jquery"),$this->version);
		// Localize the script with new data
		$path_array = array(
			'siteurl' => get_site_url(),
			'templateurl' => plugins_url("views/regforms", __FILE__),
			'USERID' => get_current_user_id()
		);
		wp_localize_script( $this->plugin_slug . "-plugin-script" , 'PATHARRAY', $path_array );
		// Enqueued script with localized data.
		wp_enqueue_script( $this->plugin_slug . "-plugin-script" );
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {
		if(current_user_can( 'manage_options' )){
			$this->plugin_screen_hook_suffix = add_menu_page(__("Client Exchange plugin - Administration..", $this->plugin_slug),
			__("Client Exchange plugin", $this->plugin_slug), "read", $this->plugin_slug, array($this, "display_plugin_admin_page"));
		}
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once("views/admin.php");
	}

	/**
	 * NOTE:  Actions are points in the execution of a page or process
	 *        lifecycle that WordPress fires.
	 *
	 *        WordPress Actions: http://codex.wordpress.org/Plugin_API#Actions
	 *        Action Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 * @since    1.0.0
	 */
	public function action_method_name() {
		// TODO: Define your action hook callback here
	}

	/**
	 * NOTE:  Filters are points of execution in which WordPress modifies data
	 *        before saving it or sending it to the browser.
	 *
	 *        WordPress Filters: http://codex.wordpress.org/Plugin_API#Filters
	 *        Filter Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
	 *
	 * @since    1.0.0
	 */
	public function filter_method_name() {
		// TODO: Define your filter hook callback here
	}
	/*
	*
	*hooking into buddypress's user sgin up to give users roles..
	*
	*/

	public function custom_signup($user_id, $user_login, $user_password, $user_email, $usermeta){
		$getchoice = $usermeta['accounttype'];
		switch ($getchoice){
		    case 'Buyer':

		     	groups_join_group( 2, $user_id );
		     	wp_update_user( array( 'ID' => $user_id, 'role' => 'buyer' ) );

		        break;
		    case 'Seller':

		     	wp_update_user( array( 'ID' => $user_id, 'role' => 'seller' ) );

		     	$testdump = get_user_meta($user_id);

		     	groups_join_group( 1, $user_id );

		        break;

		    case 'Consultants':

		     	wp_update_user( array( 'ID' => $user_id, 'role' => 'advisor' ) );

		     	groups_join_group( 3, $user_id );

		        break;

		}
	}

	/*
	*
	*User Activated...
	*
	* Update usermeta with custom registration data
	*/
public function newslettersignup_bp_activate($user_id, $key, $value ) {
		$getchoice = $value['meta']['accounttype'];
		/*
		AVIALABLE options
		$usermeta = array(
			'first_name' 	=> 	$decodeit->fname,
			'last_name' 	=> 	$decodeit->lname,
			'phone' 			=> 	$decodeit->accounttype,
			'companyname' => 	$decodeit->accounttype,
		);

		*/
		xprofile_set_field_data('First Name', $user_id, $value['meta']['first_name']  );
		xprofile_set_field_data('Last Name', $user_id, $value['meta']['last_name']  );
		xprofile_set_field_data('Company', $user_id, $value['meta']['companyname']  );
		xprofile_set_field_data('Phone Number', $user_id, $value['meta']['phone']  );
		xprofile_set_field_data(12, $user_id, 'I Accept'  );

		$savevalue =  array( $value['meta']['accounttype'] );

		switch ($getchoice){
		    case 'Buyer':

		     	groups_join_group( 2, $user_id );
					xprofile_set_field_data('User Type', $user_id, 'Buyer'  );
		     	wp_update_user( array( 'ID' => $user_id, 'role' => 'buyer' ) );

		        break;
		    case 'Seller':

				xprofile_set_field_data('User Type', $user_id, 'Seller'  );
		     	wp_update_user( array( 'ID' => $user_id, 'role' => 'seller' ) );

		     	$testdump = get_user_meta($user_id);

		     	groups_join_group( 1, $user_id );

		        break;

		    case 'Consultant':
					$Consultantvalue = array( 'Advisor/Consultant' );
					xprofile_set_field_data('User Type', $user_id, 'Advisors/Consultants'  );
		     	wp_update_user( array( 'ID' => $user_id, 'role' => 'advisor' ) );

		     	groups_join_group( 3, $user_id );

		        break;

		}
}

	/*
	*Custom post types
	*
	*
	*
	*/

	public function custompost_type_listing(){
		register_post_type( 'listing',
				array(
					'public' => true,
					'capability_type' => 'listing',
					'map_meta_cap' => false,
					'labels' => array(
						'name' => __( 'listings' ),
						'singular_name' => __( 'listing' ),
						'capability_type' => 'listings',
						'capabilities' => array(
							'publish_posts' => 'publish_listings',
							'edit_posts' => 'edit_listings',
							'delete_posts' => 'delete_listings',
							'read_private_posts' => 'read_private_listings',
							'edit_post' => 'edit_listing',
							'delete_post' => 'delete_listing',
							'read_post' => 'read_listing',
						),
					),
					'has_archive' => true,
					'supports' => array(
						'title',
						'thumbnail',
						'author'
					)
				)
		);
	}
	public function custompost_type(){
		register_post_type( 'deals',
			array(
				'public' => true,
				'labels' => array(
					'name' => __( 'Deals' ),
					'singular_name' => __( 'Deal' ),
					'capability_type' => 'deals',
					'capabilities' => array(
						'publish_posts' => 'publish_deals',
						'edit_posts' => 'edit_deals',
						'delete_posts' => 'delete_deals',
						'read_private_posts' => 'read_private_deals',
						'edit_post' => 'edit_deal',
						'delete_post' => 'delete_deal',
						'read_post' => 'read_deal',
					),
				),
				'has_archive' => true,
				'supports' => array(
					'title',
					'thumbnail' ),
			)
		);
	}
	/*
		add_action( 'init', 'create_book_tax' );

	public function create_book_tax() {
		register_taxonomy(
			'genre',
			'book',
			array(
				'label' => __( 'Genre' ),
				'rewrite' => array( 'slug' => 'genre' ),
				'hierarchical' => true,
			)
		);
	}
	*/
}
