var webSocket = WS.connect(_WS_URI);
var channel="users/"+_WS_MAT+"/notification";
webSocket.on("socket/connect", function(session){
    //session is an Autobahn JS WAMP session.


    console.log("Successfully Connected!");
    //the callback function in "subscribe" is called everytime an event is published in that channel.
    
    session.subscribe(channel, function(uri, payload){
        //console.log("Received message", payload.msg);
        $.notify({
                            title: '<strong>Notification</strong> <br/>',
                            message: '<strong>'+payload.msg+'</strong>'

                            },
                            {
                            type: 'info',
                            offset:
                            {
                                x: 20,
                                y: 80
                            }
                            }

                                    );
    });

   /*  session.publish(channel, "Un message");
   */
})

webSocket.on("socket/disconnect", function(error){
    //error provides us with some insight into the disconnection: error.reason and error.code

    console.log("Disconnected for " + error.reason + " with code " + error.code);
})