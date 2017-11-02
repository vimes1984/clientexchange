/*jshint strict:false */
'camelcase: false';
/* globals angular, jQuery, ajaxurl, action, NProgress, alert, location, window, PATHARRAY, console, alert */

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

(function ($) {

    $(function () {
        // Place your public-facing JavaScript here
        if($('#datepicker').prop('type') !== 'date'){
            $('#datepicker').datepicker();
        }
        //Set the delete buttons height same as parent
        $('.element_equ').responsiveEqualHeightGrid();
        $('.elementchild_delet').each(function( i ) {
          var getheight = $(this).parent().height();
          $(this).find('.col-md-8').height(getheight);
          $(this).find('.chckheight').height(getheight);
          $(this).find('.delete').css('line-height', getheight+'px' );
        });
        //Click Un click all
        /* Selecting unread and read messages in inbox */
        $( 'body.messages #item-body-message div.messages' ).on( 'change', '#message-type-select', function() {
          var selection   = this.value,
            checkboxes    = $( ' input[type="checkbox"].chkchkbox_hide' ),
            checkedValue = 'checked';

          checkboxes.each( function(i) {
            checkboxes[i].checked = '';
          });

          switch ( selection ) {
            case 'unread':
              checkboxes = $('div.unread .chckheight input[type="checkbox"]');
              break;
            case 'read':
              checkboxes = $('div.read .chckheight input[type="checkbox"]');
              break;
            case '':
              checkedValue = '';
              break;
          }

          checkboxes.each( function(i) {
            checkboxes[i].checked = checkedValue;
          });
        });



        	/* Marking private messages as read and unread */
        	$('a#mark_as_read, a#mark_as_unread').click( function() {
        		var checkboxesTosend = '';
        		var checkboxes = $('div .chckheight input[type="checkbox"]');
        		if ( 'mark_as_unread' === $(this).attr('id') ) {
        			var currentClass = 'read';
        			var newClass = 'unread';
        			var unreadCount = 1;
        			var inboxCount = 0;
        			var unreadCountDisplay = 'inline';
        			var action = 'messages_markunread';
        		} else {
        			var currentClass = 'unread';
        			var newClass = 'read';
        			var unreadCount = 0;
        			var inboxCount = 1;
        			var unreadCountDisplay = 'none';
        			var action = 'messages_markread';
        		}

        		checkboxes.each( function(i) {
        			if($(this).is(':checked')) {
        				if ( $('#m-' + $(this).attr('value')).hasClass(currentClass) ) {
        					checkboxesTosend += $(this).attr('value');
        					$('#m-' + $(this).attr('value')).removeClass(currentClass);
        					$('#m-' + $(this).attr('value')).addClass(newClass);
        					var threadCount = $('#m-' + $(this).attr('value') + '  span.unread-count').html();

        					$('#m-' + $(this).attr('value') + '  span.unread-count').html(unreadCount);
        					$('#m-' + $(this).attr('value') + '  span.unread-count').css('display', unreadCountDisplay);

        					var inboxcount = $('.unread').length;

        					$('a#user-messages span').html( inboxcount );

        					if ( i !== checkboxes.length - 1 ) {
        						checkboxesTosend += ',';
        					}
        				}
        			}
        		});
        		$.post( ajaxurl, {
        			action: action,
        			'thread_ids': checkboxesTosend
        		});
        		return false;
        	});
          /**
           * Animations
           */
        $('.frontpagecallswrap .item').on('mouseover', function(){
            $(this).find('.btn.watchpicker').removeClass('fadeOutDown');
            $(this).find('.btn.watchpicker').addClass('bounceInDown');

        });
        $('.frontpagecallswrap .item').on('mouseleave', function(){
            $(this).find('.btn.watchpicker').removeClass('bounceInDown');
            $(this).find('.btn.watchpicker').addClass('fadeOutDown');
        });

    });
}(jQuery));
var clientapp = angular.module('clientapp', ['ngRoute', 'wp.api', 'ngAnimate', 'angularFileUpload', 'ui-rangeSlider', 'ngAutocomplete']);
/**
 * Routes
 */
clientapp.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
  $locationProvider.html5Mode(false);
  $routeProvider
  .when('/', {
    templateUrl: PATHARRAY.templateurl + '/stepone.html',
    //controller: 'dashboardcntrl',
  })
  .when('/steptwo', {
    templateUrl: PATHARRAY.templateurl + '/steptwo.html',
    //controller: 'dashboardcntrl',
  })
  .when('/stepthree', {
    templateUrl: PATHARRAY.templateurl + '/stepthree.html',
    //controller: 'dashboardcntrl',
  });
}]);
/*
    Controllers the name should tell you where they are assinged
*/
clientapp.controller('mainapp', function ($scope) {});
clientapp.controller('dealscontrl',  function ($scope) {});

