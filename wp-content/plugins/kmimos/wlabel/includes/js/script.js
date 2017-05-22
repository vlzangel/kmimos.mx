
function  WhiteLabel_form_login(form){
    var url=jQuery(form).data('validate');
    jQuery(form).find('.message').html('').css({'display':''}).removeClass('show');

    jQuery.post(url,jQuery(form).serialize(),function(data){console.log(data);
        data=jQuery.parseJSON(data);
        jQuery(form).find('.message').html(data['message']).css({'display':'block'}).addClass('show');
        //.delay(10000).removeClass('show');
    });
}


function WhiteLabel_panel_logout(element){
    var url=jQuery(element).data('logout');
    jQuery(element).html('Espere ...');
    jQuery.get(url, function(data){
        data=jQuery.parseJSON(data);
        jQuery(element).html(data['message']);
    });
}