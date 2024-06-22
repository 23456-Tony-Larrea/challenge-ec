<template>
    <div>
        <Sidebar/>
    </div>
    
</template>
<script>
import poblacionService from '../../actions/poblacionChart.js'
import Barchar from '../../components/Poblacion/BarChar.vue' // Corregido la ruta
import Sidebar from '../../components/pages/Sidebar.vue'
export default {
    components: {
      Barchar,
      Sidebar
    },
data() {
    return {
      chartData: null,
    };
  },
  methods: {
    loadPoblacionData() {
      poblacionService.showPoblacion()
        .then(data => {
            console.log(data)
        })
        .catch(error => {
          console.error('Error al cargar los datos de población:', error);
        });
    },
  },
  mounted() {
    this.loadPoblacionData();
  },
}
</script>