// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js");
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyCAiNRJtCuaD19ESSzxLXb3cA4cNMlNxP4",
    authDomain: "findisy-17845.firebaseapp.com",
    projectId: "findisy-17845",
    storageBucket: "findisy-17845.appspot.com",
    messagingSenderId: "953296583179",
    appId: "1:953296583179:web:ecbb9259b851de391e650e",
    measurementId: "G-8MRYPZ8NH7"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log("Message received.", payload);
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png"
    };
    return self.registration.showNotification(title, options);
});
