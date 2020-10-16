const connection = require("./database");
require('dotenv').config();
//var users = new Users();
module.exports = {
    val: io => {
        io.on("connection", socket => {
            socket.on("send_message", function (input, result) {

                var insert = "INSERT INTO chats(`sender_id` , `receiver_id` ,`socket_id`, `room_id` , `message`) VALUES (?,?,?,?,?)";
                var room_id = input.room_id;
                var values = [
                    input.sender_id,
                    input.receiver_id,
                    socket.id,
                    input.room_id,
                    input.message
                ];
                let current = new Date();
                var msgArr = [{
                    sender_id: input.sender_id,
                    receiver_id: input.receiver_id,
                    room_id: input.room_id,
                    message: input.message,
                    created_at: current
                }];

                connection.query(insert, values, (error, rows, fields) => {
                    if (error) {
                        io.emit("receive_message", {
                            status: false,
                            message: error,
                            result: msgArr
                        });
                    } else {
                        console.log(msgArr, 'message---------------------**********');
                        console.log(room_id);
                        io.emit("received", {
                            status: true,
                            message: 'SUCCESS',
                            result: msgArr
                        });
                    }

                });

            });
            socket.on("user_chat_list", function (input, result) {
                var get_chat_user_list = "SELECT `room_id`, `sender_id`, `receiver_id`, `message` , `created_at` FROM `chats` WHERE `sender_id` = " + input.sender_id + " AND `receiver_id` = " + input.receiver_id + " OR  `sender_id` = " + input.receiver_id + " AND `receiver_id` = " + input.sender_id;
                connection.query(get_chat_user_list, (error, rows, fields) => {
                    if (error) {
                        socket.emit("user_chat_list", {
                            status: false,
                            message: error,
                            result: rows
                        });
                    } else {
                        if (rows.length <= 0) {
                            var genrate_room_id = Math.floor(1000000000 + Math.random() * 9000000000);
                            var room_id = genrate_room_id;
                            var room = [{
                                sender_id: input.sender_id,
                                receiver_id: input.receiver_id,
                                room_id: room_id.toString(),
                                message: "",
                                created_at: ""
                            }];
                            socket.emit("user_chat_list", {
                                status: true,
                                message: 'SUCCESS',
                                result: room
                            });

                        } else {
                            socket.emit("user_chat_list", {
                                status: true,
                                message: 'SUCCESS',
                                result: rows
                            });
                        }
                    }
                    // connected!
                });
            });
        });
    }
};
