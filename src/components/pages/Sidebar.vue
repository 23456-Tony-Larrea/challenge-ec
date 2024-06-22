<template>
  <nav>
    <v-app-bar color="blue" dark>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <v-toolbar-title>App-control</v-toolbar-title>
      <v-spacer></v-spacer>
      <!-- <v-btn icon @click="toggleDarkMode">
        <v-icon>{{ darkMode ? 'mdi-white-balance-sunny' : 'mdi-brightness-2' }}</v-icon>
      </v-btn> -->
      <v-menu offset-y>
        <template v-slot:activator="{ props }">
          <v-btn text v-bind="props" class="mx-3">
            <v-avatar size="32">
  <v-icon>mdi-account-lock</v-icon> <!-- Icono de usuario con candado -->
</v-avatar>
            {{username}}
          </v-btn>
        </template>
        <v-list>
          <v-list-item>
            <v-list-item-title>Perfil</v-list-item-title>
          </v-list-item>
          <v-list-item>
            <v-list-item-title>Cerrar sesión</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>
    <v-navigation-drawer v-model="drawer" app dark color="blue" width="250">
      <div class="text-center mt-5">
        <v-btn fab color="#E3F2FD" x-large>
          <v-avatar size="32">
  <v-icon>mdi-security</v-icon> <!-- Icono de control y seguridad -->
</v-avatar>
        </v-btn>
      </div>

      <!-- Menú con opciones -->
      <v-list dense>
        <v-list-item v-if="isAdmin">
    <router-link to="/roleAndPermissions" class="config-link">
      <v-list-item-icon>
        <v-icon>mdi-cog</v-icon>
      </v-list-item-icon>
      <v-list-item-title>Roles y permisos</v-list-item-title>
    </router-link>
  </v-list-item>
    <v-list-item>
      <router-link to="/users" class="config-link"  v-if="isPermissionEnabled('gestion usuarios')">
        <v-list-item-icon>
          <v-icon>mdi-account</v-icon>
        </v-list-item-icon>
        <v-list-item-title>Usuarios</v-list-item-title>
      </router-link>
    </v-list-item>
    <v-list-item>
      <router-link to="/configuraciones" class="config-link"  v-if="isPermissionEnabled('modulo 2')">
        <v-list-item-icon>
          <v-icon>mdi-view-dashboard</v-icon>
        </v-list-item-icon>
        <v-list-item-title>Grafica</v-list-item-title>
      </router-link>
    </v-list-item>
  </v-list>
    </v-navigation-drawer>
  </nav>
</template>

<script>
import RoleAndPermission from '../../actions/roleAndPermissions';
export default {
  name: 'Sidebar',
  data() {
    return {
      darkMode: false,
      drawer: false,
      groupOpen: false,
      username:localStorage.getItem('user'),
      permissions: [],
      showRoleAndPermissionsTab: false,
    };
  },
  methods: {
    fetchRoleAndPermissions() {
      const id = localStorage.getItem('role_id');
      RoleAndPermission.getRolePermission(id)
       .then((response) => {
         this.permissions = response;
        })
    },
    isPermissionEnabled(name) {
      const permission = this.permissions.find(
        (permission) => permission.name === name,
      );
      return permission && permission.state;
    },
  },
  computed: {
    // Paso 1: Definir la propiedad computada
    isAdmin() {
      const roleName = localStorage.getItem('role_name');
      return roleName === 'administrador';
    },
  },
  mounted() {
    this.fetchRoleAndPermissions();
  },
};
</script>

<style>
/* Estilo para desactivar el truncado de los títulos */
.v-list-item__title,
.v-list-group__header {
  white-space: normal; /* Ajusta el espaciado para mostrar todo el contenido */
  overflow: visible; /* Evita el recorte del contenido */
}
.config-link {
  text-decoration: none; /* Elimina el subrayado */
  color: white; /* Establece el color del texto en blanco */
}

/* Para asegurarse de que el color y el estilo se apliquen en todos los estados del enlace */
.config-link:link, .config-link:visited, .config-link:hover, .config-link:active {
  color: white;
  text-decoration: none;
}
</style>
