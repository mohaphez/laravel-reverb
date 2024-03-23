<template>
  <div>
    <div ref="map" :style="mapStyle"></div>
  </div>
</template>

<script>
import L from 'leaflet';

export default {
  name: 'MapWithMarker',
  props: {
    markers: {
      type: Array,
      default: () => [],
    },
    initialCenter: {
      type: Array,
      default: () => [0, 0],
    },
  },
  data() {
    return {
      map: null,
      leafletMarkers: [],
      mapStyle: {
        height: '90vh',
      },
    };
  },
  mounted() {
    this.initMap();
  },
  watch: {
    markers: {
      deep: true,
      handler(newMarkers) {
        this.updateMarkers(newMarkers);
      },
    },
  },
  methods: {
    initMap() {
      this.map = L.map(this.$refs.map).setView(this.initialCenter, 13);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      }).addTo(this.map);

      this.updateMarkers(this.markers);
    },
    updateMarkers(newMarkers) {
      // Remove existing markers
      this.leafletMarkers.forEach(marker => marker.remove());
      this.leafletMarkers = [];

      newMarkers.forEach(markerData => {
        const { id, lat, lng, iconUrl } = markerData;
        const icon = L.icon({
          iconUrl: iconUrl,
          iconSize: [52, 52],
          iconAnchor: [16, 32],
        });
        const leafletMarker = L.marker([lat, lng], { icon: icon, draggable: true }).addTo(this.map);
        leafletMarker.id = id;
        leafletMarker.on('dragend', this.onMarkerDragEnd);
        this.leafletMarkers.push(leafletMarker);
      });
    },
    onMarkerDragEnd(event) {
      const marker = event.target;
      const newPosition = marker.getLatLng();
      const markerId = marker.id;
      this.$emit('markerMoved', { id: markerId, lat: newPosition.lat, lng: newPosition.lng });
    },
    updateMarkerPosition(newPosition){
      const markerToUpdate = this.leafletMarkers.find(marker => marker.id === newPosition.id);
      if (markerToUpdate) {
        let newLatLng = new L.LatLng(newPosition.lat, newPosition.lng);
        markerToUpdate.setLatLng(newLatLng);
      }
    }
  },
};
</script>
