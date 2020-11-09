var express = require('express');

var cors = require('cors');

var app = express();

app.use(cors());

var server = require('http').createServer(app);

var io = require('socket.io')(server);

var port = '3000';

app.use(express.static(__dirname + '/node_modules'));

app.get('/', (req, res) => {
    res.send('<h1>Hello From Server Side</h1>');
});

io.on('connection', (socket)=>{
    socket.on("user_connected", (user_id)=>{
        console.log("user connected" , user_id);
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
