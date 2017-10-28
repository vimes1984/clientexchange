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
 /*
array(80) {
 ["wpcf-listing-name"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-listing-type"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-company-name"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-buisness-description"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-linkedin"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-facebook"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-twitter"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-blog"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-date-founded"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-number-of-clients"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-asking-price"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-mutual-fund-licensed"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-life-insurance-licensed"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-other-license"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-industry-category"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-area-of-expertise"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-image"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-logo"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-video-link"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-meta-keywords"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-meta-tags"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-terms-acceptance"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-assets-under-management"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-user-title"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-first-name"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-annual-compensation-from-investment-trailers"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-last-name"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-addresslineone"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-city"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-state"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-postal-code"]=> array(1) { [0]=> string(0) "" }
 ["wpcf-country"]=> array(1) { [0]=> string(0) "" } 
 }

 */

(function ($) {
	"use strict";
	$(function () {
		// Place your public-facing JavaScript here
		if($('#datepicker').prop('type') != 'date'){
			$('#datepicker').datepicker();
		}
	});
}(jQuery));
var clientapp = angular.module('clientapp', ['wp.api', 'ngAnimate', 'angularFileUpload']);
clientapp.controller('mainapp', function ($scope) {

});
clientapp.controller('dealscontrl',  function ($scope) {
   $scope.testclick = function testclick(){
    alert('test');
   } 
});
clientapp.controller('TabController', function ($scope, $http, tabsDeals){
    
    NProgress.configure({parent: '#content'});
    
    this.tab = 1;
    
    $scope.dealid = 0;
    
    $scope.tabobject = {'tab': 1, 'dealID': '', 'deals': '', 'currentuser': '', 'currentdeal': ''};
    $scope.ajaxloadedtwo = 0;
    $scope.otheruser = 0;
    $scope.dealstages = 0;
    NProgress.start();
    $scope.extrainfo = true;
    //close popdown
    $scope.closethis = function closethis(){
        $scope.extrainfo = true;
    };
    $scope.contseller  =  function contseller(){
        $scope.extrainfo = false;
    };
    var handleSuccessgetDeals = function(data, status) {
        NProgress.done();
        $scope.ajaxdata = data;
    };
    var handleSuccessDealDetails = function(data, status){
        NProgress.done();
        console.log(data);
        $scope.ajaxloadedtwo = 1;
        $scope.dealdetail = data;
        $scope.dealdetail.proceeds = $scope.dealdetail.LineItems[0].Price - $scope.dealdetail.LineItems[0].SellComm; 
    };
    var handleSuccessCorrespondence = function(data, status){
        NProgress.done();
        $scope.otheruser = data;
        console.log(data);
    };
    var handleSuccessstage = function(data, status){
        NProgress.done();
        
        console.log(data);
    };    
    var handleSuccessPayment = function(data, status){
        NProgress.done();
        
        console.log(data);
    }; 
    var handleSuccessContacts = function(data, status){
        NProgress.done();
        
        console.log(data);
    }; 
    var handleSuccessFiles = function(data, status){
        NProgress.done();
        
        console.log(data);
    };                
    var handleError = function(data, status) {
        NProgress.done();
        alert('the following error occured:'+data+'   Please try again');
    };    
    
    tabsDeals.getDeals($scope).success(handleSuccessgetDeals).error(handleError);
    
    $scope.deal_details_warn = function deal_details_warn(){
        alert('Pick a deal from the "Deals" tab')
    };
    $scope.selectdeal = function selectdeal(setTab, dealid){
            $scope.tabobject.dealID = dealid;
            $scope.dealid = dealid;
            $scope.tabobject.tab = setTab;
            $scope.panel.selectTab(setTab);
            $scope.tabobject.deals = $scope.ajaxdata;
            $scope.tabobject.currentuser = $scope.currentuser;
            $scope.dealstages = 1;
    };
    this.selectTab = function (setTab){
        
        $scope.tabobject.tab = setTab;

        this.tab = setTab;
        if(setTab === 1){
            $scope.dealdetail = '';
            $scope.tabobject.dealID = 0;
            $scope.dealid = 0;
            $scope.ajaxloadedtwo = 0;
            $scope.ajaxdata = '';
            $scope.otheruser = 0;
            NProgress.start();
            tabsDeals.getDeals($scope).success(handleSuccessgetDeals).error(handleError);
        
        }else if(setTab === 2){
            NProgress.start();
            tabsDeals.DealDetails($scope).success(handleSuccessDealDetails).error(handleError);
        
        }else if(setTab === 3){
            $scope.tabobject.currentdeal = $scope.dealdetail;
            NProgress.start();
            tabsDeals.Correspondence($scope).success(handleSuccessCorrespondence).error(handleError);
        
        }else if(setTab === 4){
            NProgress.start();
            tabsDeals.stage($scope).success(handleSuccessstage).error(handleError);
        
        }else if(setTab === 5){
            NProgress.start();
            tabsDeals.Payment($scope).success(handleSuccessPayment).error(handleError);            
        
        }else if(setTab === 6){
            NProgress.start();
            tabsDeals.Contacts($scope).success(handleSuccessContacts).error(handleError);
        
        }else if(setTab === 7){
            NProgress.start();
            tabsDeals.Files($scope).success(handleSuccessFiles).error(handleError);            
        
        }
    };

    this.isSelected = function(checkTab) {
        return this.tab === checkTab;
    };

});
clientapp.controller('adddeal', function ($scope, $http, wpAPIResource, $upload, $timeout) {
    //configue progress bar to top of form
    NProgress.configure({parent: '#content'});
    //hide popdown
    $scope.extrainfo = true;
    //showlogo
    $scope.showlogo = false;
    //close popdown
    $scope.closethis = function closethis(){
    	$scope.extrainfo = true;
    };
    //deault form settings
    $scope.listobject = {
                        "listname": "",
                        "typeoflist": "",
                        "cmpname": "",
                        "listdesc": "",
                        "linkedin": "",
                        "facebook": "",
                        "twitter": "",
                        "blog": "",
                        "fnddate": "",
                        "numbclnts": "",
                        "akspric": "",
                        "mutfund": "",
                        "liscnlife": "",
                        "othliscn": "",
                        "industrycategory": "",
                        "areaexpertise": "",
                        "image": "",
                        "logo": "",
                        "vidurl": "",
                        "metakey": "",
                        "metatag": "",
                        "slltrms": "",
                        "fname": "",
                        "lname": "",
                        "usertitle": "",
                        "astundmang": "",
                        "anlcmpnstn": "",
                        "listaddyone": "",
                        "city": "",
                        "province": "",
                        "pcode": "",
                        "country": ""


    };
    $scope.submitform = function(form) {
        
        NProgress.configure({parent: '#content'});

        // check to make sure the form is completely valid
        if (form.$valid){
                   $scope.dataform =    [
                        {"key": "wpcf-listing-name", "value": $scope.listobject.listname },
                        {"key": "wpcf-listing-type", "value": $scope.listobject.typeoflist},
                        {"key": "wpcf-company-name","value": $scope.listobject.cmpname},
                        {"key": "wpcf-buisness-description", "value": $scope.listobject.listdesc},
                        {"key": "wpcf-linkedin","value": $scope.listobject.linkedin},
                        {"key": "wpcf-facebook", "value": $scope.listobject.facebook },
                        {"key": "wpcf-twitter","value":  $scope.listobject.twitter},
                        {"key": "wpcf-blog", "value":$scope.listobject.blog},
                        {"key": "wpcf-date-founded", "value": $scope.listobject.fnddate },
                        {"key": "wpcf-number-of-clients", "value": $scope.listobject.numbclnts },
                        {"key": "wpcf-asking-price","value": $scope.listobject.akspric },
                        {"key": "wpcf-mutual-fund-licensed","value": $scope.listobject.mutfund },
                        {"key": "wpcf-life-insurance-licensed", "value": $scope.listobject.liscnlife},
                        {"key": "wpcf-other-license", "value": $scope.listobject.othliscn},
                        {"key": "wpcf-industry-category", "value": $scope.listobject.industrycategory},
                        {"key": "wpcf-area-of-expertise", "value": $scope.listobject.areaexpertise},
                        {"key": "wpcf-image", "value": $scope.listobject.image},
                        {"key": "wpcf-logo", "value": $scope.listobject.logo},
                        {"key": "wpcf-video-link", "value": $scope.listobject.vidurl},
                        {"key": "wpcf-meta-keywords", "value": $scope.listobject.metakey},
                        {"key": "wpcf-meta-tags", "value": $scope.listobject.metatag},
                        {"key": "wpcf-terms-acceptance", "value": $scope.listobject.slltrms},
                        {"key": "wpcf-first-name", "value": $scope.listobject.fname },
                        {"key": "wpcf-last-name", "value": $scope.listobject.lname },    
                        {"key": "wpcf-user-title", "value": $scope.listobject.usertitle },                    
                        {"key": "wpcf-assets-under-management", "value": $scope.listobject.astundmang},
                        {"key": "wpcf-annual-compensation-from-investment-trailers", "value": $scope.listobject.anlcmpnstn},
                        {"key": "wpcf-addresslineone", "value": $scope.listobject.listaddyone},
                        {"key": "wpcf-city", "value": $scope.listobject.city},
                        {"key": "wpcf-state", "value": $scope.listobject.province},
                        {"key": "wpcf-postal-code", "value": $scope.listobject.pcode},
                        {"key": "wpcf-country", "value": $scope.listobject.country}
                ];
            console.log($scope.listobject);
    		NProgress.start();
    		wpAPIResource.save({ param1: 'posts' },{ "title": $scope.listobject.listname, "slug": $scope.listobject.typeoflist,"type": "listing", "post_meta": $scope.dataform,  "tax_input": { "listing_categy": { "term_names": [$scope.listobject.typeoflist] } } },
    		function(data) {
    			// success
    			NProgress.done();
    			$scope.extrainfo = false;
                $scope.listform.$setPristine(true);
                $scope.model = '';
    		}, function(e) {
    			// failure
                NProgress.done();
                console.log(e);
    		    alert('Failed to add your Listing...');
    		});

        }else if(form.$invalid){
            $scope.submitted = true;
            if(form.slltrms.$invalid){
                alert('You must accept the terms');
            }else{
                console.log(form);
                alert('Your missing some required fields');
            }
        }
    };

    //FILE UPLOAD



  $scope.onFileSelect = function($files) {
        //configue progress bar to top of form
        NProgress.configure({parent: '#logoupload'});
        NProgress.start();
        
        var file = $files[0];
        console.log($files[0]);
        $scope.filetitle = $files[0].name;
        if (file.type.indexOf('image') == -1) {
             $scope.error = 'image extension not allowed, please choose a JPEG or PNG file.';       
        }
        if (file.size > 2097152){
             $scope.error ='File size cannot exceed 2 MB';
        }     
        $scope.upload = $upload.upload({
            url: $scope.plugurl +'/clientexchangeextend/uploads/upload.php?',
            data: {filname: $scope.filname},
            file: file
          }).success(function(data, status, headers, config) {
            NProgress.done();
            // file is uploaded successfully
            if (data.substr(0,7) == 'http://' || data.substr(0,8) == 'https://') {
                // do something
                $scope.listobject.logo = data;
                $scope.showlogo = true;
                $scope.showurl  = true;                 
            }else{
                $scope.listobject.logo = data;
                $scope.showurl = true;
            }
          });
  };
});
clientapp.controller('singletype', function ($scope, wpAPIResource, $http){
    NProgress.configure({parent: '#content'});
    //hide popdown
    $scope.accntobject = {'userID': '', 'title': '', 'description': '', 'price': '', 'buyer_email': '', 'seller_email': '', 'seller_id': '', 'buyer_id': '', 'listingID': ''};
    $scope.extrainfo = true;
    //close popdown
    $scope.closethis = function closethis(){
        $scope.extrainfo = true;
    };
    $scope.contseller  =  function contseller(){
        $scope.extrainfo = false;
    };
    $scope.newdeal = function newdeal(){
    $scope.accntobject.description = $scope.singlelistarray.wpcf_buisness_description;
    $scope.accntobject.title = $scope.singlelistarray.wpcf_listing_name;
    $scope.accntobject.price = $scope.singlelistarray.wpcf_asking_price;
    $scope.accntobject.listingID = $scope.singlelistarray.listingID;
    //Buyer info
    $scope.accntobject.buyer_email = $scope.singlelistarray.current_user_info.user_email;
    $scope.accntobject.buyer_id = $scope.singlelistarray.current_user_info.ID;
    //Seller info
    $scope.accntobject.seller_email = $scope.singlelistarray.author_info.user_email;
    $scope.accntobject.seller_id = $scope.singlelistarray.author_info.ID;
        
        NProgress.start();

       $http({
                method: 'POST',
                url: '/clientesxch/wp-admin/admin-ajax.php',// REMOVE /clientesxch on launch!!!!! 
                data: $scope.accntobject,
                params: { 'action': 'create_deal'}
            }).success(function(data, status, headers, config) {
                NProgress.done();
                $scope.checkdeal = 1;

                console.log(data);
            

            }).error(function(data, status, headers, config) {

                alert('the following error occured:'+data+'   Please try again');

            });

    };
    $scope.canceldeal = function canceldeal(){
        alert('test');
    };
    $scope.watchlist = function watchlist(userID, watching){
        $scope.accntobject.userID = userID;
        $scope.accntobject.watching = watching;
        NProgress.start();
            $http({
                method: 'POST',
                url: '/clientesxch/wp-admin/admin-ajax.php',// REMOVE /clientesxch on launch!!!!! 
                data: $scope.accntobject,
                params: { 'action': 'watch_add'}
            }).success(function(data, status, headers, config) {
                NProgress.done();
                $scope.checkwatching = 1;
                console.log(data);
            }).error(function(data, status, headers, config) {
                NProgress.done();
                alert('the following error occured:'+data+'   Please try again');
            });
    };
    $scope.watchlistremove = function watchlistremove(userID, watching){
        $scope.accntobject.userID = userID;
        $scope.accntobject.watching = watching;
        NProgress.start();
        $http({
            method: 'POST',
            url: '/clientesxch/wp-admin/admin-ajax.php',// REMOVE /clientesxch on launch!!!!! 
            data: $scope.accntobject,
            params: { 'action': 'watch_remove'}
        }).success(function(data, status, headers, config) {
            NProgress.done();
            $scope.checkwatching = 0;
            console.log(data);
        }).error(function(data, status, headers, config) {
            NProgress.done();
            alert('the following error occured:'+data+'   Please try again');
        });
    };
});
clientapp.controller('watchlistcntrl', function ($scope, wpAPIResource, $http, getwatchloop){
    //Default data
    NProgress.configure({parent: '#content'});
    $scope.radiodata = {'listtype': 'all'};
    $scope.accntobject = {'userID': '', 'watching':'' };
    NProgress.start();
    $scope.extrainfo = true;

    /*
        Open popup message window and set uer to send to..
    */
    $scope.contseller  =  function contseller(user_login){
        $scope.extrainfo = false;
        $scope.user_login = user_login;
    };
    
    /*
        Close popup window 
    */
    $scope.closethis = function closethis(){
        $scope.extrainfo = true;
    };
    //Get Watch list
    getwatchloop.getwatchloop($scope)
        .success(function(data, status, headers, config){
            NProgress.done();
            $scope.watchloop = data;
        })
        .error(function(data, status, headers, config) {
            NProgress.done();
        });
    /* 
        Remove from watch list
        @Param userID = INT();
        @Param watching = INT();

    */
    $scope.watchlistremove = function watchlistremove(userID, watching){
        $scope.accntobject.userID = userID;
        $scope.accntobject.watching = watching;
        NProgress.start();
        $http({
            method: 'POST',
            url: '/clientesxch/wp-admin/admin-ajax.php',// REMOVE /clientesxch on launch!!!!! 
            data: $scope.accntobject,
            params: { 'action': 'watch_remove'}
        }).success(function(data, status, headers, config) {
            NProgress.done();
            location.reload();
            //console.log(data);
        }).error(function(data, status, headers, config) {
            NProgress.done();
            alert('the following error occured:'+data+'   Please try again');
        });
    };
    /*
        Check if value is defined uses to dyanmically display shit
    */
    $scope.isDefined = function(x) {
      return angular.isDefined(x);
   };
   /*
        Clear all 
   */
   $scope.clearChoices = function clearChoices(){
        
        $scope.select_city      = '';
        $scope.select_state     = '';
        $scope.select_country   = '';
        $scope.search           = '';
        $scope.radiodata.listtype = 'all';
   };
});
clientapp.controller('sellloop', function ($scope, wpAPIResource, $http, getlistingloop){
    /*
        Default Vaules
    */
    NProgress.configure({parent: '#content'});
    NProgress.start();
    $scope.listtypes = {selling: false, buying: false, advisor: false};
    $scope.sellloop = 'sell loop';
    

    //Get Watch list
    getlistingloop.getlistingloop($scope)
        .success(function(data, status, headers, config){
            NProgress.done();
            $scope.arraydata = data;
            console.log(data);
        })
        .error(function(data, status, headers, config) {
            NProgress.done();
        });

       /* 
    wpAPIResource.query(
            { param1: 'posts', type: 'listing', context: 'edit'},
            function(data) {
                NProgress.done();
                  angular.forEach(data, function(value, key) {
                      angular.forEach(value.post_meta, function(valuesub, keysub) {                        
                        //console.log(valuesub.key);/,/g , "newchar"
                        var strippedodwn = valuesub.key.replace(/-/g , "_");
                        value[strippedodwn] = valuesub.value;
                    });
                  });

                $scope.arraydata = data;
                console.log(data);
            }, 
            function(e) {
                NProgress.done();
    });
*/
   $scope.clearChoices = function clearChoices(){
        
        $scope.select_city          = '';
        $scope.select_state         = '';
        $scope.select_country       = '';
        $scope.wordsearch           = '';
        $scope.selectedTitle        = "All"
   };

    $scope.titles = ["Selling","Buying","Advisors/Consultants", "All"];

    $scope.byTitle = function(listing){
        if($scope.selectedTitle == "All"){
           return listing.postmeta.wpcf_listing_type;
        }else{
            return listing.postmeta.wpcf_listing_type === $scope.selectedTitle || $scope.selectedTitle === undefined;
        }
    };
    $scope.setSelectedTitle = function (value) {
        if ($scope.selectedTitle === value) {
            $scope.selectedTitle = undefined;
        } else {
            $scope.selectedTitle = value;
        }
    };

});

