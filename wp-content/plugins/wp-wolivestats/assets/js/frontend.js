document.addEventListener('DOMContentLoaded', function() {
    function ajax(url, method, data, async)
    {
        method = typeof method !== 'undefined' ? method : 'GET';
        async = typeof async !== 'undefined' ? async : false;
        if (window.XMLHttpRequest)
        {
            var xhReq = new XMLHttpRequest();
        }
        else
        {
            var xhReq = new ActiveXObject("Microsoft.XMLHTTP");
        }
        if (method == 'POST')
        {
            xhReq.open(method, url, true);
            xhReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhReq.setRequestHeader("X-Requested-With", "XMLHttpRequest");
            xhReq.send(data);
        }
        else
        {
            if(typeof data !== 'undefined' && data !== null)
            {
                url = url+'?'+data;
            }
            xhReq.open(method, url, async);
            xhReq.setRequestHeader("X-Requested-With", "XMLHttpRequest");
            xhReq.send(null);
        }
        //var serverResponse = xhReq.responseText;
        //alert(serverResponse);
    }

    if (typeof wo_front_end == 'undefined' ) return false;

    var w_referer_ = document.referrer.indexOf(location.protocol + "//" + location.host) === 0?0:document.referrer;

    if  (w_referer_.length === 0 ) {
        w_referer_ = 0
    }

    // exclude
    var url_last= null;
    if (getCookie('wolive_extra_data')) {
        url_last = getCookie('wolive_extra_data').url_last;
    }
    if (url_last==wo_front_end.url) {

    } else if ( getQueryVariable("add-to-cart") ) { // Exclude URL

    } else if ( window.location.href.indexOf("wc_order_")!=-1 ) {

    }
    else {
        if (wo_front_end) {
            var data = {
                'action': 'wostats',
                w_referer: w_referer_,
                'url': wo_front_end.url,
                'original_url': wo_front_end.original_url,
                'dp':wo_front_end.dp,
                'sw': screen.width,
                'sh': screen.height
            };

            var query = [];
            for (var key in data)
            {
                query.push(encodeURIComponent(key) + '=' + encodeURIComponent(data[key]));
            }
            ajax(wo_front_end.ajax_url, "POST", query.join('&') );
        }
    }

});

function getCookie(name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length == 2) return JSON.parse(decodeURIComponent(parts.pop().split(";").shift()));
}

function getQueryVariable(variable) {
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i=0;i<vars.length;i++) {
        var pair = vars[i].split("=");
        if (pair[0] == variable) {
            return pair[1];
        }
    } 
}
