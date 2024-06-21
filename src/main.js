import { createApp } from 'vue';
import App from './App.vue';
import router from '../src/router/router';
import axios from '../src/pluggins/axios';
import VueAxios from 'vue-axios';
import vuetify from '../src/pluggins/vuetify';
import 'vuetify/styles'
import 'bootstrap/dist/css/bootstrap.min.css';

const app = createApp(App);

app.use(VueAxios, axios);
app.use(router);
app.use(vuetify);

app.mount('#app');