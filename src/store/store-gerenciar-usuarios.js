import axios from 'axios'
import { Loading } from 'quasar'

const state = {
  token: null
}

const mutations = {
  SET_TOKEN (state, token) {
    state.token = token
  }
}

const actions = {
  login (context, data) {
    context.commit('SET_TOKEN', data.data.access_token)
  },
  async carregaPagina (context, pg = 1) {
    Loading.show()
    return new Promise((resolve, reject) => {
      axios.get(`http://localhost:8000/api/users?page=${pg}`)
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
      axios.get(`http://localhost:8000/api/users/${id}`)
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
      axios.post('http://localhost:8000/api/users/', form)
        .then((response) => {
          Loading.hide()
          console.log(response)
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
      axios.put(`http://localhost:8000/api/users/${form.id}`, form)
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
      axios.delete(`http://localhost:8000/api/users/${id}`)
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
  logout (context) {
    context.commit('SET_TOKEN', null)
    this.$router.push({ name: 'Login' })
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
