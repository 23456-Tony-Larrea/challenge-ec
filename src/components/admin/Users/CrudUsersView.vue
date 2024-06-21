<template>
    <v-container>
        <Sidebar/>
      <v-card>
        <v-card-title>
          <v-icon left>mdi-account-group</v-icon>
          Control de Usuarios
          <v-spacer></v-spacer>
          <v-container>
            <v-layout>
              <v-flex>
                <v-btn color="primary" @click="openAddUserModal">Agregar Nuevo Usuario</v-btn>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card-title>
        <v-data-table :headers="headers" :items="users" class="elevation-1" item-key="id">
          <template v-slot:item.actions="{ item }">
            <v-btn fab small color="blue" @click="editUser(item)">
              <v-icon>mdi-pencil</v-icon>
            </v-btn>
            <v-btn fab small color="black" @click="viewUser(item)">
              <v-icon>mdi-eye</v-icon>
            </v-btn>
            <v-btn fab small color="red" @click="deleteUser(item)">
              <v-icon>mdi-delete</v-icon>
            </v-btn>
          </template>
        </v-data-table>
      </v-card>
      <!-- Asegúrate de agregar el atributo ref aquí -->
      <AddUserModal ref="addUserModal" />
    </v-container>
  </template>
  
  <script>
    import Sidebar from '../../pages/Sidebar.vue'
  import AddUserModal from './modal/ModalUser.vue';
  
  export default {
    components: {
      AddUserModal,
      Sidebar,
    },
    methods: {
      openAddUserModal() {
        this.$refs.addUserModal.open();
      },
      editUser(user) {
        // Lógica para editar usuario
        console.log('Editando usuario', user);
      },
      deleteUser(user) {
        // Lógica para eliminar usuario
        console.log('Eliminando usuario', user);
      },
      viewUser(user) {
  this.$refs.addUserModal.open();
  this.$refs.addUserModal.readOnly = true;
 }
    },
    data() {
      return {
        headers: [
          { text: 'Cédula', value: 'id' },
          { text: 'Nombres', value: 'firstName' },
          { text: 'Apellidos', value: 'lastName' },
          { text: 'Fecha de Nacimiento', value: 'birthDate' },
          { text: 'Estado Civil', value: 'civilStatus' },
          { text: 'Acciones', value: 'actions', sortable: false },
        ],
        users: [
          { id: '1234567890', firstName: 'Juan', lastName: 'Pérez', birthDate: '1980-01-01', civilStatus: 'Casado' },
          { id: '0987654321', firstName: 'Ana', lastName: 'Martínez', birthDate: '1990-02-02', civilStatus: 'Soltero' },
        ],
      };
    },
  };
  </script>