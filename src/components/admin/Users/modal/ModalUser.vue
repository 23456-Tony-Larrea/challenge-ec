<template>
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
        <span class="headline">{{ isEditMode ? 'Editar Usuario' : isViewMode ? 'Ver Usuario' : 'Agregar Nuevo Usuario' }}</span>
      </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6">
    <v-text-field
      label="Cédula"
      v-model="user.cedula"
      :readonly="readOnly"
      @blur="validateCedula"
      maxlength="10"
    ></v-text-field>
    <span v-if="!isValidCedula && user.cedula" style="color: red;">Cédula no válida</span>
  </v-col>
  <v-col cols="12" sm="6">
    <v-text-field
  label="Correo electrónico"
  v-model="user.email"
  :rules="emailRules"
  required
></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field label="Nombre" v-model="user.name" :readonly="readOnly"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field label="Apellido" v-model="user.apellidos" :readonly="readOnly"></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field label="Fecha de Nacimiento" v-model="user.fecha_nacimiento" type="date" :readonly="readOnly"></v-text-field>
              </v-col>
              <v-col cols="12"  sm="6">
                <v-select :items="civilStatusOptions" label="Estado Civil" v-model="user.estado_civil" :readonly="readOnly"></v-select>
              </v-col>
              <v-col cols="12"  sm="6">
                <v-select :items="rolesOptions" label="Rol" v-model="user.role_name" :readonly="readOnly"></v-select>
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
  import users from '../../../../actions/users'
  import L from 'leaflet';
  import 'leaflet/dist/leaflet.css'
  export default {
  data() {
    return {
      dialog: false,
      user: {
        name: '',
        cedula: '',
        apellidos: '',
        fecha_nacimiento: '',
        estado_civil: '',
        role_name: '',
      },
      emailRules: [
      v => !!v || 'El correo electrónico es requerido',
      v => /.+@.+\..+/.test(v) || 'El correo electrónico debe ser válido',
    ],
      isEditMode: false,
      civilStatusOptions: ['Casado', 'Soltero', 'Divorciado', 'Viudo'],
      selectedRole: null, // Asegúrate de que esto coincida con el tipo esperado por tu lógica
      rolesOptions: ['administrador', 'operador'],

      readOnly: false,
      isValidCedula: true,
    };
  },
  methods: {
    saveUser() {

  // Asegúrate de que todos los campos necesarios estén correctamente mapeados
  const userData = {
    id: this.user.id, // Asume que 'id' se usa para verificar si es una edición
    name:this.user.name, 
    cedula: this.user.cedula,
    email: this.user.email,
    nombres: this.user.name,
    apellidos: this.user.apellidos,
    fecha_nacimiento: this.user.fecha_nacimiento,
    estado_civil: this.user.estado_civil,
    latitud: this.user.latitud,
    longitud: this.user.longitud,
    role_name: this.user.role_name, // Asegúrate de que 'role.name' sea el campo correcto
  };

  if (this.user.id) {
    // Edición de usuario
    users.edit(userData)
      .then(() => {
        this.$emit('user-updated');
        this.close();
        this.$emit('userAdded');
      })
      .catch((error) => {
        console.error(error);
      });
  } else {
    // Creación de nuevo usuario
    users.createUser(userData)
      .then(() => {
        this.$emit('user-created');
        this.close();
        this.$emit('userAdded');
      })
      .catch((error) => {
        console.error(error);
      });
  }
},close() {
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
      user: {
      type: Object,
      default: () => ({}),
    },
    isViewMode: {
      type: Boolean,
      default: false,
    },
  },
  watch: {
    user: {
      handler(newVal) {
        if (this.isViewMode) {
          this.fillFormWithUserData(newVal);
        }
      },
      deep: true,
      immediate: true,
    },
  },
  validateCedula() {
      const cedula = this.user.cedula;
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