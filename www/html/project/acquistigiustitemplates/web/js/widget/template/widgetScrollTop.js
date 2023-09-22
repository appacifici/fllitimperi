
/**
 * Classe per la gestione del widgetScrollTop
 * 
 */


var WidgetScrollTop = function () {
    this.widget = $(".widget_ScrollTop");
    this.initListeners();
};

WidgetScrollTop.prototype.initListeners = function () {
    var that = this;

    $('body').on('click', '#toTop', function () {

        // Al click sull'icona, torno ad inizio pagina con movenza fluida
        $("#toTop").click(function ()
        {
            $("html,body").animate({scrollTop: 0}, 500, function () {});
        });
    });

    // Intercetto lo scroll di pagina

    $(window).scroll(function () {
        // Se l'evento scroll si verifica, mostro l'icona (invisibile) con effetto dissolvenza
        if ($("#toTop").is(":hidden")) {
            $("#toTop").fadeIn(500);
            $("#btnGoBack").fadeIn(500);
        }
        // Se si verifica il ritorno ad inizio pagina, nascondo l'icona con effetto dissolvenza
        if ($("body").scrollTop() == 0 && !$("#toTop").is(":hidden"))
        {
            $("#toTop").fadeOut(500);
            $("#btnGoBack").fadeOut(500);
        }
    });
};

widgetScrollTop = null;

WidgetScrollTop = new WidgetScrollTop();



