<?php
// Template Name: Deals template
get_header(); 
$user_ID = get_current_user_id();
$plugins_url = plugins_url();
var_dump($plugins_url.'/clientexchangeextend/includes/tabs/');
?>
	<div id="content" class="full-width">
		<?php while(have_posts()): the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="post-content">
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</div>
		</div>
		<?php endwhile; ?>
    <style>

    </style>		
		<div ng-controller="dealscontrl">
			<div ng-init="ajaxurl = '<?php echo $plugins_url; ?>/clientexchangeextend/includes/tabs/'"></div>
		<section class="tab" ng-controller="TabController as panel">
				<ul id="tabs">
				    <li  ng-class="{active:panel.isSelected(1) }">
				        <a href ng-click="panel.selectTab(1)">Active Deals</a>
				    </li>
				    <li ng-class="{active:panel.isSelected(2)  }">
				        <a href ng-click="panel.selectTab(2)">Deal Details</a>
				    </li>
				    <li ng-class="{active:panel.isSelected(3)}">
				        <a href ng-click="panel.selectTab(3)">Correspondence</a>
				    </li>
				    <li ng-class="{active:panel.isSelected(4)}">
				        <a href ng-click="panel.selectTab(4)">Deal Stage</a>
				    </li>
				    <li ng-class="{active:panel.isSelected(5)}">
				        <a href ng-click="panel.selectTab(5)">Payment</a>
				    </li>
				    <li ng-class="{active:panel.isSelected(6)}">
				        <a href ng-click="panel.selectTab(6)">Contacts</a>
				    </li>
				    <li ng-class="{active:panel.isSelected(7)}">
				        <a href ng-click="panel.selectTab(7)">Files</a>
				    </li>				    				    				    				    
				</ul>      
			    <div class="tab_panel" ng-show="panel.isSelected(1)">

					<?php 
					//my buying deals
						wp_reset_query();
						$rd_args = array(
							'post_type'=>'deals',
							'meta_query' => array(
								array(
									'key' => 'wpcf-buyer-id',
									'value' => $user_ID
								),
							),
						);
						 
						$query = new WP_Query( $rd_args );

					    while ($query->have_posts()) : $query->the_post();
					    echo "<h1>Buyer deal</h1>";
					    $postmeta = get_post_meta( $post->ID );
						$res = array();
						foreach ($postmeta as $key => $value) {$res[$key] = $value[0];}
						$transid = $res["wpcf-deal-id"];
					    echo "<pre>";
					    	var_dump($res["wpcf-deal-id"]);
					    echo "</pre>";

					    	$data = array('');
							$data_string = json_encode($data);                                                                                   			 
							$ch = curl_init("https://stgsecureapi.escrow.com/api/Transaction/$transid");                                                                      
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                     
							//curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
							curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
							    'Content-Type: application/json',
							    'Authorization: Basic Q2xpZW50RXhjaGFuZ2U6NWkzOTkwYTE=',                                                                            
							    //'Content-Length: ' . strlen($data_string) 
							    )                                                                       
							);                                                                                                                   
							

							$result = curl_exec($ch);
							$reslutarray = json_decode($result);
							var_dump($reslutarray);
					?>			
					<!-- this is where you should insert your content of the posts -->
					
					<?php endwhile; ?>
					
					<?php wp_reset_query(); ?>

					<?php
					//my Selling deals
						wp_reset_query();
						$rd_args = array(
							'post_type'=>'deals',
							'meta_query' => array(
								array(
									'key' => 'wpcf-seller-id',
									'value' => $user_ID
								),	
							),
						);
						 
						$query = new WP_Query( $rd_args );

					    while ($query->have_posts()) : $query->the_post();
					    echo "<h1>Seller deal</h1>";
					    $postmeta = get_post_meta( $post->ID );
						$res = array();
						foreach ($postmeta as $key => $value) {$res[$key] = $value[0];}

					    echo "<pre>";
					    	var_dump($res);
					    echo "</pre>";
					?>			
					<!-- this is where you should insert your content of the posts -->
					
					<?php endwhile; ?>
					
					<?php wp_reset_query(); ?>
 				</div>
			    <div class="tab_panel" ng-show="panel.isSelected(2)">
					{{ajaxdata}}
			    </div>
			    <div class="tab_panel" ng-show="panel.isSelected(3)">
					{{ajaxdata}}
			    </div>
			    <div class="tab_panel" ng-show="panel.isSelected(4)">
					{{ajaxdata}}
			    </div>
			    <div class="tab_panel" ng-show="panel.isSelected(5)">
					{{ajaxdata}}
			    </div>
			    <div class="tab_panel" ng-show="panel.isSelected(6)">
					{{ajaxdata}}
			    </div>
			    <div class="tab_panel" ng-show="panel.isSelected(7)">
					{{ajaxdata}}
			    </div>			    			    			    
			    <br />
		 
		</section>



</div>
	</div>
<?php get_footer(); ?>