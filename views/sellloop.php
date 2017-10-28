<div ng-controller="sellloop">
	<h1>{{sellloop}}</h1>
	<div class="avada row">
		<div class="repeatrow" ng-repeat="listing in arraydata">
			{{listing.title}}
		</div>
	</div>
</div>