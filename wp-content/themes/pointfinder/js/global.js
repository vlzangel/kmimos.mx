(function($) {

	$( document ).ready(function() {
		$("#close_login").on("click", function(e){
	        close_login_modal();
	    });

		$("#login").on("click", function(e){
	        show_login_modal("login");
	    });

		$("#recuperar").on("click", function(e){
	        show_login_modal("recuperar");
	    });

		$("#login_submit").on("click", function(e){
			logear();
			e.preventDefault();
	    });

	    $("#form_login").submit(function(e){ 
	    	logear(); 
	   	});
	});

	function logear(){
		$.post( 
	    	HOME+"/procesos/login/login.php", {
	    		usu: $("#form_login #usuario").val(),
	    		clv: $("#form_login #clave").val()
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
				$(".modal_login form").css("display", "none");
				$("#form_login").css("display", "block");
			break;
			case "recuperar":
				$(".modal_login form").css("display", "none");
				$("#form_recuperar").css("display", "block");
			break;
		}
	    $(".modal_login").css("display", "table");
	}

	function close_login_modal(){
	    
	    $(".modal_login").hide();
	}
	
});