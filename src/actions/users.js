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
    createUser(users){
      let params = {
        identity:users.identity,
        name: users.name,
        email: users.email,
        role_id:users.role_id,
        password:"123456"
      };
      return http.post('/register', params).then((data) => {
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
        identity:users.identity,
        id: users.id,
        role_id:users.role_id
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
  
    changeStateBool(id) {
      return Swal.fire({
        title: '¿Estas seguro?',
        icon: 'warning',
        text: 'No podras revertir esto!',
        confirmButtonText: 'Si,Cambiar!',
        showCancelButton: true,
      }).then((result) => {
        if (result.value) {
          return http.put(`/usersBool/${id}`).then((data) => {
            console.log(data);
            Swal.fire({
              icon: 'success',
              title: 'Eliminar!',
              text: 'El usuario ha sido cambaido su estado con exito.',
              showConfirmButton: false,
              timer: 1500
            })
            return data.data.data
          });
        } else if (result.dismiss === 'cancelar') {
          Swal.fire('Cancelado', 'El usuario no fue eliminado', 'error');
          return false;
        }
      });
    },

    }