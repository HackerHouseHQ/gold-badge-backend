const connection = require("./database");
require("dotenv").config();
const { Users } = require("./user");
let users = new Users();
//var users = new Users();
module.exports = {
    val: io => {
        io.on("connection", socket => {
            console.log("made socket connection", socket.id);
            socket.on("send_message", function (input, result) {
                console.log(input);
                var insert = "INSERT INTO chats(`sender_id` , `receiver_id` ,`socket_id`, `room_id` , `message`) VALUES (?,?,?,?,?)";
                var room_id = input.room_id;
                let current = new Date();
                let output = [
                    {
                        sender_id: input.sender_id,
                        receiver_id: input.receiver_id,
                        room_id: input.room_id,
                        message: input.message,
                        created_at: current
                    }
                ];
                console.log(users);
                io.to(room_id).emit("receive_message", {
                    status: true,
                    message: "SUCCESS",
                    result: output
                });

                var values = [
                    input.sender_id,
                    input.receiver_id,
                    socket.id,
                    room_id,
                    input.message
                ];
                connection.query(insert, values, (error, rows, fields) => {
                    if (error) {
                        console.error(error);
                    } else {
                        console.log("inserted");
                    }
                });
            });
            socket.on("user_chat_list", function (input, result) {
                console.log(input);
                var get_chat_user_list = "SELECT `room_id`, `sender_id`, `receiver_id`, `message` , `created_at` FROM `chats` WHERE `sender_id` = " + input.sender_id + " AND `receiver_id` = " + input.receiver_id + " OR  `sender_id` = " + input.receiver_id + " AND `receiver_id` = " + input.sender_id;
                connection.query(get_chat_user_list, (error, rows, fields) => {
                    if (error) {
                        console.log(error);
                        // socket.emit("user_chat_list", {
                        //     status: false,
                        //     message: error,
                        //     result: rows
                        // });
                    } else {
                        if (rows.length <= 0) {
                            var genrate_room_id = Math.floor(
                                1000000000 + Math.random() * 9000000000
                            );
                            var room_id = genrate_room_id.toString();
                            var room = [
                                {
                                    sender_id: input.sender_id,
                                    receiver_id: input.receiver_id,
                                    room_id: room_id,
                                    message: "",
                                    created_at: ""
                                }
                            ];
                            cart = [];
                            input.id = socket.id;
                            input.room_id = room_id;
                            cart.push(input);
                            socket.join(room_id);
                            users.removeUser(socket.id);
                            users.addUser(input);
                            socket.emit("user_chat_list", {
                                status: true,
                                message: "SUCCESS",
                                result: room
                            });
                        } else {
                            cart = [];
                            room_id = rows[0].room_id;
                            input.id = socket.id;
                            input.room_id = room_id;
                            cart.push(input);
                            socket.join(room_id);
                            users.removeUser(socket.id);
                            users.addUser(input);
                            socket.emit("user_chat_list", {
                                status: true,
                                message: "SUCCESS",
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
