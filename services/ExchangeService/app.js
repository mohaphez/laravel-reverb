const Binance = require('./exchanges/binance');
const Kucoin = require('./exchanges/kucoin');
const redisClient = require('./utils/redisClient');


const binance = new Binance();
const kucoin = new Kucoin();

// listen for data
binance.on('data', (data) => {
    console.log(`Received data from Binance: ${JSON.stringify(data)}`);
});

kucoin.on('data', (data) => {
    console.log(`Received data from Kucoin: ${JSON.stringify(data)}`);
});


// handle process exit
process.on('SIGINT', () => {
    console.log('Closing WebSocket connections...');
    redisClient.quit();
    binance.ws.close();
    kucoin.ws.close();
    process.exit();
});