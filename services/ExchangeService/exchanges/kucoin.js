const axios = require('axios');
const WebSocket = require('ws');
const EventEmitter = require('eventemitter3');
const redisClient = require('../utils/redisClient');

class Kucoin extends EventEmitter {
    constructor() {
        super();
        this.getServerListAndToken();
    }

    async getServerListAndToken() {
        try {
            const response = await axios.post('https://api.kucoin.com/api/v1/bullet-public');
            const { token, instanceServers } = response.data.data;
            this.token = token;
            this.instanceServers = instanceServers;
            this.createWebSocketConnection();
        } catch (error) {
            console.error(`Error getting Kucoin server list and token: ${error}`);
        }
    }

    createWebSocketConnection() {
        const { endpoint } = this.instanceServers[0];
        const url = `${endpoint}?token=${this.token}`;
        this.ws = new WebSocket(url);
        this.ws.on('open', this.onOpen.bind(this));
        this.ws.on('message', this.onMessage.bind(this));
        this.ws.on('error', this.onError.bind(this));
        this.ws.on('close', this.onClose.bind(this));

        const pingInterval = 30000; // 30 seconds
        setInterval(() => {
            if (this.ws.readyState === WebSocket.OPEN) {
                this.ws.send(JSON.stringify({
                    id: new Date().getTime(),
                    type: 'ping'
                }));
            }
        }, pingInterval);
    }

    onOpen() {
        console.log('Connected to Kucoin');
    }

    onMessage(data) {
        const parsed = JSON.parse(data);
        if (parsed.type === 'welcome') {
            this.subscribeToTopic();
        } else {
            this.emit('data', parsed);
            redisClient.publish('exchange-kucoin', JSON.stringify(parsed));
        }
    }

    subscribeToTopic() {
        const { topic, type } = this.getSubscriptionPayload();
        this.ws.send(JSON.stringify({ topic, type, privateChannel: false, response: true }));
    }

    getSubscriptionPayload() {
        return {
            topic: '/market/snapshot:BTC-USDT,ETH-USDT,XRP-USDT,XLM-USDT,LTC-USDT,DOT-USDT,ADA-USDT,LINK-USDT,BNB-USDT,DOGE-USDT',
            type: 'subscribe',
        };
    }

    onError(error) {
        console.error(`Kucoin WebSocket error: ${error}`);
    }

    onClose() {
        console.log('Disconnected from Kucoin');
    }
}

module.exports = Kucoin;
