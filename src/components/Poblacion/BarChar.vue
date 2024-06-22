<template>
  <Bar
    id="my-chart-id"
    :options="chartOptions"
    :data="chartData"
  />
</template>

<script>
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
  name: 'BarChart',
  components: { Bar },
  props: ['data'], // Asume que los datos se pasan como prop al componente
  data() {
    return {
      chartData: {
        labels: [],
        datasets: [
          {
            data: [],
            backgroundColor: [], // Opcional: para colores de fondo de las barras
          }
        ]
      },
      chartOptions: {
        responsive: true,
        plugins: {
          legend: {
            display: false // Oculta la leyenda si no la necesitas
          }
        }
      }
    }
  },
  mounted() {
    this.processData(this.data);
  },
  methods: {
    processData(data) {
      const labels = data.map(item => `${item.Provincia} (${item.CodProvincia})`);
      const datasetData = data.map(item => item.Poblacion);
      // Opcional: Generar colores aleatorios para cada barra
      const backgroundColors = data.map(() => `#${Math.floor(Math.random()*16777215).toString(16)}`);

      this.chartData.labels = labels;
      this.chartData.datasets[0].data = datasetData;
      this.chartData.datasets[0].backgroundColor = backgroundColors;
    }
  }
}
</script>