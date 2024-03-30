const redis = require('redis');

const client = redis.createClient({
    url: ' redis://redis:6379',
});

(async () => {
    try {
        await client.connect();
        console.log('Connected to Redis');
    } catch (err) {
        console.error(`Redis client error: ${err}`);
    }
})();

client.on('end', () => {
    console.log('Disconnected from Redis');
});

module.exports = client;