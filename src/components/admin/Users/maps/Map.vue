<template>
    <div id="map" style="height: 400px;"></div>
  </template>
  
  <script>
  import L from 'leaflet';
  import 'leaflet/dist/leaflet.css';
  
  export default {
    name: 'Maps',
    mounted() {
      this.initMap();
    },
    methods: {
      initMap() {
        const map = L.map('map').setView([1, 2], 3); // Ajusta el zoom inicial según necesidad.
  
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
  
        // Evento de clic en el mapa para obtener latitud y longitud
        map.on('click', (e) => {
          const { lat, lng } = e.latlng;
          console.log(`Latitud: ${lat}, Longitud: ${lng}`);
  
          // Agrega un marcador en la ubicación clickeada
          const marker = L.marker([lat, lng]).addTo(map);
  
          // Opcional: Agrega un popup al marcador
          marker.bindPopup("Ubicación seleccionada").openPopup();
  
          // Define el cuadro delimitador al que quieres acercar el mapa
          // Ejemplo: [[latitud1, longitud1], [latitud2, longitud2]]
          const bounds = [
            [lat - 0.01, lng - 0.01], // Esquina superior izquierda
            [lat + 0.01, lng + 0.01]  // Esquina inferior derecha
          ];
  
          // Acercar el mapa al cuadro delimitador
          map.fitBounds(bounds);
        });
      },
    },
  };
</script>
  
  <style>
  /* Importante para asegurarse de que el mapa se muestre correctamente */
  .leaflet-container {
    height: 400px;
    width: 100%;
  }
  </style>