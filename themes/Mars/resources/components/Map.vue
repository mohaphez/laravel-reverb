<template>
  <div>
    <MapWithMarker ref="mapWithMarker" :markers="markers" :initialCenter="initialCenter" @markerMoved="handleMarkerMoved" />
  </div>
</template>

<script>
import MapWithMarker from './MapWithMarker.vue';
import 'leaflet/dist/leaflet.css';


export default {
  name: 'App',
  components: {
    MapWithMarker,
  },
  props: {
    id: {
      type:String,
      default: () => 1,
    },
  },
  data() {
    return {
      markers: [
        { id:'driver',lat: 51.505, lng: -0.09, iconUrl: '/assets/icon/car.png' },
        { id:'passenger',lat: 51.5300935170305, lng: -0.06695330339393735, iconUrl: '/assets/icon/pin.png' },
      ],
      initialCenter: [51.505, -0.09],
    };
  },
  mounted() {
    Echo.private(`travel-live-location.${this.id}`)
        .listenForWhisper('driver-location', (e) => {
          this.$refs.mapWithMarker.updateMarkerPosition(e.newPosition);
        });
  },
  methods: {
    handleMarkerMoved(newPosition) {
      Echo.private(`travel-live-location.${this.id}`)
          .whisper('driver-location', {
            newPosition:newPosition,
          });
    },
  },
};
</script>