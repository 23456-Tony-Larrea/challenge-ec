<template>
    <v-container>
      <Navbar />
      <v-row>
        <v-col cols="4">
          <h2 class="border-bottom border-3 pb-3">Roles</h2>
          <v-btn color="primary" class="mb-2" @click="newRole()">
      <v-icon left>mdi-plus</v-icon>Agregar rol
    </v-btn>
    <v-list dense >
      <v-list-item
        v-for="role in listRoles"
        :key="role.id"
        class="justify-content-space-between align-items-center mb-2"
        @click="getRolePermissions(role.id)"
      >
      <v-list-item-content>{{ role.name }}</v-list-item-content>
      <v-list-item-action>
        <v-tooltip top>
          <template v-slot:activator="{ on }">
            <v-btn color="gray" icon v-on="on" @click="formEdit(role.id,role.name)">
              <v-icon>mdi-pencil</v-icon>
            </v-btn>
          </template>
          <span>Editar rol</span>
        </v-tooltip>
      </v-list-item-action>
    </v-list-item>
  </v-list>
        </v-col>
        <v-col cols="8"> 
          <h2 class="border-bottom border-3 pb-3">Permisos de {{ selectedRoleName }} </h2> 
          <v-list dense > 
              <v-list-item v-for="permission in rolePermissions" :key="permission.id"> 
    <v-list-item-content>{{ permission.name }}</v-list-item-content> 
    <v-list-item-action> 
      <v-switch v-model="permission.newState" color="primary" @change="updatePermissionState(permission.id, permission.newState)"/>
    </v-list-item-action> 
  </v-list-item> 
          </v-list> 
        </v-col>
            
        <v-dialog v-model="dialog" max-width="500">
  <v-card>
    <v-card-title class="teal darken-2 white--text">Roles</v-card-title>
    <v-card-text>
      <v-form action="">
        <v-container>
          <v-row>
            <input hidden v-model="roles.id">
            <v-col cols="12" md="4">
              <!-- Elimina la interpolación {{roles.name}} de aquí -->
              <v-text-field v-model="roles.name" label="Nombre" required></v-text-field>
            </v-col>
          </v-row>
        </v-container>
      </v-form>
    </v-card-text>         
    <v-card-actions>  
      <v-spacer></v-spacer>
      <v-btn color="green darken-1" text @click="saveRole()">Guardar</v-btn>
      <v-btn color="red darken-1" type="submit" text @click="dialog = false">Cancelar</v-btn>
    </v-card-actions>         
  </v-card>
</v-dialog>  
      </v-row>
    </v-container>
  </template>
  
  <script>
  import Navbar from '../../../components/pages/Sidebar.vue';
  import RoleAndPermission from '../../../actions/roleAndPermissions';
  import Swal from 'sweetalert2';
export default {
    name: 'RolePermissionsView',
    components: {
      Navbar
    },
    data() {
      return {
        roles: {
          id: null,
          name: "",
        },
        listRoles:[],
        dialog: false,
        operation: "",
        selectedRoleId: null,
      rolePermissions: [], 
      selectedRoleName: '',
      newState:Boolean,
      roleName:''
    };
    },
    created() {
      this.getRoles()
    },
    mounted() {
      
      this.getRolePermissions(this.selectedRoleId);
    },
    methods: {
    async getRoles(){
      this.listRoles= await RoleAndPermission.showRole();
    },
    async createRole(){
      await RoleAndPermission.createRole(this.roles);
      this.getRoles();
    },
    async deleteRole(id){
      await RoleAndPermission.deleteRole(id);
      this.getRoles();
    },
    async editRole(){
      await RoleAndPermission.editRole(this.roles);
      this.roles.name = ""; 
      this.getRoles();
         Swal.fire({
          position: "center",
          icon: "success",
          type: "success",
          title: "Rol editado correctamente",
          showConfirmButton: false,
          timer: 1500,
        });
    },
    
    newRole(){ 
        this.dialog = true;
        this.operation = "create";
        this.roles.name= "";
         
    },
    saveRole(){
      if (this.operation === "create") {
          this.createRole();
        }
      if (this.operation === "edit") {
          this.editRole();
        } 
        this.dialog = false;
    },
    formEdit(id,name){
      this.dialog = true;
      this.operation = "edit";
      this.roles.id = id;
  this.roles.name = name;
    },
  
    async getRolePermissions(id) {
  const selectedRole = this.listRoles.find(role => role.id === id);
  if (selectedRole) {
    this.selectedRoleName = selectedRole.name;
    this.selectedRoleId = id;
    this.rolePermissions = await RoleAndPermission.getRolePermission(id);
    this.rolePermissions = this.rolePermissions.map((permission) => {
      return {
        id: permission.id,
        name: permission.name,
        newState: permission.state,
      };
    });
  }
},
  
  
  async updatePermissionState(permissionId, newState) {
    RoleAndPermission.updateStateRole( this.selectedRoleId,permissionId,newState);
    this.rolePermissions = this.rolePermissions.map((permission) => {
      if (permission.id === permissionId) {
        return {
          ...permission,
          newState: newState,
        };
      }
      this.$toast.success('Permiso actualizado correctamente');
      return permission;
    });
   },
    }
  }
  </script>
  
  <style scoped>
  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }
  
  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }
  
  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    border-radius: 34px;
  }
  
  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    border-radius: 50%;
  }
  
  input:checked + .slider {
    background-color: #2196F3;
  }
  
  input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
  }
  
  input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }
  
  .slider.round {
    border-radius: 34px;
  }
  
  .slider.round:before {
    border-radius: 50%;
  }
  </style>