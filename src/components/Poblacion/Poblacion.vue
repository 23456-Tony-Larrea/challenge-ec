<template>
  <div>
    <Sidebar/>
    <v-card> <!-- Añade un v-card para contener el título y el gráfico -->
      <v-card-title class="headline">Población</v-card-title> <!-- Título del card -->
      <BarChart v-if="chartData" :data="chartData"/>
    </v-card>
  </div>
</template>

<script>
import poblacionService from '../../actions/poblacionChart.js'
import BarChart from '../../components/Poblacion/BarChar.vue' // Asegúrate de que el nombre del archivo es correcto, podría ser BarChart.vue
import Sidebar from '../../components/pages/Sidebar.vue'

export default {
  components: {
    BarChart,
    Sidebar
  },
  data() {
    return {
      chartData: null, // Inicializa chartData como null
    };
  },
  methods: {
    loadPoblacionData() {
      poblacionService.showPoblacion()
        .then(response => {
          // Asegúrate de que la respuesta tenga el formato esperado por processData
          const transformedData = response.allData.map(item => ({
            Provincia: item.Municipio, // Asumiendo que Municipio es lo que quieres mostrar como Provincia
            CodProvincia: item.CodProvincia, // Asegúrate de que este campo exista o ajusta según tus datos
            Poblacion: item.Poblacion
          }));
          
          this.chartData = transformedData;
          console.log('Datos transformados para el gráfico:', this.chartData);
        }).catch(error => {
          console.error('Error al cargar y transformar los datos de población:', error);
        });
    }
  },
  mounted() {
    this.loadPoblacionData();
  },
}
</script>