clientapp.controller('regformctrl',['$scope', 'regform', '$location', function ($scope, regform, $location) {
  NProgress.configure({parent: '#npprogparent'});
  $scope.nextstepdis = true;
  $scope.formmodel = {};
  $scope.formstep = 'Step 1 of 3:';
  $scope.formdesc = 'Create your Account';
  //Form one fucntions
  $scope.infoclick = function(){
    alert('The Client Exchange mailing list is used to send newsletters and special event notifications throughout the year.  With your permission, we will use your name and email address provided here to send this communication to you.  You may unsubscribe at any time by using the unsubscribe instructions at the bottom of any communication you receive.');
  };
  $scope.$watchCollection(function () {
        if ($scope.form){
            return $scope.form;
        }
    }, function () {
       if ($scope.form){}
       if (($scope.form.$invalid === true)){
            $scope.nextstepdis = true;
       }else{
         $scope.nextstepdis = false;
       }
    }, true);

  $scope.$on('$routeChangeSuccess', function(current, path) {
    if(typeof $scope.formmodel.username === 'undefined'){
      $location.path('/');
    }
    switch (path.$$route.originalPath) {
      case '/':
            $scope.formstep = 'Step 1 of 3:';
            $scope.formdesc = 'Create your Account';
        break;
      case '/steptwo':
            $scope.formstep = 'Step 2 of 3:';
            $scope.formdesc = 'Select your Account Type';
          break;
      case '/stepthree':
            $scope.formstep = 'Step 3 of 3:';
            $scope.formdesc = 'Complete your user Profile';
          break;
      default:

      break;

    }
  });
  $scope.steptwoback = function(){
    $location.path('/');
  };
  $scope.stepthreeback = function(){
    $location.path('steptwo');
  };
  $scope.steptwogo = function(form){
    NProgress.start();
    $scope.nextstepdis = true;
    regform.formoneCheck($scope)
    .success(function(data){
        $scope.returndata = data;
        NProgress.done();
        $scope.nextstepdis = false;
        if(!data.error){
              $location.path('steptwo');
          }
    }).error(function(){
      $scope.nextstepdis = false;
      NProgress.done();

    });
  };
  //Form two functions
  $scope.stepthreego = function(){
    NProgress.start();
    $location.path('stepthree');
    NProgress.done();
  };
  //Form three
  $scope.submitform = function(){
    $scope.nextstepdis = true;
    NProgress.start();
    regform.formthreeSubmit($scope)
    .success(function(){
      NProgress.done();
      window.location = PATHARRAY.siteurl + '/thankyoupage';
    })
    .error(function(){
      NProgress.done();

    });
  };
}]);
clientapp.controller('TabController', function ($scope, $http, tabsDeals){
    /** Default values **/

    NProgress.configure({parent: '#content'});
    NProgress.start();
    this.tab                = 1;
    $scope.dealid           = 0;
    $scope.tabobject        = {'tab': 1, 'dealID': '', 'deals': '', 'currentuser': '', 'currentdeal': ''};
    $scope.ajaxloadedtwo    = 0;
    $scope.otheruser        = 0;
    $scope.dealstages       = 0;
    $scope.extrainfo        = true;
    $scope.predicate        = 'EscrowUniqueIdentifier';
    /** close popdown **/
    $scope.closethis = function closethis(){
        $scope.extrainfo = true;
    };

    /**   **/
    $scope.contseller  =  function contseller(){
        $scope.extrainfo = false;
    };

    /**    **/
    var handleSuccessgetDeals = function(data, status) {
        NProgress.done();
        $scope.ajaxdata = data;
    };

    /**   **/
    var handleSuccessDealDetails = function(data, status){
        NProgress.done();
        //console.log(data);
        $scope.ajaxloadedtwo = 1;
        $scope.dealdetail = data;
        $scope.dealdetail.proceeds = $scope.dealdetail.LineItems[0].Price - $scope.dealdetail.LineItems[0].SellComm;
    };

    /**   **/
    var handleSuccessCorrespondence = function(data, status){
        NProgress.done();
        $scope.otheruser = data;
        //console.log(data);
    };

    /**   **/
    var handleSuccessstage = function(data, status){
        NProgress.done();

        //console.log(data);
    };

    /**   **/
    var handleSuccessPayment = function(data, status){
        NProgress.done();

        //console.log(data);
    };

    /**   **/
    var handleSuccessContacts = function(data, status){
        NProgress.done();

        //console.log(data);
    };

    /**   **/
    var handleSuccessFiles = function(data, status){
        NProgress.done();

        //console.log(data);
    };

    /**   **/
    var handleError = function(data, status) {
        NProgress.done();
        alert('the following error occured:'+data+'   Please try again');
    };

    /**   **/
    tabsDeals.getDeals($scope).success(handleSuccessgetDeals).error(handleError);

    /**   **/
    $scope.deal_details_warn = function deal_details_warn(){
        alert('Pick a deal from the "Deals" tab');
    };

    /**   **/
    $scope.selectdeal = function selectdeal(setTab, dealid){
            $scope.tabobject.dealID = dealid;
            $scope.dealid = dealid;
            $scope.tabobject.tab = setTab;
            $scope.panel.selectTab(setTab);
            $scope.tabobject.deals = $scope.ajaxdata;
            $scope.tabobject.currentuser = $scope.currentuser;
            $scope.dealstages = 1;
    };

    /**   **/
    this.selectTab = function (setTab){

        $scope.tabobject.tab = setTab;

        this.tab = setTab;
        if(setTab === 1){
            $scope.dealdetail       = '';
            $scope.tabobject.dealID = 0;
            $scope.dealid           = 0;
            $scope.ajaxloadedtwo    = 0;
            $scope.ajaxdata         = '';
            $scope.otheruser        = 0;
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

    /**   **/
    this.isSelected = function(checkTab) {
        return this.tab === checkTab;
    };
});
clientapp.controller('addlisting', function ($scope, $http, wpAPIResource, $upload, $timeout) {
    /** Default Values   **/
    NProgress.configure({parent: '#content'});
    $scope.extrainfo    = true;
    $scope.showlogo     = false;

    /** close popdown **/
    $scope.closethis = function closethis(){
        $scope.extrainfo = true;
    };

    /** deault form settings **/
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
                        "country": "CA",
                        "website": "",
                        "email": "",
                        "cellphn": "",
                        "phone": ""
    };
    $scope.disenb       = true;
    $scope.disenbfields = true;
    //default values
    //autocomplete
    $scope.result2 = '';
    $scope.options2 = {
      country: $scope.listobject.country,
      types: 'geocode'
    };
    $scope.details2 = '';
    //Country watch for autocomplete
    $scope.$watch("listobject.country", function(newValue, oldValue) {
      $scope.options2 = {
        country: $scope.listobject.country,
        types: 'geocode'
      };
    }, true);

    $scope.$watch("details2", function(newValue, oldValue) {


      angular.forEach($scope.details2.address_components, function(value, key){

          $scope.disenb       = false;

          if(value.types[0] == "postal_code"){

              $scope.listobject.pcode =value.long_name;
              $scope.listform.pcode.$setViewValue($scope.listobject.pcode);
              $scope.listform.pcode.$render();

          }else if(value.types[0] == "administrative_area_level_1"){

              $scope.listobject.province = value.long_name;
              $scope.listform.province.$setViewValue($scope.listobject.province);
              $scope.listform.province.$render();

          }else if(value.types[0] == "locality"){

              $scope.listobject.city = value.long_name;
              $scope.listform.city.$setViewValue($scope.listobject.city);
              $scope.listform.city.$render();

          }else if(value.types[0] == "route"  || value.types[0] == "street_number"  ){
              if( $scope.listobject.listaddyone !== ''){
                $scope.listobject.listaddyone =  $scope.listobject.listaddyone + ' ' + value.long_name ;
              }else{
                $scope.listobject.listaddyone =  value.long_name ;
              }
              $scope.listform.listaddyone.$setViewValue($scope.listobject.listaddyone);
              $scope.listform.listaddyone.$render();
          }
          $scope.disenbfields = false;
      });

    }, true);
    /** Submit form **/
    $scope.submitform = function submitform(form) {

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
                        {"key": "wpcf-simple-date-founded", "value": $scope.listobject.fnddate },
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
                        {"key": "wpcf-country", "value": $scope.listobject.country},
                        {"key": "wpcf-consultant-website", "value": $scope.listobject.website},
                        {"key": "wpcf-consultant-email", "value": $scope.listobject.email},
                        {"key": "wpcf-consultant-cell", "value": $scope.listobject.cellphn},
                        {"key": "wpcf-consultant-phone", "value": $scope.listobject.phone}
                ];
            NProgress.start();

            wpAPIResource.save({
                                param1: 'posts'
                                },
                                {
                                  "status": "publish",
                                  "author": PATHARRAY.USERID,
                                  "title": $scope.listobject.listname,
                                  "slug": $scope.listobject.typeoflist,
                                  "type": "listing",
                                  "post_meta": $scope.dataform,
                                  "term":     $scope.catslug,
                                  "tax":      "listing_categy"
                                },
            function(data) {
                // success
                NProgress.done();
                $scope.extrainfo = false;
                $scope.listform.$setPristine(true);
                $scope.model = '';
            }, function(e, headers) {
                // failure
                NProgress.done();

                alert('Failed to add your Listing...');
            });

        }else if(form.$invalid){
            $scope.submitted = true;
            if(form.slltrms.$invalid){
                alert('You must accept the terms');
            }else{
                alert('Your missing some required fields');
            }
        }
    };

    /** FILE UPLOAD **/
    $scope.onFileSelect = function onFileSelect($files) {
        //configue progress bar to top of form
        NProgress.configure({parent: '#logoupload'});
        NProgress.start();

        var file = $files[0];
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
clientapp.controller('singletype', function ($scope, createdeal, watchadd, watchremove){
    /** Default values **/
    NProgress.configure({parent: '#single_cont'});
    $scope.accntobject      = {'userID': '', 'title': '', 'description': '', 'price': '', 'buyer_email': '', 'seller_email': '', 'seller_id': '', 'buyer_id': '', 'listingID': ''};
    $scope.extrainfo        = true;
    $scope.contact          = true;
    /** Close popdown **/
    $scope.closethis        = function closethis(){

        $scope.extrainfo    = true;
        $scope.contact      = true;

    };

    /** Create a new deal! **/
    $scope.newdeal          = function newdeal(){
        //Default values
        $scope.include                  = $scope.templateurl + 'creating_deal.html';
        $scope.accntobject.description  = $scope.singlelistarray.wpcf_buisness_description;
        $scope.accntobject.title        = $scope.singlelistarray.wpcf_listing_name;
        $scope.accntobject.price        = $scope.singlelistarray.wpcf_asking_price;
        $scope.accntobject.listingID    = $scope.singlelistarray.listingID;
        //Buyer info
        $scope.accntobject.buyer_email  = $scope.singlelistarray.current_user_info.user_email;
        $scope.accntobject.buyer_id     = $scope.singlelistarray.current_user_info.ID;
        //Seller info
        $scope.accntobject.seller_email = $scope.singlelistarray.author_info_mine.user_email;
        $scope.accntobject.seller_id    = $scope.singlelistarray.author_info_mine.ID;
        //Start Progress bar
        NProgress.start();
        createdeal.createdeal($scope)
            .success(function(data, status, headers, config) {
                //Stop progress bar
                NProgress.done();
                //set default values
                $scope.checkdeal = 1;
                //$scope.extrainfo                = true;
                $scope.EscrowUniqueIdentifier   = data;
                $scope.include                  = $scope.templateurl + 'deal_created.html';

            }).error(function(data, status, headers, config) {});
    };

    //NOT IN USE
    //$scope.canceldeal       = function canceldeal(){};
    /** Contact user **/
    $scope.contseller           =  function contseller(user_login){
        $scope.contact = false;

    };
    /** Add to watch list! **/
    $scope.watchlist        = function watchlist(userID, watching){
        //Default Values
        $scope.accntobject.userID       = userID;
        $scope.accntobject.watching     = watching;
        $scope.alertaction              = "Adding to watch list";
        $scope.extrainfo                = false;
        $scope.createdeal               = false;
        $scope.include                  = '';

        //Start progress bar
        NProgress.start();
        //Factory start
        watchadd.watchadd($scope)
            .success(function(data, status, headers, config) {
                //Stop progress bar
                NProgress.done();
                //Set return values
                $scope.checkwatching    = 1;
                $scope.extrainfo        = true;
            }).error(function(data, status, headers, config) {
                NProgress.done();
                $scope.alerttext = "Failed to remove please try again";
        });
    };

    /** Prior to new deal! **/
    $scope.expressinterest  = function expressinterest(){
        $scope.alertaction              = "";
        $scope.alerttext                = "";
        $scope.extrainfo                = false;
        $scope.createdeal               = true;
        $scope.include                  = $scope.templateurl + 'contact_gate.html';
        //$scope.newdeal();
    };

    /** Remove from watch list! **/
    $scope.watchlistremove  = function watchlistremove(userID, watching){
        //Default values
        $scope.accntobject.userID       = userID;
        $scope.accntobject.watching     = watching;
        $scope.alertaction              = "Removing from watch list";
        $scope.extrainfo                = false;
        $scope.createdeal               = false;
        $scope.include                  = '';

        //Start progress bar
        NProgress.start();

        watchremove.watchremove($scope)
            .success(function(data, status, headers, config) {
                NProgress.done();
                $scope.checkwatching    = 0;
                $scope.extrainfo        = true;
            })
            .error(function(data, status, headers, config) {
                NProgress.done();
                $scope.alerttext = "Failed to Add please try again";
        });
    };
});
clientapp.controller('watchlistcntrl', function ($scope, getwatchloop, watchremove){
    /** Default data **/
    NProgress.configure({parent: '#content'});
    //Start loading bar on page load
    NProgress.start();
    $scope.radiodata            = {'listtype': 'all'};
    $scope.accntobject          = {'userID': '', 'watching':'' };
    $scope.extrainfo            = true;
    $scope.contact              =  true;
    $scope.select_city          = '';
    $scope.select_state         = '';
    $scope.select_country       = '';
    $scope.search               = '';
    $scope.radiodata.listtype   = 'all';
    $scope.selectedTitle    = "All";
    $scope.listtypes        = {selling: false, buying: false, advisor: false};
    $scope.titles           = [
       {title: "All", filtertitle: "All"},
       {title: "Sellers", filtertitle: "Selling"},
       {title: "Buyers", filtertitle: "Buying"},
       {title: "Consultants", filtertitle: "Advisors/Consultants"}
    ];
    /**    **/
    $scope.setSelectedTitle = function setSelectedTitle(value) {
        if ($scope.selectedTitle === value) {
            $scope.selectedTitle = undefined;
        } else {
            $scope.selectedTitle = value;
        }
            $scope.radiodata.listtype   = '';
    };
    /** Get Watch list on page load **/
    getwatchloop.getwatchloop($scope)
        .success(function(data, status, headers, config){
            NProgress.done();
            $scope.watchloop = data;
        })
        .error(function(data, status, headers, config) {
            NProgress.done();
        });

    /** Open popup message window and set uer to send to.. **/
    $scope.contseller           =  function contseller(user_login){
        $scope.contact = false;
        $scope.user_login = user_login;
    };

    /** Close popup window **/
    $scope.closethis           = function closethis(){
        $scope.contact = true;
    };

    /** Remove from watchlist**/
    $scope.watchlistremove     = function watchlistremove(userID, watching){
        $scope.accntobject.userID = userID;
        $scope.accntobject.watching = watching;
        NProgress.start();
        watchremove.watchremove($scope)
            .success(function(data, status, headers, config) {
                /** Reload watchlist**/
                getwatchloop.getwatchloop($scope)
                    .success(function(data, status, headers, config){
                        NProgress.done();
                        $scope.watchloop = data;
                    })
                    .error(function(data, status, headers, config) {
                        NProgress.done();
                    });
            })
            .error(function(data, status, headers, config) {
                NProgress.done();
                alert('the following error occured:'+data+'   Please try again');
        });
    };
    /** Check if value is defined uses to dyanmically display shit **/
    $scope.isDefined           = function(x) {
      return angular.isDefined(x);
   };
   $scope.byTitle = function byTitle(listing){
       if($scope.selectedTitle == "All"){
          return listing.postmeta.wpcf_listing_type;
       }else{
           return listing.postmeta.wpcf_listing_type === $scope.selectedTitle || $scope.selectedTitle === undefined;
       }
   };
   /** Clear all! **/
   $scope.clearChoices = function clearChoices(){

       $scope.select_city          = '';
       $scope.select_state         = '';
       $scope.select_country       = '';
       $scope.wordsearch           = '';
       $scope.selectedTitle        = "All";
       $scope.radiodata.listtype   = '';
   };
});
clientapp.controller('fullloop', function ($scope, wpAPIResource, $http, getlistingloop, $filter){
    /**  Default Vaules **/
    NProgress.configure({parent: '#content'});
    NProgress.start();
    // set available range efault this get's overwrote the moment the loop is returned
    $scope.minPrice         = 0;
    $scope.maxPrice         = 1999;
    // default the user's values to the available range
    $scope.userMinPrice     = $scope.minPrice;
    $scope.userMaxPrice     = $scope.maxPrice;
    $scope.radiodata        = {'listtype': ''};

    $scope.titles           = [
       {title: "All", filtertitle: "All"},
       {title: "Sellers", filtertitle: "Selling"},
       {title: "Buyers", filtertitle: "Buying"},
       {title: "Consultants", filtertitle: "Advisors/Consultants"}
    ];

    $scope.selectedTitle    = "All";
    $scope.listtypes        = {selling: false, buying: false, advisor: false};
    $scope.sellloop         = 'sell loop';
    $scope.prices           = [];

    /** Get Full loop **/
    getlistingloop.getlistingloop($scope)
        .success(function(data, status, headers, config){
            NProgress.done();
            $scope.arraydata        = data;

            angular.forEach($scope.arraydata, function(value, key) {
                if(value.postmeta.wpcf_listing_type == "Selling"){
                    $scope.prices.push(value.postmeta.wpcf_asking_price);
                }

            });
            $scope.maxPrice         = Math.max.apply(Math,$scope.prices); // 3
            $scope.minPrice         = Math.min.apply(Math,$scope.prices); // 1
            $scope.userMinPrice     = $scope.minPrice;
            $scope.userMaxPrice     = $scope.maxPrice;
        })
        .error(function(data, status, headers, config) {
            NProgress.done();
    });

    /** Clear all! **/
    $scope.clearChoices = function clearChoices(){

        $scope.select_city          = '';
        $scope.select_state         = '';
        $scope.select_country       = '';
        $scope.wordsearch           = '';
        $scope.selectedTitle        = "All";
        $scope.userMinPrice         = $scope.minPrice;
        $scope.userMaxPrice         = $scope.maxPrice;
        $scope.radiodata.listtype   = '';
    };

    /**    **/
    $scope.byTitle = function byTitle(listing){
        if($scope.selectedTitle == "All"){
           return listing.postmeta.wpcf_listing_type;
        }else{
            return listing.postmeta.wpcf_listing_type === $scope.selectedTitle || $scope.selectedTitle === undefined;
        }
    };

    /**    **/
    $scope.setSelectedTitle = function setSelectedTitle(value) {
        if ($scope.selectedTitle === value) {
            $scope.selectedTitle = undefined;
        } else {
            $scope.selectedTitle = value;
        }
            $scope.radiodata.listtype   = '';
    };
});
clientapp.controller('advertiseform', function ($scope, wpAPIResource, $http){});
clientapp.controller('mylistings', function ($scope, getmylistings, deletelist){
    /**Default Values**/
    NProgress.configure({parent: '#content'});
    NProgress.start();
    $scope.contact = true;

    /** **/
    getmylistings.getmylistings($scope)
      .success(function(data, status, headers, config) {
                NProgress.done();
                $scope.arraydata        = data;
            })
            .error(function(data, status, headers, config) {
                NProgress.done();
                alert('the following error occured:'+data+'   Please try again');
    });
    /**  **/
    $scope.closethis = function closethis(){
        $scope.contact = true;
    };

    /**  **/
    $scope.deletelist = function deletelist(listID){
        $scope.contact      = false;
        $scope.posteditID   = listID;
    };
    $scope.deletelistsure = function deletelistsure(){
        NProgress.configure({parent: '#addealinfo'});
        NProgress.start();

        deletelist.deletelist($scope)
          .success(function(data, status, headers, config) {
                    NProgress.done();
                    location.reload();

                })
                .error(function(data, status, headers, config) {
                    NProgress.done();
                    alert('the following error occured:'+data+'   Please try again');
        });
    };
});
clientapp.controller('editlisting', function ($scope, getlistedit, editlisting, $upload){
    /** DEfault Values **/
    $scope.extrainfo = true;
    NProgress.configure({parent: '#addealinfo'});
    NProgress.start();

    /** close popdown **/
    $scope.closethis = function closethis(){
        $scope.extrainfo = true;
    };

    /**Submit form **/
    $scope.submitform = function submitform(form) {
        $scope.extrainfo    = false;
        $scope.alertaction  = "Updating Listing";
        $scope.alerttext    = "Please wait";
        // check to make sure the form is completely valid

        if (form.$valid){

            NProgress.start();
            editlisting.editlisting($scope)
                .success(function(data, status, headers, config) {
                    $scope.extrainfo    = false;
                    NProgress.done();
                    $scope.alerttext    = "Listing updated successfully";

                })
                .error(function(data, status, headers, config) {
                    NProgress.done();
                    $scope.alerttext    = 'the following error occured:'+data+'   Please try again';
            });

        }else if(form.$invalid){
            $scope.submitted = true;
            $scope.alerttext    = 'Your missing some required fields!';
        }
    };
    /** Get Post ID **/
    $scope.$watch('posteditID', function(){
        $scope.extrainfo    = false;
        $scope.alertaction  = "Retriving  Listing";
        $scope.alerttext    = "Please wait";

        getlistedit.getlistedit($scope)
          .success(function(data, status, headers, config) {
                    NProgress.done();
                    $scope.extrainfo        = true;
                    $scope.arraydata        = data;
                    $scope.arraydata.wpcf_number_of_clients    =  parseInt($scope.arraydata.wpcf_number_of_clients);
                    $scope.arraydata.wpcf_annual_compensation_from_investment_trailers    =  parseInt($scope.arraydata.wpcf_annual_compensation_from_investment_trailers);
                    $scope.arraydata.wpcf_asking_price    =  parseInt($scope.arraydata.wpcf_asking_price);
                    $scope.arraydata.posteditID    =  parseInt($scope.posteditID);
                })
                .error(function(data, status, headers, config) {
                    NProgress.done();
                    alert('the following error occured:'+data+'   Please try again');
            });
    });
    /** FILE UPLOAD **/
    $scope.onFileSelect = function onFileSelect($files) {
        //configue progress bar to top of form
        NProgress.configure({parent: '#logoupload'});
        NProgress.start();

        var file = $files[0];
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
                $scope.arraydata.wpcf_logo = data;
                $scope.showlogo = true;
                $scope.showurl  = true;
            }else{
                $scope.arraydata.wpcf_logo = data;
                $scope.showurl = true;
            }
          });
    };

});