clientapp.controller('advertiseform', function ($scope, wpAPIResource, $http){
    $scope.test = "test";
});
//tabs functions 
clientapp.factory('tabsDeals', function($http){
    return {
        getDeals: function($scope) {
            return  $http({
                method: 'POST',
                url: '/clientesxch/wp-admin/admin-ajax.php',// REMOVE /clientesxch on launch!!!!! 
                data: $scope.tabobject,
                params: { 'action': 'tab_select_deallloop'}
            });
        },
        DealDetails: function($scope){
            return $http({
                method: 'POST',
                url: '/clientesxch/wp-admin/admin-ajax.php',// REMOVE /clientesxch on launch!!!!! 
                data: $scope.tabobject,
                params: { 'action': 'deal_details'}
            });
        },
        Correspondence: function($scope){
            return $http({
                method: 'POST',
                url: '/clientesxch/wp-admin/admin-ajax.php',// REMOVE /clientesxch on launch!!!!! 
                data: $scope.tabobject,
                params: { 'action': 'deal_Correspondence'}
            });
        },
        stage: function($scope){
            return $http({
                method: 'POST',
                url: '/clientesxch/wp-admin/admin-ajax.php',// REMOVE /clientesxch on launch!!!!! 
                data: $scope.tabobject,
                params: { 'action': 'deal_stage'}
            });
        },
        Payment: function($scope){
            return $http({
                method: 'POST',
                url: '/clientesxch/wp-admin/admin-ajax.php',// REMOVE /clientesxch on launch!!!!! 
                data: $scope.tabobject,
                params: { 'action': 'deal_Payment'}
            });
        },
        Contacts: function($scope){
            return $http({
                method: 'POST',
                url: '/clientesxch/wp-admin/admin-ajax.php',// REMOVE /clientesxch on launch!!!!! 
                data: $scope.tabobject,
                params: { 'action': 'deal_Contacts'}
            });
        },
        Files: function($scope){
            return $http({
                method: 'POST',
                url: '/clientesxch/wp-admin/admin-ajax.php',// REMOVE /clientesxch on launch!!!!! 
                data: $scope.tabobject,
                params: { 'action': 'deal_Files'}
            });
        },                                
    };
});
//popdown
clientapp.directive("centered", function() {
  return {
		restrict : "ECA",
		transclude : true,
		template : "<div class=\"angular-center-container\">\
						<div class=\"angular-centered\" ng-transclude>\
						</div>\
					</div>"
	};
});
//prevent default form

