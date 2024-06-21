<script setup>
import { ref, onMounted } from 'vue';
import { Pie } from 'vue-chartjs';

const props = defineProps({
  chartData: Object,
});

const chartRef = ref(null);

onMounted(() => {
  if (chartRef.value && props.chartData) {
    chartRef.value.renderChart(props.chartData, {
      responsive: true,
      maintainAspectRatio: false,
    });
  }
});
</script>

<template>
  <Pie ref="chartRef" :chart-data="props.chartData" />
</template>