import { createApp } from 'vue';
import App from './App.vue';
import router from '../src/router/router';
import axios from '../src/pluggins/axios';
import VueAxios from 'vue-axios';
import vuetify from '../src/pluggins/vuetify';
import 'vuetify/styles'
import 'bootstrap/dist/css/bootstrap.min.css';
import ToastPlugin from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';


const app = createApp(App);

app.use(VueAxios, axios);
app.use(router);
app.use(vuetify);
app.use(ToastPlugin);

app.mount('#app');