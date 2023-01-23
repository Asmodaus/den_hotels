(function ($) {
	jQuery('.wpcf7-uacf7_country_dropdown').each(function(){
		var fieldId = jQuery(this).attr('id');
		var defaultCountry = jQuery(this).attr('country-code');
		var onlyCountries = jQuery(this).attr('only-countries');  
		if(typeof onlyCountries !== "undefined" && onlyCountries != ''){
			onlyCountries = JSON.parse(onlyCountries);
		}else{
			onlyCountries = '';
		}
		
		$("#"+fieldId).countrySelect({
			defaultCountry: defaultCountry,
			onlyCountries: onlyCountries,
			responsiveDropdown: true,
			preferredCountries: []
		});
	});
})(jQuery);
