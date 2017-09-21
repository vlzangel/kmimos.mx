jQuery(document).ready(function(e){

    var filejs=[];
    filejs.push('scroll/scroll_visible/scroll-visible.js');
    //filejs.push('scroll/scroll-paralax/scroll-paralax.js');
    //filejs.push('scroll/scroll-carousel/scroll-carousel.js');
    //filejs.push('scroll/scroll-suavizar/scroll-suavizar.js');
    filejs.push('scroll/scroll_efecto/scroll-efecto.js');
    filejs.push('image/image-load.js');
    filejs.push('image/image-easyload.js');
    //filejs.push();
    //filejs_import(filejs,0);

    var filecss=[];
    filecss.push('scroll/scroll_efecto/scroll-efecto.css');
    filecss.push('image/image-easyload.css');
    //filecss_import(filecss,0);

});

function files_path(file){
    var scripts= document.getElementsByTagName('script');

    var iscript = 0;
    for(var index in scripts){
        var src = scripts[index]['src'];
        if(src.indexOf("kmimos/includes/js/script.js")>= 0){
            iscript = index;
            break;
        };
    }

    var path= scripts[iscript].src.split('?')[0];
    var dir= path.split('/').slice(0, -1).join('/')+'/';
    return dir+file;
}

function filejs_import(file,count){
    if(file.length>count){
        var dirfile = files_path(file[count]);
        jQuery.getScript(dirfile, function(){
            //console.log('Loaded: '+file[count]);
            filejs_import(file,(count+1));
        });
    }
}

function filecss_import(file,count){
    if(file.length>count){
        var dirfile = files_path(file[count]);
        jQuery('head').append(jQuery('<link rel="stylesheet" type="text/css" />').attr('href',dirfile));
        filecss_import(file,(count+1));
    }
}

//MESSAGE
var timeMessage=0;
function message(message){
    clearTimeout(timeMessage);
    messageCreate('#message',message);
}

function messageCreate(element,message){
    //console.log(message);
    var action = function() {
        jQuery(element).html(message);
        messageShow(element);
    }

    if(jQuery(element).length==0){
        jQuery('body').append('<div id="message"></div>');
        action();

    }else{
        jQuery(element).fadeOut(500,function(){
            //jQuery(element).remove();
            action();
        });
    }
}

function messageInsite(element,message){
    messageCreate(element,message);
}

function messageShow(element){
    //var height = element.height();
    jQuery(element).fadeIn(500,function(){
        timeMessage = setTimeout(function(){
            var callback = function(){}
            messageClose(element, callback);
        }, 6000);
    });
}

function messageClose(element, callback){
    if(jQuery(element).length>0){
        jQuery(element).fadeOut(500,function(){
            //jQuery(element).remove();
            callback();
        });
    }
}


//POPUP
function messagePopUp_Create(html){
    var element = '#message.PopUp';
    if(jQuery(element).length==0){
        jQuery('body').append('<div id="message" class="popup"></div>');
        jQuery(element).append('<div class="contain"></div>');
    }

    jQuery(element).find('.contain').html(html);
    jQuery(element).fadeIn(500,function(){
        /*
         vsetTime = setTimeout(function(){
         SubscribePopUp_Close(element);
         }, 6000);
         */
    });
}

function messagePopUp_Close(element){
    if(jQuery(element).length>0){
        jQuery(element).fadeOut(500,function(){
            jQuery(element).remove();
        });
    }
}