<template>
  <div class="flex justify-center items-center h-screen">
    <button @click="requestUber" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
      Request Uber
    </button>
  </div>
</template>

<script>
export default {
  methods: {
    async requestUber() {
      try {
        const response = await fetch('/api/v1/travel/store', {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
          }
        });
      } catch (error) {
        console.error('Error:', error);
      }
    },
  }
}
</script>
