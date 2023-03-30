import axios from 'axios'

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
    this.$router.push('/')
  },
  async carregaPagina (context, pg = 1) {
    this.$reuso.showLoading()
    return new Promise((resolve, reject) => {
      axios.get(`http://localhost:8000/api/users?page=${pg}`)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => {
          this.$reuso.hideLoading()
          this.$reuso.mensagemErro('Erro ao carregar lista de usuarios', error)
        })
        .finally(() => {
          this.$reuso.hideLoading()
        })
    })
  },
  async buscaUsuario (context, id) {
    this.$reuso.showLoading()
    return new Promise((resolve, reject) => {
      axios.get(`http://localhost:8000/api/users/${id}`)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => {
          this.$reuso.hideLoading()
          this.$reuso.mensagemErro('Erro ao carregar dados do usuario', error)
        })
        .finally(() => {
          this.$reuso.hideLoading()
        })
    })
  },
  async criarUsuario (context, form) {
    this.$reuso.showLoading()
    return new Promise((resolve, reject) => {
      axios.post('http://localhost:8000/api/users/', form)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => {
          this.$reuso.hideLoading()
          this.$reuso.mensagemErro('Erro ao criar usuario', error)
        })
        .finally(() => {
          this.$reuso.hideLoading()
        })
    })
  },
  async alterarUsuario (context, form) {
    this.$reuso.showLoading()
    return new Promise((resolve, reject) => {
      axios.put(`http://localhost:8000/api/users/${form.id}`, form)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => {
          this.$reuso.hideLoading()
          this.$reuso.mensagemErro('Erro ao alterar usuario', error)
        })
        .finally(() => {
          this.$reuso.hideLoading()
        })
    })
  },
  async deletarUsuario (context, id) {
    this.$reuso.showLoading()
    return new Promise((resolve, reject) => {
      axios.delete(`http://localhost:8000/api/users/${id}`)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => {
          this.$reuso.hideLoading()
          this.$reuso.mensagemErro('Erro ao deletar usuario', error)
        })
        .finally(() => {
          this.$reuso.hideLoading()
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
