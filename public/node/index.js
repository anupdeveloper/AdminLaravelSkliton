const express = require("express");
const app = express();
const https = require('https');
const http = require("http");
//const conn = require("./config");
const cors = require("cors");
const path = require("path");

const fs = require('fs');
const myConsole = new console.Console(fs.createWriteStream(path.join(__dirname, "debug.log"), {
  flags: "a"
}));


const { Server } = require("socket.io");
const { count } = require("console");
app.use(cors());

const server = https.createServer(app);

app.get('/', (req, res) => {
  res.send('Hello World!')
  
  myConsole.log(`Hello World`);
})

const io = new Server(server, {
  cors: {
    origin:'*',
    methods: ["GET", "POST"],
  },
});


io.on("connection", (socket) => {
  console.log(`User Connected: ${socket.id}`);
  myConsole.log(`User Connected: ${socket.id}`);

  socket.on("join_room", (data) => {
    socket.join(data);
    console.log(`User with ID: ${socket.id} joined room: ${data}`);
    myConsole.log(`User with ID: ${socket.id} joined room: ${data}`);
  });


  socket.on("send_message", (data) => {
    
    
    socket.to(data.room).emit("receive_message", data);
    console.log(data)
    myConsole.log(data)
  });

  /*
  socket.on('send_file', function(data) {
    var fs = require('fs');
    var timestamp = new Date().getTime();
    var imgName = timestamp+"-"+data.name
    var fileName = __dirname + '/uploads/' + imgName;
    fs.open(fileName, 'a', 0755, function(err, fd) {
        if (err) throw err;
        fs.write(fd, data.buffer, null, 'Binary', function(err, written, buff) {
            fs.close(fd, function() {
              socket.to(data.room).emit("receive_message", data);
            });
        })
    });
  });
  */

  socket.on("disconnect", () => {
    console.log("User Disconnected", socket.id);
  });
});

server.listen(3001, () => {
  console.log("SERVER RUNNING");
  myConsole.log('SERVER RUNNING');
});
