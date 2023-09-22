WidgetEditArticle = null;
$(function () {
    widgetEditArticle = new WidgetEditArticle();
});

/**
 * Classe per la gestione del widget
 */
var WidgetEditArticle = function () {
    this.buttonBack = $(".btnBack");
    this.dataArticleId = $('#dataArticleId').val();
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
WidgetEditArticle.prototype.initListeners = function () {
    var that = this;

    $(this.buttonBack).click(function () {
        window.history.back();
    });

    setTimeout(function () {
        $('.widget_EditArticle').find('#form_topNewsImg').css('width', '20%');
    }, 50);

    //se il bottone per rimuovere l'immagine in primo piano è presente aggiungo una classe per sistemare la disposizione dei bottoni
    if ($('div[data-imgTopNews]').val() === "") {
        $('.button-action').find('div.buttonDefault').addClass('btnFormSmall');

        //Recupero il path dell'immagine Top News ed appendo alla fine del form l'immagine
        var pathImgTopNews = $('div[data-imgtopnews]').attr('data-imgtopnews');
        $('.widget_EditArticle').find('#form_topNewsImg').closest('div').append('<img src="/imagesTopNews/' + pathImgTopNews + '" alt="photo" class="formPriorityImage" style="width:150px; height:100px; float:left; margin-bottom:25px"/>');
    }

    //Al caricamento della pagina nascondo il campo per l'upload dell'immagine in primo piano
    if ($('#form_topNews').val() != 1) {
        $('#form_topNewsImg').closest('.form-group').addClass('hide');
        $('#form_positionTopNewsImg').closest('.form-group').addClass('hide');
    }
    //Al caricamento della pagina nascondo il campo negotiation status e opinionCm

    if ($('#form_category').val() != 71) {
        $('#form_negotiationStatus').closest('.form-group').addClass('hide');
        $('#form_opinionCm').closest('.form-group').addClass('hide');
    }

    //Se la news è una top news riabilito il campo per l'upload dell'immagine
    $('#form_topNews').change(function () {
        if ($('#form_topNews').val() == 1) {
            $('#form_topNewsImg').closest('.form-group').removeClass('hide');
            $('#form_positionTopNewsImg').closest('.form-group').removeClass('hide');
        } else {
            $('#form_topNewsImg').closest('.form-group').addClass('hide');
            $('#form_positionTopNewsImg').closest('.form-group').addClass('hide');
        }
    });
    
    //Se la news è una di mercato abilito i campi negotiation status e opinionCm
    $('#form_category').change(function () {
        if ($('#form_category').val() == 71) {
             $('#form_negotiationStatus').closest('.form-group').removeClass('hide');
             $('#form_opinionCm').closest('.form-group').removeClass('hide');
        } else {
            $('#form_negotiationStatus').closest('.form-group').addClass('hide');
            $('#form_opinionCm').closest('.form-group').addClass('hide');
        }
    });

    //sul click del bottone con l'attributo republish si scatena la funzione che fa partire la chiamata ajax
    $('body').on('click', '[data-republish]', function () {
        that.confirmRepublishArticle(this);
    });

    //sul click del bottone con l'attributo topNewsImg si scatena la funzione che fa partire la chiamata ajax per eliminare l'immagine della topNews
    $('body').on('click', '[data-articleId]', function () {
        that.deleteTopNewsImg(this);
    });

    //sul click del bottone con la classe listImgTop si apre il popoup per la scelta delle immagini in primo piano
    $('body').on('click', 'div[data-listImgTop="1"]', function () {
        that.openPopupTopNewsImg();
    });

    //sul click sull'immagine aggiungo la classe slect
    $('body').on('click', '.galleryTopImg img', function () {
        $('.galleryTopImg img').removeClass('selectTopNewsImg');
        $(this).toggleClass('selectTopNewsImg');
    });

    // Ascoltatore sul bottone per l'associazione dell'immagine in primo piano all'articolo
    $('body').on('click', 'div[data-joinTopNews="1"]', function (e) {
        that.setTopNewsImg();
    });

    //Se l'articolo è stato salvato quindi se è presente l'id in querysyting appendo il bottone per la scelta delle immagini in Primo Piano
    if (typeof window.location.pathname.match(/(?:\d*\.)?\d+/g) != 'undefined' && window.location.pathname.match(/(?:\d*\.)?\d+/g) != null) {
        var id = window.location.pathname.match(/(?:\d*\.)?\d+/g);
        $('#form_topNewsImg').closest('div').append('<div class="buttonDefault" data-listImgTop="1"  data-article="' + id + '"><div class="add" >Scegli Foto Primo Piano</div><i class="fa fa-camera-retro"></i></div>');
        $('#form_topNewsImg').css({"width": "30%", "float": "left"});
    }
    
    //ascoltatore per il conteggio delle parole textarea
    CKEDITOR.on("instanceReady",function() {
        CKEDITOR.instances.form_body.document.on( 'keydown', function (evt) {
            var numWords = that.words( );
            var numChar = CKEDITOR.instances.form_body.document.getBody().getHtml().length;
            if( $('.numWords').length == 0 ) {
                $('#form_body').closest('div').append('<label class="numWords" style="float:right; color:#4CAF50;margin-top: 5px;">NUMERO PAROLE: '+ numWords +'</label>');
                $('#form_body').closest('div').append('<label class="numChar" style="float:right; margin-right: 15px; color:#F44336;margin-top: 5px;"> NUMERO CARATTERI: '+ numChar +'</label>');
            } else {
                $('.numWords').html('NUMERO PAROLE: '+numWords);
                $('.numChar').html(' NUMERO CARATTERI: '+numChar);
            }
        });
        
        var numWords = that.words();
        var numChar = CKEDITOR.instances.form_body.document.getBody().getHtml().length;
        
        if( $('.numWords').length == 0 ) {
            $('#form_body').closest('div').append('<label class="numWords" style="float:right; color:#4CAF50;margin-top: 5px;">NUMERO PAROLE: '+ numWords +'</label>');
            $('#form_body').closest('div').append('<label class="numChar" style="float:right; margin-right: 15px; color:#F44336;margin-top: 5px;"> NUMERO CARATTERI: '+ numChar +'</label>');
        } else {
            $('.numWords').html('NUMERO PAROLE: '+numWords);
            $('.numChar').html(' NUMERO CARATTERI: '+numChar);
        }
        
    });
};

WidgetEditArticle.prototype.words = function ( ) {
    var str = CKEDITOR.instances.form_body.document.getBody().getHtml();
    return str.split(" ").length;
};

WidgetEditArticle.prototype.confirmRepublishArticle = function (sender) {
    if (widgetLogin.isLogged() != 1) {
        var callback = {'call': this.confirmRepublishArticle.bind(this), 'params': {'0': sender}};
        bootbox.hideAll();
        widgetLogin.getLoginBox(callback);
        return false;
    }

    mainAdmin.speakSite('Vuoi aggiornare la data di questo articolo?');

    var callback = {'call': this.republishArticle.bind(this), 'params': {0: sender}};
    var params = {
        type: 'confirm',
        confirm: 'Vuoi aggiornare la data di questo articolo?',
        finalCallback: callback
    };
    classModals.openModals(params);
};


WidgetEditArticle.prototype.republishArticle = function (sender) {
    var that = this;
    var id = $(sender).attr('data-republish');

    var request = $.ajax({
        url: "/admin/updateArticleDate/" + id,
        type: "POST",
        async: true,
        dataType: "json"
    });
    request.done(function (resp) {
        that.readResponseAjax(resp);
    });
};

//Metodo che rimuove l'immagine in primo piano
WidgetEditArticle.prototype.deleteTopNewsImg = function (sender) {
    var that = this;
    var id = $(sender).attr('data-articleId');

    var request = $.ajax({
        url: "/admin/deleteTopNewsImg/" + id,
        type: "POST",
        async: true,
        dataType: "json"
    });
    request.done(function (resp) {
        that.readResponseAjax(resp);
        if (!resp.error)
            $('.widget_EditArticle').find('#form_topNewsImg').closest('.form-group').find('img').remove();
    });
};

WidgetEditArticle.prototype.readResponseAjax = function (response) {
    var parameters = new Array();
    parameters['type'] = response.error == 0 ? 'success' : 'error';
    parameters['layout'] = 'top';
    parameters['mex'] = response.msg;
    classNotyfy.openNotyfy(parameters);
    mainAdmin.speakSite(response.msg);
};

// Funzione che apre il popup delle immagini in Primo Piano già esistenti
WidgetEditArticle.prototype.openPopupTopNewsImg = function () {
    var that = this;

    var request = $.ajax({
        url: "/admin/listTopNewsImg",
        type: "POST",
        async: true,
        dataType: "json"
    });
    request.done(function (resp) {
        if (!resp.error) {
            var imgs = '';
            resp.imgs.forEach(function (item) {
                imgs += '<img src="/imagesTopNews/' + item.src + '" data-imgTopNews="' + item.src + '" data-imgPosition="' + item.position + '" style="margin-left:7px; float: left; width:250px; height:150px" />';
            });
            var params = {
                type: 'custom',
                title: 'SCEGLI LA FOTO IN PRIMO PIANO',
                callbackModals: '\
                        <div class="galleryTopImg">\
                            <div class="topImgBox">\
                                <div class="preview">' + imgs + '</div>\
                                <div class="form-group">\
                                    <div class=" buttonDefault pull-right" data-joinTopNews="1">\
                                        <div type="button" class="add">Scegli</div>\
                                        <i class="fa fa-camera-retro"></i>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>'
            };
            classModals.openModals(params);

            setTimeout(function () {
                $('.modal-dialog').css('width', '95%');
            }, 100);
        } else {
            that.readResponseAjax(resp);
        }
    });
};

/**
 * Metodo che setta l'immagine in primo piano
 * @returns {undefined}
 */
WidgetEditArticle.prototype.setTopNewsImg = function () {
    var that = this;
    var articleId = this.dataArticleId;
    var parameters = new Array();
    var src = null;
    var position = null;
    $('.galleryTopImg img.selectTopNewsImg').each(function () {
        src = $(this).attr('data-imgTopNews');
        position = $(this).attr('data-imgposition');
    });

    $('.widget_EditArticle #form_positionTopNewsImg').val(position);

    if (src == null)
        return false;

    var request = $.ajax({
        url: "/admin/setTopNewsImg",
        type: "POST",
        data: {'articleId': articleId, 'src': src, 'position': position},
        async: true,
        dataType: "json"
    });
    request.done(function (resp) {
        bootbox.hideAll();
        that.readResponseAjax(resp);
        if (!resp.error)
            $('form').submit();
    });
};