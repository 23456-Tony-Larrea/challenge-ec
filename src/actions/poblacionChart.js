import http from '../pluggins/axios';
export default {
    showPoblacion() {
      return http.get('/poblacion/chart-data').then((data) => {
        return data.data;
      });
    },
    }