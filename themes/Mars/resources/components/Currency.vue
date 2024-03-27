<template>
  <div>
    <div class="crypto-cards">
      <div v-for="(currency, index) in cryptocurrencies" :key="index" class="crypto-card" :style="{ background: getGradientBackground(index) }">
        <div class="crypto-card-content">
          <h3>{{ currency.currency }}</h3>
          <p>Amount: {{ currency.amount }}</p>
          <p>Change: {{ currency.change }}%</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      cryptocurrencies: []
    };
  },
  mounted() {
    // Fetch initial cryptocurrency data
    this.fetchCryptocurrencyData();

    // Listen for real-time updates using Laravel Echo
    window.Echo.channel('cryptocurrency-updates')
      .listen('.Modules\\Currency\\Events\\Api\\V1\\CurrencyMarketUpdateEvent', (event) => {
        this.cryptocurrencies = event.cryptocurrencies;
      });
  },
  methods: {
    fetchCryptocurrencyData() {
      // Make an HTTP GET request to your API route
      fetch('/api/v1/webhook/handle')
        .then(response => response.json())
        .then(data => {
          // Assign the retrieved data to the cryptocurrencies array
          this.cryptocurrencies = data;
        })
        .catch(error => {
          console.error('Error fetching cryptocurrency data:', error);
        });
    },
    getGradientBackground(index) {
      // Generate gradient background based on index
      return `linear-gradient(135deg, #${Math.floor(Math.random()*16777215).toString(16)} 0%, #${Math.floor(Math.random()*16777215).toString(16)} 100%)`;
    }
  }
};
</script>

<style>
.crypto-cards {
  display: flex;
  flex-wrap: wrap;
}

.crypto-card {
  width: calc(33.33% - 20px); /* Adjust based on your design */
  margin: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.crypto-card:hover {
  transform: translateY(-5px);
}

.crypto-card-content {
  padding: 20px;
}

.crypto-card h3 {
  margin-top: 0;
}

.crypto-card p {
  margin: 5px 0;
}
</style>
