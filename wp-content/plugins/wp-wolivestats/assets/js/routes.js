
angular.module("Wolive").config(function($routeProvider, $locationProvider){

	$routeProvider
	.when ('/', {
		templateUrl: wolive_assets_url+ 'js/templates/index.html',
		controller: "OverviewController",
		controllerAs: "overview"
        })

        .when ('/Users/:id?', {
            templateUrl: wolive_assets_url+ 'js/templates/users.html',
            controller: "UsersController",
            controllerAs: "users"
	})

	.when ('/Woocommerce', {
	    templateUrl: wolive_assets_url+ 'js/templates/wooindex.html',
            controller: "WooController",
            controllerAs: "woocommerce"
	})


    	.when ('/Reports', {
	    templateUrl: wolive_assets_url+ 'js/templates/reports.html',
            controller: "Reports",
            controllerAs: "report"
	})


	.otherwise ({redirectTo:"/"})
	;






});




