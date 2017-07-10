jQuery(document).ready(function(){
    jQuery(document).on('change','select.redirect',function(e){
        var value=jQuery(this).val(); console.log(value);
        if(value!=''){
            if(jQuery(this).find('option[value="'+value+'"]').hasClass('action_confirmed')){

                var confirmed = confirm("Esta Seguro de cancelar esta reserva?");
                if (confirmed == true) {
                    //alert("You pressed OK!");
                    window.location.href = value;
                }else{
                    //alert("You pressed Cancel!");
                }

            }else{
                window.location.href = value;
            }
        }
    });
});