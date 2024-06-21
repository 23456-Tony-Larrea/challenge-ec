<template>
    <div class="dashboard">
      <div>
        <Sidebar/>
      </div>
      <main>
        <v-container>
          <v-row>
            <v-col cols="12">
              <h1 class="welcome-message">Bienvenido a Medi-web, te saludamos, <span class="highlighted-username">hola</span></h1>
              <p class="tagline">Descubre en la web tu camino hacia una vida plena y saludable.</p>
            </v-col>
          </v-row>
        </v-container>
      </main>
    </div>
  </template>
  
  <script>
  import Sidebar from '../../pages/Sidebar.vue'
  
  export default {
    name: 'MainPage',
    components: {
     Sidebar
    },
  };
  </script>
  
  <style scoped>
.dashboard {
  display: flex;
}

  main {
    flex-grow: 1;
    padding: 24px;
  }
  .welcome-message {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 16px;
  }
  
  .tagline {
    font-size: 18px;
    color: #666666;
  }
  </style>