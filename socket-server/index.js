const WebSocket = require('ws');
const axios = require('axios');

const url = 'wss://stream.binance.com:9443/ws/btcusdt@bookTicker';

let bid = null;
let ask = null;

const ws = new WebSocket(url);

ws.on('open', () => {
    console.log('Connected to WebSocket server!');
});

ws.on('message', (data) => {
    try {
        const parsedData = JSON.parse(data);
        const newBid = parsedData.b;
        const newAsk = parsedData.a;

        let needRefresh = false;

        if (bid !== newBid) {
            bid = newBid;
            needRefresh = true;
        }

        if (ask !== newAsk) {
            ask = newAsk;
            needRefresh = true;
        }

        if (needRefresh) {
            axios.post('http://127.0.0.1:8000/trader/update-rate', { bid, ask })
                .then(() => {
                    console.log('Data sent successfully:', { bid, ask });
                })
                .catch((error) => {
                    console.error('Error sending data:', error.message);
                });
        }
    } catch (error) {
        console.error('Error processing message:', error.message);
    }
});

ws.on('close', () => {
    console.log('Connection closed.');
});

ws.on('error', (error) => {
    console.error('WebSocket error:', error.message);
});