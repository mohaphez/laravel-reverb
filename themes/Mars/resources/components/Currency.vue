<template>
  <div>
    <div class="crypto-cards flex flex-wrap">
      <div v-for="(currency, index) in cryptocurrencies" :key="index" class="crypto-card w-full md:w-1/3 lg:w-1/4 xl:w-1/5 mb-6 px-4">
        <div class="bg-white ring ring-neutral-200 rounded-md p-4 transition-transform duration-300 transform hover:-translate-y-2">
          <div class="flex justify-between items-center">
            <h3 class="text-2xl font-semibold">{{ currency.currency }}</h3>
            <p class="text-gray-600">{{ currency.amount }}</p>
          </div>
          <p :class="{ 'text-green-500': currency.change > 0, 'text-red-500': currency.change < 0 }" class="text-xl font-semibold text-right mt-auto">
            <span v-if="currency.change > 0">&#9650;</span>
            <span v-else-if="currency.change < 0">&#9660;</span>
            {{ currency.change }}%
          </p>
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
    }
  }
};
</script>

<style>
body {
  background-color: #f3f4f6; /* Equivalent to bg-neutral-100 in Tailwind */
}
</style>