clientapp.factory('getwatchloop', function($http) {
    return {
        getwatchloop: function(){
            return  $http({
                        method: 'GET', 
                        url: '/clientesxch/wp-admin/admin-ajax.php',
                        params: { 'action': 'watch_list'}
                    }); 
        }

    };
});
clientapp.factory('getlistingloop', function($http) {
    return {
        getlistingloop: function(){
            return  $http({
                        method: 'GET', 
                        url: '/clientesxch/wp-admin/admin-ajax.php',
                        params: { 'action': 'get_listing_loop'}
                    }); 
        }

    };
});

clientapp.filter('undefined', function(){ 
    return function(input, message) {
        return angular.isDefined(input) ? input : message;
    };
});

clientapp.filter('unique', function () {

  return function (items, filterOn) {

    if (filterOn === false) {
      return items;
    }

    if ((filterOn || angular.isUndefined(filterOn)) && angular.isArray(items)) {
      var hashCheck = {}, newItems = [];

      var extractValueToCompare = function (item) {
        if (angular.isObject(item) && angular.isString(filterOn)) {
          return item[filterOn];
        } else {
          return item;
        }
      };

      angular.forEach(items, function (item) {
        var valueToCheck, isDuplicate = false;

        for (var i = 0; i < newItems.length; i++) {
          if (angular.equals(extractValueToCompare(newItems[i]), extractValueToCompare(item))) {
            isDuplicate = true;
            break;
          }
        }
        if (!isDuplicate) {
          newItems.push(item);
        }

      });
      items = newItems;
    }
    return items;
  };
});