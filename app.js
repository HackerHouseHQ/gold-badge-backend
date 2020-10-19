const express = require("express");
const socket = require("socket.io");
const bodyParser = require("body-parser");
const cors = require("cors");
const app = express();
const port = 4005;
app.use(
    bodyParser.urlencoded({
        extended: false
    })
);

var server = require("http").createServer(app);
var io = socket(server);
const sckt = require("./chat/chat");
sckt.val(io);
server.listen(port, () =>
    console.log("Express server is runing at port number :" + port)
);
