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
  props: ['data'],
  data() {
    return {
      chartData: {
        labels: [],
        datasets: [
          {
            data: [],
            backgroundColor: [],
          }
        ]
      },
      chartOptions: {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: 'Población por Provincia' // Título del gráfico
          },
          legend: {
            display: false
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
    const backgroundColors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];
    const colors = data.map((_, index) => backgroundColors[index % backgroundColors.length]);

    // Actualiza chartData de manera reactiva
    this.chartData = {
      labels: labels,
      datasets: [
        {
          data: datasetData,
          backgroundColor: colors,
        }
      ]
    };
  }
}
}
</script>