/*
    Factories galore
*/
//Reg form factories
clientapp.factory('regform', ['$http', function($http){
  return {
      formoneCheck: function($scope) {
          return  $http({
              method: 'POST',
              url: PATHARRAY.siteurl +'/wp-admin/admin-ajax.php',
              data: $scope.formmodel,
              params: { 'action': 'reg_form_one_check'}
          });
      },
      formthreeSubmit: function($scope) {
          return  $http({
              method: 'POST',
              url: PATHARRAY.siteurl +'/wp-admin/admin-ajax.php',
              data: $scope.formmodel,
              params: { 'action': 'reg_form_three'}
          });
      },
    };
}]);
//tabs functions
clientapp.factory('tabsDeals', function($http){
    return {
        getDeals: function($scope) {
            return  $http({
                method: 'POST',
                url: PATHARRAY.siteurl + '/wp-admin/admin-ajax.php',
                data: $scope.tabobject,
                params: { 'action': 'tab_select_deallloop'}
            });
        },
        DealDetails: function($scope){
            return $http({
                method: 'POST',
                url: PATHARRAY.siteurl + '/wp-admin/admin-ajax.php',
                data: $scope.tabobject,
                params: { 'action': 'deal_details'}
            });
        },
        Correspondence: function($scope){
            return $http({
                method: 'POST',
                url: PATHARRAY.siteurl + '/wp-admin/admin-ajax.php',
                data: $scope.tabobject,
                params: { 'action': 'deal_Correspondence'}
            });
        },
        stage: function($scope){
            return $http({
                method: 'POST',
                url: PATHARRAY.siteurl + '/wp-admin/admin-ajax.php',
                data: $scope.tabobject,
                params: { 'action': 'deal_stage'}
            });
        },
        Payment: function($scope){
            return $http({
                method: 'POST',
                url: PATHARRAY.siteurl + '/wp-admin/admin-ajax.php',
                data: $scope.tabobject,
                params: { 'action': 'deal_Payment'}
            });
        },
        Contacts: function($scope){
            return $http({
                method: 'POST',
                url: PATHARRAY.siteurl + '/wp-admin/admin-ajax.php',
                data: $scope.tabobject,
                params: { 'action': 'deal_Contacts'}
            });
        },
        Files: function($scope){
            return $http({
                method: 'POST',
                url: PATHARRAY.siteurl + '/wp-admin/admin-ajax.php',
                data: $scope.tabobject,
                params: { 'action': 'deal_Files'}
            });
        },
    };
});
//Retrive users own listings
clientapp.factory('getmylistings', function($http) {
    return {
        getmylistings: function(){
            return  $http({
                        method: 'GET',
                        url: PATHARRAY.siteurl + '/wp-admin/admin-ajax.php',
                        params: { 'action': 'get_my_listings'}
                    });
        }

    };
});
//Retrive get list to edit
clientapp.factory('getlistedit', function($http) {
    return {
        getlistedit: function($scope){
            return  $http({
                        method: 'POST',
                        url: PATHARRAY.siteurl + '/wp-admin/admin-ajax.php',
                        data: $scope.posteditID,
                        params: { 'action': 'get_list_edit'}
                    });
        }

    };
});
//Delete list
clientapp.factory('deletelist', function($http) {
    return {
        deletelist: function($scope){
            return  $http({
                        method: 'POST',
                        url: PATHARRAY.siteurl + '/wp-admin/admin-ajax.php',
                        data: $scope.posteditID,
                        params: { 'action': 'delete_listing'}
                    });
        }

    };
});
//Retrive watchloop
clientapp.factory('getwatchloop', function($http) {
    return {
        getwatchloop: function(){
            return  $http({
                        method: 'GET',
                        url: PATHARRAY.siteurl + '/wp-admin/admin-ajax.php',
                        params: { 'action': 'watch_list'}
                    });
        }

    };
});
//edit listing
clientapp.factory('editlisting', function($http) {
    return {
        editlisting: function($scope){
            return  $http({
                        method: 'POST',
                        url: PATHARRAY.siteurl + '/wp-admin/admin-ajax.php',
                        data: $scope.arraydata,
                        params: { 'action': 'edit_listing'}
                    });
        }

    };
});
//Create a escrow deal
clientapp.factory('createdeal', function($http) {
    return {
        createdeal: function($scope){
            return  $http({
                            method: 'POST',
                            url: PATHARRAY.siteurl + '/wp-admin/admin-ajax.php',
                            data: $scope.accntobject,
                            params: { 'action': 'create_deal'}
                    });
        }

    };
});
//get all listings
clientapp.factory('getlistingloop', function($http) {
    return {
        getlistingloop: function(){
            return  $http({
                        method: 'GET',
                        url: PATHARRAY.siteurl + '/wp-admin/admin-ajax.php',
                        params: { 'action': 'get_listing_loop'}
                    });
        }

    };
});
//Add to watch list
clientapp.factory('watchadd', function($http) {
    return {
        watchadd: function($scope){
            return  $http({
                            method: 'POST',
                            url: PATHARRAY.siteurl + '/wp-admin/admin-ajax.php',
                            data: $scope.accntobject,
                            params: { 'action': 'watch_add'}
                    });
        }

    };
});
//Add to watch list
clientapp.factory('watchremove', function($http) {
    return {
        watchremove: function($scope){
            return  $http({
                            method: 'POST',
                            url: PATHARRAY.siteurl + '/wp-admin/admin-ajax.php',
                            data: $scope.accntobject,
                            params: { 'action': 'watch_remove'}
                    });
        }

    };
});

