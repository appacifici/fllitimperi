const CACHE_NAME = 'clienIdGM4';
const OFFLINE_URL = '/';

self.addEventListener('install', event => {    
    console.log("Service Worker Installato");
    self.skipWaiting();    

});
   
self.addEventListener('activate', event => {    
    console.log("Service Worker Attivo");    
});


self.addEventListener('push', function (event) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        return;
    }

    const sendNotification = body => {
        const title = body['title'];               
        sendTogetGM4('view', 'event_type', body['push_send_id'], body['channel_id']); 
        return self.registration.showNotification(title, body);
    };

    if (event.data) {
        const message = event.data.json();
        event.waitUntil(sendNotification(message));
    }
});

self.addEventListener('notificationclick', function(event) {
    event.notification.close();    
    var d = event.notification.data.url;

    sendTogetGM4('click', 'event_type', event.notification.data.push_send_id, event.notification.data.channel_id);    

    event.waitUntil(
      clients.openWindow(d)
    );
});


async function sendTogetGM4(eventName, eventType, pushSendId, channelId) {
    const cache = await caches.open(CACHE_NAME);
    cache.keys().then((keys) => {
        console.log(keys);
        keys.forEach((request, index, array) => {
            console.log(request.url);

            var url                 = new URL(request.url);
            var clientID            = url.searchParams.get("MGCID");        
            const measurement_id    = `G-Z77SHXSRTW`;
            const api_secret        = `j_gAYy8bQ2C5VI_N6qVjTw`;

            console.log(`urlgoogle: https://www.google-analytics.com/mp/collect?measurement_id=${measurement_id}&api_secret=${api_secret}`);
            console.log(`clientID: ${clientID}`);

        if( typeof channelId === 'undefined' ) {
            channelId = 0;
        }

        let object;
            if(eventName == 'click') {
                object = [
                    {
                        "name": "pushEvent",
                        "params": {
                            "items": [],
                            "click": "channel_"+channelId
                        }
                    }
                ];
            } else if(eventName == 'view') {
                object = [
                    {
                        "name": "pushEvent",
                        "params": {
                            "items": [],
                            "view": "channel_"+channelId
                        }
                    }
                ]
            }

            console.info(object);

            fetch(`https://www.google-analytics.com/mp/collect?measurement_id=${measurement_id}&api_secret=${api_secret}`, {
                method: "POST",
                body: JSON.stringify({
                    "client_id": clientID,
                    "non_interaction": true,
                    "non_personalized_ads": false,
                    "validationBehavior": "ENFORCE_RECOMMENDATIONS",    
                    "events": object
                })
            });
            
        });
    });
}