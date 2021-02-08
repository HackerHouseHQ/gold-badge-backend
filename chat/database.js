var mysql = require("mysql");
var db_config = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "gold_badge",
    charset: "utf8mb4"
});


function handleDisconnect() {
  connection = mysql.createConnection(db_config); // Recreate the connection, since
                                                  // the old one cannot be reused
  connection.connect(function(err) {              // The server is either down
    if(err) {                                     // or restarting (takes a while sometimes).
      console.log('error when connecting to db:', err);
      setTimeout(handleDisconnect, 2000); // We introduce a delay before attempting to reconnect,
    }
    console.log("connected as id " + connection.threadId);
                                        // to avoid a hot loop, and to allow our node script to
  });                                     // process asynchronous requests in the meantime.
                                          // If you're also serving http, display a 503 error.
  connection.on('error', function(err) {
    console.log('db error', err);
    if(err.code === 'PROTOCOL_CONNECTION_LOST') { // Connection to the MySQL server is usually
      handleDisconnect();                         // lost due to either server restart, or a
    } else {                                      // connnection idle timeout (the wait_timeout
      throw err;                                  // server variable configures this)
    }
  });
}

handleDisconnect();
// connection.connect(function (err) {
//     if (err) {
//         console.error("error connecting: " + err.stack);
//         return;
//     }
//     console.log("connected as id " + connection.threadId);
// });

// let pool = mysql.createPool(connection);

// pool.on('connection', function (_conn) {
//     if (_conn) {
//         logger.info('Connected the database via threadId %d!!', _conn.threadId);
//         _conn.query('SET SESSION auto_increment_increment=1');
//     }
// });
module.exports = connection;
