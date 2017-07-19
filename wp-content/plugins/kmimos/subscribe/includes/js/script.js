//FORM
var vsetTime=0;

function form_subscribe(element){
    var base = jQuery(element).closest('.subscribe').data('subscribe');
    jQuery.post(url, jQuery(element).serialize(),function(data){
        //console.log(data);
    });
    return false;
}

function form_subscribe(element){
    var subscribe = jQuery(element).closest('.subscribe');
    var message = subscribe.find('.message');
    var base = subscribe.data('subscribe');
    var url = base+'/subscribe/subscription.php';
    jQuery.post(url, jQuery(element).serialize(),function(data){
        //data = jQuery.parseJSON(data);
        //console.log(data);
        if(data['result']===true){
            if(message.length>0){
                message.addClass('show');
                message.html('<i class="icon fa fa-envelope"></i>'+data['message']+'');
                vsetTime = setTimeout(function(){
                    message_subscribe(message);
                }, 5000);
            }

        }else{


        }
    });
    return false;
}




function message_subscribe(element){
    clearTimeout(vsetTime);
    element.removeClass('show');
    element.html('');
    return true;
}