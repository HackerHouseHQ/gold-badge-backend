var mysql = require("mysql");
var connection = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "goldbadge@!!!1",
    database: "gold_badge",
    charset: "utf8mb4"
});
connection.connect(function (err) {
    if (err) {
        console.error("error connecting: " + err.stack);
        return;
    }
    console.log("connected as id " + connection.threadId);
});
let dbConfig ={
    host: "localhost",
    user: "root",
    password: "goldbadge@!!!1",
    database: "gold_badge",
    charset: "utf8mb4"
}
let pool = mysql.createPool(dbConfig);

pool.on('connection', function (_conn) {
    if (_conn) {
        console.log('Connected the database via threadId %d!!', _conn.threadId);
        _conn.query('SET SESSION auto_increment_increment=1');
    }
});
module.exports = pool;
