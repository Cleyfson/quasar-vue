import axios from 'axios'

const state = {
  usuario: null,
  token: null
}

const mutations = {
  SET_USUARIO (state, usuario) {
    state.usuario = usuario
  },
  SET_TOKEN (state, token) {
    state.token = token
  }
}

const actions = {

  async login (context, payload) {
    try {
      this.$reuso.showLoading()
      const response = await axios.post('http://localhost:8000/api/v1/login', payload)
      context.commit('SET_USUARIO', response.data[0])
      context.commit('SET_TOKEN', response.data.access_token)
      this.$router.push('listagem-usuarios')
      return response.data
    } catch (error) {
      this.$reuso.mensagemErro('Erro ao fazer login.', error)
    } finally {
      this.$reuso.hideLoading()
    }
  },
  async carregaPagina (context, pg = 1) {
    try {
      this.$reuso.showLoading()
      const token = context.rootState.usuarios.token
      const response = await axios.get(`http://localhost:8000/api/v1/users?page=${pg}`, { headers: { Authorization: 'Bearer ' + token } })
      return response
    } catch (error) {
      this.$reuso.mensagemErro('Erro ao carregar lista de usuarios', error)
    } finally {
      this.$reuso.hideLoading()
    }
  },
  async buscaUsuario (context, id) {
    try {
      this.$reuso.showLoading()
      const token = context.rootState.usuarios.token
      const response = await axios.get(`http://localhost:8000/api/v1/users/${id}`, { headers: { Authorization: 'Bearer ' + token } })
      return response
    } catch (error) {
      this.$reuso.mensagemErro('Erro ao carregar dados do usuarios', error)
    } finally {
      this.$reuso.hideLoading()
    }
  },
  async criarUsuario (context, form) {
    try {
      this.$reuso.showLoading()
      const token = context.rootState.usuarios.token
      const response = await axios.post('http://localhost:8000/api/v1/users/', form, { headers: { Authorization: 'Bearer ' + token } })
      return response.data
    } catch (error) {
      this.$reuso.mensagemErro('Erro ao criar usuario', error)
    } finally {
      this.$reuso.hideLoading()
    }
  },
  async alterarUsuario (context, form) {
    try {
      this.$reuso.showLoading()
      const token = context.rootState.usuarios.token
      const response = await axios.put(`http://localhost:8000/api/v1/users/${form.id}`, form, { headers: { Authorization: 'Bearer ' + token } })
      return response.data
    } catch (error) {
      this.$reuso.mensagemErro('Erro ao alterar usuario', error)
    } finally {
      this.$reuso.hideLoading()
    }
  },
  async deletarUsuario (context, id) {
    try {
      console.log(id)
      this.$reuso.showLoading()
      const token = context.rootState.usuarios.token
      const response = await axios.delete(`http://localhost:8000/api/v1/users/${id}`, { headers: { Authorization: 'Bearer ' + token } })
      return response.data
    } catch (error) {
      this.$reuso.mensagemErro('Erro ao deletar usuario', error)
    } finally {
      this.$reuso.hideLoading()
    }
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
