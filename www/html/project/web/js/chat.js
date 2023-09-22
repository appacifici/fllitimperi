 // This object will be sent everytime you submit a message in the sendMessage function.
    var clientInformation = {
        username: ''
        // You can add more information in a static object
    };
    
    // START SOCKET CONFIG
    /**
     * Note that you need to change the "sandbox" for the URL of your project. 
     * According to the configuration in Sockets/Chat.php , change the port if you need to.
     * @type WebSocket
     */
    var conn = new WebSocket( 'ws://'+socketChatHostClient+':'+socketChatPort );
    
    conn.onopen = function(e) {
        console.info("Connection established succesfully");
        clientInformation.username = main.getCookie("externalUserName");
    };

    conn.onmessage = function(e) {
        var data = JSON.parse(e.data);        
        Chat.appendMessage(data.username, data.message);
    };
    
    conn.onerror = function(e){
//        alert("Error: something went wrong with the socket.");
//        console.error(e);
    };
    // END SOCKET CONFIG
    
    // Apertura widget Chat
    $('body').find('[data-openChat]').click(function() {
        if (widgetUser.isLogged() == 1) {
            $('.widget_Chat').toggle();
            $(".widget_Chat .panel-body").scrollTop(9999999);
            $('[data-notifyMsg]').css('display', 'none');
        }
    });
    // Chiusura widget Chat
    $('body').find('[data-closeChat]').click(function() {
        $('.widget_Chat').toggle();
    });
    
    // recupero msg dal click e chiamata metodo per inviare il messaggio
    document.getElementById("btn-chat").addEventListener("click",function(){
        var msg =  $('.widget_Chat').find('[data-containerMsg]').val();
        
        if(!msg){
//            alert("Inserisci il testo del tuo messaggio");
            return false;
        } 
        Chat.sendMessage(msg);
        // Empty text area
        $('.widget_Chat').find('[data-containerMsg]').val("");
    }, false);
    
    // recupero msg dal keypress e chiamata metodo per inviare il messaggio
    document.getElementById("btn-input").addEventListener("keypress",function(e){
        if (e.keyCode != 13) 
            return false;
        var msg =  $('.widget_Chat').find('[data-containerMsg]').val();
        
        if(!msg){
//            alert("Inserisci il testo del tuo messaggio");
            return false;
        }
        Chat.sendMessage(msg);
        


        // Empty text area
        
        $('.widget_Chat').find('[data-containerMsg]').val("");
//            li.appendChild(document.createTextNode(from + " : "+ message));
    }, false);
    
    // Mini API to send a message with the socket and append a message in a UL element.
    var Chat = {
        appendMessage: function(username,message){
            var from;
                        
            console.info(username);
            console.info(clientInformation.username);
            if(username == clientInformation.username){
                from = "Io";
            }else{
                from = username;
//                from = main.getCookie("externalUserName");
            }            
            if (username == '' ) {
                return false;
            }
            // Append List Item
            var ul = $('.widget_Chat').find('[data-msgBox]');
            var newContainerMsg = $('.widget_Chat').find('[data-newMsg]:last-child').css('display', 'block').clone();
            newContainerMsg.find('[data-msg]').html(message);
            newContainerMsg.find('[data-sender]').html(from);
            
            var superUser = [];
            $.each(superUserChat.split(','), function(){
                superUser.push($.trim(this).toLowerCase());
            });
            
            if( $.inArray(username.toLowerCase(), superUser) != -1 ) {            
                var newContainerSuperMsg = $('.widget_Chat').find('[data-superNewMsg]:last-child').css('display', 'block').clone();
                newContainerSuperMsg.find('[data-superMsg]').html(message);
                newContainerSuperMsg.find('[data-superSender]').html(from);
                $('.widget_Chat').find('[data-superMsgBox]').append(newContainerSuperMsg);
            }
            
            var notifyMsg = $('.widget_Chat').is(":visible");
            if (!notifyMsg) {
                $('[data-notifyMsg]').css('display', 'block');
            } else {
                 $('[data-notifyMsg]').css('display', 'none');
            }
            ul.append(newContainerMsg);
            $(".widget_Chat .panel-body").scrollTop(9999999);
//            li.appendChild(document.createTextNode(from + " : "+ message));
        },
        sendMessage: function(text){
            console.info(escape(text));
            clientInformation.username = main.getCookie("externalUserName");
            clientInformation.message = text.replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi, " ");
            // Send info as JSON
            conn.send(JSON.stringify(clientInformation));
            // Add my own message to the list
            this.appendMessage(clientInformation.username, clientInformation.message);
        }
    };
    
    