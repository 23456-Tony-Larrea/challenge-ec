<template>
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline">Agregar Nuevo Usuario</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
    <v-text-field
      label="Cédula"
      v-model="user.identity"
      :readonly="readOnly"
      @blur="validateCedula"
      maxlength="10"
    ></v-text-field>
    <span v-if="!isValidCedula && user.identity" style="color: red;">Cédula no válida</span>
  </v-col>

              <v-col cols="12" sm="6">
                <v-text-field label="Nombre" v-model="user.firstName" :readonly="readOnly"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field label="Apellido" v-model="user.lastName" :readonly="readOnly"></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field label="Fecha de Nacimiento" v-model="user.birthDate" type="date" :readonly="readOnly"></v-text-field>
              </v-col>
              <v-col cols="12"  sm="6">
                <v-select :items="civilStatusOptions" label="Estado Civil" v-model="user.civilStatus" :readonly="readOnly"></v-select>
              </v-col>
              
              <v-col cols="12"  sm="6">
                <v-select :items="rolesOptions" label="Rol" v-model="user.roles" :readonly="readOnly"></v-select>
              </v-col>
              <v-col>
  <label for="map" style="display: block; margin-bottom: 10px;">Elige ubicación</label>
  <v-card id="map" class="mx-auto" style="height: 400px; width: 400px;"></v-card>
</v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="close">Cancelar</v-btn>
          <v-btn color="blue darken-1" text @click="saveUser">Guardar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </template>
  
  <script>
  import L from 'leaflet';
  import 'leaflet/dist/leaflet.css'
  export default {
  data() {
    return {
      dialog: false,
      user: {
        firstName: '',
        identity: '',
        lastName: '',
        birthDate: '',
        civilStatus: '',
        role: '',
      },
      civilStatusOptions: ['Casado', 'Soltero', 'Divorciado', 'Viudo'],
      rolesOptions: ['Administrador', 'Usuario', 'Invitado'],
      readOnly: false,
      isValidCedula: true,
    };
  },
  methods: {
    saveUser() {
      // Lógica para guardar el usuario
      console.log(JSON.stringify(this.user, null, 2)); // La ubicación ya está incluida directamente en el objeto del usuario
      this.close();
    },
    close() {
      this.dialog = false;
    },
    open() {
      this.dialog = true;
      this.$nextTick(() => {
        this.initMap();
      });
    },
    initMap() {
      const map = L.map('map').setView([1, 2], 3);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
      }).addTo(map);
      map.on('click', (e) => {
        const { lat, lng } = e.latlng;
        this.user.latitud = lat; // Actualizado para asignar directamente la latitud
        this.user.longitud = lng; // Actualizado para asignar directamente la longitud
        const marker = L.marker([lat, lng]).addTo(map);
        marker.bindPopup("Ubicación seleccionada").openPopup();
        const bounds = [
          [lat - 0.01, lng - 0.01],
          [lat + 0.01, lng + 0.01]
        ];
        map.fitBounds(bounds);
      });
    },
    props: {
    readOnly: {
      type: Boolean,
      default: false,
    },
  },
  validateCedula() {
      const cedula = this.user.identity;
      if (cedula.length === 10) {
        let tercerDigito = parseInt(cedula.substring(2, 3));
        if (tercerDigito < 6) {
          // Los coeficientes para el cálculo
          const coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];
          let verificador = parseInt(cedula.substring(9, 10));
          let suma = 0;

          for (let i = 0; i < 9; i++) {
            let valor = coeficientes[i] * parseInt(cedula.charAt(i));
            suma += valor > 9 ? valor - 9 : valor;
          }

          suma = 10 - (suma % 10);
          if (suma === 10) suma = 0;

          this.isValidCedula = suma === verificador;
        } else {
          this.isValidCedula = false;
        }
      } else {
        this.isValidCedula = false;
      }
    },
  }
  };
  </script>