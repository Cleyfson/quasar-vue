import axios from 'axios'

const state = {
  users: null,
  page: null,
  perPage: null,
  total: null,
  totalPages: null
}

const mutations = {
  CARREGAR_PAGINA (state, payload) {
    state.users = payload.data
    state.page = payload.page
    state.perPage = payload.per_page
    state.total = payload.total
    state.totalPages = payload.total_pages
  },

  DELETAR_USUARIO (state, payload) {
    state.users.splice(payload, 1)
  }
}

const actions = {
  async carregaPagina (context, pg = 1) {
    const response = await axios.get(`https://reqres.in/api/users?page=${pg}`)
    context.commit('CARREGAR_PAGINA', response.data)
  },
  async buscaUsuario (context, id) {
    const response = await axios.get(`https://reqres.in/api/users/${id}`)
    console.log(response)
  },
  // async criarUsuario (context, form) {
  //   const response = await axios.post('https://reqres.in/api/users/', form)
  //   console.log(response)
  // },
  // async alterarUsuario (context, form) {
  //   const response = await axios.put(`https://reqres.in/api/users/${form.id}`, form)
  //   console.log(response)
  // },
  async deletarUsuario (context, id, index) {
    try {
      await axios.delete(`https://reqres.in/api/users/${id}`)
      context.commit('DELETAR_USUARIO', index)
    } catch (error) {
      console.log(error)
    }
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
