import http from '../pluggins/axios';
import Swal from 'sweetalert2';
import router from '../router/router'
export function login(email,password){
        let json={
        "email":email,
        "password":password
      };
      http.post('/users-login',json)
      .then(data=>{
        console.log(data);
        localStorage.setItem('user',data.data.name);
        localStorage.setItem('user',data.data.role_name);
        Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Bienvenido',
              showConfirmButton: false,
              timer: 1500
            })
          router.push('/mainpage')
    }).catch(e=>{
        if(e.response.data.message=="Unauthorized"){
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Usuario o Contraseña incorrectos',
          })
        }else  if(e.response.status==400){
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Usuario no encontrado',
          })
        }
    }) 
}