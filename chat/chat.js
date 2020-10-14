const connection = require("./database");
require('dotenv').config();
//var users = new Users();
module.exports = {
    val: io => {
        io.on("connection", socket => {
            console.log("made socket connection ", socket.id);
            console.log("hello");
            socket.on("send_message", function (input, result) {
                var genrate_room_id = Math.floor(1000000000 + Math.random() * 9000000000);
                var check_sender_receiver = "SELECT `sender_id` , `receiver_id` , `room_id` , `message`, `created_at` FROM `chats` WHERE sender_id = " + input.sender_id + " AND receiver_id  = " + input.receiver_id + " OR  `sender_id` = " + input.receiver_id + " AND `receiver_id` = " + input.sender_id;
                connection.query(check_sender_receiver, (error, rows, fields) => {
                    if (error) {
                        socket.emit("send_message", {
                            status: false,
                            message: error,
                            result: rows
                        });
                    } else {
                        var room_id = rows.length <= 0 ? genrate_room_id : rows[0].room_id;
                        var insert = "INSERT INTO chats(`sender_id` , `receiver_id` ,`socket_id`, `room_id` , `message`) VALUES (?,?,?,?,?)";
                        var values = [
                            input.sender_id,
                            input.receiver_id,
                            socket.id,
                            room_id,
                            input.message
                        ];
                        let current = new Date();

                        var msgArr = [{
                            sender_id: input.sender_id,
                            receiver_id: input.receiver_id,
                            room_id: room_id,
                            message: input.message,
                            created_at: current
                        }];
                        connection.query(insert, values, (error, rows, fields) => {
                            if (error) {
                                socket.emit("send_message", {
                                    status: false,
                                    message: error,
                                    result: msgArr
                                });
                            } else {
                                var fetch_message = "SELECT `room_id`, `sender_id`, `receiver_id`, `message` , `created_at` FROM `chats` WHERE `sender_id` =" + input.sender_id + " AND `receiver_id` =" + input.receiver_id;

                                connection.query(fetch_message, (error, rows, fields) => {
                                    if (error) {
                                        socket.emit("send_message", {
                                            status: false,
                                            message: error,
                                            result: msgArr
                                        });
                                    } else {
                                        socket.emit("send_message", {
                                            status: true,
                                            message: 'SUCCESS',
                                            result: msgArr
                                        });
                                    }

                                });
                            }

                        });

                    }
                    // connected!
                });
            });
            socket.on("user_list", function (input, result) {
                var image_url = `${process.env.APP_URL}` + "storage/uploads/user_image/";
                console.log(image_url);
                var get_user_list = "SELECT  room_id, sender_id, receiver_id, message , c.created_at ,u.id as user_id, u.first_name , CONCAT('" + image_url + "', u.image) as image, u.user_name FROM chats c  LEFT JOIN users u ON c.sender_id = u.id OR c.receiver_id = u.id GROUP BY u.id  ORDER BY c.created_at DESC";
                connection.query(get_user_list, (error, rows, fields) => {
                    if (error) {
                        socket.emit("user_list", {
                            status: false,
                            message: error,
                            result: rows
                        });
                    } else {
                        socket.emit("user_list", {
                            status: true,
                            message: 'SUCCESS',
                            result: rows
                        });
                    }
                    // connected!
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
                        socket.emit("user_chat_list", {
                            status: true,
                            message: 'SUCCESS',
                            result: rows
                        });
                    }
                    // connected!
                });
            });
        });
    }
};
