import { createApp } from 'vue';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import '@mdi/font/css/materialdesignicons.css'; // Importa MDI

const app = createApp({});

const vuetify = createVuetify({
  components,
  directives,
  icons: {
    iconfont: 'mdi', // Especifica MDI como la fuente de íconos
  },
});

app.use(vuetify);

export default vuetify;