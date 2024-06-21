<template>
    <v-container>
      <v-row align="center" justify="center">
        <v-col cols="12" sm="10">
          <v-card class="elevation-6 mt-10">
            <v-window v-model="step">
              <v-window-item :value="1">
                <v-row>
                  <v-col cols="12" md="6">
                    <v-card-text class="mt-12">
                      <h4 class="text-center">Inicie sesión en su cuenta</h4>
                      <h6 class="text-center grey--text">Inicia sesión en tu cuenta por favor</h6>
                      <v-row align="center" justify="center">
                        <v-col cols="12" sm="8">
                          <v-text-field
                            label="Correo electronico"
                            name="Correo Elecronico"
                            v-model="email"
                            :rules="emailRules"
                            outlined
                            dense
                            color="blue"
                            autocomplete="false"
                            class="mt-16"
                            @input="toUpperCase('email')"
                          ></v-text-field>
                          <v-text-field
                            label="Contraseña"
                            name="password"
                            v-model="password"
                            :rules="passwordRules"
                            outlined
                            dense
                            color="blue"
                            autocomplete="false"
                            type="password"
                            @input="toUpperCase('password')"
  
                          ></v-text-field>
                         
      <div>
        <v-btn color="blue" dark block tile @click="login()">
          Ingresar
        </v-btn>
      </div>
                        </v-col>
                      </v-row>
                    </v-card-text>
                  </v-col>
                  <v-col cols="12" md="6" class="blue bg-blue">
                    <div style="text-align: center; padding: 180px 0;">
                      <v-card-text class="white--text">
                        <h3 class="text-center">App-control</h3>
                        <v-img :src="image" class="my-6" contain width="455"></v-img>
                        <h6 class="text-center">¡Bienvenido!👋</h6>
                      </v-card-text>
                    </div>
                  </v-col>
                </v-row>
              </v-window-item>
            </v-window>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </template>
  <script>
  import { login } from '../actions/login';
export default {
    name: 'HomeView',
  components: {

},
data: () => ({
    step: 1,
    email: '',
    password: '',
    error:false,
    errorMessage:'',
    emailRules: [
    v => !!v || 'El email es requerido',
    v => (v && v.length >= 3) || 'El email debe tener al menos 3 caracteres'
  ],
  passwordRules: [
    v => !!v || 'La contraseña es requerida',
    v => (v && v.length >= 3) || 'La contraseña debe tener al menos 3 caracteres'
  ]
}),
methods:{
    async login() {
      try {
        await login(this.email, this.password);
      } catch (error) {
        console.log(error);
        this.error = true;
      } 
  }
},
}
</script>

<style scoped>
.v-application .rounded-bl-xl {
    border-bottom-left-radius: 300px !important;
}
.v-application .rounded-br-xl {
    border-bottom-right-radius: 300px !important;
}
.bg-blue {
  background-color: #1e88e5;
}
.fill-height {
  height: 100vh;
}

</style>