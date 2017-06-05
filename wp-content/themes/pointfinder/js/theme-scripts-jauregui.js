function number_format(e,t,n,r){e=(e+"").replace(/[^0-9+\-Ee.]/g,"");var i=!isFinite(+e)?0:+e,s=!isFinite(+t)?0:Math.abs(t),o=typeof r==="undefined"?",":r,u=typeof n==="undefined"?".":n,a="",f=function(e,t){var n=Math.pow(10,t);return""+(Math.round(e*n)/n).toFixed(t)};a=(s?f(i,s):""+Math.round(i)).split(".");if(a[0].length>3){a[0]=a[0].replace(/\B(?=(?:\d{3})+(?!\d))/g,o)}if((a[1]||"").length<s){a[1]=a[1]||"";a[1]+=(new Array(s-a[1].length+1)).join("0")}return a.join(u)}
function numbersonly(e,t,n){var r;var i;if(window.event)r=window.event.keyCode;else if(t)r=t.which;else return true;i=String.fromCharCode(r);if(r==null||r==0||r==8||r==9||r==13||r==27)return true;else if("0123456789".indexOf(i)>-1)return true;else if(n&&i=="."){e.form.elements[n].focus();return false}else return false}
jQuery.fn.center=function(absolute){return this.each(function(){var t=jQuery(this);t.css({position:absolute?'absolute':'fixed',left:'50%',top:'50%',zIndex:'99'}).css({marginLeft:'-'+(t.outerWidth()/2)+'px',marginTop:'-'+(t.outerHeight()/2)+'px'});if(absolute){t.css({marginTop:parseInt(t.css('marginTop'),10)+jQuery(window).scrollTop(),marginLeft:parseInt(t.css('marginLeft'),10)+jQuery(window).scrollLeft()})}})};

if (!String.prototype.format) {
  String.prototype.format = function() {
    var args = arguments;
    return this.replace(/{(\d+)}/g, function(match, number) { 
      return typeof args[number] != "undefined"
        ? args[number]
        : match
      ;
    });
  };
}

jQuery.validator.addMethod("pattern", function(value, element, param) {
  if (this.optional(element)) {
    return true;
  }
  if (typeof param === 'string') {
    param = new RegExp('^(?:' + param + ')$');
  }
  return param.test(value);
}, "Formato Inválido.");

