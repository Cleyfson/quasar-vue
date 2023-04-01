import axios from 'axios'

const state = {
}

const mutations = {
}

const actions = {
  async carregaEnderecos (context, id) {
    try {
      this.$reuso.showLoading()
      const token = context.rootState.usuarios.token
      const response = await axios.get(`http://localhost:8000/api/v1/address?user=${id}`, { headers: { Authorization: 'Bearer ' + token } })
      return response
    } catch (error) {
      this.$reuso.mensagemErro('Erro ao carregar endereços do usuarios', error)
    } finally {
      this.$reuso.hideLoading()
    }
  },
  async criarEndereco (context, form) {
    console.log(form)
    try {
      this.$reuso.showLoading()
      const token = context.rootState.usuarios.token
      const response = await axios.post('http://localhost:8000/api/v1/address/', form, { headers: { Authorization: 'Bearer ' + token } })
      return response.data
    } catch (error) {
      this.$reuso.mensagemErro('Erro ao criar endereço', error)
    } finally {
      this.$reuso.hideLoading()
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
