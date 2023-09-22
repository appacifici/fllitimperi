"use strict";
importScripts("//cdn.notifyon.com/js/analytics.js"), self.analytics.trackingId = "UA-886456-2";
var _apiURL = {
        serverUrl: "https://api.notifyon.com/v1",
        subscriber_id: "",
        notification_id: ""
    },
    splitEndPointSubscription = function(i) {
        var t = "https://android.googleapis.com/gcm/send/",
            n = i.endpoint;
        return 0 === n.indexOf(t) ? n.replace(t, "") : i.subscriptionId
    };
self.addEventListener("push", function(i) {
    i.waitUntil(self.registration.pushManager.getSubscription().then(function(t) {
        if (splitEndPointSubscription(t), i.data) {
            var n = i.data.json(),
                a = {};
            a.title = n.title, a.message = n.message, a.icon = n.icon, a.notificationTag = n.tag, a.url = n.url, a.requireInteraction = !0, a.silent = !1, a.subscriber_id = n.subscriber_id, a.notification_id = n.notification_id, n.hasOwnProperty("ri_flag") && !1 === n.ri_flag && (a.requireInteraction = !1), n.hasOwnProperty("image") && (a.image = n.image), n.hasOwnProperty("badge") && (a.badge = n.badge), n.hasOwnProperty("silent") && (a.silent = n.silent), n.hasOwnProperty("hasAction") && (a.actions = [{
                action: n.action,
                title: n.action_title,
                icon: n.action_icon,
                url: n.action_url
            }]), n.hasOwnProperty("vibrate") && (a.vibrate = [500, 110, 500, 110, 450, 110, 200, 110, 170, 40, 450, 110, 200, 110, 170, 40, 500]), _apiURL.subscriber_id = a.subscriber_id, _apiURL.notification_id = a.notification_id,  
            var e = "";
            e = _apiURL.serverUrl + "/notification-delivered/" + a.subscriber_id + "/" + a.notification_id, fetch(e)["catch"](function(i) {});
            var o = {};
            return o.body = a.message, o.icon = a.icon, o.tag = a.notificationTag, n.hasOwnProperty("ri_flag") && !1 === n.ri_flag && (a.requireInteraction = !1), n.hasOwnProperty("image") && (o.image = n.image), n.hasOwnProperty("badge") && (o.badge = n.badge), n.hasOwnProperty("silent") && (o.silent = n.silent), n.hasOwnProperty("hasAction") ? (o.actions = [{
                action: n.action,
                title: n.action_title,
                icon: n.action_icon,
                url: n.action_url
            }], o.data = {
                url: a.url,
                url_action: a.actions[0].url
            }) : o.data = {
                url: a.url
            }, n.hasOwnProperty("vibrate") && (o.vibrate = [500, 110, 500, 110, 450, 110, 200, 110, 170, 40, 450, 110, 200, 110, 170, 40, 500]), self.registration.showNotification(a.title, o)
        }
    }))
}), self.addEventListener("notificationclick", function(i) {
    function t() {
        s 
        var t = i.notification.data.url;
        return i.action && (t = i.notification.data.url_action), t
    }
    self.registration.pushManager.getSubscription().then(function(i) {
        var t = "";
        t = _apiURL.serverUrl + "/notification-clicked/" + _apiURL.subscriber_id + "/" + _apiURL.notification_id, fetch(t)["catch"](function(i) {})
    }), i.notification.close(), i.waitUntil(clients.matchAll({
        type: "window"
    }).then(function(i) {
        for (var n = 0; n < i.length; n++) {
            var a = i[n];
            if (a.url === t() && "focus" in a) return a.focus()
        }
        return clients.openWindow ? clients.openWindow(t()) : void 0
    }))
}), self.addEventListener("notificationclose", function(i) {
    i.waitUntil(Promise.all([]).then(function() {
        var i = "";
        i = _apiURL.serverUrl + "/notification-close/" + _apiURL.subscriber_id + "/" + _apiURL.notification_id, fetch(i)["catch"](function(i) {})
    }))
});
