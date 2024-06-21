import http from '../pluggins/axios';
import Swal from 'sweetalert2';
import router from '../router/router'
export function login(name,password){
        let json={
        "name":name,
        "password":password
      };
      http.post('/login',json)
      .then(data=>{
        //console.log(data);
       /*  Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Bienvenido',
              showConfirmButton: false,
              timer: 1500
            }) */
          router.push('/mainpage')
    }).catch(e=>{
        console.log(e);
        router.push('/mainpage')

        /*  if(e.response.data.message=="User not found."){
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Usuario no encontrado',
            })
          }
          else if(e.response.data.message=="Contraseña inválida."){
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Contraseña incorrecta',
            })
          }
          else if (e.response.data.message=="Eres rol paciente, no se te ha asignado ningún perfil."){
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Eres rol paciente, no se te ha asignado ningún perfil.',
            })
          } */
    }) 
}