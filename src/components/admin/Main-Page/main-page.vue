<template>
    <div class="dashboard">
      <div>
        <Sidebar/>
      </div>
      <main>
        <v-container>
          <v-row>
            <v-col cols="12">
              <h1 class="welcome-message">Bienvenido a App-control, te saludamos, <span class="highlighted-username"> 
              {{username}}
              </span></h1>
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
    data() {
    return{
      username:localStorage.getItem('user')
    }
    }
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