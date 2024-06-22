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
      <AddUserModal ref="addUserModal" @userAdded="fetchUsers" />
    </v-container>
  </template>
  
  <script>
    import Sidebar from '../../pages/Sidebar.vue'
  import AddUserModal from './modal/ModalUser.vue';
  import users from '../../../actions/users'
  
  export default {
    components: {
      AddUserModal,
      Sidebar,
    },
    methods: {
      openAddUserModal() {
        this.$refs.addUserModal.open();
      },
      editUser(user) 
      {
        this.$refs.addUserModal.open();
        this.$refs.addUserModal.readOnly = false;
        this.$refs.addUserModal.isEditMode = true;
        this.$refs.addUserModal.isViewMode = false;
        this.$refs.addUserModal.user = user;
        },
      async deleteUser (user) {
        // Lógica para eliminar usuario
        const deleteUserModal = await users.deleteUser(user.id);
        if (deleteUserModal) {
          this.$refs.addUserModal.close();
          this.fetchUsers();
        }
        this.$refs.addUserModal.close();
      },
      viewUser(user) {
    this.$refs.addUserModal.open();
    this.$refs.addUserModal.readOnly = true;
    this.$refs.addUserModal.isViewMode = true;
    this.$refs.addUserModal.user = user;
  },
 async fetchUsers() {
  const response = await users.show();
  this.users = response;
},
    },
    mounted() {
      this.fetchUsers();
    },
    data() {
      return {
        headers: [
          { text: 'Cédula', value: 'cedula' },
          { text: 'Nombres', value: 'nombres' },
          { text: 'Apellidos', value: 'apellidos' },
          { text: 'Fecha de Nacimiento', value: 'fecha_nacimiento' },
          { text: 'Estado Civil', value: 'estado_civil' },
          { text: 'email', value: 'email' },
          { text: 'Teléfono', value: 'telefono' },
          { text: 'Dirección', value: 'direccion' },
          { text: 'Rol', value: 'role.name' },
          { text: 'latitud', value: 'latitud' },
          { text: 'longitud', value: 'longitud' },
          { text: 'Acciones', value: 'actions', sortable: false },
        ],
        users: [],
      };
    },

  };
  </script>