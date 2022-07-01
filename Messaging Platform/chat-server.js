// Require the packages we will use:
const http = require("http"),
    fs = require("fs");

const port = 3456;
const file = "chat-server.html";
// Listen for HTTP connections.  This is essentially a miniature static file server that only serves our one file, client.html, on port 3456:
const server = http.createServer(function (req, res) {
    // This callback runs when a new connection is made to our HTTP server.

    fs.readFile(file, function (err, data) {
        // This callback runs when the client.html file has been read from the filesystem.

        if (err) return res.writeHead(500);
        res.writeHead(200);
        res.end(data);
    });
});
server.listen(port);

// Import Socket.IO and pass our HTTP server object to it.
const socketio = require("socket.io")(http, {
    wsEngine: 'ws'
});

// Attach our Socket.IO server to our HTTP server to listen
const io = socketio.listen(server);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//make sure home room is in array of rooms
let room = {name: "home room", number: 0};
let rooms = [];
rooms.push(room);
let count = 1;

let masterList = [];
console.table(masterList);
masterList.push([]); //adds home room to master list
console.table(masterList);
let curname;
let curRoom;
let users = [];

//basically when a user is added or changes rooms, push user to masterlist[data["room"]]

/* put my users into an array that has the index index as the room and an array of the users
at that room at each of those indices */


//userroom 
io.sockets.on("connection", function (socket) {
    
    /***********PRINT ACTIVES WHEN THEY ARRIVE**********/
    io.sockets.emit("printactives", {activeusers: masterList});
    // This callback runs when a new Socket.IO connection is established.
    console.log("a user connected + up to date 0");

    /************ Recieve room name from client, add to room array and send to everyone ************/
    socket.on('room_to_server', function (data) {
        let roomname = data["room"];
        let password = data["pass"];
        if (roomname != ""){
        let roomnumber = count;
        room = {name: roomname, number: roomnumber, pass: password};
        rooms.push(room);
        masterList.push([]); 
        console.table(masterList);
        console.log(rooms);
        io.sockets.emit("create_room", {roomlist: rooms});
        count++;
        } else {
            io.sockets.emit("create_room", {roomlist: rooms});
        }
    });
    //make it so everyone starts at main room, then on a room change event remove the user from masterList[oldroom]
    // and push them to masterList[newroom]

    socket.on("setUsername", function(data){
        console.log("setting username: " + data["username"]);
        if (users.indexOf(data["username"]) > -1){
            socket.emit('userExists', data["username"] + ' username is taken. Try again.');
        } else {
            users.push(data["username"]);
            curname = data["username"];
            curRoom = data["room"]; //here, it should always be zero, gotta change it on change room
            masterList[curRoom].push(data["username"]); // push the username into the room we're at
            console.table(masterList);
            socket.emit('userSet', {username: data["username"]});
            io.sockets.emit("printactives", {activeusers: masterList});
            socket.emit("create_room", {roomlist: rooms});
        }
    });

    socket.on("removeuser", function(data){
        console.log("removing " + data["name"] + " from " + data["roomnumber"]);
        io.sockets.emit("removeuser", {name: data["name"], room: data["roomnumber"]}); //check everyone, if name = name, and room = room, then clear everything
    });

    socket.on("banuser", function(data){
        console.log("removing " + data["name"] + " from " + data["roomnumber"]);
        io.sockets.emit("banuser", {name: data["name"], room: data["roomnumber"]}); //check everyone, if name = name, and room = room, then clear everything
    });


    socket.on("changeroom", function(data){
        console.log(data["name"] + " is changing from " + data["previous"] + " to " + data["newroom"]);
        let prevroom = data["previous"];
        masterList[prevroom].splice(masterList[prevroom].indexOf(data["name"]), 1);
        masterList[data["newroom"]].push(data["name"]);
        console.table(masterList);
        io.sockets.emit("printactives", {activeusers: masterList});
    });

    socket.on('message_to_server', function (data) {
        // This callback runs when the server receives a new message from the client.
        console.log("message: " + data["message"]); // log it to the Node.JS output
        let user = data["username"];
        io.sockets.emit("message_to_client", { message: data["message"], room: data["room"], username: user }) // broadcast the message and room # to other users
    });
    socket.on('dm_user', function (data) {      
        let user = data["from"];
        let usertoDm = data["to"];
        let dmRoom = data["room"];
        console.log("message from " + user + " to " + usertoDm + "at room " + dmRoom + " message: " + data["message"]); // log it to the Node.JS output
        io.sockets.emit("message_to_DM", {message: data["message"], room: dmRoom, from: user , to: usertoDm}) // broadcast the message and room # to other users
    });
    
    socket.on('siteToEarthTheme', function(data){
        console.log("changing to earth theme from " + data["username"]);
        io.sockets.emit("toEarthTheme", {user: data["username"]});
    });

    socket.on('siteToOceanTheme', function(data){
        io.sockets.emit("toOceanTheme", {user: data["username"]});
    })

    socket.on('siteToFireTheme', function(data){
        io.sockets.emit("toFireTheme", {user: data["username"]});
    })

    socket.on('siteToSpaceTheme', function(data){
        io.sockets.emit("toSpaceTheme", {user: data["username"]});
    })

    socket.on('siteToUSATheme', function(data){
        io.sockets.emit("toUSATheme", {user: data["username"]});
    })

    socket.on('siteToStandardTheme', function(data){
        io.sockets.emit("toStandardTheme", {user: data["username"]});
    })

    socket.on("disconnect", function (){ //this is going to be super similair for room change
        console.table(masterList);
        console.log(curname + " disconnected");
        users.splice(users.indexOf(curname), 1);
        for(let i = 0; i < masterList.length; i++ ){
            if (masterList[i]){
                masterList[i].splice(masterList[i].indexOf(curname), 1); 
                }
        }
        
        console.table(masterList);
        io.sockets.emit("printactives", {activeusers: masterList});
       // socket.emit('loggingout');
    });
    
});

    /**
     * need to add to creative (make a site wide admin)
     * need to fix ban user (chase down from the go home function)
     * ^^^ same as remove user
     * on disconnect, maybe remove a user from every room?
     */

    /*BUGS TO FIX: 
        1. user is only "properly" disconnected (i.e., removed from master list) when 
        they disconnect in the home room. That's because curRoom will always be zero...
        maybe ask a TA about how i can handle that... cuz it's not like i can trigger an event
        on the client side when they disconnect
        2. there are some issues with going to multiple chat rooms cuz the divs stay shown...
        have to hide all the other chat divs when we switch rooms
        */

//everyone recieves from io.sockets.emit
//only CURRENT recieves from socket.emit


