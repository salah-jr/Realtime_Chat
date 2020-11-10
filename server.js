var express = require('express');
var cors = require('cors');
var app = express();
app.use(cors());
var server = require('http').createServer(app);
var io = require('socket.io')(server);
var Redis = require('ioredis');
var redis = new Redis();
var port = '3000';
var users = [];


app.use(express.static(__dirname + '/node_modules'));

app.get('/', (req, res) => {
    res.send('<h1>Hello From Server Side</h1>');
});

redis.subscribe('private-channel', function(){
    console.log('Subscribed to private channel');
});

redis.on('message', function(channel, message) {
    message = JSON.parse(message);
    console.log(message);
    if (channel == 'private-channel') {
        let data = message.data.data;
        let receiver_id = data.receiver_id;
        let event = message.event;

        io.to(`${users[receiver_id]}`).emit(channel + ':' + message.event, data);
    }
});


io.on('connection', (socket)=>{
    socket.on("user_connected", (user_id)=>{
        users[user_id] = socket.id;
        io.emit('updateUserStatus', users);
        console.log("user connected" , user_id);
    });

    socket.on('disconnect', function(){
        var i = users.indexOf('socket.id');
        console.log(' user #' + i + ' disconnected');
        users.splice(i, 1, 0);
        io.emit('updateUserStatus', users);

    });
});

server.listen(port, () => {
    console.log('Listening to port ' + port);
});





// app.use((req,res,next)=>{
//     res.header("Access-Control-Allow-Origin", "*");
//     res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept, Authorization");
//     if(req.method === 'OPTIONS'){
//         res.header('Access-Control-Allow-Methods', 'PUT, POST, PATCH, DELETE, GET');
//         return res.status(200).json({});
//     }
//     next();
// });
