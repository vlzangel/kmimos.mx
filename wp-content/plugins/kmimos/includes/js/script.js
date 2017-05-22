jQuery(document).ready(function(e){
    filejs_import('scroll/scroll_visible/scroll-visible.js');
    //filejs_import('../includes/js/scroll/scroll-paralax/scroll-paralax.js');
    //filejs_import('../includes/js/scroll/scroll-carousel/scroll-carousel.js');
    //filejs_import('../includes/js/scroll/scroll-suavizar/scroll-suavizar.js');
    filejs_import('scroll/scroll_efecto/scroll-efecto.js');
    filejs_import('image/image-load.js');
    filejs_import('image/image-easyload.js');
    filejs_import('image/image-easyload.css');
    //filjse_import('../');

    filecss_import('scroll/scroll_efecto/scroll-efecto.css');
    filecss_import('image/image-easyload.css');
});

function files_path(file){
    var scripts= document.getElementsByTagName('script'); //console.log(scripts);

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

function filejs_import(file){
    var dirfile = files_path(file);
    jQuery.getScript(dirfile, function(){
        //console.log('Loaded: '+file);
    });
}

function filecss_import(file){
    var dirfile = files_path(file);
    jQuery('head').append(jQuery('<link rel="stylesheet" type="text/css" />').attr('href',dirfile));
}
