<?php 
/**
 * Client Exchange plugin class.
 *
 * @package Deals Class
 * @author  C.J.Churchill <churchill.c.j@gmail.com>
 */
class Deals{
	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	protected $version = "1.0.0";

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	public function __construct() {

	}
		/**
	 * Fired from adddeal().
	 *
	 * @since    1.0.0
	 *
	 * @return 	Unique User ID
	 */
	public function currentuserchkgroup(){
		$user_ID = get_current_user_id();
		$getgroups = BP_Groups_Member::get_group_ids( $user_ID );
		$usermeta = get_user_meta($user_ID);
		
		return $getgroups["groups"];
	}
	/**
	 * Fired from adddeal().
	 *
	 * @since    1.0.0
	 *
	 * @return 	Unique deal ID
	 */
	public function createdealid(){

	}
	/**
	 * Fired when User add Deals on the front end.
	 *
	 * @since    1.0.0
	 *
	 * @param   $wp->userID.
	 * @param 	deal ID
	 */
	public function adddeal($userID = NULL){
		/*
			TO DO add deals on front end
		*/
	}
	/**
	 * Fired when User add Deals on the front end.
	 *
	 * @since    1.0.0
	 *
	 * @param   $wp->userID.
	 * @param 	deal ID
	 */
	public function removedeal($userID = NULL, $dealID = NULL){

	}
	/**
	 * Fired from adddeal().
	 *	Only because I'm fucking tired of writing echo la di da
	 * @since    1.0.0
	 *
	 * @param content of var_dump to be echoed 
	 */
	public function vardumpdebug($var){
		echo "<pre>";
		var_dump($var);
		echo "</pre>";
	}
}