<template>
    <v-container>
      <v-row>
        <v-col cols="12">
          <v-text-field
            v-model="name"
            label="Tu nombre"
            outlined
          ></v-text-field>
        </v-col>
        <v-col cols="12">
          <v-text-field
            v-model="message"
            label="Escribe un mensaje..."
            outlined
            @keyup.enter="sendMessage"
          ></v-text-field>
        </v-col>
        <v-col cols="12">
          <v-btn color="primary" @click="sendMessage">Enviar</v-btn>
        </v-col>
        <v-col cols="12">
          <v-list>
            <v-list-item v-for="(msg, index) in messages" :key="index" :style="{ backgroundColor: getColor(msg.name) }">
              <v-list-item-content>
                <v-list-item-title>
                  <strong>{{ msg.name }}:</strong> {{ msg.message }}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-col>
      </v-row>
    </v-container>
  </template>
  
  <script>
  import { io } from "socket.io-client";
  import Swal from 'sweetalert2';
  export default {
    data() {
      return {
        socket: null,
        name: '',
        message: '',
        messages: [],
        colors: ['#FFCDD2', '#E1BEE7', '#BBDEFB', '#C8E6C9', '#FFF9C4', '#FFECB3', '#D1C4E9', '#B2EBF2', '#DCEDC8', '#FFAB91']
      };
    },
    mounted() {
  this.socket = io("http://192.168.56.1:3000");

  this.socket.on("receiveMessage", (data) => {
    console.log("Mensaje recibido:", data);
    this.messages.push(data);
  });

  this.socket.on("duplicateConnection", (data) => {
    Swal.fire({
      title: 'Conexión duplicada',
      text: data.message,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, desconectar',
      cancelButtonText: 'No'
    }).then((result) => {
      if (result.isConfirmed) {
        this.socket.disconnect();
        Swal.fire(
          'Desconectado!',
          'Tu conexión anterior ha sido cerrada.',
          'success'
        )
      }
    });
  });
},
    methods: {
      sendMessage() {
        if (this.message.trim()) {
          const data = { name: this.name, message: this.message };
          this.socket.emit("sendMessage", data);
          this.message = '';
        }
      },
      getColor(name) {
        const hash = this.hashCode(name);
        const index = hash % this.colors.length;
        return this.colors[index];
      },
      hashCode(str) {
        let hash = 0;
        for (let i = 0; i < str.length; i++) {
          const char = str.charCodeAt(i);
          hash = (hash << 5) - hash + char;
          hash |= 0; // Convert to 32bit integer
        }
        return hash;
      }
    },
  };
  </script>
  
  <style>
  .v-list-item {
    margin-bottom: 5px;
    border-radius: 5px;
    padding: 10px;
  }
  .v-list-item-title {
    color: #333;
  }
  </style>
  