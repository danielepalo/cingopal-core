//* disable import button for pro demo *//
jQuery(document).ready(function($) {
	
	$.each($('.js-ocdi-gl-import-data'), function(index, val){
		//console.log(index, val);
		if($(this).val() > 1){
			$(this).hide();
		}
	});
});