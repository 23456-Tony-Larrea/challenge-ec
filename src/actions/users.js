import http from '../pluggins/axios';
import Swal from 'sweetalert2';
export default {
    show() {
      return http.get('/users').then((data) => {
        return data.data;
      });
    },
    showRole(){
      return http.get('/roles').then((data) => {
        return data.data;
      });
    },
   async createUser(users){
      if (!users.email || !/.+@.+\..+/.test(users.email)) {
        await Swal.fire({
          icon: 'error',
          title: 'Error en la validación',
          text: 'Por favor, introduce un correo electrónico válido.',
        });
      }

      
    
      if (!users.latitud || !users.longitud) {
        Swal.fire({
          icon: 'error',
          title: 'Error en la validación',
          text: 'Por favor, selecciona una ubicación válida.',
        });
        return Promise.reject(new Error('Ubicación inválida'));
      }
      let params = {
        name: users.name,
        email: users.email,
        password:"12345678",
        cedula:users.cedula,
        nombres:users.name,
        apellidos:users.apellidos,
        fecha_nacimiento:users.fecha_nacimiento,
        estado_civil:users.estado_civil,
        latitud:users.latitud.toString(),
        longitud:users.longitud.toString(),
        role_name:users.role_name,
      };
      return http.post('/users', params).then((data) => {
        Swal.fire({
          position: "center",
          icon: "success",
          type: "success",
          title: "Usuario creado correctamente",
          showConfirmButton: false,
          timer: 1500,
        });
        return data.data.data;
      } 
      )
      .catch((error) => {
        if(error.response){
          if (error.response.status === 409){
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'El email o la cédula ya existe.',
            })
          }
        }
      });
    },
    edit(users) {
      let params = {
        name: users.name,
        email: users.email,
        cedula:users.cedula,
        nombres:users.name,
        apellidos:users.apellidos,
        fecha_nacimiento:users.fecha_nacimiento,
        estado_civil:users.estado_civil,
        latitud:users.latitud,
        longitud:users.longitud,
        role_name:users.role_name,
      };
      return http.put(`/users/${users.id}`, params).then((data) => {
        Swal.fire({
          position: "center",
          icon: "success",
          type: "success",
          title: "Usuario editado correctamente",
          showConfirmButton: false,
          timer: 1500,
        });
            return data.data.data;
      });
    },
    deleteUser(id) {
      return Swal.fire({
        title: '¿Estás seguro?',
        icon: 'warning',
        text: 'No podrás revertir esto',
        confirmButtonText: 'Sí, eliminar',
        showCancelButton: true,
      }).then((result) => {
        if (result.value) {
          return http.delete(`/users/${id}`).then((data) => {
            Swal.fire({
              position: "center",
              icon: "success",
              type: "success",
              title: "Usuario eliminado correctamente",
              showConfirmButton: false,
              timer: 1500,
            });
            return data.data;
          });
        } else if (result.dismiss === 'cancelar') {
          Swal.fire('Cancelado', 'El usuario no fue eliminado', 'error');
          return false;
        }
      });
    },
    showUserById(id) {
      return http.get(`/users/${id}`).then((data) => {
        return data.data;
      });
    },
    }