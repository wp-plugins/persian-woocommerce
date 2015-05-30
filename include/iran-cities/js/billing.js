(function($){billing_state = function(){$('body').on('change', 'select#billing_state, input#billing_state',function(){$.get(HANNANStd_Ajax_Billing_Cities.ajaxurl,{action: 'get_cities_from_state_by_hannanstd',nextNonce: HANNANStd_Ajax_Billing_Cities.nextNonce,i_state: this.value},
function(data,status){$('#billing_city').empty();var arr = data.split(';');var count = arr.length-1;var i = 0;var selected = '';
$('#billing_city').append('<option value="">شهر مورد نظر را انتخاب نمایید</option>');$.each(arr, function (i,valu){if (valu != '' && valu != '0') {               
if ( count != 1 && ( i != 0 && i != 1 ) ){if (valu == arr[0]) selected = 'selected=selected';else selected = '';
$('#billing_city').append('<option value="'+valu+'" '+selected+' >'+valu+'</option>');}
i++;}});$('#billing_city').trigger('chosen:updated');});});}})(jQuery);