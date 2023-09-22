(function($)
{
	if ($('[data-toggle="prettyPhoto"]').length)
		$('[data-toggle="prettyPhoto"]').prettyPhoto( {
            custom_markup: '<video width="{width}" height="{height}" controls="controls" autoplay="{autoplay}"><source src="{path}" type="video/mp4"></video>',
            social_tools: '',
            default_width: 300,
			default_height: 300,
        });
})(jQuery);