(function($) {
  "use strict";
  
  	$.fn.reverse = [].reverse;

	function pfOrientResizeFunction(){
		// window.location.reload();
	}
	if (window.DeviceOrientationEvent) {
		window.addEventListener('orientationchange', pfOrientResizeFunction, false);
	}

	$('#pfpostitemlink a').on('click', function(event) {
		if (theme_scriptspf.userlog == 1) {
			window.location = theme_scriptspf.dashurl;
		}else{
			$.pfOpenLogin('open','login','','',2);
		};

	});



/***************************************************************************************************************
*
*
* DIRECTORY LIST FUNCTIONS
*
*
***************************************************************************************************************/
	$('.pf-main-term a').mouseover(function(event) {
		$(this).css({
			color: $(this).data('hovercolor'),
		});
	});

	$('.pf-main-term a').mouseleave(function(event) {
		$(this).css({
			color: $(this).data('standartc'),
		});
	});

	$('.pf-child-term a').mouseover(function(event) {
		$(this).css({
			color: $(this).data('hovercolor'),
		});
	});

	$('.pf-child-term a').mouseleave(function(event) {
		$(this).css({
			color: $(this).data('standartc'),
		});
	});


/***************************************************************************************************************
*
*
* HORIZONTAL SEARCH WINDOW FUNCTIONS
*
*
***************************************************************************************************************/

	$('.pfsopenclose').live('click touchstart', function(event) {
		$( "#pfsearch-draggable" ).toggle( "slide",{direction:"up",mode:"hide"},function(){
			$('.pfsopenclose').fadeToggle("fast");
			$('.pfsopenclose2').fadeToggle("fast");
		});
	});
	$('.pfsopenclose2').live('click touchstart', function(event) {
		$('.pfsopenclose2').fadeToggle("fast");
		$( "#pfsearch-draggable" ).toggle( "slide",{direction:"up",mode:"show"},function(){
			$('.pfsopenclose').fadeToggle("fast");
		});
	});



/***************************************************************************************************************
*
*
* PF GET SUB ITEMS FOR SEARC
*
*
***************************************************************************************************************/
	$.PFGetSubItems = function(pfcat,pformvalues,widgetpf,horpf){
		if(pfcat != null && pfcat != 'undefined' && pfcat != ''){
			if (pfcat.length !== 0) {
				$.ajax({
					beforeSend: function(){
						$('.pfsearch-content').pfLoadingOverlay({action:'show',opacity:0.5});
					},
		            type: 'POST',
		            dataType: 'html',
		            url: theme_scriptspf.ajaxurl,
		            data: { 
		                'action': 'pfget_searchitems',
		                'pfcat': pfcat,
		                'formvals': pformvalues,
		                'widget':widgetpf,
		                'hor':horpf,
		                'cl':theme_scriptspf.pfcurlang,
		                'security': theme_scriptspf.pfget_searchitems
		            },
		            success:function(data){
						$('#pfsearchsubvalues').html(data);
		            },
		            complete: function(){
		            	$('.pfsearch-content').pfLoadingOverlay({action:'hide'});
		            },
		        });
			};
		};
	};


/***************************************************************************************************************
*
*
* PF RENEW FEATURES WHEN LISTING TYPE SELECTED
*
*
***************************************************************************************************************/
	$.PFRenewFeatures = function(pfcat,fieldid){
		if(pfcat != null && pfcat != 'undefined' && pfcat != ''){
			if (pfcat.length !== 0) {
				$.ajax({
					beforeSend: function(){
						$('.pfsearch-content').pfLoadingOverlay({action:'show',opacity:0.5});
					},
		            type: 'POST',
		            dataType: 'html',
		            url: theme_scriptspf.ajaxurl,
		            data: { 
		                'action': 'pfget_featuresfilter',
		                'pfcat': pfcat,
		                'cl':theme_scriptspf.pfcurlang,
		                'security': theme_scriptspf.pfget_searchitems
		            },
		            success:function(data){
		            	$('#'+fieldid)
						    .find('option')
						    .remove()
						    .end()
						    .append('<option></option>'+data);
		            },
		            complete: function(){
		            	$('.pfsearch-content').pfLoadingOverlay({action:'hide'});
		            },
		        });
			};
		};
	};
  
  
/***************************************************************************************************************
*
*
* PF GENERAL FUNCTIONS & ACTIONS
*
*
***************************************************************************************************************/
	
	$.pfscrolltotop = function(){$.smoothScroll();};
	$.pfmessagehide = function(){
		/*
		setTimeout(function() { 
			$('#pfuaprofileform-notify').hide("slide",{direction : "up"},100);
		}, 5000);
		*/
	};


	
	/*Fix for sharebar*/
	$('.pf-sharebar-icons li a').live('click',function(){
	  	return false;
	});

	$.pf_mobile_check = function(){
		if ($(window).width() > 568) {return true;} else{return false;};
	}

	$.pf_tablet_check = function(){
		if ($(window).width() > 992) {return true;} else{return false;};
	}

	$.pf_tablet2_check = function(){
		if ($(window).width() > 1024) {return true;} else{return false;};
	}

	
		

	
	
	$(function() {
		/*Please select fix for mobile*/
			setTimeout(function(){
				if ($.pf_tablet_check() == false) {
					$(".pf-special-selectbox").each(function(index, el) {
						$(this).children('option:first').remove();

						var dataplc = $(this).data('pf-plc');
						if (dataplc) {
							$(this).prepend('<option value="">'+dataplc+'</option>');
						}else{
							$(this).prepend('<option value="">'+theme_scriptspf.pfselectboxtex+'</option>');
						};
					});
				};
			},1000);

		if ($('#respond.comment-respond').length > 0) {$('#respond.comment-respond').addClass('golden-forms')};
		$('.pfshowmaplink').live('click',function(){

			var markerit_id = $(this).data('pfitemid');
			var marker_this = $("#wpf-map").gmap3({
			    get: {
			      id: ""+markerit_id+""
			    }
			  });
			var map_this = $("#wpf-map").gmap3('get');
			map_this.setZoom(12);
			var pos = marker_this.getPosition();
		
			if($.pf_mobile_check()){
				$.pfmap_recenter(map_this,marker_this.getPosition(),0,0);
			}else{
				$.pfmap_recenter(map_this,marker_this.getPosition(),0,-70);
			}
			setTimeout(function(){
				$.pfloadinfowindow(marker_this, '', markerit_id);
				if($.pf_tablet_check()){
					if ($.isEmptyObject($.zindexclicker)) { $.zindexclicker = {}; $.zindexclicker.click = 0};
		  			$.zindexclicker.click++
					marker_this.setZIndex(google.maps.Marker.MAX_ZINDEX + $.zindexclicker.click);
				}
			},300)
			$.pfscrolltotop();
			return false;
		});

		$(window).scroll(function(){
			if ($(this).scrollTop() > 100) {
				$('.pf-up-but').fadeIn();
			} else {
				$('.pf-up-but').fadeOut();
			}
		});
		
		//Click event to scroll to top
		$('.pf-up-but').click(function(){
			$('html, body').animate({scrollTop : 0},800);
			return false;
		});
	
		
		$("a[rel^='prettyPhoto']").prettyPhoto({
			animation_speed: 'fast', /* fast/slow/normal */
			slideshow: 5000, /* false OR interval time in ms */
			autoplay_slideshow: false, /* true/false */
			opacity: 0.80, /* Value between 0 and 1 */
			show_title: true, /* true/false */
			allow_resize: true, /* Resize the photos bigger than viewport. true/false */
			//theme: '', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
			horizontal_padding: 20, /* The padding on each side of the picture */
			autoplay: true, /* Automatically start videos: True/False */
			keyboard_shortcuts: true, /* Set to false if you open forms inside prettyPhoto */
		});
		
		//Pretty Photo for VC elements
		$('.prettyphoto').find().prettyPhoto({
			animation_speed: 'fast', /* fast/slow/normal */
			slideshow: 5000, /* false OR interval time in ms */
			autoplay_slideshow: false, /* true/false */
			opacity: 0.80, /* Value between 0 and 1 */
			show_title: true, /* true/false */
			//theme: '', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
			horizontal_padding: 20, /* The padding on each side of the picture */
			autoplay: true, /* Automatically start videos: True/False */
			keyboard_shortcuts: true, /* Set to false if you open forms inside prettyPhoto */
			allowresize: true, /* true/false */
			counter_separator_label: '/', /* The separator for the gallery counter 1 "of" 2 */
			hideflash: false, /* Hides all the flash object on a page, set to TRUE if flash appears over prettyPhoto */
			deeplinking: false, /* Allow prettyPhoto to update the url to enable deeplinking. */
			modal: false, /* If set to true, only the close button will close the window */
			callback: function() {
				var url = location.href;
				var hashtag = (url.indexOf('#!prettyPhoto')) ? true : false;
				if (hashtag) location.hash = "!";
			} /* Called when prettyPhoto is closed */,
			social_tools : ''
		});
		
		
		//Notification clear
		$('.pfnot-err-button').click(function(){$.pftogglewnotificationclear();});		
					
		
		$('#pfuaprofileform .pf-favorites-link').live('click',function(){
			if($(this).attr('data-pf-active') == 'true'){
				$(this).closest('.pfmu-itemlisting-inner').remove();
			};
		});

	});

/***************************************************************************************************************
*
*
* RESPONSIVE MENU FUNCTIONS & MOBILE MENU FUNCTIONS
*
*
***************************************************************************************************************/

	$(window).bind('load resize orientationchange', function(){
		$('#pf-topprimary-navmobi').hide();
		$('#pf-topprimary-navmobi2').hide();
		if ($('#pfsearch-draggable').length && !$.pf_mobile_check()) {
			$('#pf-primary-search-button').show('fast');			
		}else if ($('#pfsearch-draggable').length && $.pf_mobile_check()) {
			$('#pf-primary-search-button').hide('fast');	
		};
		if ($.pf_mobile_check() && $("#pfsearch-draggable").is(":hidden")) {
			if (!$('#pfsearch-draggable').hasClass('pfsearch-draggable-full')) {
				$('#pfsearch-draggable').css('display','block');

				if ($('#pfsearch-draggable').hasClass('pfshowmobile')) {
					$('#pfsearch-draggable').removeClass('pfshowmobile');
				};
			};
		};
		
	});


	
	$.PFCheckButtonStatus = function(buttonname){
		function pf_searchbutton_hide(){
			$.PFSearchButtonStatus = 0;
			$('#pf-primary-search-button i').switchClass('pfadmicon-glyph-96', 'pfadmicon-glyph-627', 'fast');
			$('#pfsearch-draggable').removeClass('pfshowmobile');
			$('#pfsearch-draggable').hide("fade",{}, "fast");
		}

		function pf_tbutton_hide(){
			$.PFTNavButtonStatus = 0;
			$('#pf-topprimary-navmobi').hide("fade",{}, "fast",function(){
				$('#pf-topprimary-nav-button i').switchClass('pfadmicon-glyph-96', 'pfadmicon-glyph-632', 'fast');
				$('#pf-topprimary-nav-button').removeClass('pfopened', 'fast');
			});
		}
		function pf_lbutton_hide(){
			$.PFLNavButtonStatus = 0;
			$('#pf-topprimary-navmobi2').hide("fade",{}, "fast",function(){
				$('#pf-topprimary-nav-button2 i').switchClass('pfadmicon-glyph-96', 'pfadmicon-glyph787', 'fast');
				$('#pf-topprimary-nav-button2').removeClass('pfopened', 'fast');
			});
		}

		function pf_button_hide(){
			$.PFNavButtonStatus = 0;
			$('#pf-primary-nav').hide("fade",{}, "fast",function(){
				$('#pf-primary-nav-button i').switchClass('pfadmicon-glyph-96', 'pfadmicon-glyph-500', 'fast');
				$('#pf-primary-nav-button').removeClass('pfopened');
				$('.pf-menu-container').removeClass('pfactive', 'fast');
			});
		}


		switch(buttonname){
			case 'PFTNavButtonStatus':
				if ($.PFNavButtonStatus == 1) {
					pf_button_hide();
				};
				if ($.PFSearchButtonStatus == 1) {
					pf_searchbutton_hide();
				};
				if ($.PFLNavButtonStatus == 1) {
					pf_lbutton_hide();
				};
			break;
			case 'PFNavButtonStatus':
				if ($.PFTNavButtonStatus == 1) {
					pf_tbutton_hide();
				};
				if ($.PFSearchButtonStatus == 1) {
					pf_searchbutton_hide();
				};
				if ($.PFLNavButtonStatus == 1) {
					pf_lbutton_hide();
				};
			break;
			case 'PFSearchButtonStatus':
				if ($.PFTNavButtonStatus == 1) {
					pf_tbutton_hide();
				};
				if ($.PFNavButtonStatus == 1) {
					pf_button_hide();
				};
				if ($.PFLNavButtonStatus == 1) {
					pf_lbutton_hide();
				};
			break;
			case 'PFLNavButtonStatus':
				if ($.PFNavButtonStatus == 1) {
					pf_button_hide();
				};
				if ($.PFSearchButtonStatus == 1) {
					pf_searchbutton_hide();
				};
				if ($.PFTNavButtonStatus == 1) {
					pf_tbutton_hide();
				};
			break;
		}
	}


	
	$(function() {
		
		/* Main Menu Click */
		$('#pf-primary-nav-button').live('click',function(){
			$.PFCheckButtonStatus('PFNavButtonStatus');
			if($('#pf-primary-nav').css('display') == 'none'){
				$.PFNavButtonStatus = 1;
				$('.pf-menu-container').addClass('pfactive');
				$('#pf-primary-nav').show("fade",{ direction: "up" }, "fast",function(){
					$('#pf-primary-nav-button i').switchClass('pfadmicon-glyph-500', 'pfadmicon-glyph-96', 'fast',"easeInOutQuad");
					$('#pf-primary-nav-button').addClass('pfopened', 'fast');
				});
				
			}else{	
				$.PFNavButtonStatus = 0;
				$('#pf-primary-nav').hide("fade",{ direction: "up" }, "fast",function(){
					$('#pf-primary-nav-button i').switchClass('pfadmicon-glyph-96', 'pfadmicon-glyph-500', 'fast',"easeInOutQuad");
					$('#pf-primary-nav-button').removeClass('pfopened');
					$('.pf-menu-container').removeClass('pfactive', 'fast');
				});

			}
		});


		/* User Menu Click */
		$('#pf-topprimary-nav-button').live('click',function(){
			$.PFCheckButtonStatus('PFTNavButtonStatus');
			if($('#pf-topprimary-navmobi').css('display') == 'none'){
				$.PFTNavButtonStatus = 1;
				$('#pf-topprimary-navmobi').show("fade",{ direction: "up" }, "fast",function(){
					$('#pf-topprimary-nav-button i').switchClass('pfadmicon-glyph-632', 'pfadmicon-glyph-96', 'fast',"easeInOutQuad");
					$('#pf-topprimary-nav-button').addClass('pfopened', 'fast');
				});
				
			}else{	
				$.PFTNavButtonStatus = 0;
				$('#pf-topprimary-navmobi').hide("fade",{ direction: "up" }, "fast",function(){
					$('#pf-topprimary-nav-button i').switchClass('pfadmicon-glyph-96', 'pfadmicon-glyph-632', 'fast',"easeInOutQuad");
					$('#pf-topprimary-nav-button').removeClass('pfopened', 'fast');
				});

			}
		});

		/* Search Menu Click */
		$('#pf-primary-search-button').live('click',function(){
			$.PFCheckButtonStatus('PFSearchButtonStatus');
			if($('#pfsearch-draggable').hasClass('pfshowmobile') == false){
				$.PFSearchButtonStatus = 1;
				$('#pf-primary-search-button i').switchClass('pfadmicon-glyph-627', 'pfadmicon-glyph-96', 'fast',"easeInOutQuad");
				$('#pfsearch-draggable').addClass('pfshowmobile');
				$('#pfsearch-draggable').show("fade",{ direction: "up" }, "fast");
			}else{
				$.PFSearchButtonStatus = 0;
				$('#pf-primary-search-button i').switchClass('pfadmicon-glyph-96', 'pfadmicon-glyph-627', 'fast',"easeInOutQuad");
				$('#pfsearch-draggable').removeClass('pfshowmobile');
				$('#pfsearch-draggable').hide("fade",{ direction: "up" }, "fast");
			}
		});

		/* Language Menu Click */
		$('#pf-topprimary-nav-button2').live('click',function(){
			$.PFCheckButtonStatus('PFLNavButtonStatus');
			if($('#pf-topprimary-navmobi2').css('display') == 'none'){
				$.PFLNavButtonStatus = 1;
				$('#pf-topprimary-navmobi2').show("fade",{ direction: "up" }, "fast",function(){
					$('#pf-topprimary-nav-button2 i').switchClass('pfadmicon-glyph-787', 'pfadmicon-glyph-96', 'fast',"easeInOutQuad");
					$('#pf-topprimary-nav-button2').addClass('pfopened', 'fast');
				});
				
			}else{	
				$.PFLNavButtonStatus = 0;
				$('#pf-topprimary-navmobi2').hide("fade",{ direction: "up" }, "fast",function(){
					$('#pf-topprimary-nav-button2 i').switchClass('pfadmicon-glyph-96', 'pfadmicon-glyph-787', 'fast',"easeInOutQuad");
					$('#pf-topprimary-nav-button2').removeClass('pfopened', 'fast');
				});

			}
		});


		$('#pf-primary-nav').pfresponsivenav();
		$('#pf-topprimary-nav').pfresponsivenav({mleft:0});
		

		//Scroll action
		var shrinkHeader = 70;
		$(window).scroll(function() {
			var scroll = getCurrentScroll();
			if ( scroll >= shrinkHeader && $.pf_tablet_check() ) {
				$('.wpf-header').addClass('pfshrink');
			} else {
				$('.wpf-header').removeClass('pfshrink');
			}
		});
		
		function getCurrentScroll() {
			return window.pageYOffset || document.documentElement.scrollTop;
		}

		$(window).bind('load resize orientationchange', function(){
			if($('#pf-primary-nav').attr('style') == 'display: none;' && $.pf_tablet_check()){
			   $('#pf-primary-nav').removeAttr('style');
			}
		});


	});
	

/***************************************************************************************************************
*
*
* PF FAVORITES SYSTEM FUNCTIONS & ACTIONS
*
*
***************************************************************************************************************/
	$(function(){

		$('.pf-favorites-link').live('click',function(){
			$.maindivfav = $(this);
			$.ajax({
				beforeSend: function(){
					$.maindivfav.parent('.pflist-item').pfLoadingOverlay({action:'show'});
				},
	            type: 'POST',
	            dataType: 'json',
	            url: theme_scriptspf.ajaxurl,
	            data: { 
	                'action': 'pfget_favorites',
	                'item': $.maindivfav.attr('data-pf-num'),
	                'active':$.maindivfav.attr('data-pf-active'),
	                'security': theme_scriptspf.pfget_favorites
	            },
	            success:function(data){
					var obj = [];
					$.each(data, function(index, element) {
						obj[index] = element;
					});

					if (!$.isEmptyObject(obj)) {

						if (obj.user == 0) {
							$.pfOpenLogin('open','login');
						}else{
							if (obj.active == 'true') {
								var datatextfv = 'true';
							}else{
								var datatextfv = 'false';
							};
							$.maindivfav.attr('data-pf-active',datatextfv);
							$.maindivfav.attr('title',obj.favtext);		
							if ($.maindivfav.data('pf-item') == true) {
								
								if (obj.active == 'true') {
									$.maindivfav.children('i').switchClass('pfadmicon-glyph-376','pfadmicon-glyph-375');
								}else{
									$.maindivfav.children('i').switchClass('pfadmicon-glyph-375','pfadmicon-glyph-376');
								}

								$.maindivfav.children('#itempage-pffav-text').html(obj.favtext);
							};				
						};
					};

	            },
	            complete: function(){
	            	$.maindivfav.parent('.pflist-item').pfLoadingOverlay({action:'hide'});
	            },
	        });
		});

	});


/***************************************************************************************************************
*
*
* PF ITEM REPORT SYSTEM
*
*
***************************************************************************************************************/
	$(function(){
		
		$('.pf-report-link').live('click',function(){
			$.maindivfav = $(this);
			$.ajax({
	            type: 'POST',
	            dataType: 'json',
	            url: theme_scriptspf.ajaxurl,
	            data: { 
	                'action': 'pfget_reportitem',
	                'item': $.maindivfav.attr('data-pf-num'),
	                'security': theme_scriptspf.pfget_reportitem
	            },
	            success:function(data){
					var obj = [];
					$.each(data, function(index, element) {
						obj[index] = element;
					});

					if (!$.isEmptyObject(obj)) {

						if (obj.user == 0 && obj.rs == "1") {
							$.pfOpenLogin('open','login');
						}else if(obj.user == 0 && obj.rs == "0"){
							$.pfOpenModal('open','reportform','','',obj.item);
						}else if(obj.user != 0 && obj.rs == "1"){
							$.pfOpenModal('open','reportform','','',obj.item);
						}else if(obj.user != 0 && obj.rs == "0"){
							$.pfOpenModal('open','reportform','','',obj.item);
						};

					};

	            }
	        });
		});

	});


/***************************************************************************************************************
*
*
* PF ITEM CLAIM SYSTEM
*
*
***************************************************************************************************************/
	$(function(){
		
		$('#pfclaimitem').live('click touchstart',function(){
			$.maindivfav = $(this);
			$.ajax({
	            type: 'POST',
	            dataType: 'json',
	            url: theme_scriptspf.ajaxurl,
	            data: { 
	                'action': 'pfget_claimitem',
	                'item': $.maindivfav.attr('data-pf-num'),
	                'security': theme_scriptspf.pfget_claimitem
	            },
	            success:function(data){
					var obj = [];
					$.each(data, function(index, element) {
						obj[index] = element;
					});

					if (!$.isEmptyObject(obj)) {

						if (obj.user == 0 && obj.rs == "1") {
							$.pfOpenLogin('open','login');
						}else if(obj.user == 0 && obj.rs == "0"){
							$.pfOpenModal('open','claimform','','',obj.item);
						}else if(obj.user != 0 && obj.rs == "1"){
							$.pfOpenModal('open','claimform','','',obj.item);
						}else if(obj.user != 0 && obj.rs == "0"){
							$.pfOpenModal('open','claimform','','',obj.item);
						};

					};

	            }
	        });
		});

	});



/***************************************************************************************************************
*
*
* PF REVIEW SYSTEM FUNCTIONS & ACTIONS
*
*
***************************************************************************************************************/

	


	$.pfReviewwithAjax = function(vars){
		
		$.ajax({
			beforeSend: function(){
				$('#pftrwcontainer').pfLoadingOverlay({action:'show'});
			},
            type: 'POST',
            dataType: 'json',
            url: theme_scriptspf.ajaxurl,
            data: { 
                'action': 'pfget_modalsystemhandler',
                'formtype': 'reviewform',
                'vars': vars,
                'security': theme_scriptspf.pfget_modalsystemhandler
            },
            success:function(data){
				var obj = [];
				$.each(data, function(index, element) {
					obj[index] = element;
				});

				// Review Form works ---------------------------------------------------
				var form = $('#pf-review-form');
				var pfreviewoverlay = $("#pftrwcontainer-overlay");
				pfreviewoverlay.click(function(){
					pfreviewoverlay.hide("slide",{direction : "up"},100);
					pfreviewoverlay.find('.pf-overlay-close').remove();
					pfreviewoverlay.find('.pfrevoverlaytext').remove();
					if(obj.process == true){
						if (typeof grecaptcha !== 'undefined') {
							grecaptcha.reset();
						};
						form.find("textarea").val("");
						form.find(':input').removeAttr('checked');
					}
				});
				if(obj.process == true){
					pfreviewoverlay.append("<div class='pf-overlay-close'><i class='pfadmicon-glyph-470'></i></div><div class='pfrevoverlaytext pfoverlayapprove'><i class='pfadmicon-glyph-62'></i><span>"+obj.mes+"</span></div>");
					pfreviewoverlay.show("slide",{direction : "up"},100);
				}else{
					pfreviewoverlay.append("<div class='pf-overlay-close'><i class='pfadmicon-glyph-470'></i></div><div class='pfrevoverlaytext'><i class='pfadmicon-glyph-485'></i><span>"+obj.mes+"</span></div>");
					pfreviewoverlay.show("slide",{direction : "up"},100);
				}

				$('.pf-overlay-close').click(function(){
					pfreviewoverlay.hide("slide",{direction : "up"},100);
					pfreviewoverlay.find('.pf-overlay-close').remove();
					pfreviewoverlay.find('.pfrevoverlaytext').remove();
					if(obj.process == true){
						if (typeof grecaptcha !== 'undefined') {
							grecaptcha.reset();
						};
						form.find("textarea").val("");
						form.find(':input').removeAttr('checked');
					}
				});
				// Review Form works ---------------------------------------------------


            },
            error: function (request, status, error) {
                $("#pftrwcontainer-overlay").append("<span class='pfrevoverlaytext'>Error:"+request.responseText+"</span>");
            },
            complete: function(){
            	$('#pftrwcontainer').pfLoadingOverlay({action:'hide'});
            },
        });
				
	};


	$('.pf-show-review-details').bind( "mouseenter mouseleave",function(){
		
		if ($(this).find('.pf-itemrevtextdetails').is( ':visible' )) {
			$(this).find('.pf-itemrevtextdetails').hide();
			$(this).find('.pf-itemrevtextdetails').removeClass('animated bounceIn');
			$(this).find('.pf-itemrevtextdetails').addClass('animated bounceOut');
		}else{
			$(this).find('.pf-itemrevtextdetails').show();
			$(this).find('.pf-itemrevtextdetails').removeClass('animated bounceOut');
			$(this).find('.pf-itemrevtextdetails').addClass('animated bounceIn');
		};
		
	});


	$('.review-flag-link').live('click',function(){
		$.maindivfav = $(this);
		$.ajax({
            type: 'POST',
            dataType: 'json',
            url: theme_scriptspf.ajaxurl,
            data: { 
                'action': 'pfget_flagreview',
                'item': $.maindivfav.attr('data-pf-revid'),
                'security': theme_scriptspf.pfget_flagreview
            },
            success:function(data){
				var obj = [];
				$.each(data, function(index, element) {
					obj[index] = element;
				});

				if (!$.isEmptyObject(obj)){

					if (obj.user == 0 ) {
						$.pfOpenLogin('open','login');
					}else{
						$.pfOpenModal('open','flagreview','','',obj.item);
					
					};

				};

            }
        });
	});



	



/***************************************************************************************************************
*
*
* USER LOGIN SYSTEM ACTIONS
*
*
***************************************************************************************************************/
	


	$.pfLoginwithAjax = function(vars,formtype){
		$.ajax({
			beforeSend: function(){
				$('#pf-membersystem-dialog').pfLoadingOverlay({action:'show'});
			},
            type: 'POST',
            dataType: 'json',
            url: theme_scriptspf.ajaxurl,
            data: { 
                'action': 'pfget_usersystemhandler',
                'formtype': formtype,
                'vars': vars,
                'security': theme_scriptspf.pfget_usersystemhandler
            },
            success:function(data){
				var obj = [];
				$.each(data, function(index, element) {
					obj[index] = element;
				});

				// Login Form works ---------------------------------------------------
				if(formtype == 'login'){
					var form = $('#pf-ajax-login-form');
					var pfreviewoverlay = $("#pflgcontainer-overlay");

					if(obj.login == true){
						pfreviewoverlay.append("<div class='pf-overlay-close'><i class='pfadmicon-glyph-707'></i></div><div class='pfrevoverlaytext pfoverlayapprove'><i class='pfadmicon-glyph-62'></i><span>"+obj.mes+"</span></div>");
						pfreviewoverlay.show("slide",{direction : "up"},100);
						if (obj.redirectpage == 0) {
							setTimeout(function() {
								window.location = theme_scriptspf.profileurl;
							}, 120);
						}else if(obj.redirectpage == 2){
							setTimeout(function() {
								window.location = theme_scriptspf.dashurl;
							}, 120);
						}else{
							setTimeout(function() {
								window.location = obj.referurl;
							}, 120);
						};
					}else{
						pfreviewoverlay.append("<div class='pf-overlay-close'><i class='pfadmicon-glyph-707'></i></div><div class='pfrevoverlaytext'><i class='pfadmicon-glyph-485'></i><span>"+obj.mes+"</span></div>");
						pfreviewoverlay.show("slide",{direction : "up"},100);

						pfreviewoverlay.click(function(){
							pfreviewoverlay.hide("slide",{direction : "up"},100);
							pfreviewoverlay.find('.pf-overlay-close').remove();
							pfreviewoverlay.find('.pfrevoverlaytext').remove();
							
							if (typeof grecaptcha !== 'undefined') {
								grecaptcha.reset();
							};
							form.find("textarea").val("");
							
						});
					}

					$('.pf-overlay-close').click(function(){
						pfreviewoverlay.hide("slide",{direction : "up"},100);
						pfreviewoverlay.find('.pf-overlay-close').remove();
						pfreviewoverlay.find('.pfrevoverlaytext').remove();
						
						if (typeof grecaptcha !== 'undefined') {
							grecaptcha.reset();
						};
						form.find("textarea").val("");
						
					});

				}
				// Login Form works ---------------------------------------------------



				// Register Form works ---------------------------------------------------
				if(formtype == 'register'){
					var form = $('#pf-ajax-register-form');
					var pfreviewoverlay = $("#pflgcontainer-overlay");

					if(obj.status == 0){
						pfreviewoverlay.append("<div class='pf-overlay-close'><i class='pfadmicon-glyph-707'></i></div><div class='pfrevoverlaytext pfoverlayapprove'><i class='pfadmicon-glyph-62'></i><span>"+obj.mes+"</span></div>");
						pfreviewoverlay.show("slide",{direction : "up"},100);
						/*
						// Disabled with v1.5.9
						setTimeout(function() {
							$.pfOpenLogin('close');
						}, 4000);
						setTimeout(function() {
							window.location = theme_scriptspf.homeurl;
						}, 4000);
						*/
						pfreviewoverlay.click(function(){
							pfreviewoverlay.hide("slide",{direction : "up"},100);
							pfreviewoverlay.find('.pf-overlay-close').remove();
							pfreviewoverlay.find('.pfrevoverlaytext').remove();
							/*
							// Disabled with v1.5.9
							if(obj.status == 0){
								$.pfOpenLogin('close');
								window.location = theme_scriptspf.homeurl;
							}
							*/
						});


					}else{
						pfreviewoverlay.append("<div class='pf-overlay-close'><i class='pfadmicon-glyph-707'></i></div><div class='pfrevoverlaytext'><i class='pfadmicon-glyph-485'></i><span>"+obj.mes+"</span></div>");
						pfreviewoverlay.show("slide",{direction : "up"},100);

						pfreviewoverlay.click(function(){
							pfreviewoverlay.hide("slide",{direction : "up"},100);
							pfreviewoverlay.find('.pf-overlay-close').remove();
							pfreviewoverlay.find('.pfrevoverlaytext').remove();
							
								if (typeof grecaptcha !== 'undefined') {
									grecaptcha.reset();
								};
							
						});
					}

					$('.pf-overlay-close').click(function(){
						pfreviewoverlay.hide("slide",{direction : "up"},100);
						pfreviewoverlay.find('.pf-overlay-close').remove();
						pfreviewoverlay.find('.pfrevoverlaytext').remove();
						if(obj.status == 0){
							setTimeout(function() {
								$.pfOpenLogin('close');
							}, 4000);
							setTimeout(function() {
								window.location = theme_scriptspf.homeurl;
							}, 4000);
						}
					});


				}
				// Register Form works ---------------------------------------------------



				// Lost Password Form works ---------------------------------------------------
				if(formtype == 'lp'){
					var form = $('#pf-ajax-lp-form');

					var pfreviewoverlay = $("#pflgcontainer-overlay");

					if(obj.status == 0){
						pfreviewoverlay.append("<div class='pf-overlay-close'><i class='pfadmicon-glyph-707'></i></div><div class='pfrevoverlaytext pfoverlayapprove'><i class='pfadmicon-glyph-62'></i><span>"+obj.mes+"</span></div>");
						pfreviewoverlay.show("slide",{direction : "up"},100);
						setTimeout(function() {
							$.pfOpenLogin('close');
						}, 10000);

						pfreviewoverlay.click(function(){
							pfreviewoverlay.hide("slide",{direction : "up"},100);
							pfreviewoverlay.find('.pf-overlay-close').remove();
							pfreviewoverlay.find('.pfrevoverlaytext').remove();
							if(obj.status == 0){
								$.pfOpenLogin('close');
							}
						});
						
					}else{
						pfreviewoverlay.append("<div class='pf-overlay-close'><i class='pfadmicon-glyph-707'></i></div><div class='pfrevoverlaytext'><i class='pfadmicon-glyph-485'></i><span>"+obj.mes+"</span></div>");
						pfreviewoverlay.show("slide",{direction : "up"},100);

						pfreviewoverlay.click(function(){
							pfreviewoverlay.hide("slide",{direction : "up"},100);
							pfreviewoverlay.find('.pf-overlay-close').remove();
							pfreviewoverlay.find('.pfrevoverlaytext').remove();
							
								if (typeof grecaptcha !== 'undefined') {
									grecaptcha.reset();
								};
							
						});
					}

					$('.pf-overlay-close').click(function(){
						pfreviewoverlay.hide("slide",{direction : "up"},100);
						pfreviewoverlay.find('.pf-overlay-close').remove();
						pfreviewoverlay.find('.pfrevoverlaytext').remove();
						if(obj.status == 0){
							$.pfOpenLogin('close');
						}
					});


				}
				// Lost Password Form works ---------------------------------------------------

            },
            error: function (request, status, error) {
                $("#pf-membersystem-dialog").html('Error:'+request.responseText);
            },
            complete: function(){
            	$('#pf-membersystem-dialog').pfLoadingOverlay({action:'hide'});
            },
        });
	};

	
	$.pfOpenLogin = function(status,modalname,errortext,errortype,redirectpage) {
		$.pfdialogstatus = '';
		
		if (modalname != 'error') {
			var errortext = '';
			var errortype = 0;
		};
		if(errortype != 2){
		    if(status == 'open'){
		    	
		    	if ($.pfdialogstatus == 'true') {$( "#pf-membersystem-dialog" ).dialog( "close" );}
		    	$('#pf-membersystem-dialog').pfLoadingOverlay({action:'show'});
		 
	    		var minwidthofdialog = 380;

	    		if(!$.pf_mobile_check()){ minwidthofdialog = 320;};
			
	    		$.ajax({
		            type: 'POST',
		            dataType: 'html',
		            url: theme_scriptspf.ajaxurl,
		            data: { 
		                'action': 'pfget_usersystem',
		                'formtype': modalname,
		                'security': theme_scriptspf.pfget_usersystem,
		                'errortype': errortype,
		                'redirectpage': redirectpage
		            },
		            success:function(data){
		            	
						$("#pf-membersystem-dialog").html(data);
						$('#pf-login-trigger-button-inner').click(function(){$.pfOpenLogin('open','login')});
						$('#pf-register-trigger-button-inner').click(function(){$.pfOpenLogin('open','register')});
						$('#pf-lp-trigger-button-inner').click(function(){$.pfOpenLogin('open','lp')});

						if (modalname == 'error') {
							$('#pf-ajax-cl-details').html(errortext);
						};

						$('#pf-ajax-loginfacebook').click(function(){
							$('#pf-membersystem-dialog').pfLoadingOverlay({action:'show'});
						});

						$('#pf-ajax-logintwitter').click(function(){
							$('#pf-membersystem-dialog').pfLoadingOverlay({action:'show'});
						});

						$('#pf-ajax-logingoogle').click(function(){
							$('#pf-membersystem-dialog').pfLoadingOverlay({action:'show'});
						});

						
						
						// LOGIN FUNCTION STARTED --------------------------------------------------------------------------------------------
						
						$('#pf-ajax-login-button').click(function(){

							//console.log("Hola");

							var form = $('#pf-ajax-login-form');
							
							var recaptchanum = form.find('#recaptcha_div_us .g-recaptcha-field').data('rekey');
							if (recaptchanum) {
								recaptchanum = $.recaptchanum;
								form.find('#g-recaptcha-response').text(grecaptcha.getResponse(recaptchanum));
							};
							

							var pfsearchformerrors = form.find(".pfsearchformerrors");
							if (!$.isEmptyObject($.pfAjaxUserSystemVars)) {
								$.pfAjaxUserSystemVars = {};
								//Jauregui
								// $.pfAjaxUserSystemVars.username_err = 'Please write username';
								// $.pfAjaxUserSystemVars.username_err2 = 'Please enter at least 3 characters for Username.';
								// $.pfAjaxUserSystemVars.password_err = 'Please write password';
								$.pfAjaxUserSystemVars.username_err = 'Por favor, escriba su Nombre de Usuario';
								$.pfAjaxUserSystemVars.username_err2 = 'Por favor, introduzca entre 5 y 15 caracteres de Nombre de Usuario.';
								$.pfAjaxUserSystemVars.password_err = 'Por favor, escriba la contraseña';
							}
							form.validate({
								  debug:false,
								  onfocus: false,
								  onfocusout: false,
								  onkeyup: false,
								  rules:{
								  	username:{
								      required: true,
								      rangelength: [5, 	15], 
								      nowhitespace: true //No permite espacios en blanco
								    },
								  	password:"required"
								  },
								  messages:{
								  	username:{
								  		required:$.pfAjaxUserSystemVars.username_err,
								  		minlength:$.pfAjaxUserSystemVars.username_err2
								  	},
								  	password:$.pfAjaxUserSystemVars.password_err
								  },
								  validClass: "pfvalid",
								  errorClass: "pfnotvalid pfadmicon-glyph-858",
								  errorElement: "li",
								  errorContainer: pfsearchformerrors,
								  errorLabelContainer: $("ul", pfsearchformerrors),
								  invalidHandler: function(event, validator) {
									var errors = validator.numberOfInvalids();
									if (errors) {
										pfsearchformerrors.show("slide",{direction : "up"},100);
										form.find(".pfsearch-err-button").click(function(){
											pfsearchformerrors.hide("slide",{direction : "up"},100);
											return false;
										});
									}else{
										pfsearchformerrors.hide("fade",300);
									}
								  }
							});
							
							
							
							// if(form.valid()){
								$.pfLoginwithAjax(form.serialize(),'login');
							// };
							return false;
						});
						
						// LOGIN FUNCTION FINISHED --------------------------------------------------------------------------------------------






						// REGISTER FUNCTION STARTED --------------------------------------------------------------------------------------------
						$('#pf-ajax-register-button').click(function(){
							var form = $('#pf-ajax-register-form');

							var recaptchanum = form.find('#recaptcha_div_us .g-recaptcha-field').data('rekey');
							if (recaptchanum) {
								recaptchanum = $.recaptchanum;
								form.find('#g-recaptcha-response').text(grecaptcha.getResponse(recaptchanum));
							};

							var pfsearchformerrors = form.find(".pfsearchformerrors");
							if ($.isEmptyObject($.pfAjaxUserSystemVars2)) {
								$.pfAjaxUserSystemVars2 = {};
								/*Jauregui*/
								// $.pfAjaxUserSystemVars2.username_err = 'Please write username';
								// $.pfAjaxUserSystemVars2.username_err2 = 'Please enter at least 3 characters for Username.';
								// $.pfAjaxUserSystemVars2.email_err = 'Please write an email';
								// $.pfAjaxUserSystemVars2.email_err2 = 'Your email address must be in the format of name@domain.com';
								$.pfAjaxUserSystemVars2.username_err = 'Por favor, escriba su Nombre de Usuario';
								$.pfAjaxUserSystemVars2.username_err2 = 'Por favor, introduzca entre 5 y 15 caracteres de Nombre de Usuario.';
								$.pfAjaxUserSystemVars2.username_err3 = 'Por favor, ingrese un Nombre válido, no se permiten espacios en blanco.';
								$.pfAjaxUserSystemVars2.email_err = 'Por favor, escriba un correo electrónico';
								$.pfAjaxUserSystemVars2.email_err2 = 'Su dirección de correo electrónico debe estar en el formato de nombre@dominio.com';
							}
							form.validate({
								  debug:false,
								  onfocus: false,
								  onfocusout: false,
								  onkeyup: false,
								  rules:{
								  	username:{
								      required: true,
								      pattern:"^([a-z]+[0-9]{0,4}){3,12}$"
								      //rangelength: [5, 	15],
								      //nowhitespace: true, //No permite espacios en blanco

								    },
								  	email:{
								  		required:true,
								  		email:true,
								  		nowhitespace: true //No permite espacios en blanco
								  	}
								  },
								  messages:{
								  	username:{
									  	required:"Falta el Nombre de usuario",
									  	minlength:$.pfAjaxUserSystemVars2.username_err2,
									  	nowhitespace:$.pfAjaxUserSystemVars2.username_err3,
									  	pattern:"Nombre de usuario Inválido"
								  	},
								  	email: {
									    required: $.pfAjaxUserSystemVars2.email_err,
									    email: $.pfAjaxUserSystemVars2.email_err2
								    }
								  },
								  validClass: "pfvalid",
								  errorClass: "pfnotvalid pfadmicon-glyph-858",
								  errorElement: "li",
								  errorContainer: pfsearchformerrors,
								  errorLabelContainer: $("ul", pfsearchformerrors),
								  invalidHandler: function(event, validator) {
									var errors = validator.numberOfInvalids();
									if (errors) {
										pfsearchformerrors.show("slide",{direction : "up"},100);
										form.find(".pfsearch-err-button").click(function(){
											pfsearchformerrors.hide("slide",{direction : "up"},100);
											return false;
										});
									}else{
										pfsearchformerrors.hide("fade",300);
									}
								  }
							});
							
							
							//if(form.valid()){
								$.pfLoginwithAjax(form.serialize(),'register');
							//};
							return false;
						});
						// REGISTER FUNCTION FINISHED --------------------------------------------------------------------------------------------





						// LOST PASSWORD FUNCTION STARTED --------------------------------------------------------------------------------------------
						$('#pf-ajax-lp-button').click(function(){
							var form = $('#pf-ajax-lp-form');

							var recaptchanum = form.find('#recaptcha_div_us .g-recaptcha-field').data('rekey');
							if (recaptchanum) {
								recaptchanum = $.recaptchanum;
								form.find('#g-recaptcha-response').text(grecaptcha.getResponse(recaptchanum));
							};
							
							var pfsearchformerrors = form.find(".pfsearchformerrors");
							if ($.isEmptyObject($.pfAjaxUserSystemVars3)) {
								$.pfAjaxUserSystemVars3 = {};
								$.pfAjaxUserSystemVars3.username_err = 'Username or Email must be filled.';
								$.pfAjaxUserSystemVars3.username_err2 = 'Please enter at least 3 characters for Username.';
								$.pfAjaxUserSystemVars3.email_err2 = 'Your email address must be in the format of name@domain.com';
							}
							form.validate({
								  debug:false,
								  onfocus: false,
								  onfocusout: false,
								  onkeyup: false,
								  rules:{
								  	username:{
								    	minlength: 3
								    },
								  	email:{
								  		email:true
								  	}
								  },
								  messages:{
								  	username:{
									  	minlength:$.pfAjaxUserSystemVars3.username_err2
								  	},
								  	email: {
									    required: $.pfAjaxUserSystemVars3.email_err,
									    email: $.pfAjaxUserSystemVars3.email_err2
								    }
								  },
								  validClass: "pfvalid",
								  errorClass: "pfnotvalid pfadmicon-glyph-858",
								  errorElement: "li",
								  errorContainer: pfsearchformerrors,
								  errorLabelContainer: $("ul", pfsearchformerrors),
								  invalidHandler: function(event, validator) {
									var errors = validator.numberOfInvalids();
									if (errors) {
										pfsearchformerrors.show("slide",{direction : "up"},100);
										form.find(".pfsearch-err-button").click(function(){
											pfsearchformerrors.hide("slide",{direction : "up"},100);
											return false;
										});
									}else{
										pfsearchformerrors.hide("fade",300);
									}
								  }
							});
							
							
							if(form.valid()){
								if(form.find("input[name=username]").val() != '' || form.find("input[name=email]").val() != ''){
									$.pfLoginwithAjax(form.serialize(),'lp');
								}else{
									
									$("ul", pfsearchformerrors).append('<li>'+$.pfAjaxUserSystemVars3.username_err+'</li>');
									$("ul", pfsearchformerrors).show();
									pfsearchformerrors.show("slide",{direction : "up"},100);
										form.find(".pfsearch-err-button").click(function(){
											pfsearchformerrors.hide("slide",{direction : "up"},100);
											return false;
										});
									return false;
								}

							};
							return false;
						});
						// LOST PASSWORD FUNCTION FINISHED --------------------------------------------------------------------------------------------


						// ERROR FUNCTION STARTED --------------------------------------------------------------------------------------------
						$('#pf-ajax-cl-button').click(function(){

							$.pfOpenLogin('close')
							return false;

						});
						// ERROR FUNCTION FINISHED --------------------------------------------------------------------------------------------



		            },
		            error: function (request, status, error) {
		            	
	                	$("#pf-membersystem-dialog").html('Error:'+request.responseText);
		            	
		            },
		            complete: function(){
		            	
	            		$('#pf-membersystem-dialog').pfLoadingOverlay({action:'hide'});
						setTimeout(function(){$("#pf-membersystem-dialog").dialog({position:{my: "center", at: "center",collision:"fit"}});},500);
						$('.pointfinder-dialog').center(true);
		            },
		        });
			
	        	if(modalname != ''){
			    $("#pf-membersystem-dialog").dialog({
			        resizable: false,
			        modal: true,
			        minWidth: minwidthofdialog,
			        show: { effect: "fade", duration: 100 },
			        dialogClass: 'pointfinder-dialog',
			        open: function() {
				        $('.ui-widget-overlay').addClass('pf-membersystem-overlay');
				    },
				    close: function() {
				        $('.ui-widget-overlay').removeClass('pf-membersystem-overlay');
				    },
				    position:{my: "center", at: "center", collision:"fit"}
			    });
			    $.pfdialogstatus = 'true';
				}

			}else{
				$( "#pf-membersystem-dialog" ).dialog( "close" );
				$.pfdialogstatus = '';
			}
		}

	};

	$('#pf-login-trigger-button').click(function(){$.pfOpenLogin('open','login')});
	$('#pf-login-trigger-button-mobi').click(function(){$.pfOpenLogin('open','login')});
	$('.pf-login-modal').click(function(){$.pfOpenLogin('open','login')});
	$('.comment-reply-login').click(function(){$.pfOpenLogin('open','login');return false;});



	$('#pf-register-trigger-button').click(function(){$.pfOpenLogin('open','register')});
	$('#pf-register-trigger-button-mobi').click(function(){$.pfOpenLogin('open','register')});
	$('#pf-lp-trigger-button').click(function(){$.pfOpenLogin('open','lp')});
	$('#pf-lp-trigger-button-mobi').click(function(){$.pfOpenLogin('open','lp')});
	$('.pf-membersystem-overlay').live('click',function(){$.pfOpenLogin('close')});
	$('.pfmodalclose').live('click',function(){$.pfOpenLogin('close');});

/***************************************************************************************************************
*
*
* MODAL SYSTEM ACTIONS
*
*
***************************************************************************************************************/

	$.pfModalwithAjax = function(vars,formtype){
		$.ajax({
			beforeSend: function(){
				$('#pf-membersystem-dialog').pfLoadingOverlay({action:'show'});
			},
            type: 'POST',
            dataType: 'json',
            url: theme_scriptspf.ajaxurl,
            data: { 
                'action': 'pfget_modalsystemhandler',
                'formtype': formtype,
                'vars': vars,
                'security': theme_scriptspf.pfget_modalsystemhandler
            },
            success:function(data){
				var obj = [];
				$.each(data, function(index, element) {
					obj[index] = element;
				});


				// Contact Form works ---------------------------------------------------
				if(formtype == 'enquiryform'){
					var form = $('#pf-ajax-enquiry-form');
				}
				// Contact Form works ---------------------------------------------------



				// Author Form works ---------------------------------------------------
				if(formtype == 'enquiryformauthor'){
					var form = $('#pf-ajax-enquiry-form-author');

				}
				// Author Form works ---------------------------------------------------



				// Report Form works ---------------------------------------------------
				if(formtype == 'reportitem'){
					var form = $('#pf-ajax-report-form');
				}
				// Report Form works ---------------------------------------------------


				// Claim Form works ---------------------------------------------------
				if(formtype == 'claimitem'){
					var form = $('#pf-ajax-claim-form');
				}
				// Claim Form works ---------------------------------------------------



				// Flag Review Form works ---------------------------------------------------
				if(formtype == 'flagreview'){
					var form = $('#pf-ajax-flag-form');
				}
				// Flag Review Form works ---------------------------------------------------


				// Contact Form works ---------------------------------------------------
				if(formtype == 'contactform'){
					var form = $('#pf-contact-form');
				}
				// Contact Form works ---------------------------------------------------

				if(formtype == 'enquiryform'){
					var pfreviewoverlay = $("#pfmdcontainer-overlaynew");
				}else{
					var pfreviewoverlay = $("#pfmdcontainer-overlay");
				}
				

				if(obj.process == true){
					if (formtype == 'contactform') {
						pfreviewoverlay.pfLoadingOverlay({action:'hide'});
					};
				
					pfreviewoverlay.append("<div class='pf-overlay-close'><i class='pfadmicon-glyph-707'></i></div><div class='pfrevoverlaytext pfoverlayapprove'><i class='pfadmicon-glyph-62'></i><span>"+obj.mes+"</span></div>");
					pfreviewoverlay.show("slide",{direction : "up"},100);

					pfreviewoverlay.click(function(){
						pfreviewoverlay.hide("slide",{direction : "up"},100);
						pfreviewoverlay.find('.pf-overlay-close').remove();
						pfreviewoverlay.find('.pfrevoverlaytext').remove();
						if(obj.process == true && formtype != 'contactform' && formtype != 'enquiryform'){
							$.pfOpenModal('close');
							if (formtype == 'flagreview') {
								window.location.reload();
							};
						}
					});
					
				}else{
					if (formtype == 'contactform') {
						pfreviewoverlay.pfLoadingOverlay({action:'hide'});
					};

					pfreviewoverlay.append("<div class='pf-overlay-close'><i class='pfadmicon-glyph-707'></i></div><div class='pfrevoverlaytext'><i class='pfadmicon-glyph-485'></i><span>"+obj.mes+"</span></div>");
					pfreviewoverlay.show("slide",{direction : "up"},100);

					pfreviewoverlay.click(function(){
						pfreviewoverlay.hide("slide",{direction : "up"},100);
						pfreviewoverlay.find('.pf-overlay-close').remove();
						pfreviewoverlay.find('.pfrevoverlaytext').remove();
						if (formtype == 'enquiryform') {
							$('#pf-ajax-enquiry-button').attr('disabled',false);
						};
						if(obj.process == true){
							if (typeof grecaptcha !== 'undefined') {
								grecaptcha.reset();
							};
							form.find("textarea").val("");
						}
					});
				}


				$('.pf-overlay-close').on('click touchstart',function(){
					pfreviewoverlay.hide("slide",{direction : "up"},100);
					pfreviewoverlay.find('.pf-overlay-close').remove();
					pfreviewoverlay.find('.pfrevoverlaytext').remove();
					if(obj.process == true && formtype != 'contactform' && formtype != 'enquiryform'){
						$.pfOpenModal('close');
					}
					if (formtype == 'enquiryform') {
						$('#pf-ajax-enquiry-button').attr('disabled',false);

					};
					if (formtype == 'flagreview') {
						window.location.reload();
					};
				});

            },
            error: function (request, status, error) {
                $("#pf-membersystem-dialog").html('Error:'+request.responseText);
            },
            complete: function(){
            	$('#pf-membersystem-dialog').pfLoadingOverlay({action:'hide'});
            },
        });
	};


	$.pfOpenModal = function(status,modalname,errortext,errortype,itemid,userid) {
		$.pfdialogstatus = '';
		
		if (modalname != 'error') {
			var errortext = '';
			var errortype = 0;
		};
		if(errortype != 2){
		    if(status == 'open'){
		    	
		    	if ($.pfdialogstatus == 'true') {$( "#pf-membersystem-dialog" ).dialog( "close" );}
		    	$('#pf-membersystem-dialog').pfLoadingOverlay({action:'show'});
	    		var minwidthofdialog = 380;

	    		if(!$.pf_mobile_check()){ minwidthofdialog = 320;};
			
	    		$.ajax({
		            type: 'POST',
		            dataType: 'html',
		            url: theme_scriptspf.ajaxurl,
		            data: { 
		                'action': 'pfget_modalsystem',
		                'formtype': modalname,
		                'itemid': itemid,
		                'userid': userid,
		                'security': theme_scriptspf.pfget_modalsystem,
		                'errortype': errortype
		            },
		            success:function(data){
		            	
						$("#pf-membersystem-dialog").html(data);

						if (modalname == 'error') {
							$('#pf-ajax-cl-details').html(errortext);
						};

						


						// AUTHOR CONTACT FORM FUNCTION STARTED --------------------------------------------------------------------------------------------
						$('#pf-ajax-enquiry-button-author').on('click touchstart',function(){
							var form = $('#pf-ajax-enquiry-form-author');

							var recaptchanum = form.find('#recaptcha_div_mod .g-recaptcha-field').data('rekey');
							if (recaptchanum) {
								recaptchanum = $.recaptchanum;
								form.find('#g-recaptcha-response').text(grecaptcha.getResponse(recaptchanum));
							};


							var pfsearchformerrors = form.find(".pfsearchformerrors");
							form.validate({
								  debug:false,
								  onfocus: false,
								  onfocusout: false,
								  onkeyup: false,
								  rules:{
								  	name:"required",
								  	email:{
								  		required:true,
								  		email:true
								  	},
								  	msg:"required",
								  },
								  messages:{
								  	name:theme_scriptspf.pfnameerr,
								  	email: {
									    required: theme_scriptspf.pfemailerr,
				    					email: theme_scriptspf.pfemailerr2
								    },
								    msg:theme_scriptspf.pfmeserr,
								  },
								  validClass: "pfvalid",
								  errorClass: "pfnotvalid pfadmicon-glyph-858",
								  errorElement: "li",
								  errorContainer: pfsearchformerrors,
								  errorLabelContainer: $("ul", pfsearchformerrors),
								  invalidHandler: function(event, validator) {
									var errors = validator.numberOfInvalids();
									if (errors) {
										pfsearchformerrors.show("slide",{direction : "up"},100);
										form.find(".pfsearch-err-button").click(function(){
											pfsearchformerrors.hide("slide",{direction : "up"},100);
											return false;
										});
									}else{
										pfsearchformerrors.hide("fade",300);
									}
								  }
							});
							
							
							
							if(form.valid()){
								$.pfModalwithAjax(form.serialize(),'enquiryformauthor');
							};
							return false;
						});
						// AUTHOR CONTACT FORM FUNCTION FINISHED --------------------------------------------------------------------------------------------




						// REPORT FORM FUNCTION STARTED --------------------------------------------------------------------------------------------
						$('#pf-ajax-report-button').on('click touchstart',function(){
							var form = $('#pf-ajax-report-form');
							var pfsearchformerrors = form.find(".pfsearchformerrors");
							
							var recaptchanum = form.find('#recaptcha_div_mod .g-recaptcha-field').data('rekey');
							if (recaptchanum) {
								recaptchanum = $.recaptchanum;
								form.find('#g-recaptcha-response').text(grecaptcha.getResponse(recaptchanum));
							};

							form.validate({
								  debug:false,
								  onfocus: false,
								  onfocusout: false,
								  onkeyup: false,
								  rules:{
								  	name:"required",
								  	email:{
								  		required:true,
								  		email:true
								  	},
								  	msg:"required",
								  },
								  messages:{
								  	name:theme_scriptspf.pfnameerr,
								  	email: {
									    required: theme_scriptspf.pfemailerr,
									    email: theme_scriptspf.pfemailerr2
								    },
								    msg:theme_scriptspf.pfmeserr2,
								  },
								  validClass: "pfvalid",
								  errorClass: "pfnotvalid pfadmicon-glyph-858",
								  errorElement: "li",
								  errorContainer: pfsearchformerrors,
								  errorLabelContainer: $("ul", pfsearchformerrors),
								  invalidHandler: function(event, validator) {
									var errors = validator.numberOfInvalids();
									if (errors) {
										pfsearchformerrors.show("slide",{direction : "up"},100);
										form.find(".pfsearch-err-button").click(function(){
											pfsearchformerrors.hide("slide",{direction : "up"},100);
											return false;
										});
									}else{
										pfsearchformerrors.hide("fade",300);
									}
								  }
							});
							
							
							
							if(form.valid()){
								$.pfModalwithAjax(form.serialize(),'reportitem');
							};
							return false;
						});
						// REPORT FORM FUNCTION FINISHED --------------------------------------------------------------------------------------------



						// CLAIM FORM FUNCTION STARTED --------------------------------------------------------------------------------------------
						$('#pf-ajax-claim-button').on('click touchstart',function(){
							var form = $('#pf-ajax-claim-form');
							var pfsearchformerrors = form.find(".pfsearchformerrors");
							
							var recaptchanum = form.find('#recaptcha_div_mod .g-recaptcha-field').data('rekey');
							if (recaptchanum) {
								recaptchanum = $.recaptchanum;
								form.find('#g-recaptcha-response').text(grecaptcha.getResponse(recaptchanum));
							};

							form.validate({
								  debug:false,
								  onfocus: false,
								  onfocusout: false,
								  onkeyup: false,
								  rules:{
								  	name:"required",
								  	email:{
								  		required:true,
								  		email:true
								  	},
								  	msg:"required",
								  },
								  messages:{
								  	name:theme_scriptspf.pfnameerr,
								  	email: {
									    required: theme_scriptspf.pfemailerr,
									    email: theme_scriptspf.pfemailerr2
								    },
								    msg:theme_scriptspf.pfmeserr2,
								  },
								  validClass: "pfvalid",
								  errorClass: "pfnotvalid pfadmicon-glyph-858",
								  errorElement: "li",
								  errorContainer: pfsearchformerrors,
								  errorLabelContainer: $("ul", pfsearchformerrors),
								  invalidHandler: function(event, validator) {
									var errors = validator.numberOfInvalids();
									if (errors) {
										pfsearchformerrors.show("slide",{direction : "up"},100);
										form.find(".pfsearch-err-button").click(function(){
											pfsearchformerrors.hide("slide",{direction : "up"},100);
											return false;
										});
									}else{
										pfsearchformerrors.hide("fade",300);
									}
								  }
							});
							
							
							
							if(form.valid()){
								$.pfModalwithAjax(form.serialize(),'claimitem');
							};
							return false;
						});
						// CLAIM FORM FUNCTION FINISHED --------------------------------------------------------------------------------------------




						// FLAG REVIEW FORM FUNCTION STARTED --------------------------------------------------------------------------------------------
						$('#pf-ajax-flag-button').on('click touchstart',function(){
							var form = $('#pf-ajax-flag-form');
							var pfsearchformerrors = form.find(".pfsearchformerrors");
							
							var recaptchanum = form.find('#recaptcha_div_mod .g-recaptcha-field').data('rekey');
							if (recaptchanum) {
								recaptchanum = $.recaptchanum;
								form.find('#g-recaptcha-response').text(grecaptcha.getResponse(recaptchanum));
							};
							
							form.validate({
								  debug:false,
								  onfocus: false,
								  onfocusout: false,
								  onkeyup: false,
								  rules:{
								  	name:"required",
								  	email:{
								  		required:true,
								  		email:true
								  	},
								  	msg:"required",
								  },
								  messages:{
								  	name:theme_scriptspf.pfnameerr,
								  	email: {
									    required: theme_scriptspf.pfemailerr,
									    email: theme_scriptspf.pfemailerr2
								    },
								    msg:theme_scriptspf.pfmeserr,
								  },
								  validClass: "pfvalid",
								  errorClass: "pfnotvalid pfadmicon-glyph-858",
								  errorElement: "li",
								  errorContainer: pfsearchformerrors,
								  errorLabelContainer: $("ul", pfsearchformerrors),
								  invalidHandler: function(event, validator) {
									var errors = validator.numberOfInvalids();
									if (errors) {
										pfsearchformerrors.show("slide",{direction : "up"},100);
										form.find(".pfsearch-err-button").click(function(){
											pfsearchformerrors.hide("slide",{direction : "up"},100);
											return false;
										});
									}else{
										pfsearchformerrors.hide("fade",300);
									}
								  }
							});
							
							
							
							if(form.valid()){
								$.pfModalwithAjax(form.serialize(),'flagreview');
							};
							return false;
						});
						// FLAG REVIEW FORM FUNCTION FINISHED --------------------------------------------------------------------------------------------




						
						// ERROR FUNCTION STARTED --------------------------------------------------------------------------------------------
						$('#pf-ajax-cl-button').click(function(){

							$.pfOpenModal('close')
							return false;

						});
						// ERROR FUNCTION FINISHED --------------------------------------------------------------------------------------------



		            },
		            error: function (request, status, error) {
		            	
	                	$("#pf-membersystem-dialog").html('Error:'+request.responseText);
		            	
		            },
		            complete: function(){
		            	
	            		$('#pf-membersystem-dialog').pfLoadingOverlay({action:'hide'});
	            		
	            		setTimeout(function(){$("#pf-membersystem-dialog").dialog({position:{my: "center", at: "center",collision:"fit"}});},500);
		            	$('.pointfinder-dialog').center(true);
		            },
		        });
			
	        	if(modalname != ''){
			    $("#pf-membersystem-dialog").dialog({
			        resizable: false,
			        modal: true,
			        minWidth: minwidthofdialog,
			        show: { effect: "fade", duration: 100 },
			        dialogClass: 'pointfinder-dialog',
			        open: function() {
				        $('.ui-widget-overlay').addClass('pf-membersystem-overlay');
				    },
				    close: function() {
				        $('.ui-widget-overlay').removeClass('pf-membersystem-overlay');
				    },
				    position:{my: "center", at: "center",collision:"fit"}
			    });
			    $.pfdialogstatus = 'true';
				}

			}else{
				$( "#pf-membersystem-dialog" ).dialog( "close" );
				$.pfdialogstatus = '';
			}
		}

	};


	// CONTACT FORM FUNCTION STARTED --------------------------------------------------------------------------------------------
	$('#pf-ajax-enquiry-button').on('click touchstart',function(){
		var form = $('#pf-ajax-enquiry-form');

		var recaptchanum = form.find('#recaptcha_div_mod .g-recaptcha-field').data('rekey');
		if (recaptchanum) {
			recaptchanum = $.recaptchanum;
			form.find('#g-recaptcha-response').text(grecaptcha.getResponse(recaptchanum));
		};

		var pfsearchformerrors = form.find(".pfsearchformerrors");
		form.validate({
			  debug:false,
			  onfocus: false,
			  onfocusout: false,
			  onkeyup: false,
			  rules:{
			  	name:"required",
			  	email:{
			  		required:true,
			  		email:true
			  	},
			  	msg:"required",
			  },
			  messages:{
			  	name:theme_scriptspf.pfnameerr,
			  	email: {
				    required: theme_scriptspf.pfemailerr,
					email: theme_scriptspf.pfemailerr2
			    },
			    msg:theme_scriptspf.pfmeserr,
			  },
			  validClass: "pfvalid",
			  errorClass: "pfnotvalid pfadmicon-glyph-858",
			  errorElement: "li",
			  errorContainer: pfsearchformerrors,
			  errorLabelContainer: $("ul", pfsearchformerrors),
			  invalidHandler: function(event, validator) {
				var errors = validator.numberOfInvalids();
				if (errors) {
					pfsearchformerrors.show("slide",{direction : "up"},100);
					form.find(".pfsearch-err-button").click(function(){
						pfsearchformerrors.hide("slide",{direction : "up"},100);
						return false;
					});
				}else{
					pfsearchformerrors.hide("fade",300);
				}
			  }
		});
		
		
		
		if(form.valid()){
			$('#pf-ajax-enquiry-button').attr('disabled',true);
			$.pfModalwithAjax(form.serialize(),'enquiryform');
		};
		return false;
	});
	// CONTACT FORM FUNCTION FINISHED --------------------------------------------------------------------------------------------


	// CONTACT FORM FUNCTION STARTED --------------------------------------------------------------------------------------------
	$('#pf-contact-form-submit').on('click touchstart',function(){
		var form = $('#pf-contact-form');
		var pfsearchformerrors = form.find(".pfsearchformerrors");

		form.validate({
			  debug:false,
			  onfocus: false,
			  onfocusout: false,
			  onkeyup: false,
			  rules:{
			  	name:"required",
			  	email:{
			  		required:true,
			  		email:true
			  	}
			  },
			  messages:{
			  	name: theme_scriptspf.pfnameerr,
			  	email: {
				    required: theme_scriptspf.pfemailerr,
				    email: theme_scriptspf.pfemailerr2
			    }
			  },
			  validClass: "pfvalid",
			  errorClass: "pfnotvalid pfadmicon-glyph-858",
			  errorElement: "li",
			  errorContainer: pfsearchformerrors,
			  errorLabelContainer: $("ul", pfsearchformerrors),
			  invalidHandler: function(event, validator) {
				var errors = validator.numberOfInvalids();
				if (errors) {
					pfsearchformerrors.show("slide",{direction : "up"},100);
					form.find(".pfsearch-err-button").click(function(){
						pfsearchformerrors.hide("slide",{direction : "up"},100);
						return false;
					});
				}else{
					pfsearchformerrors.hide("fade",300);
				}
			  }
		});
		
		if(form.valid()){
			var pfreviewoverlay = $("#pfmdcontainer-overlay");
			pfreviewoverlay.pfLoadingOverlay({action:'show'});
			pfreviewoverlay.show("slide",{direction : "up"},100);
			$.pfModalwithAjax(form.serialize(),'contactform');
		};
		return false;
	});
	// CONTACT FORM FUNCTION FINISHED --------------------------------------------------------------------------------------------



	$('#pf-enquiry-trigger-button-author').click(function(){$.pfOpenModal('open','enquiryformauthor','','','',$('#pf-enquiry-trigger-button-author').attr('data-pf-user'))});

	// MANUAL SEARCH BUTTON STARTED --------------------------------------------------------------------------------------------
	$('#pf-search-button-manual').live('click',function(){
		var form = $('#pointfinder-search-form-manual');
		form.validate();

		var temp = ['input[name=pointfinder_radius_search]', 'input[name=ne]', 'input[name=ne2]', 'input[name=sw]', 'input[name=sw2]']
		form.find("div:hidden[id$='_main']").each(function(){
			$(this).find('input[type=hidden]').not(temp.join(',')).val(""); 
			$(this).find('input[type=text]').val($.pfsliderdefaults.fields[$(this).attr('id')]);
			$(this).find('.slider-wrapper .ui-slider-range').css('width','0%');
			$(this).find('.slider-wrapper a:nth-child(2)').css('left','0%');
			$(this).find('.slider-wrapper a:nth-child(3)').css('left','100%');
		});
		
		if(form.valid()){
			form.submit();
		};
		return false;
	});
	// MANUAL SEARCH BUTTON END --------------------------------------------------------------------------------------------
	
	$( window ).resize(function() {
		if ($(window).width() < 550) {
			$('div.vlz_bloquear_map>p').text('Toca la pantalla para ver en el mapa');
		}

	});

	// Footer row fix v1.6.1.3
	$(document).ready(function($) {
		$(".pointfinderexfooterclassx").appendTo(".wpf-footer-row-move");
		 /*Jaurgeui*/
		$('a.edit').addClass('button');
		// $('a.checkout-button.button.alt.wc-forward').text('Pague Ahora');
		// $('a.checkout-button.button.alt.wc-forward').css({'color': '#fff', 'background-color': '#5ec9aa'});
		$('p.return-to-shop>a.button.alt.wc-backward').hide();
		$('p.return-to-shop>a.button.wc-backward').hide();
		$('button.wc-bookings-booking-form-button.single_add_to_cart_button.button.alt').css('text-transform', 'uppercase');
		$('[data-toggle="tooltip"]').tooltip();

		if ($(window).width() < 550) {
			$('div.vlz_bloquear_map>p').text('Toca la pantalla para ver en el mapa');
		}
	});

})(jQuery);