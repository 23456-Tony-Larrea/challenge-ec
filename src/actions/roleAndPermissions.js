import http from '../pluggins/axios';
import Swal from 'sweetalert2';

const RoleAndPermission = {
  getRolePermission(id) {
    return http.get(`/role-permissions/${id}`).then((data) => {
      return data.data.data;
    });
  },
    updateStateRole(idRole, idPermission,newState) {
      const body ={
      newState:newState
      }
      return http
        .put(`/role-permissions/${idRole}/permissions/${idPermission}`,body)
        .then((response) => {
          const updatedPermission = response.data.data;
          return updatedPermission; 
               })
        .catch((error) => {
          console.error('Error updating role permission:', error);
          throw error;
        });
   }, 
   showRole() {
    return http.get('/roles').then((data) => {
      const roles = data.data.filter(role => role.name !== 'SUPERADMINISTRADOR');
    return roles;
    });
  },
  createRole(role) {
    let params = {
      name: role.name,
    };
    return http.post('/roles', params).then((data) => {
      return data.data;
    });
  },
  editRole(roles) {
    let params = {
      name: roles.name,
      id: roles.id,
    };
    return http.put(`/roles/${roles.id}`, params).then((data) => {
      return data.data;
    });
  },
  deleteRole(id) {
    return Swal.fire({
      title: '¿Estás seguro?',
      icon: 'warning',
      text: 'No podrás revertir esto',
      confirmButtonText: 'Sí, eliminar',
      showCancelButton: true,
    }).then((result) => {
      if (result.value) {
        return http.delete(`/roles/${id}`).then((data) => {
          return data.data;
        });
      } else if (result.dismiss === 'cancelar') {
        Swal.fire('Cancelado', 'El rol no fue eliminado', 'error');
        return false;
      }
    });
  },
};

export default RoleAndPermission;