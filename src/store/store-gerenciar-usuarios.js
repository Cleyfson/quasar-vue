import axios from 'axios'

const state = {
  usuarios: null
}

const mutations = {
  CARREGAR_USUARIOS (state, usuarios) {
    state.usuarios = usuarios
  }
}

const actions = {
  async carregaUsuarios (context, pg = 1) {
    const response = await axios.get(`https://reqres.in/api/users?page=${pg}`)
    context.commit('CARREGAR_USUARIOS', response.data.data)
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
