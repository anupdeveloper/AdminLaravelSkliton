// Importing the required modules
const WebSocketServer = require('ws');
const { isJsonString } = require('./Helpers/JsonHelper');


// Creating a new websocket server
const wss = new WebSocketServer.Server({ port: 8080 })
var chatClients = []

wss.getUniqueID = function () {
    function s4() {
        return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
    }
    return s4() + s4() + '-' + s4();
};

// Creating connection using websocket
wss.on("connection", (ws, req, client) => {
    // clients.push(ws);
    console.log("new client connected");
    ws.send("welcome ");
    // console.log(wss);

    // sending message
    ws.on('message', function message(data) {
        // {type:[ setId|sendMessage ]}
        // console.log(data);
        // @ validation whether json or not
        if (!isJsonString(data)) {
            ws.send(JSON.stringify({ message: "Plz send data as JSON STRING format" }))
            return
        }
        data = JSON.parse(data)

        if (data.type == undefined) {
            ws.send(JSON.stringify({ message: "there is no type field forund" }))
            return
        }

        // @ check type is valid
        if (!["setId", "sendMessage"].find(item => data.type === item)) {
            ws.send(JSON.stringify({ message: "type is not valid" }))
            return
        }

        if (data.type == 'setId') {
            if (data.id == undefined) {
                ws.send(JSON.stringify({ message: "id field is required" }))
                return
            }
            if (chatClients.find((item, index) => index === data.id)) {
                // ws.send(JSON.stringify({message:"id field should be unique"}))  
                // return 
            } else {
                if (!data.id) {
                    ws.send(JSON.stringify({ message: "id field should not be empty" }))
                    return

                }
                chatClients[data.id] = ws
                ws.send(JSON.stringify({success:true,type:'setId', message: "id added successfully" }))
                return
            }
        }



        // ws.send(JSON.stringify({ keys: Object.keys(chatClients) }));







    });
    // handling what to do when clients disconnects from server
    ws.on("close", () => {
        console.log("the client has connected");
    });
    // handling client connection error
    ws.onerror = function () {
        console.log("Some Error occurred")
    }
});
console.log("The WebSocket server is running on port 8080");