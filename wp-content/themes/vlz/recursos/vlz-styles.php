<style type="text/css">
	
	body{
		margin: 0px;
	    padding-top: 78px;
	}

	header{
	    position: fixed;
	    top: 0px;
	    left: 0px;
	    width: 100%;
	    height: 110px;
	    background: #59c9a8;
	    box-sizing: border-box;
	    padding: 0px;
	    margin: 0px;
        z-index: 9999999999999999999999;
	}

	footer{
		background-image: url(<?php echo get_template_directory_uri()."/recursos/imgs/footerBg.png"; ?>);
	    background-repeat: no-repeat;
	    background-size: cover;
	    height: 420px;
	    padding-top: 150px !important;
	    padding-bottom: 20px !important;
	    font-family: 'Roboto', sans-serif !important;
	    font-style: italic !important;
        color: #FFF;
	}

	footer ul{
		list-style: none;
	}

	footer a{
		text-decoration: none;
		color: #FFF;
	}

	footer h2{
		font-size: 21px;
		font-weight: 400;
	}

	.socialBtn {
	    width: 57px;
	    height: 46px;
	    display: inline-block;
	}

	.facebookBtn {
	    background-image: url(<?php echo get_template_directory_uri()."/recursos/imgs/facebookBtn.png"; ?>);
	}

	.twitterBtn {
	    background-image: url(<?php echo get_template_directory_uri()."/recursos/imgs/twitterBtn.png"; ?>);
	}

	.instagramBtn {
	    background-image: url(<?php echo get_template_directory_uri()."/recursos/imgs/instagramBtn.png"; ?>);
	}

	/* Menu */
		.contenedor_logo{
		    position: absolute;
		    left: 0px;
		    top: 0px;
		    width: 200px;
		    height: 80px;
		    background-position: left center;
		    background-repeat: no-repeat; 
		    display: inline-block;
		}

		#site-navigation{
			position: relative;
			max-width: 1150px;
    		margin: 0px auto;
	        height: 80px;
		}
		#site-navigation a{
			text-decoration: none;
		    font-family: "Open Sans";
    		font-size: 15px;
		}
		.contenedor_menu{
		    position: absolute;
		    top: 0px;
		    right: 0px;
		}
		#menu-main{
		    list-style: none;
		    padding: 0px;
		    margin: 0px;
		    text-align: right;
		    vertical-align: top;
		}
		#menu-main li{
			display: inline-block;
			padding: 0px;
			margin: 0px;
			vertical-align: top;
			text-align: left;
			float: left;
			position: relative;		
		}
		#menu-main > li > a {
			padding: 29px 10px 30px;
			display: inline-block;
    		color: #FFF;
    		transition-duration: 0.2s;
		}
		#menu-main > li:hover > a {
    		background: rgba(255, 255, 255, 0.3);
    		transition-duration: 0.2s;
		}
		#menu-main .sub-menu{
			max-width: 200px;
		}
		#menu-main > li > .sub-menu{
			position: absolute;
		    margin: 0px;
		    padding: 0px;
		    min-width: 214px;
    		display: none;
		}

		#menu-main > li.menu-item-has-children > a{
			padding: 29px 25px 30px 10px;
		}

		#menu-main > li.menu-item-has-children::after{
		    content: '';
		    position: absolute;
		    top: calc( 50% - 2px );
		    right: 5px;
		    border-top: solid 10px #FFF;
		    width: 0;
		    height: 0;
		    border-left: 5px solid transparent;
		    border-top: 5px solid #ffffff;
		    border-right: 5px solid transparent;
		}

		#menu-main > li > .sub-menu li{
    		display: block;
			float: none;
		}
		#menu-main .sub-menu li > a{
    		display: block;
    		padding: 10px;
    		background: #FFF;
    		font-size: 15px;
    		transition-duration: 0.2s;
		}
		#menu-main .sub-menu li > a:hover{
			color: #FFF;
	   	 	background: #59c9a8;
    		transition-duration: 0.2s;
		}

		#menu-main > li > .sub-menu li a{
			color: #757575;
		}

		#menu-main > li:hover > .sub-menu{
    		display: inline-block;
		}

		#site-navigation-user{
		    width: 100%;
		    height: 30px;
		    background: #23475e;
		}

		#site-navigation-user .secundary-menu{
		    position: relative;
		    max-width: 1150px;
		    margin: 0px auto;
		}

		#site-navigation-user .contenedor_menu_externo{
    		position: relative;
		    max-width: 1150px;
		    margin: 0px auto;
		}

		#site-navigation-user .secundary-menu{
			list-style: none;
		}

		#site-navigation-user .secundary-menu li{
			float: left;
		}

		#site-navigation-user .secundary-menu li a{
			color: #FFF;
			padding: 7px 10px;
			text-decoration: none;
			font-size: 14px;
			font-family: "Roboto Condensed",Arial, Helvetica, sans-serif;
			display: inline-block;
		}

		#site-navigation-user .secundary-menu li a:hover{
		    background: rgba(255, 255, 255, 0.2);
		}

	/* Mapa */

      	.vlz_contenedor_mapa{
      		position: relative;
      		height: 450px;
      	}

      	#map { 
      		height: 450px;
      		z-index: 1;
      	}

      	.vlz_filtros { 
		    position: absolute;
		    bottom: 0px;
		    left: 0px;
		    width: 100%;
		    z-index: 100;
		    background: rgba(0, 0, 0, 0.5);
		    box-sizing: border-box;
		    text-align: center;
		    padding: 20px;
      	}

      	.vlz_input{
  		    padding: 10px;
		    border-radius: 5px;
		    width: 15%;
		    outline: none;
      	}

      	.vlz_date{
      		padding: 7px;
		    border-radius: 5px;
		    width: 15%;
		    font-size: 16px !important;
		    border: 0;
		    outline: none;
      	}

      	.vlz_input:focus,
      	.vlz_boton:focus,
      	.vlz_date:focus
      	{
      		box-shadow: 0px 0px 0px #000;
      	}

      	.vlz_boton{
  		    padding: 10px;
		    border-radius: 5px;
		    width: 15%;
		    background: #6cba9b;
		    color: white;
		    font-size: 16px !important;
		    border: 0;
		    cursor: pointer;
		    outline: none;
      	}

    /* Resultados */

		.vlz_contenedor_cuidador {
		    position: relative;
		    display: inline-block;
		    width: 25%;
		    box-sizing: border-box;
		    padding: 10px;
		}

    	.vlz_contenedor_foto{
		    height: 300px;
		    background-size: cover;
		    background-position: center;
		    background-repeat: no-repeat;
		    border: solid 1px #CCC;
		    z-index: 1;
		    filter: blur(1px);
    		overflow: hidden;
    	}

    	.vlz_foto{
			height: 280px;
			width: calc( 100% - 60px );
			background-size: contain;
			background-position: center;
			background-repeat: no-repeat;
			position: absolute;
			top: 20px;
			z-index: 100;
			left: 30px;
    	}

    	.vlz_nombre{
			padding: 5px;
			font-size: 16px;
			font-family: Roboto;
			border: solid 1px #CCC;
			border-top: 0;
			border-bottom: 0;
		    text-transform: capitalize;
    	}

    	.vlz_precio {
			padding: 5px;
			font-size: 16px;
			font-family: Roboto;
			text-align: right;
			border: solid 1px #CCC;
			border-top: 0;
		}

		a.vlz_link {
		    position: absolute;
		    top: 0px;
		    left: 0px;
		    width: 100%;
		    height: 100%;
		    z-index: 100;
		}
</style>