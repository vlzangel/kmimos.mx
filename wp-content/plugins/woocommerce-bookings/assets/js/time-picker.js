jQuery(document).ready(function($) {

	$('.block-picker').on('click', 'a', function(){
		var value  = $(this).data('value');
		var target = $(this).closest('div').find('input');

		target.val( value ).change();
		$(this).closest('ul').find('a').removeClass('selected');
		$(this).addClass('selected');

		return false;
	});

	$('#wc_bookings_field_resource, #wc_bookings_field_duration').change(function(){
		show_available_time_blocks( this );
	});
	$('.wc-bookings-booking-form fieldset').on( 'date-selected', function() {
		show_available_time_blocks( this );
	});

	var xhr;

	function show_available_time_blocks( element ) {
		var $form               = $(element).closest('form');
		var block_picker        = $(element).next().find('.block-picker');
		var fieldset            = $(element);

		var year  = parseInt( fieldset.find( 'input.booking_date_year' ).val(), 10 );
		var month = parseInt( fieldset.find( 'input.booking_date_month' ).val(), 10 );
		var day   = parseInt( fieldset.find( 'input.booking_date_day' ).val(), 10 );

		if ( ! year || ! month || ! day ) {
			return;
		}

		// clear blocks
		block_picker.closest('div').find('input').val( '' ).change();
		block_picker.closest('div').block({message: null, overlayCSS: {background: '#fff', backgroundSize: '16px 16px', opacity: 0.6}}).show();

		// Get blocks via ajax
		if ( xhr ) xhr.abort();

		xhr = $.ajax({
			type: 		'POST',
			url: 		booking_form_params.ajax_url,
			data: 		{
				action: 'wc_bookings_get_blocks',
				form:   $form.serialize()
			},
			success: function( code ) {
				block_picker.html( code );
				resize_blocks();
				block_picker.closest('div').unblock();
			},
			dataType: 	"html"
		});
	}

	function resize_blocks() {
		var max_width  = 0;
		var max_height = 0;

		$('.block-picker a').each(function() {
			var width  = $(this).width();
			var height = $(this).height();
			if ( width > max_width ) {
				max_width = width;
			}
			if ( height > max_height ) {
				max_height = height;
			}
		});

		$('.block-picker a').width( max_width );
		$('.block-picker a').height( max_height );
	}
});
