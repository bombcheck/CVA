import axios from 'axios'
import {store} from '../store'

export const Http = axios.create({
  baseURL: 'api/'
})

Http.interceptors.request.use(function (request) {
  request.headers.Authorization = 'Bearer ' + store.state.authStore.token.access_token

  return request
})

Http.interceptors.response.use(response => {
  return response
}, error => {
  // if (error.response.status == 409) {
  //   store.dispatch('errorsStore/addError', {title: error.response.data.error, body: error.response.data.message, status: error.response.status})
  // } else if (error.response.status == 401 && error.response.data.type == null) {
  //   localStorage.setItem('vuex', '')
  //   window.location.replace('/')
  // } else if (error.response.status == 500) {
  //   if (error.response.data.errors != null) {
  //     swal.fire({title: 'Server error!', text: error.response.data.errors.general, type: 'error'})
  //   } else {
  //     swal.fire({title: 'Server error!', text: null, type: 'error'})
  //   }
  // } else {
  //   console.log('Time !!')
  // }
  return Promise.reject(error)
})

export const AuthHttp = axios.create({
  headers: {
    'Content-Type': 'multipart/form-data'
  }
})
