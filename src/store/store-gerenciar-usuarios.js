import axios from 'axios'
import { Loading } from 'quasar'

const state = {
}

const mutations = {
}

const actions = {
  async carregaPagina (context, pg = 1) {
    Loading.show()
    return new Promise((resolve, reject) => {
      axios.get(`https://reqres.in/api/users?page=${pg}`)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => {
          Loading.hide()
          reject(error)
        })
        .finally(() => {
          Loading.hide()
        })
    })
  },
  async buscaUsuario (context, id) {
    Loading.show()
    return new Promise((resolve, reject) => {
      axios.get(`https://reqres.in/api/users/${id}`)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => {
          Loading.hide()
          reject(error)
        })
        .finally(() => {
          Loading.hide()
        })
    })
  },
  async criarUsuario (context, form) {
    Loading.show()
    return new Promise((resolve, reject) => {
      axios.post('https://reqres.in/api/users/', form)
        .then((response) => {
          Loading.hide()
          resolve(response)
        })
        .catch((error) => {
          Loading.hide()
          reject(error)
        })
        .finally(() => {
          Loading.hide()
        })
    })
  },
  async alterarUsuario (context, form) {
    return new Promise((resolve, reject) => {
      axios.put(`https://reqres.in/api/users/${form.id}`, form)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => {
          reject(error)
        })
        .finally(() => {
          Loading.hide()
        })
    })
  },
  async deletarUsuario (context, id) {
    return new Promise((resolve, reject) => {
      axios.delete(`https://reqres.in/api/users/${id}`)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => {
          reject(error)
        })
        .finally(() => {
          Loading.hide()
        })
    })
  }
}
const getters = {
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
