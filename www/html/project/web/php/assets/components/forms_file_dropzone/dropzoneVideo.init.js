( function( $ ) {
	if ( typeof Dropzone != 'undefined' )
        Dropzone.autoDiscover = false;         
	
	if ( $.fn.dropzone != 'undefined' ) {
		$( '.dropzone' ).dropzone( {
            addRemoveLinks: true,
            maxFilesize: 10,
            dictRemoveFileConfirmation:'Vuoi eliminare questo file?',
            dictDefaultMessage: '<b>Trascina i file<b> qui per caricarli<br> oppure clicca!',
            dictFileTooBig: "Il file è di({{filesize}}MiB). Max: {{maxFilesize}}MiB.",
            dictRemoveFile: "Rimuovi File",
            dictCancelUploadConfirmation:true,
            dictInvalidFileType: 'Formato del file non consentito',
            dictResponseError:'Server ha risposto con {{}} statusCode codice',
            dictCancelUpload:'Ferma Upload',
            dictCancelUploadConfirmation:'Sei sicuro di voler cancellare questo caricamento?',
            dictMaxFilesExceeded:'È possibile caricare solo {{maxfiles}} file',
            acceptedFiles: 'video/*',
            paramName: "files[]",
            success: function(file, resp ){
                response = jQuery.parseJSON( resp );                
                if( response.code == 501 ) { // succeeded
                    $( file.previewTemplate ).attr( 'data-id', response.id );
                    
                    $( file.previewTemplate ).click( function(){
                        var modals = {
                            type : 'custom',
                            title : 'Impostazioni Video',                            
                            callbackModals: classImages.settingUserImage( $( this ).attr( 'data-id' ) ) 
                        }
                        classModals.openModals( modals );
                    });
                    
                    return file.previewElement.classList.add( "dz-success" );
                  
                } else if ( response.code == 403 ) {  //  error
                    var node, _i, _len, _ref, _results;
                    var message = response.msg 
                    file.previewElement.classList.add( "dz-error" );
                    _ref = file.previewElement.querySelectorAll( "[data-dz-errormessage]" );
                    _results = [];
                    for ( _i = 0, _len = _ref.length; _i < _len; _i++ ) {
                        node = _ref[_i];
                        _results.push( node.textContent = message );
                    }
                    return _results;
                }
            },
            removedfile: function( file ) {                
                var id = $( file.previewTemplate ).attr( 'data-id' );                
                var request = $.ajax({
                    url: ajaxCallPath+"call.php?action=removeUserVideo&id=" + id,
                    type: "GET",
                    dataType: "json"
                }).done( function( response ) {
                    if( response.code == 501 ) {
                        $( file.previewTemplate ).remove();
                        
                    } else if ( response.code == 403 ) {                        
                        var parameters = new Array();   
                        parameters['type'] = 'error';
                        parameters['layout'] = 'top';
                        parameters['mex'] = 'Attenzione: cancellazione video non riuscita, riprovare e se il problema persiste contattare info@eroticland.it';
                        classNotyfy.openNotyfy( parameters ); 
                    }
                });                               
            },
            uploadprogress: function(file, progress, bytesSent) {
                var node, _i, _len, _ref, _results;
                _ref = file.previewElement.querySelectorAll("[data-dz-uploadprogress]");
                _results = [];
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                  node = _ref[_i];
                  _results.push(node.style.width = "" + progress + "%");
                }
                return _results;
            }
        });
    }    
})( jQuery );


//            addedfile: function(file) {
//                $( file.previewElement ).click( function() {
//                    var path = $( file.previewTemplate ).attr( 'data-path' );
//                    if (!path) { return; }
//                    alert( path );
//                    // That appBaseUrl is a custom global variable of mine
//                });
//            }