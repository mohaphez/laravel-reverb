<template>
  <div class="flex justify-center items-center h-screen" v-if="show">
    <div class="bg-white shadow-md rounded-lg p-8 max-w-xl">
      <h2 class="text-xl font-semibold mb-4">Request Details</h2>
      <div class="flex flex-col space-y-4">
        <div>
          <label class="text-gray-700 font-semibold">Customer Name:</label>
          <span class="text-gray-800">{{ details.customerName }}</span>
        </div>
        <div>
          <label class="text-gray-700 font-semibold">Tracking Code:</label>
          <span class="text-gray-800">{{ details.trackingCode }}</span>
        </div>
        <div>
          <label class="text-gray-700 font-semibold">Date:</label>
          <span class="text-gray-800">{{ details.date }}</span>
        </div>
        <div>
          <label class="text-gray-700 font-semibold">Total Amount:</label>
          <span class="text-gray-800">{{ details.amount }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    userId: {
      type: Number,
      default: () => 1,
    }
  },
  data() {
    return {
      details: {
        type: Object,
        default: {
          customerName: "John Doe",
          trackingCode: "1111-111111",
          date: "2024-03-24",
          amount: "$100.00"
        },
      },
      show:false,
    }
  },
  mounted() {
    Echo.private('users.' + this.userId)
        .notification((notification) => {
          console.log(notification.type);
          this.details.customerName = notification.user
          this.details.date =  notification.date
          this.details.trackingCode = notification.tracking_code
          this.details.amount = notification.amount
          this.show = true
          this.showNotification(notification);
        });
  },
  methods: {
    showNotification(data) {
      if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
      } else if (Notification.permission === "granted") {
        let notification = new Notification(`You have new service for ${data.user} ${data.tracking_code}`);
      } else if (Notification.permission !== 'denied') {
        Notification.requestPermission().then(function (permission) {
          if (permission === "granted") {
           new Notification(`You have new service for ${data.user} ${data.tracking_code}`);
          }
        });
      }
    }
  }
}
</script>
