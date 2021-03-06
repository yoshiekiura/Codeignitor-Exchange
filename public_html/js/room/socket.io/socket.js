'use strict';

function ClientSockets(objectOfTables, user) {

    //Fetch the libs
  //  var io = require('./vendor/socket.io.min');

    //Get the name of the room
    var room = user.room;

    var ask = objectOfTables['asks'],
            bids = objectOfTables['bids'],
            trade = objectOfTables['marketHistory'],
            orderOpen = objectOfTables['openOrders'],
            orderHistory = objectOfTables['orderHistory'];

    return {
        start: function () {

            if (!window.WebSocket) {
                alert('Your browser does not support WebSocket.');
            } else {
                // create connection
             //   var socket = io.connect('http://node.guldentrader.com');
                var socket = io.connect('http://localhost:8080', {transports: ['websocket']});

                var ch = require('../sevices/chart');


                var chart = new ch;
                chart.init(user);
                chart.createChart();

                //Connection to the room
                socket.emit('market', {'room': room, 'userId': user.userId, 'user_hash': user.hash});

                socket.on('market', function (msg) {
                    console.log(msg);

                    switch (msg['table']) {
                        case 'table-bids':
                        {
                            bids.updateValue(msg['data']);
                            break;
                        }

                        case 'table-ask':
                        {
                            ask.updateValue(msg['data']);
                            break;
                        }

                        case 'chart':
                        {
                            //console.log(msg['data']);
                            chart.stream(msg['data']);
                            break;
                        }

                        default:
                        {
                            console.log(msg);
                            break;
                        }
                    }
                });

            }
            ;
        }
    };

}
;

module.exports = ClientSockets;

