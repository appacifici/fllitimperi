if (typeof $.fn.bdatepicker == 'undefined')
	$.fn.bdatepicker = $.fn.datepicker.noConflict();



;(function($){
        $.fn.bdatepicker.defaults.format = "mm/dd/yyyy";
	$.fn.bdatepicker.dates['it'] = {
		days: ["Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato", "Domenica"],
		daysShort: ["Dom", "Lun", "Mar", "Mer", "Gio", "Ven", "Sab", "Dom"],
		daysMin: ["Do", "Lu", "Ma", "Me", "Gi", "Ve", "Sa", "Do"],
		months: ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"],
		monthsShort: ["Gen", "Feb", "Mar", "Apr", "Mag", "Giu", "Lug", "Ago", "Set", "Ott", "Nov", "Dic"],
		today: "Oggi",
		weekStart: 1,
		format: "dd/mm/yyyy"
	};
}(jQuery));

$(function()
{
    	/* DatePicker */
	// default
	$(".datepicker1").bdatepicker({
            
                language: 'it',
		//format: 'dd MM yyyy',
		startDate: '-0d',
        todayBtn: true 
	});

	// component
	$('.datepicker2').bdatepicker({
        language: 'it',
		format: "dd MM yyyy",
		startDate: "2013-02-14"
	});

    var options = {language: 'en',
                format: "dd MM yyyy",
                todayBtn: true,
                autoclose: true,
                clearBtn: true
            };

        $( '.datepicker3' ).bdatepicker(
            options        
        );

	// advanced
	$('.datetimepicker4').bdatepicker({
		format: "dd MM yyyy - hh:ii",
        autoclose: true,
        todayBtn: true,
        startDate: "2013-02-14 10:00",
        minuteStep: 10
	});
	
	// meridian
	$('.datetimepicker5').bdatepicker({
		format: "dd MM yyyy - HH:ii P",
	    showMeridian: true,
	    autoclose: true,
	    startDate: "2013-02-14 10:00",
	    todayBtn: true
	});

	// other
	if ($('.datepicker').length) $(".datepicker").bdatepicker({ showOtherMonths:true });
	if ($('.datepicker-inline').length) $('#datepicker-inline').bdatepicker({ inline: true, showOtherMonths:true });

});