/*
    Filters galore
*/
//Check for undefined value in html
clientapp.filter('undefined', function(){
    return function(input, message) {
        return angular.isDefined(input) ? input : message;
    };
});
clientapp.filter('customunique', function() {
   return function(collection, keyname) {
      var output = [], keys = [];

      angular.forEach(collection, function(item, keyvalue) {
        var key       = item.postmeta[keyname];
        var checkit   = item.postmeta.hasOwnProperty(keyname);
        if(keys.indexOf(key) === -1 && key.replace(/\s/g,"") !== '') {
            keys.push(key);
            output.push(item);
        }
    });

      return output;
   };
});

//escapeurl for model
clientapp.filter('escape', function() {
  return window.encodeURIComponent;
});

//Used to return unique items from array for dropdown
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
//Used for slider on selling listings loop
clientapp.filter("minmaxfilter", function() {
  return function(items, from, to, title) {
    if(title == "Selling"){
        var from = parseInt(from);
        var to = parseInt(to);
        var result = [];
        angular.forEach(items, function(value, key){
            var price = parseInt(value.postmeta.wpcf_asking_price);
            if(price >= from && price <= to){
                result.push(value);
            }
        });
        return result;

    }else{
        return items;
    }
  };
});
/*
    Directives galore
*/
clientapp.directive('aDisabled', function() {
    return {
        compile: function(tElement, tAttrs, transclude) {
            //Disable ngClick
            tAttrs["ngClick"] = "!("+tAttrs["aDisabled"]+") && ("+tAttrs["ngClick"]+")";

            //return a link function
            return function (scope, iElement, iAttrs) {

                //Toggle "disabled" to class when aDisabled becomes true
                scope.$watch(iAttrs["aDisabled"], function(newValue) {
                    if (newValue !== undefined) {
                        iElement.toggleClass("disabled", newValue);
                    }
                });

                //Disable href on click
                iElement.on("click", function(e) {
                    if (scope.$eval(iAttrs["aDisabled"])) {
                        e.preventDefault();
                    }
                });
            };
        }
    };
});
//popdown
clientapp.directive("centered", function() {
  return {
        restrict : "ECA",
        transclude : true,
        template : '<div class=\"angular-center-container\">\
                        <div class=\"angular-centered\" ng-transclude>\
                        </div>\
                    </div>'
    };
});
clientapp.directive("passwordVerify", function() {
   return {
      require: "ngModel",
      scope: {
        passwordVerify: '='
      },
      link: function(scope, element, attrs, ctrl) {
        scope.$watch(function() {
            var combined;

            if (scope.passwordVerify || ctrl.$viewValue) {
               combined = scope.passwordVerify + '_' + ctrl.$viewValue;
            }
            return combined;
        }, function(value) {
            if (value) {
                ctrl.$parsers.unshift(function(viewValue) {
                    var origin = scope.passwordVerify;
                    if (origin !== viewValue) {
                        ctrl.$setValidity("passwordVerify", false);
                        return false;
                    } else {
                        ctrl.$setValidity("passwordVerify", true);
                        return viewValue;
                    }
                });
            }
        });
     }
   };
});
