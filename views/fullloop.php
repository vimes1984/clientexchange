<div ng-cloak ng-controller="sellloop">
<div class="progress-box">
  <div class="percentage-cur" ng-init="selectedRange=0">
    <span class="num">{{ selectedRange }}%</span>
  </div>
  <div class="progress-bar progress-bar-slider">
    <input class="progress-slider" type="range" min="0" max="100" ng-model="selectedRange">
    <div class="inner" ng-style="{ width: selectedRange + '%' || '0%' }"></div>
  </div>
</div>
	<div class="avada row">				
		<div class="col-md-12" id="watchsearch">
			<input type="text" ng-model="wordsearch" placeholder="Search" />
		</div>
	</div>
	<div class="row avada">
		<div class="col-md-3">
			<select ng-model="select_city" placeholder="Select a City" ng-options=" post.postmeta.wpcf_city  as post.postmeta.wpcf_city for post in arraydata | unique:'post.postmeta.wpcf_city'"> </select>
		</div>
		<div class="col-md-3">
			<select ng-model="select_state" ng-options=" post.postmeta.wpcf_state as post.postmeta.wpcf_state for post in arraydata | unique:'post.postmeta.wpcf_state'"> </select>
		</div>
		<div class="col-md-3">
			<select ng-model="select_country" ng-options=" post.postmeta.wpcf_country as post.postmeta.wpcf_country for post in arraydata | unique:'post.postmeta.wpcf_country'"> </select>
		</div>
		<div class="col-md-3">
			<button ng-click="clearChoices()" class="btn btn-default">Clear All</button>
		</div>
	</div>
	<button type="button" ng-repeat="title in titles" class="btn btn-default" ng-model="selected[title]" btn-checkbox ng-class="{active: title == selectedTitle}" ng-click="setSelectedTitle(title)">{{title}}</button>
	<div class="avada row">
		<div ng-animate="'animate'" class="repeatrow row" ng-repeat="listing in arraydata | filter:wordsearch | filter:byTitle | filter:select_city | filter:select_state | filter:select_country">
			<div class="col-md-2">
				<img ng-show='listing.postmeta.wpcf_logo == ""' src="{{listing.avatar}}" alt="">
				<img ng-show='listing.postmeta.wpcf_logo != ""' src="{{listing.postmeta.wpcf_logo}}" alt="">
			</div>
			<div class="col-md-2">
				<p>{{listing.first_name}}</p>
				<p>{{listing.last_name}}</p>
			</div>
			<div class="col-md-2">
				<h3>{{listing.post_title}}</h3>
			</div>
			<div class="col-md-2">
				<p ng-show='listing.postmeta.wpcf_asking_price != ""'>Asking price: ${{listing.postmeta.wpcf_asking_price}}</p>
				<p ng-show='listing.postmeta.wpcf_area_of_expertise != ""'>{{listing.postmeta.wpcf_area_of_expertise}}</p>
			</div>
			<div class="col-md-2">
				<p class="col-md-6" ng-show='listing.postmeta.wpcf_city != ""'>{{listing.postmeta.wpcf_city}}</p>
				<p class="col-md-6" ng-show='listing.postmeta.wpcf_state != ""'>{{listing.postmeta.wpcf_state}}</p>
				<a href="{{listing.permalink}}">Read more...</a>
			</div>
		</div>
	</div>
</div>