const connection = require("./database");
//var users = new Users();
module.exports = {
    val: io => {
        io.on("connection", socket => {
            console.log("made socket connection ", socket.id);
            console.log("hello");
            socket.on("send_message", function (input, result) {
                var genrate_room_id = Math.floor(1000000000 + Math.random() * 9000000000);
                var check_sender_receiver = "SELECT `sender_id` , `receiver_id` , `room_id` , `message`, `created_at` FROM `chats` WHERE sender_id = " + input.sender_id + " AND receiver_id  = " + input.receiver_id;
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
                        connection.query(insert, values, (error, rows, fields) => {
                            if (error) {
                                socket.emit("send_message", {
                                    status: false,
                                    message: error,
                                    result: rows
                                });
                            } else {
                                var fetch_message = "SELECT `room_id`, `sender_id`, `receiver_id`, `message` , `created_at` FROM `chats` WHERE `sender_id` =" + input.sender_id + " AND `receiver_id` =" + input.receiver_id;

                                connection.query(fetch_message, (error, rows, fields) => {
                                    if (error) {
                                        socket.emit("send_message", {
                                            status: false,
                                            message: error,
                                            result: rows
                                        });
                                    } else {
                                        socket.emit("send_message", {
                                            status: true,
                                            message: 'SUCCESS',
                                            result: rows
                                        });
                                    }

                                });
                            }

                        });

                    }
                    // connected!
                });
            });
        });
    }
};
