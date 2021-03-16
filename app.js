const express = require("express");
const socket = require("socket.io");
const bodyParser = require("body-parser");
const cors = require("cors");
const fs = require("file-system")
const app = express();
const port = 4005;
app.use(
    bodyParser.urlencoded({
        extended: false
    })
);
var privateKey = fs.readFileSync('gold_badge.key');
var certificate = fs.readFileSync('17f7a213bda74a30.crt');
//var ca = fs.readFileSync('gd_bundle-g2-g1.crt');
var ca = fs.readFileSync('17f7a213bda74a30.pem');
var credentials = { key: privateKey, cert: certificate, ca: ca };
// var httpsServer = https.createServer(credentials, app);
var server = require("https").createServer(credentials, app);
var io = socket(server);
const sckt = require("./chat/chat");
sckt.val(io);
server.listen(port, () =>
    console.log("Express server is runing at port number :" + port)
);
