//(function(jQuery) {

	jQuery( document ).ready(function() {
		jQuery("#close_login").on("click", function(e){
	        close_login_modal();
	    });

		jQuery("#login").on("click", function(e){
	        show_login_modal("login");
	    });

		jQuery("#recuperar").on("click", function(e){
	        show_login_modal("recuperar");
	    });

		jQuery("#login_submit").on("click", function(e){
			logear();
			e.preventDefault();
	    });

	    jQuery("#form_login").submit(function(e){ 
	    	logear(); 
	   	});
	});

	function logear(){
		jQuery.post( 
	    	HOME+"/procesos/login/login.php", {
	    		usu: jQuery("#form_login #usuario").val(),
	    		clv: jQuery("#form_login #clave").val()
	    	}
	    ).done(
	    	function( data ) {
			    location.reload();
		  	}
	  	);
	}

	function show_login_modal(seccion){
		switch(seccion){
			case "login":
				jQuery(".modal_login form").css("display", "none");
				jQuery("#form_login").css("display", "block");
			break;
			case "recuperar":
				jQuery(".modal_login form").css("display", "none");
				jQuery("#form_recuperar").css("display", "block");
			break;
		}
	    jQuery(".modal_login").css("display", "table");
	}

	function close_login_modal(){
	    
	    jQuery(".modal_login").hide();
	}
	
//});