(function($){shipping_state = function(){$('body').on('change', 'select#shipping_state, input#shipping_state',function(){$.get(HANNANStd_Ajax_Shipping_Cities.ajaxurl,{action: 'get_cities_from_state_by_hannanstd',nextNonce: HANNANStd_Ajax_Shipping_Cities.nextNonce,i_state: this.value},
function(data,status){$('#shipping_city').empty();var arr = data.split(';');var count = arr.length-1;var i = 0;var selected = '';
$('#shipping_city').append('<option value="">شهر مورد نظر را انتخاب نمایید</option>');$.each(arr, function (i,valu){if (valu != '' && valu != '0') {               
if ( count != 1 && ( i != 0 && i != 1 ) ){if (valu == arr[1]) selected = 'selected=selected';else selected = '';
$('#shipping_city').append('<option value="'+valu+'" '+selected+' >'+valu+'</option>');}
i++;}});$('#shipping_city').trigger('chosen:updated');});});}})(jQuery);