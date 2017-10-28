<?php 
	$postsarry = get_watch_list();
	if(count($postsarry) > 0){	
?>

		<div ng-controller="watchlistcntrl" ng-cloak>
			<div class="selectors" id="selectors" >
				<div class="input_wrap">
					<input type="radio" id="buyers" name="type" value="Buying" ng-model="radiodata.listtype"/><label for="buyers"><span></span>Buyers</label>
				</div>
				<div class="input_wrap">
					<input type="radio" id="sellers" name="type" value="Selling" ng-model="radiodata.listtype"/><label for="sellers"><span></span>Sellers</label>
				</div>
				<div class="input_wrap">
					<input type="radio" id="consultants" name="type" value="Advisors/Consultants" ng-model="radiodata.listtype"/><label for="consultants"><span></span>Consultants</label>
				</div>
				<div class="input_wrap">
					<input type="radio" id="all" name="type" value="all" ng-model="radiodata.listtype"/><label for="all"><span></span>All</label>
				</div>
			</div>
			<div class="avada row">				
				<div class="col-md-12" id="watchsearch">
					<input type="text" ng-model="search" placeholder="Search" />
				</div>
			</div>
			<div class="row avada">
				<div class="col-md-3">
					 <select ng-model="select_city" placeholder="Select a City" ng-options=" post.postmeta.wpcf_city  as post.postmeta.wpcf_city for post in watchloop | unique:'post.postmeta.wpcf_city'"> </select>
				</div>
				<div class="col-md-3">
					 <select ng-model="select_state" ng-options=" post.postmeta.wpcf_state as post.postmeta.wpcf_state for post in watchloop | unique:'post.postmeta.wpcf_state'"> </select>
				</div>
				<div class="col-md-3">
					 <select ng-model="select_country" ng-options=" post.postmeta.wpcf_country as post.postmeta.wpcf_country for post in watchloop | unique:'post.postmeta.wpcf_country'"> </select>
				</div>
				<div class="col-md-3">
					<button ng-click="clearChoices()" class="btn btn-default">Clear All</button>
				</div>
			</div>

			<div ng-repeat="post in watchloop | filter:search | filter:select_city | filter:select_state | filter:select_country" ng-show="radiodata.listtype == 'all' || radiodata.listtype == '{{post.postmeta.wpcf_listing_type}}' ">
				<div class="avada row" >
					<div class="col-md-4">
					</div>
					<div class="col-md-4">
					</div>
				</div>
				<div class="avada row">
					<div class="col-md-2">
						<img src="{{post.avatar}}">
					</div>
					<div class="col-md-6">
						<h3>{{post.postmeta.wpcf_user_title}} {{post.last_name}}, {{post.first_name}}</h3>
						<h4><a href="{{post.permalink}}">{{post.post_title}}</a></h4>
						<p ng-show="post.postmeta.wpcf_area_of_expertise != '' ">{{post.postmeta.wpcf_area_of_expertise}}</p>
						<p ng-show="post.postmeta.wpcf_asking_price != '' && isDefined(post.postmeta.wpcf_asking_price)">Asking Price: ${{post.postmeta.wpcf_asking_price}}</p>
						<p ng-show="post.postmeta.wpcf_assets_under_management != '' && isDefined(post.postmeta.wpcf_assets_under_management)">Assets under management: ${{post.postmeta.wpcf_assets_under_management}}</p>
					</div>
					<div class="col-md-4">
						<div class="avada row">	
							<div class="col-md-6">
								<button ng-click="contseller(post.user_login )" class="btn btn-default">Contact</button>
							</div>
							<div class="col-md-6">
								<button ng-click="watchlistremove(post.post_author, post.ID )" class="btn btn-default">Remove</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div ng-cloak class="addealinfo" ng-hide="extrainfo">
				<centered>
					<div class="contactform addinfoinner">
							<p class="closethis" ng-click="closethis()">x</p>
							<div id="clientform">
								<form action="<?php bp_messages_form_action('compose' ); ?>/compose" method="post" id="send_message_form" class="standard-form" role="main" enctype="multipart/form-data">
									<?php do_action( 'bp_before_messages_compose_content' ); ?>
										<?php bp_message_get_recipient_tabs(); ?>
										<input type="hidden" name="send-to-input" class="send-to-input" id="send-to-input"  value="{{user_login}}"/>
										<label for="subject"><?php _e( 'Subject', 'buddypress' ); ?></label>
										<input type="text" name="subject" id="subject" value="<?php get_the_title(); ?>" />
										<label for="content"><?php _e( 'Message', 'buddypress' ); ?></label>
										<textarea name="content" id="message_content" rows="15" cols="40"><?php bp_messages_content_value(); ?></textarea>
										<input type="hidden" name="send_to_usernames" id="send-to-usernames" value="<?php bp_message_get_recipient_usernames(); ?>" class="<?php bp_message_get_recipient_usernames(); ?>" />
									<?php do_action( 'bp_after_messages_compose_content' ); ?>
										<div class="submit">
											<input type="submit" value="<?php esc_attr_e( "Send Message", 'buddypress' ); ?>" name="send" id="send" />
										</div>
									<?php wp_nonce_field( 'messages_send_message' ); ?>
								</form>
										<script type="text/javascript">document.getElementById("send-to-input").focus();</script>
							</div>
					</div>
				</centered>
			</div>
		</div>
<?php }else{ ?>
	<h3>Nothing in your watch list why not searching through our listings and adding something...</h3>
<?php } ?>
