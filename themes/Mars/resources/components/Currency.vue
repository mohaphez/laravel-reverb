<template>
  <div v-for="(exchange, index) in exchanges" :key="index">
  <div class="mb-8">
    <h1 class="text-3xl font-bold">{{ index }}</h1>
    <hr class="my-2 border-neutral-300">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2">
      <template v-for="(currency, index) in exchange" :key="index">
          <div class="bg-white rounded-md shadow-md p-5 transition-transform duration-300 transform hover:-translate-y-2">

            <h3 class="text-2xl font-semibold">{{ currency.currency }}</h3>

            <div class="flex justify-between items-center mt-2">
              <p  class="text-xl font-semibold text-right">
                {{ currency.amount }}
              </p>
              <p :class="{ 'text-green-500': currency.change > 0, 'text-red-500': currency.change < 0 }" class="text-sm text-gray-600">
                <span v-if="currency.change > 0">&#9650;</span>
                <span v-else-if="currency.change < 0">&#9660;</span>
                {{ currency.change }}%
              </p>
            </div>

          </div>
      </template>
    </div>
     </div>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      exchanges: []
    };
  },
  mounted() {
    window.Echo.channel('cryptocurrency-updates')
      .listen('.Modules\\Currency\\Events\\V1\\CurrencyMarketUpdateEvent', (event) => {
        this.exchanges = event.cryptocurrencies;
      });
  }
};
</script>

<style>
body {
  background-color: #f3f4f6;
}
</style>
