const WebSocket = require('ws');
const EventEmitter = require('eventemitter3');
const redisClient = require('../utils/redisClient');

class Binance extends EventEmitter {
    constructor() {
        super();
        this.ws = new WebSocket('wss://stream.binance.com:9443/ws');
        this.ws.on('open', this.onOpen.bind(this));
        this.ws.on('message', this.onMessage.bind(this));
        this.ws.on('error', this.onError.bind(this));
        this.ws.on('close', this.onClose.bind(this));
    }

    onOpen() {
        console.log('Connected to Binance');
        this.ws.send(JSON.stringify({ method: 'SUBSCRIBE', params: [
                'btcusdt@kline_1h',
                'ethusdt@kline_1h',
                'xrpusdt@kline_1h',
                'dogeusdt@kline_1h',
            ], id: 1 }));
    }

    onMessage(data) {
        const parsed = JSON.parse(data);
        this.emit('data', parsed);
        redisClient.publish('exchange-binance', JSON.stringify(parsed));
    }

    onError(error) {
        console.error(`Binance WebSocket error: ${error}`);
    }

    onClose() {
        console.log('Disconnected from Binance');
    }
}

module.exports = Binance;