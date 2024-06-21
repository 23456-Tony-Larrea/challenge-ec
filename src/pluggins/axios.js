// import Vue from 'vue'
import axios from 'axios'
import {URL_API} from '/constants/URL.JS'
const http = axios.create({
  baseURL: `${URL_API}`
})

// Agregar un interceptor de solicitud
http.interceptors.request.use(function (config) {
  return config; 
})
export default http;