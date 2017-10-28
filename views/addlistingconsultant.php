<?php
/**
 * Represents the view for the public-facing component of the plugin.
 *
 * This typically includes any information, if any, that is rendered to the
 * frontend of the theme when the plugin is activated.
 *
 * @package   client-exchange-plugin
 * @author    C.J.Churchill <churchill.c.j@gmail.com>
 * @license   GPL-2.0+
 * @link      http://buildawebdoctor.com
 * @copyright 7-13-2014 BAWD
 */
  		ini_set('display_errors', 1);
  		error_reporting(E_ALL ^ E_NOTICE);
	
	$dealclass = new Deals;
	
	$chkusergroups = $dealclass->currentuserchkgroup();
	  
	  global $current_user;
      
      get_currentuserinfo();
?>
<div ng-controller="adddeal">
	<?php include_once ('adddealforms/adddealConsultants.php'); ?>
	<div ng-cloak class="addealinfo" ng-hide="extrainfo">
		<centered>
		<div class="addinfoinner">
			<p class="closethis" ng-click="closethis()">x</p>
			<h1>Thank you <?php echo  $current_user->user_login; ?></h1>
			<p>Thank you for registering as a {{accntype}} on Client Exchange. One of our representatives will review your submission shortly. Our review process takes 3 business days for approval. You will be notified when your listing becomes available online. Thank you.</p>
			<p>Your list summary:</p>
			<ul>
				<li>Title: {{listobject.listname}}</li>
				<li>Description: {{listobject.listdesc}}</li>
				<li>Asking Price: {{listobject.akspric}}</li>
			</ul>
			<h3>Or you can view all your listings <a href="listingsmy">here</a></h3>
		</div>
		</centered>
	</div>
</div>
